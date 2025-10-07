<form method="post" id="search-taxonomy" action="<?php echo esc_url( home_url() ); ?>/">
    <fieldset>
        <input name="post_type" type="hidden" value="staff">
		<input type="text" name="s"<?php if (isset($wp_query->query_vars['s'])) { echo ' value="'; print sanitize_text_field($wp_query->query_vars['s']); echo '"'; } ?> id="s" />
        <input type="submit" class="button green" name="taxonomy-search" id="taxonomy-search" value="<?php _e('Search staff directory', 'academia_textdomain'); ?>" />
    </fieldset>
</form>
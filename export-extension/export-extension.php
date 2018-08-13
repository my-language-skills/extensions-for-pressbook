<?php

/**
 *
 *File responsible for adding new options in export settings
 */

add_action ('admin_init', 'add_template_checkbox');

function add_template_checkbox () {
	add_settings_field ('is_template', __('Book Is Template', 'extensions-for-pressbooks'), 'render_opt_checkbox', 'pressbooks_export_options', 'pressbooks_export_options_section', [__('Not include "isBasedOn" information in exported or cloned book.' , 'extensions-for-pressbooks')]);
}

function render_opt_checkbox ($args) {
	?>
	<input type="checkbox" name="pressbooks_export_options[is_template]" id="is_template" value="1" <?php checked(isset(get_option('pressbooks_export_options')['is_template']), 1) ?>><label for="is_template"><?php echo $args[0] ?></label>
	<?php
}
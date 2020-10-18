<?php

/**
 * Original Mark
 *
 * Sites can be mark and later to receive special treatment (as to receive an original site sibon).
 *
 * @link URL
 *
 * @since x.x.x (when the file was introduced)
 * @package extensions-for-pressbooks
 */


/**
 * File responsible for adding option to mark original content
 */
add_action('admin_enqueue_scripts', 'efpb_om_enqueue_scripts');
add_action('wp_ajax_efpb_mark_as_original', 'efpb_mark_as_original', 1);
add_filter( 'wpmu_blogs_columns', 'efpb_add_original_column' );
add_action( 'manage_sites_custom_column', 'efpb_render_original_column', 1, 3 );

/**
 * Summary.
 *
 * @since
 *
 */

function efpb_om_enqueue_scripts () {
	wp_enqueue_script( 'original-mark-script', plugin_dir_url( __FILE__ ).'assets/scripts/original-mark-admin.js');
}

/**
 * Summary.
 *
 * @since
 *
 */

function efpb_mark_as_original() {
	if ( ! current_user_can( 'manage_network' ) || ! check_ajax_referer( 'pressbooks-aldine-admin' ) ) {
		return;
	}

	//$blog_id = intval($_POST['book_id']);
	$blog_id = intval(sanitize_key($_POST['book_id']));
	if(!$blog_id){
		$blog_id = "";
	}
	$blog_id = sanitize_text_field ($blog_id);
	$is_original = sanitize_key($_POST['is_original']);
	//$is_original = sanitize_text_field ($is_original);


	if ( $is_original === 'true' ) {
		delete_blog_option( $blog_id, 'efp_publisher_is_original' );
		update_blog_option( $blog_id, 'efp_publisher_is_original', 1 );
	} else {
		delete_blog_option( $blog_id, 'efp_publisher_is_original' );
		update_blog_option( $blog_id, 'efp_publisher_is_original', 0 );
	}
}

/**
 * Summary.
 *
 * @since
 *
 */

function efpb_add_original_column ($columns) {
	$columns['is_original'] = __( 'Featured Book', 'extensions-for-pressbooks' );
	return $columns;
}

/**
 * Summary.
 *
 * @since
 *
 */

function efpb_render_original_column ($column, $blog_id ) {
	if ( 'is_original' === $column && ! is_main_site( $blog_id ) ) { ?>
		<input class="is-original" type="checkbox" name="is_original" value="1" aria-label="<?php echo esc_attr_x( 'Mark As Original Content', 'extensions-for-pressbooks' ); ?>" <?php checked( sanitize_option($blog_id,get_blog_option( $blog_id, 'efp_publisher_is_original' )), 1 ); ?> />
	<?php }
}

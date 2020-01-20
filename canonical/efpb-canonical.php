<?php
/**
 * Extensions for PressBooks / TSF modification
 *
 * This file create a functionality of Extensions for PressBooks Plugin. It works only
 * with "The SEO Framework" plugin. It creates a new column "Father Canonical Url"
 * in the page network/sites.php whit a checkbox that allows to manage the canonical
 * URL of the choosen book. Book's default canonical URL is the one given by "The SEO
 * Framework". If the book is featured and the checkbox is "ON" the canonical URL will
 * be the one of the father book.
 *
 * @link              URL
 * @since             1.2.7
 * @package           extensions-for-pressbooks
 *
 **/

/**
 * FILTERS AND ACTIONS:
**/
//It works only with "The SEO Framework" plugin active
if(is_plugin_active('autodescription/autodescription.php')){
  add_filter( 'wpmu_blogs_columns', 'efpb_add_canonical_column' );
  add_action( 'manage_sites_custom_column', 'efpb_render_canonical_column', 1, 3 );
  add_action('wp_ajax_efpb_mark_canonical', 'efpb_mark_canonical', 1);
  add_action('admin_enqueue_scripts', 'efpb_om_enqueue_scripts_canonical');
}

/**
 * CORE:
 * @since 1.2.7
**/
if(is_plugin_active('autodescription/autodescription.php')){
  if(get_current_blog_id() != 1){
    global $wpdb;
    $blog_id =get_current_blog_id();
    $wp_blog_id_postmeta = "wp_".$blog_id."_postmeta";
    $query_is_based_on = "SELECT * FROM `$wp_blog_id_postmeta` WHERE meta_key = 'pb_is_based_on'";
    $count_is_based_on = $wpdb->get_results($query_is_based_on);
    if (sizeof($count_is_based_on) > 0){
      //book is a clone
      $flag = 0;
      $wp_blog_id_options = "wp_".$blog_id."_options";
      $query_is_original = "SELECT option_value FROM `$wp_blog_id_options` WHERE option_name = 'efp_publisher_is_original'";
      $result_is_original = $wpdb->get_var($query_is_original);
      if ( $result_is_original == 1 ){
        //book is featured
        $query_canonical = "SELECT option_value FROM `$wp_blog_id_options` WHERE option_name = 'efp_publisher_canonical'";
        $result_canonical = $wpdb->get_var($query_canonical);
        if($result_canonical != 1){
          // canonical checkbox = OFF
          $flag = 1;
          //It will return default canonical URL
        }
      }
      if ($flag == 0){
        //book is not featured or is featured and canonical checkbox = ON
        add_filter( 'the_seo_framework_rel_canonical_output', 'get_canonical_url' );
      }
    }
  }
}

/**
 * FUNCTIONS:
 *
 * Create column
 * @since 1.2.7
**/
function efpb_add_canonical_column ($columns) {
  $columns['canonical'] = __( 'Father Canonical Url', 'extensions-for-pressbooks' );
  return $columns;
}

/**
 * Render columns
 * @since 1.2.7
**/
function efpb_render_canonical_column ($column, $blog_id ) {
  if ( 'canonical' === $column && ! is_main_site( $blog_id ) ) { ?>
    <input class="canonical" type="checkbox" name="canonical" value="1" aria-label="<?php echo esc_attr_x( 'Father Canonical Url', 'extensions-for-pressbooks' ); ?>" <?php checked( get_blog_option( $blog_id, 'efp_publisher_canonical' ), 1 ); ?> />
  <?php }
}

 /**
  * Mark original link / father's link
  * @since 1.2.7
 **/
function efpb_mark_canonical() {
  if ( ! current_user_can( 'manage_network' ) || ! check_ajax_referer( 'pressbooks-aldine-admin' ) ) {
    return;
  }
  $blog_id = intval($_POST['book_id']);
  if(!$blog_id){
    return;
  }
  $blog_id = sanitize_text_field ($blog_id);
  $canonical = $_POST['canonical'];
  $canonical = sanitize_text_field ($canonical);
  if ( $canonical === 'true' ) {
    delete_blog_option( $blog_id, 'efp_publisher_canonical' );
    update_blog_option( $blog_id, 'efp_publisher_canonical', 1 );
  } else {
    delete_blog_option( $blog_id, 'efp_publisher_canonical' );
    update_blog_option( $blog_id, 'efp_publisher_canonical', 0 );
  }
}

/**
 * Enqueue script
 * @since 1.2.7
**/
function efpb_om_enqueue_scripts_canonical () {
  wp_enqueue_script( 'canonical-script', plugin_dir_url( __FILE__ ).'assets/scripts/canonical-admin.js');
}

/**
 * Return father's canonical URL
 * @since 1.2.7
**/
function get_canonical_url($result_is_original){
  global $wpdb;
  $blog_id =get_current_blog_id();
  $wp_blog_id_options = "wp_".$blog_id."_options";
  $query_is_original = "SELECT option_value FROM `$wp_blog_id_options` WHERE option_name = '_transient_pb_book_source_url'";
  $result_is_original = $wpdb->get_var($query_is_original);
  return $result_is_original;
}

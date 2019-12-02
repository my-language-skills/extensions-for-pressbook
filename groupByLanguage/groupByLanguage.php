<?php
/*
    @package groupByLanguage
*/

/*
Plugin Name: groupByLanguage
Plugin URI: http://www.test.com
Description: Plug-in to choose books in a language
Version: 1.0.0
Author: Arald
Author URI: http://www.arald.com
License: GPLv2 or later
Text Domain: myplugin
*/

/*if ( ! function_exists('add_action')){
  echo 'ACCESS DENIED';
  die;
}*/
/*
function get_site_versions() {
    global $wpdb;
    $query = $wpdb->prepare( "SELECT blog_id, meta_value FROM $wpdb->blogmeta WHERE meta_key = 'pb_language' ORDER BY blog_id DESC");
    return $wpdb->get_results( $query );
}
*/
add_action( 'restrict_manage_sites', 'myplugin_add_cuisines_dropdown' );
function myplugin_add_cuisines_dropdown( $which ) {
    if ( 'top' !== $which ) {
        return;
    }

    echo '<select name="cuisine">';
    printf( '<option value="">%s</option>', __( 'All languages', 'myplugin' ) );

    $cuisines = array(
        'es'  => __( 'Spanish', 'myplugin' ),
        'it'  => __( 'Italian', 'myplugin' ),
        'en' => __( 'English', 'myplugin' ),
        'fr' => __('French', 'myplugin'),
    );
    $cuisines = array(
  					'ar'     => __( 'Arabic', 'myplugin' ),
  					'bg'     => __( 'Bulgarian', 'myplugin' ),
  					'cs'     => __( 'Czech', 'myplugin' ),
            'da'     => __( 'Danish', 'myplugin' ),
  					'de'     => __( 'German', 'myplugin' ),
  					'el'     => __( 'Greek', 'myplugin' ),
  					'en'     => __( 'English', 'myplugin' ),
  					'es'     => __( 'Spanish', 'myplugin' ),
  					'et'     => __( 'Estonian', 'myplugin' ),
  					'fi'     => __( 'Finnish', 'myplugin' ),
  					'fr'     => __( 'French', 'myplugin' ),
  					'ga'     => __( 'Irish', 'myplugin' ),
  					'he'     => __( 'Hebrew', 'myplugin' ),
  					'hi'     => __( 'Hindi', 'myplugin' ),
  					'hr'     => __( 'Croatian', 'myplugin' ),
            'hu'     => __( 'Hungarian', 'myplugin' ),
  					'hu'     => __( 'Hungarian', 'myplugin' ),
  					'id'     => __( 'Indonesian', 'myplugin' ),
  					'it'     => __( 'Italian', 'myplugin' ),
  					'ja'     => __( 'Japanese', 'myplugin' ),
  					'ka'     => __( 'Georgian', 'myplugin' ),
  					'lt'     => __( 'Lithuanian', 'myplugin' ),
  					'lv'     => __( 'Latvian', 'myplugin' ),
  					'mt'     => __( 'Maltese', 'myplugin' ),
  					'nl'     => __( 'Dutch', 'myplugin' ),
  					'pl'     => __( 'Polish', 'myplugin' ),
  					'pt'     => __( 'Portuguese', 'myplugin' ),
  					'ro'     => __( 'Romanian', 'myplugin' ),
  					'ru'     => __( 'Russian', 'myplugin' ),
  					'sk'     => __( 'Slovak', 'myplugin' ),
  					'sl'     => __( 'Slovenian', 'myplugin' ),
  					'sr'     => __( 'Serbian', 'myplugin' ),
  					'sv'     => __( 'Swedish', 'myplugin' ),
  					'tr'     => __( 'Turkish', 'myplugin' ),
  					'uk'     => __( 'Ukrainian', 'myplugin' ),
  					'vi'     => __( 'Vietnamese', 'myplugin' ),
  					'zh'     => __( 'Chinese', 'myplugin' ),
  			);

    $requested_cuisine = isset( $_GET['cuisine'] ) ? wp_unslash( $_GET['cuisine'] ) : '';

    foreach ( $cuisines as $cuisine => $label ) {
        $selected = selected( $cuisine, $requested_cuisine, false );          //aggiunge tutte le voci al menu
        printf( '<option%s>%s</option>', $selected, $label );
    }

    echo '</select>';

    return;
}

add_filter( 'ms_sites_list_table_query_args', 'myplugin_sites_with_cuisine' );
function myplugin_sites_with_cuisine( $args ) {
    if ( empty( $_GET['cuisine' ] ) ) {
        return $args;
    }
    //da fixare
  //  $blog_ids = array();


    $meta_query = array(                                                  //array --> inserire colonna e valore da cercare
        'key'   => 'pb_language',
        'value' => traduci(wp_unslash( $_GET['cuisine' ] ))
    );

    if ( isset( $args['meta_query'] ) ) {
        // add our meta query to the existing one(s).
        $args['meta_query'] = array(                                        //
            'relation' => 'AND',
            $meta_query,
            array( $args['meta_query'] ),
        );
    }
    else {
        // add our meta query.
        $args['meta_query'] = array(
            $meta_query,
        );
    }

    return $args;
}


function traduci($args){
  $translateChoice = array(
					'non_tr' => 'Not translation',
					'ar'     => 'Arabic',
					'bg'     => 'Bulgarian',
					'cs'     => 'Czech',
					'da'     => 'Danish',
					'de'     => 'German',
					'el'     => 'Greek',
					'en'     => 'English',
					'es'     => 'Spanish',
					'et'     => 'Estonian',
					'fi'     => 'Finnish',
					'fr'     => 'French',
					'ga'     => 'Irish',
					'he'     => 'Hebrew',
					'hi'     => 'Hindi',
					'hr'     => 'Croatian',
					'hu'     => 'Hungarian',
					'id'     => 'Indonesian',
					'it'     => 'Italian',
					'ja'     => 'Japanese',
					'ka'     => 'Georgian',
					'lt'     => 'Lithuanian',
					'lv'     => 'Latvian',
					'mt'     => 'Maltese',
					'nl'     => 'Dutch; Flemish',
					'pl'     => 'Polish',
					'pt'     => 'Portuguese',
					'ro'     => 'Romanian; Moldavian; Moldovan',
					'ru'     => 'Russian',
					'sk'     => 'Slovak',
					'sl'     => 'Slovenian',
					'sr'     => 'Serbian',
					'sv'     => 'Swedish',
					'tr'     => 'Turkish',
					'uk'     => 'Ukrainian',
					'vi'     => 'Vietnamese',
					'zh'     => 'Chinese'
			);
      foreach ($translateChoice as $key => $value) {
          if($args == $value) return $key;
      }
      return '';
	}




























/*
$my_variable = get_site_versions();

//---------------->>>>>>       var_dump($my_variable); //stampare a video la variabile (oggetto, int, string, array, ...)

//ciclo for funzionante!!!
//foreach ($my_variable as $array) {
//  echo "blog_id: " . $array->blog_id . " language: " . $array->meta_value .'<br>';
//}
$selezione='void';


add_action('test_dropdown', 'myplugin_language_dropdown');
function myplugin_language_dropdown( $which ) {
    if ( 'top' !== $which ) {
        return;
    }


/*
add_action( 'restrict_manage_sites', 'myplugin_language_dropdown' );
function myplugin_language_dropdown( $which ) {
    if ( 'top' !== $which ) {
        return;
    }

    echo '<select name="language">';
    printf( '<option value="">%s</option>', __( 'All languages', 'arald' ) );  //questa è la tendina che scorre cr

    $languages = array(
        'it'  => __( 'English', 'arald' ),
        'en'  => __( 'Italian', 'arald' ),
        'es' => __( 'Spanish', 'arald' ),
    );

    $requested_language = isset( $_GET['language'] ) ? wp_unslash( $_GET['language'] ) : '';

    $selezione = $requested_language;
    foreach ( $languages as $language => $label ) {
        $selected = selected( $language, $requested_language, false );
        printf( '<option%s>%s</option>', $selected, $label );

    }

    echo '</select>';

    return;
}
echo '......................................................................................'; echo $selezione;
add_filter( 'ms_sites_list_table_query_args', 'myplugin_sites_with_language' );
function myplugin_sites_with_language( $args ) {
    if ( empty( $_GET['language' ] ) ) {
        return $args;
    }

    $meta_query = array(
        'key'   => 'blogmeta',
        'value' => wp_unslash( $_GET['language' ] ),
    );

    if ( isset( $args['meta_query'] ) ) {
        // add our meta query to the existing one(s).
        $args['meta_query'] = array(
            'relation' => 'AND',
            $meta_query,
            array( $args['meta_query'] ),
        );
    }
    else {
        // add our meta query.
        $args['meta_query'] = array(
            $meta_query,
        );
    }

    return $args;
}

/*



function translate($args){
 array(
					'non_tr' => 'Not translation',

					'ar'     => 'Arabic',

					'bg'     => 'Bulgarian',

					'cs'     => 'Czech',

					'da'     => 'Danish',
					'de'     => 'German',

					'el'     => 'Greek',
					'en'     => 'English',

					'es'     => 'Spanish',
					'et'     => 'Estonian',

					'fi'     => 'Finnish',

					'fr'     => 'French',

					'ga'     => 'Irish',
					'he'     => 'Hebrew',
					'hi'     => 'Hindi',
					'hr'     => 'Croatian',
					'hu'     => 'Hungarian',
					'id'     => 'Indonesian',
					'it'     => 'Italian',
					'ja'     => 'Japanese',
					'ka'     => 'Georgian', //not attribut flag icons right now
					'lt'     => 'Lithuanian',
					// 'lu'     => 'Luba-Katanga', //not attribut flag icons right now
					'lv'     => 'Latvian',
					'mt'     => 'Maltese',
					'nl'     => 'Dutch; Flemish',
					'pl'     => 'Polish',
					// 'ps'     => 'Pushto; Pashto', //not attribut flag icons right now
					'pt'     => 'Portuguese',
					// 'rn'     => 'Rundi', //not attribut flag icons right now
					'ro'     => 'Romanian; Moldavian; Moldovan',
					'ru'     => 'Russian',
					// 'si'     => 'Sinhala; Sinhalese', //not attribut flag icons right now
					'sk'     => 'Slovak',
					'sl'     => 'Slovenian',
					'sr'     => 'Serbian',
					// 'su'     => 'Sundanese', //not attribut flag icons right now
					'sv'     => 'Swedish',
					'tr'     => 'Turkish',
					'uk'     => 'Ukrainian', //not attribut flag icons right now
					'vi'     => 'Vietnamese',
					// 'za'     => 'Zhuang; Chuang', //not attribut flag icons right now
					'zh'     => 'Chinese'

			)
	}

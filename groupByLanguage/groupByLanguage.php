<?php
/*
    @package groupByLanguage
*/

/*
Plugin Name: groupByLanguage
Plugin URI: http://www.test.com
Description: Plug-in to create a dropdown menu to filter books by language
Version: 1.0.0
Author: Arald Garbolino
Author URI: http://www.arald.com
License: GPLv2 or later
Text Domain: groupByLanguagePlugin
*/

add_action( 'restrict_manage_sites', 'efppb_add_language_dropdown_menu' );
function efppb_add_language_dropdown_menu( $which ) {
    if ( 'top' !== $which ) {
        return;
    }
    echo '<select name="cuisine">';
    printf( '<option value="">%s</option>', __( 'All languages', 'groupByLanguagePlugin' ) );

    $dropdown_languages = array(
  					'ar'     => __( 'Arabic', 'groupByLanguagePlugin' ),
  					'bg'     => __( 'Bulgarian', 'groupByLanguagePlugin' ),
  					'cs'     => __( 'Czech', 'groupByLanguagePlugin' ),
            'da'     => __( 'Danish', 'groupByLanguagePlugin' ),
  					'de'     => __( 'German', 'groupByLanguagePlugin' ),
  					'el'     => __( 'Greek', 'groupByLanguagePlugin' ),
  					'en'     => __( 'English', 'groupByLanguagePlugin' ),
  					'es'     => __( 'Spanish', 'groupByLanguagePlugin' ),
  					'et'     => __( 'Estonian', 'groupByLanguagePlugin' ),
  					'fi'     => __( 'Finnish', 'groupByLanguagePlugin' ),
  					'fr'     => __( 'French', 'groupByLanguagePlugin' ),
  					'ga'     => __( 'Irish', 'groupByLanguagePlugin' ),
  					'he'     => __( 'Hebrew', 'groupByLanguagePlugin' ),
  					'hi'     => __( 'Hindi', 'groupByLanguagePlugin' ),
  					'hr'     => __( 'Croatian', 'groupByLanguagePlugin' ),
            'hu'     => __( 'Hungarian', 'groupByLanguagePlugin' ),
  					'hu'     => __( 'Hungarian', 'groupByLanguagePlugin' ),
  					'id'     => __( 'Indonesian', 'groupByLanguagePlugin' ),
  					'it'     => __( 'Italian', 'groupByLanguagePlugin' ),
  					'ja'     => __( 'Japanese', 'groupByLanguagePlugin' ),
  					'ka'     => __( 'Georgian', 'groupByLanguagePlugin' ),
  					'lt'     => __( 'Lithuanian', 'groupByLanguagePlugin' ),
  					'lv'     => __( 'Latvian', 'groupByLanguagePlugin' ),
  					'mt'     => __( 'Maltese', 'groupByLanguagePlugin' ),
  					'nl'     => __( 'Nederlands', 'groupByLanguagePlugin' ),
  					'pl'     => __( 'Polish', 'groupByLanguagePlugin' ),
  					'pt'     => __( 'Portuguese', 'groupByLanguagePlugin' ),
  					'ro'     => __( 'Romanian', 'groupByLanguagePlugin' ),
  					'ru'     => __( 'Russian', 'groupByLanguagePlugin' ),
  					'sk'     => __( 'Slovak', 'groupByLanguagePlugin' ),
  					'sl'     => __( 'Slovenian', 'groupByLanguagePlugin' ),
  					'sr'     => __( 'Serbian', 'groupByLanguagePlugin' ),
  					'sv'     => __( 'Swedish', 'groupByLanguagePlugin' ),
  					'tr'     => __( 'Turkish', 'groupByLanguagePlugin' ),
  					'uk'     => __( 'Ukrainian', 'groupByLanguagePlugin' ),
  					'vi'     => __( 'Vietnamese', 'groupByLanguagePlugin' ),
  					'zh'     => __( 'Chinese', 'groupByLanguagePlugin' )
            /*       OTHERS LANGUAGES:
  					'ka'     => __( 'Georgian', 'groupByLanguagePlugin' ),
  					'lu'     => __( 'Luba-Katanga', 'groupByLanguagePlugin' ),
  					'ps'     => __( 'Pushto; Pashto', 'groupByLanguagePlugin' ),
  					'rn'     => __( 'Rundi', 'groupByLanguagePlugin' ),
  					'si'     => __( 'Sinhala; Sinhalese', 'groupByLanguagePlugin' ),
  					'su'     => __( 'Sundanese', 'groupByLanguagePlugin' ),
  					'za'     => __( 'Zhuang; Chuang', 'groupByLanguagePlugin' ),
            */
  			);

    $requested_cuisine = isset( $_GET['cuisine'] ) ? wp_unslash( $_GET['cuisine'] ) : '';

    foreach ( $dropdown_languages as $cuisine => $label ) {
        $selected = selected( $cuisine, $requested_cuisine, false );          //add all languages to the dropdown menu
        printf( '<option%s>%s</option>', $selected, $label );
    }
    echo '</select>';
    return;
}

add_filter( 'ms_sites_list_table_query_args', 'efpm_sites_with_language_choosen_in_dropdown_menu' );
function efpm_sites_with_language_choosen_in_dropdown_menu( $args ) {
    if ( empty( $_GET['cuisine' ] ) ) {
        return $args;
    }

    $meta_query = array(
        'key'   => 'pb_language',
        'value' => translate_choice(wp_unslash( $_GET['cuisine' ] ))
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

function translate_choice($args){
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
					'nl'     => 'Nederlands',
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
          //OTHERS LANGUAGES
          // 'ka'     => 'Georgian', //not attribut flag icons right now
					// 'lu'     => 'Luba-Katanga', //not attribut flag icons right now
					// 'ps'     => 'Pushto; Pashto', //not attribut flag icons right now
					// 'rn'     => 'Rundi', //not attribut flag icons right now
					// 'si'     => 'Sinhala; Sinhalese', //not attribut flag icons right now
					// 'su'     => 'Sundanese', //not attribut flag icons right now
					// 'za'     => 'Zhuang; Chuang', //not attribut flag icons right now
			);
      foreach ($translateChoice as $key => $value) {
          if($args == $value) return $key;
      }
      return '';
	}

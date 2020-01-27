<?php
/**
 * Extensions for PressBooks / groupByLanguage Plugin
 *
 * This file is a functionality of Extensions for PressBooks Plugin. It creates a
 * new dropdown menu in the Admin Books page and gives the possibity to show in the
 * list only the books in a specific language (selected in the dropdown menu).
 *
 * @link              URL
 * @since             ???
 * @package           extensions-for-pressbooks
 */

/**
* This function create a new dropdown menu and it shows only available languages.
* If there's no books about a language, this language not appear in the dropdown menu.
*/

add_action( 'restrict_manage_sites', 'efppb_add_language_dropdown_menu' );
function efppb_add_language_dropdown_menu( $which ) {
    if ( 'top' !== $which ) {  // the dropdown menu must be on the top
        return;
    }
    echo '<select name="language">';
    printf( '<option value="">%s</option>', __( 'All languages', 'groupByLanguagePlugin' ) );  //print the button "All languages"
/**
* The query that return the list with all the languages in which at least one book has been written.
*/
    global $wpdb;
    $languages_from_db = $wpdb->get_results( "SELECT DISTINCT meta_value FROM $wpdb->blogmeta WHERE meta_key = 'pb_language'");
/**
* The list with all the languages of Pressbooks books.
*/
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
            /*       OTHERS LANGUAGES NOT AVAILABLE YET:
  					'ka'     => __( 'Georgian', 'groupByLanguagePlugin' ),
  					'lu'     => __( 'Luba-Katanga', 'groupByLanguagePlugin' ),
  					'ps'     => __( 'Pushto; Pashto', 'groupByLanguagePlugin' ),
  					'rn'     => __( 'Rundi', 'groupByLanguagePlugin' ),
  					'si'     => __( 'Sinhala; Sinhalese', 'groupByLanguagePlugin' ),
  					'su'     => __( 'Sundanese', 'groupByLanguagePlugin' ),
  					'za'     => __( 'Zhuang; Chuang', 'groupByLanguagePlugin' ),
            */
  			);
/*
* This is the core of the filter. There is the comparison beetween "query list"
* and "full list". If the language is available the flag = 1, else flag = 0.
* If flag = 0 the element is deleted from the list.
* query list => $languages_from_db. Languages name is potted (English = en).
* full list => $dropdown_languages.
*/
    foreach ($dropdown_languages as $key => $value) {
      $flag = 0;
      foreach ($languages_from_db as $lang) {
        if($key == $lang->meta_value) $flag = 1;
      }
      if($flag == 0) unset($dropdown_languages[$key]);
    }

    $requested_language = isset( $_GET['language'] ) ? wp_unslash( $_GET['language'] ) : '';

    foreach ( $dropdown_languages as $language => $label ) {
        $selected = selected( $language, $requested_language, false );          //add all languages to the dropdown menu
        printf( '<option%s>%s</option>', $selected, $label );                 //and print the full name of language
    }
    echo '</select>';
    return;
}
/**
* The filter function.
* It gets the choice of the user (full name of language) and transforms it
* in the potted name with the "translate_choice" function.
*/
add_filter( 'ms_sites_list_table_query_args', 'efpm_sites_with_language_choosen_in_dropdown_menu' );
function efpm_sites_with_language_choosen_in_dropdown_menu( $args ) {
    if ( empty( $_GET['language' ] ) ) {
        return $args;
    }

    $meta_query = array(
        'key'   => 'pb_language',
        'value' => translate_choice(wp_unslash( $_GET['language' ] ))
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

/**
* The function that translates full name in potted name.
*/

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
      return ''; //return an empty string if the language doesn't exist (that's impossible).
	}

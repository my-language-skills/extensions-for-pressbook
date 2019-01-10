<?php

/**
 * Package, which creates automatic translations relationships between books of official publisher and official translations
 *
 * @author Daniil Zhitnitskii (My Language Skills)
 */

add_action('wp_ajax_efp_mark_as_original', 'tre_update_trans_table', 2);
add_action('custom_metadata_manager_init_metadata', 'tre_create_language_box', 10);

/**
 * Function responsible for creation/updating translations table in database
 */
function tre_update_trans_table () {

	//security check
	if ( ! current_user_can( 'manage_network' ) || ! check_ajax_referer( 'pressbooks-aldine-admin' ) ) {
		return;
	}

	global $wpdb;

	$table_name = $wpdb->prefix . 'trans_rel';

	//>> check if the book was marked as translation of another book

	switch_to_blog($_POST['book_id']);

	$info_post_id = tre_get_info_post();

	$trans_lang = get_post_meta($info_post_id, 'efp_trans_language') ?: 'not_set';
	//<<

	switch_to_blog( 1 );

	//if book was marked as original, not unmarked
	if (1 == get_blog_option($_POST['book_id'], 'efp_publisher_is_original')){

		//if book was not marked as translation, create a new row in translations table
		if ($trans_lang == 'non_tr' || $trans_lang == 'not_set') {

			//if translations table doesn't exist, create
			if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {
				//table not in database. Create new table

				$charset_collate = $wpdb->get_charset_collate();

				$sql = "CREATE TABLE $table_name (
          		book_id bigint(20) NOT NULL,
          		UNIQUE KEY book_id (book_id)
     			) $charset_collate;";

				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
			}

			$wpdb->insert( $table_name, [ 'book_id' => absint( $_POST['book_id'] ) ] );

		} elseif(isset($trans_lang)) {
			//book is a translation, add it as a translation to original one

			//get translation's language
			switch_to_blog($_POST['book_id']);
			$lang = get_post_meta($info_post_id, 'pb_language', true);
			$origin = str_replace(['http://', 'https://'], '', get_post_meta($info_post_id, 'pb_is_based_on', true)).'/';

			//>> Add column if not present.
			switch_to_blog(1);
			$check = $wpdb->get_row("SELECT * FROM $table_name;");

			if(!isset($check->$lang)){
   			 	$wpdb->query("ALTER TABLE $table_name ADD $lang BIGINT(20);");
			}
			//<<

			$origin_id = $wpdb->get_results("SELECT `blog_id` FROM $wpdb->blogs WHERE CONCAT(`domain`, `path`) = '$origin'", ARRAY_A)[0]['blog_id'];
			
			$wpdb->query("UPDATE $table_name SET $lang = '$_POST[book_id]' WHERE `book_id` = '$origin_id';");

		}
	} else {

		if ($trans_lang == 'non_tr' || $trans_lang == 'not_set'){
			$trans = $wpdb->get_row("SELECT * FROM $table_name WHERE `book_id` = '$_POST[book_id]';", ARRAY_A);
			unset($trans['book_id']);
			$wpdb->query("DELETE FROM $table_name WHERE `book_id` = $_POST[book_id]");
			foreach ($trans as $tran){
				delete_blog_option($tran, 'efp_publisher_is_original');
			}
		} elseif (isset($trans_lang)) {
			switch_to_blog($_POST['book_id']);
			$origin = str_replace(['http://', 'https://'], '', get_post_meta($info_post_id, 'pb_is_based_on', true)).'/';
			$lang = get_post_meta($info_post_id, 'pb_language', true);
			switch_to_blog(1);
			$origin_id = $wpdb->get_results("SELECT `blog_id` FROM $wpdb->blogs WHERE CONCAT(`domain`, `path`) = '$origin'", ARRAY_A)[0]['blog_id'];
			$wpdb->query("UPDATE $table_name SET `$lang` = '' WHERE `book_id` = '$origin_id';");
		}

	}
}


/**
 * Function for producing metabox for selecting translation language
 */
function tre_create_language_box () {
	
	if (get_post_meta(tre_get_info_post(),'pb_is_based_on')) {

		x_add_metadata_group( 'efp_trans', 'metadata', array(
			'label'    => 'Studying content',
			'priority' => 'high'
		) );

		x_add_metadata_field( 'efp_trans_language', 'metadata', array(
				'group'            => 'efp_trans',
				'field_type'       => 'select',
				'values'           => [
					'non_tr' => 'Not translation',
					'ab'     => 'Abkhazian',
					'aa'     => 'Afar',
					'af'     => 'Afrikaans',
					'ak'     => 'Akan',
					'sq'     => 'Albanian',
					'am'     => 'Amharic',
					'ar'     => 'Arabic',
					'an'     => 'Aragonese',
					'hy'     => 'Armenian',
					'as'     => 'Assamese',
					'av'     => 'Avaric',
					'ae'     => 'Avestan',
					'ay'     => 'Aymara',
					'az'     => 'Azerbaijani',
					'bm'     => 'Bambara',
					'ba'     => 'Bashkir',
					'eu'     => 'Basque',
					'be'     => 'Belarusian',
					'bn'     => 'Bengali',
					'bh'     => 'Bihari languages',
					'bi'     => 'Bislama',
					'nb'     => 'Bokmål, Norwegian; Norwegian Bokmål',
					'bs'     => 'Bosnian',
					'br'     => 'Breton',
					'bg'     => 'Bulgarian',
					'my'     => 'Burmese',
					'km'     => 'Central Khmer',
					'ch'     => 'Chamorro',
					'ce'     => 'Chechen',
					'ny'     => 'Chichewa; Chewa; Nyanja',
					'zh'     => 'Chinese',
					'cv'     => 'Chuvash',
					'kw'     => 'Cornish',
					'co'     => 'Corsican',
					'cr'     => 'Cree',
					'hr'     => 'Croatian',
					'cs'     => 'Czech',
					'da'     => 'Danish',
					'nl'     => 'Dutch; Flemish',
					'dz'     => 'Dzongkha',
					'en'     => 'English',
					'eo'     => 'Esperanto',
					'et'     => 'Estonian',
					'ee'     => 'Ewe',
					'fo'     => 'Faroese',
					'fj'     => 'Fijian',
					'fi'     => 'Finnish',
					'fr'     => 'French',
					'ff'     => 'Fulah',
					'gd'     => 'Gaelic',
					'gl'     => 'Galician',
					'lg'     => 'Ganda',
					'ka'     => 'Georgian',
					'de'     => 'German',
					'el'     => 'Greek',
					'gn'     => 'Guarani',
					'gu'     => 'Gujarati',
					'ht'     => 'Haitian',
					'ha'     => 'Hausa',
					'he'     => 'Hebrew',
					'hz'     => 'Herero',
					'hi'     => 'Hindi',
					'ho'     => 'Hiri Motu',
					'hu'     => 'Hungarian',
					'is'     => 'Icelandic',
					'io'     => 'Ido',
					'ig'     => 'Igbo',
					'id'     => 'Indonesian',
					'iu'     => 'Inuktitut',
					'ik'     => 'Inupiaq',
					'ga'     => 'Irish',
					'it'     => 'Italian',
					'ja'     => 'Japanese',
					'jv'     => 'Javanese',
					'kl'     => 'Kalaallisut; Greenlandic',
					'kn'     => 'Kannada',
					'kr'     => 'Kanuri',
					'ks'     => 'Kashmiri',
					'kk'     => 'Kazakh',
					'ki'     => 'Kikuyu; Gikuyu',
					'rw'     => 'Kinyarwanda',
					'ky'     => 'Kirghiz; Kyrgyz',
					'kv'     => 'Komi',
					'kg'     => 'Kongo',
					'ko'     => 'Korean',
					'kj'     => 'Kuanyama; Kwanyama',
					'ku'     => 'Kurdish',
					'lo'     => 'Lao',
					'la'     => 'Latin',
					'lv'     => 'Latvian',
					'li'     => 'Limburgan; Limburger; Limburgish',
					'ln'     => 'Lingala',
					'lt'     => 'Lithuanian',
					'lu'     => 'Luba-Katanga',
					'lb'     => 'Luxembourgish; Letzeburgesch',
					'mk'     => 'Macedonian',
					'mg'     => 'Malagasy',
					'ms'     => 'Malay',
					'ml'     => 'Malayalam',
					'dv'     => 'Maldivian',
					'mt'     => 'Maltese',
					'gv'     => 'Manx',
					'mi'     => 'Maori',
					'mr'     => 'Marathi',
					'mh'     => 'Marshallese',
					'mn'     => 'Mongolian',
					'na'     => 'Nauru',
					'nv'     => 'Navajo; Navaho',
					'nd'     => 'Ndebele, North; North Ndebele',
					'nr'     => 'Ndebele, South; South Ndebele',
					'ng'     => 'Ndonga',
					'ne'     => 'Nepali',
					'no'     => 'Norwegian',
					'nn'     => 'Norwegian Nynorsk; Nynorsk, Norwegian',
					'oc'     => 'Occitan; Provençal',
					'oj'     => 'Ojibwa',
					'or'     => 'Oriya',
					'om'     => 'Oromo',
					'os'     => 'Ossetian; Ossetic',
					'pi'     => 'Pali',
					'pa'     => 'Panjabi; Punjabi',
					'fa'     => 'Persian',
					'pl'     => 'Polish',
					'pt'     => 'Portuguese',
					'ps'     => 'Pushto; Pashto',
					'qu'     => 'Quechua',
					'ro'     => 'Romanian; Moldavian; Moldovan',
					'rm'     => 'Romansh',
					'rn'     => 'Rundi',
					'ru'     => 'Russian',
					'sn'     => 'Shona',
					'sm'     => 'Samoan',
					'sg'     => 'Sango',
					'sa'     => 'Sanskrit',
					'sc'     => 'Sardinian',
					'sr'     => 'Serbian',
					'ii'     => 'Sichuan Yi',
					'sd'     => 'Sindhi',
					'si'     => 'Sinhala; Sinhalese',
					'sk'     => 'Slovak',
					'sl'     => 'Slovenian',
					'so'     => 'Somali',
					'st'     => 'Sotho, Southern',
					'es'     => 'Spanish',
					'su'     => 'Sundanese',
					'sw'     => 'Swahili',
					'ss'     => 'Swati',
					'sv'     => 'Swedish',
					'tl'     => 'Tagalog',
					'tg'     => 'Tajik',
					'ty'     => 'Tahitian',
					'ta'     => 'Tamil',
					'tt'     => 'Tatar',
					'te'     => 'Telugu',
					'th'     => 'Thai',
					'bo'     => 'Tibetan',
					'ti'     => 'Tigrinya',
					'to'     => 'Tonga',
					'tn'     => 'Tswana',
					'tr'     => 'Turkish',
					'tk'     => 'Turkmen',
					'tw'     => 'Twi',
					'ug'     => 'Uighur; Uyghur',
					'ur'     => 'Urdu',
					'uk'     => 'Ukrainian',
					'uz'     => 'Uzbek',
					'vl'     => 'Valencian',
					've'     => 'Venda',
					'vi'     => 'Vietnamese',
					'vo'     => 'Volapük',
					'wa'     => 'Walloon',
					'cy'     => 'Welsh',
					'fy'     => 'Western Frisian',
					'wo'     => 'Wolof',
					'xh'     => 'Xhosa',
					'yi'     => 'Yiddish',
					'yo'     => 'Yoruba',
					'za'     => 'Zhuang; Chuang',
					'zu'     => 'Zulu'
					/* code organization (before language organization)				
					'aa'     => 'Afar',
					'ab'     => 'Abkhazian',
					'ae'     => 'Avestan',
					'af'     => 'Afrikaans',
					'ak'     => 'Akan',
					'am'     => 'Amharic',
					'an'     => 'Aragonese',
					'ar'     => 'Arabic',
					'as'     => 'Assamese',
					'av'     => 'Avaric',
					'ay'     => 'Aymara',
					'az'     => 'Azerbaijani',
					'ba'     => 'Bashkir',
					'be'     => 'Belarusian',
					'bg'     => 'Bulgarian',
					'bh'     => 'Bihari languages',
					'bm'     => 'Bambara',
					'bi'     => 'Bislama',
					'bn'     => 'Bengali',
					'bo'     => 'Tibetan',
					'br'     => 'Breton',
					'bs'     => 'Bosnian',
					'ce'     => 'Chechen',
					'ch'     => 'Chamorro',
					'co'     => 'Corsican',
					'cr'     => 'Cree',
					'cs'     => 'Czech',
					'cv'     => 'Chuvash',
					'cy'     => 'Welsh',
					'da'     => 'Danish',
					'de'     => 'German',
					'dv'     => 'Maldivian',
					'dz'     => 'Dzongkha',
					'ee'     => 'Ewe',
					'el'     => 'Greek',
					'en'     => 'English',
					'eo'     => 'Esperanto',
					'es'     => 'Spanish',
					'et'     => 'Estonian',
					'eu'     => 'Basque',
					'fa'     => 'Persian',
					'ff'     => 'Fulah',
					'fi'     => 'Finnish',
					'fj'     => 'Fijian',
					'fo'     => 'Faroese',
					'fr'     => 'French',
					'fy'     => 'Western Frisian',
					'ga'     => 'Irish',
					'gd'     => 'Gaelic',
					'gl'     => 'Galician',
					'gn'     => 'Guarani',
					'gu'     => 'Gujarati',
					'gv'     => 'Manx',
					'ha'     => 'Hausa',
					'he'     => 'Hebrew',
					'hi'     => 'Hindi',
					'ho'     => 'Hiri Motu',
					'hr'     => 'Croatian',
					'ht'     => 'Haitian',
					'hu'     => 'Hungarian',
					'hy'     => 'Armenian',
					'hz'     => 'Herero',
					'ia'     => 'Interlingua',
					'id'     => 'Indonesian',
					'ie'     => 'Interlingue',
					'ig'     => 'Igbo',
					'ii'     => 'Sichuan Yi',
					'ik'     => 'Inupiaq',
					'io'     => 'Ido',
					'is'     => 'Icelandic',
					'it'     => 'Italian',
					'iu'     => 'Inuktitut',
					'ja'     => 'Japanese',
					'jv'     => 'Javanese',
					'ka'     => 'Georgian',
					'kg'     => 'Kongo',
					'ki'     => 'Kikuyu; Gikuyu',
					'kj'     => 'Kuanyama; Kwanyama',
					'kk'     => 'Kazakh',
					'kl'     => 'Kalaallisut; Greenlandic',
					'km'     => 'Central Khmer',
					'kn'     => 'Kannada',
					'ko'     => 'Korean',
					'kr'     => 'Kanuri',
					'ks'     => 'Kashmiri',
					'ku'     => 'Kurdish',
					'kv'     => 'Komi',
					'kw'     => 'Cornish',
					'ky'     => 'Kirghiz; Kyrgyz',
					'la'     => 'Latin',
					'lb'     => 'Luxembourgish; Letzeburgesch',
					'lg'     => 'Ganda',
					'li'     => 'Limburgan; Limburger; Limburgish',
					'ln'     => 'Lingala',
					'lo'     => 'Lao',
					'lt'     => 'Lithuanian',
					'lu'     => 'Luba-Katanga',
					'lv'     => 'Latvian',
					'mg'     => 'Malagasy',
					'mh'     => 'Marshallese',
					'mi'     => 'Maori',
					'mk'     => 'Macedonian',
					'ml'     => 'Malayalam',
					'mn'     => 'Mongolian',
					'mr'     => 'Marathi',
					'ms'     => 'Malay',
					'mt'     => 'Maltese',
					'my'     => 'Burmese',
					'na'     => 'Nauru',
					'nb'     => 'Bokmål, Norwegian; Norwegian Bokmål',
					'nd'     => 'Ndebele, North; North Ndebele',
					'ne'     => 'Nepali',
					'ng'     => 'Ndonga',
					'nl'     => 'Dutch; Flemish',
					'nn'     => 'Norwegian Nynorsk; Nynorsk, Norwegian',
					'no'     => 'Norwegian',
					'nr'     => 'Ndebele, South; South Ndebele',
					'nv'     => 'Navajo; Navaho',
					'ny'     => 'Chichewa; Chewa; Nyanja',
					'oc'     => 'Occitan; Provençal',
					'oj'     => 'Ojibwa',
					'om'     => 'Oromo',
					'or'     => 'Oriya',
					'os'     => 'Ossetian; Ossetic',
					'pa'     => 'Panjabi; Punjabi',
					'pi'     => 'Pali',
					'pl'     => 'Polish',
					'ps'     => 'Pushto; Pashto',
					'pt'     => 'Portuguese',
					'qu'     => 'Quechua',
					'rm'     => 'Romansh',
					'rn'     => 'Rundi',
					'ro'     => 'Romanian; Moldavian; Moldovan',
					'ru'     => 'Russian',
					'rw'     => 'Kinyarwanda',
					'sa'     => 'Sanskrit',
					'sc'     => 'Sardinian',
					'sd'     => 'Sindhi',
					'se'     => 'Northern Sami',
					'sg'     => 'Sango',
					'si'     => 'Sinhala; Sinhalese',
					'sk'     => 'Slovak',
					'sl'     => 'Slovenian',
					'sm'     => 'Samoan',
					'sn'     => 'Shona',
					'so'     => 'Somali',
					'sq'     => 'Albanian',
					'sr'     => 'Serbian',
					'ss'     => 'Swati',
					'st'     => 'Sotho, Southern',
					'su'     => 'Sundanese',
					'sv'     => 'Swedish',
					'sw'     => 'Swahili',
					'ta'     => 'Tamil',
					'te'     => 'Telugu',
					'tg'     => 'Tajik',
					'th'     => 'Thai',
					'ti'     => 'Tigrinya',
					'tk'     => 'Turkmen',
					'tl'     => 'Tagalog',
					'tn'     => 'Tswana',
					'to'     => 'Tonga',
					'tr'     => 'Turkish',
					'ts'     => 'Tsonga',
					'tt'     => 'Tatar',
					'tw'     => 'Twi',
					'ty'     => 'Tahitian',
					'ug'     => 'Uighur; Uyghur',
					'uk'     => 'Ukrainian',
					'ur'     => 'Urdu',
					'uz'     => 'Uzbek',
					'vl'     => 'Valencian',
					've'     => 'Venda',
					'vi'     => 'Vietnamese',
					'vo'     => 'Volapük',
					'wa'     => 'Walloon',
					'wo'     => 'Wolof',
					'xh'     => 'Xhosa',
					'yi'     => 'Yiddish',
					'yo'     => 'Yoruba',
					'za'     => 'Zhuang; Chuang',
					'zh'     => 'Chinese',
					'zu'     => 'Zulu'
					*/
				],
				'label'            => 'Language',
				'description'      => 'Choose language, which original book is about (if current book is original, choose "Not translation option")',
				'display_callback' => ''
			)
		);
	}
}

/**
 * Function for getting book info post ID
 */
function tre_get_info_post () {

	global $wpdb;
	$info_post = $wpdb->get_results("SELECT `ID` FROM $wpdb->posts WHERE `post_type` = 'metadata' LIMIT 1", ARRAY_A);

	return isset($info_post[0]['ID']) ? $info_post[0]['ID'] : 0;

}


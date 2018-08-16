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
          		id bigint(20) NOT NULL,
          		UNIQUE KEY id (id)
     			) $charset_collate;";

				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
			}

			$wpdb->insert( $table_name, [ 'id' => absint( $_POST['book_id'] ) ] );

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
			
			$wpdb->query("UPDATE $table_name SET $lang = '$_POST[book_id]' WHERE `id` = '$origin_id';");

		}
	} else {

		if ($trans_lang == 'non_tr' || $trans_lang == 'not_set'){
			$trans = $wpdb->get_row("SELECT * FROM $table_name WHERE `id` = '$_POST[book_id]';", ARRAY_A);
			unset($trans['id']);
			$wpdb->query("DELETE FROM $table_name WHERE `id` = $_POST[book_id]");
			foreach ($trans as $tran){
				delete_blog_option($tran, 'efp_publisher_is_original');
			}
		} elseif (isset($trans_lang)) {
			switch_to_blog($_POST['book_id']);
			$origin = str_replace(['http://', 'https://'], '', get_post_meta($info_post_id, 'pb_is_based_on', true)).'/';
			$lang = get_post_meta($info_post_id, 'pb_language', true);
			switch_to_blog(1);
			$origin_id = $wpdb->get_results("SELECT `blog_id` FROM $wpdb->blogs WHERE CONCAT(`domain`, `path`) = '$origin'", ARRAY_A)[0]['blog_id'];
			$wpdb->query("UPDATE $table_name SET `$lang` = '' WHERE `id` = '$origin_id';");
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

	return $info_post[0]['ID'];

}


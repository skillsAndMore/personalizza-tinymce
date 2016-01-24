<?php
/*
Plugin Name: Personalizza TinyMCE 4
Plugin URI: http://wpandmore.info/personalizza-tinymce/
Description: Con questo plugin desidero mostrare quanto sia semplice personalizzare l'editor di testo presente in WordPress
Version: 1.0
Author: Andrea Barghigiani
Author URI: http://wpandmore.info
License: GPL2 (o anche 3 va bene)
*/

// 1. Attivo la selezione del font size e della famiglia nell'editor
if ( ! function_exists( 'ptmce_mce_buttons' ) ) {
	function ptmce_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Aggiungo la Selezione del Font
		array_unshift( $buttons, 'fontsizeselect' ); // Aggiungo la Selezione delle Dimensioni
		return $buttons;
	}
}
add_filter( 'mce_buttons_2', 'ptmce_mce_buttons' );

// 2. Inserisci Grandezze Font Personalizzate
if ( ! function_exists( 'ptmce_mce_text_sizes' ) ) {
	function ptmce_mce_text_sizes( $initArray ){
		$initArray['fontsize_formats'] = "12px 14px 16px 18px 21px 24px 28px 32px 36px 50px";
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'ptmce_mce_text_sizes' );

// 3. Rimuovo delle Famiglie alla Lista Font
if ( ! function_exists( 'ptmce_mce_fonts_array' ) ) {
	function ptmce_mce_fonts_array( $initArray ) {
		$initArray['font_formats'] = 'Arial=arial,helvetica,sans-serif;Helvetica=helvetica;Impact=impact,chicago;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
		return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'ptmce_mce_fonts_array' );

// 4. Aggiungo delle Famiglie Personalizzate alla Lista Font
if ( ! function_exists( 'ptmce_mce_google_fonts_array' ) ) {
	function ptmce_mce_google_fonts_array( $initArray ) {
	    $initArray['font_formats'] = 'Roboto=Roboto;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
            return $initArray;
	}
}
add_filter( 'tiny_mce_before_init', 'ptmce_mce_google_fonts_array' );

// 5. Aggiungo il CSS per usare il Google Font 
if ( ! function_exists( 'ptmce_mce_google_fonts_styles' ) ) {
	function ptmce_mce_google_fonts_styles() {
	   $font_url = 'http://fonts.googleapis.com/css?family=Lato:300,400,700';
           add_editor_style( str_replace( ',', '%2C', $font_url ) );
	}
}
add_action( 'init', 'ptmce_mce_google_fonts_styles' );

// 6. Aggiungo un Menu Dropdown
if ( ! function_exists( 'ptmce_style_select' ) ) {
	function ptmce_style_select( $buttons ) {
		array_push( $buttons, 'styleselect' );
		return $buttons;
	}
}
add_filter( 'mce_buttons', 'ptmce_style_select' );

// 7. Aggiungo una Nuova Voce al menu a tendina Formati
if ( ! function_exists( 'ptmce_styles_dropdown' ) ) {
	function ptmce_styles_dropdown( $settings ) {

		// Creo un array contenente i Nuovi Stili
		$new_styles = array(
			array(
				'title'	=> __( 'Stili Personalizzati', 'ptmce' ),
				'items'	=> array(
					array(
						'title'		=> __('Bottone','ptmce'),
						'selector'	=> 'a',
						'classes'	=> 'btn'
					),
					array(
						'title'		=> __('Evidenzia','ptmce'),
						'inline'	=> 'span',
						'classes'	=> 'highlight',
					),
				),
			),
		);

		// Opzione per Fondere i Vecchi e i Nuovi Stili
		$settings['style_formats_merge'] = true;

		// Aggiungo i Nuovi Stili
		$settings['style_formats'] = json_encode( $new_styles );

		// Restituisco le nuove impostazioni
		return $settings;

	}
}
add_filter( 'tiny_mce_before_init', 'ptmce_styles_dropdown' );
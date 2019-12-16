<?php
/*
Plugin Name: WP Smart Rating
Plugin URI: https://github.com/smartDevel/wp-smart-rate
Description: Add Ratings to your post or Page with a shortcode
Version: 1.0
Author: Herbert Sablotny
Author URI: https://ways4.eu
Text Domain: wp-smart-rate
Domain Path: /languages
*/

//Security
//zunächst prüfen ob die Wordpress- Konstante ABSPATH gesetzt ist, sonst unbefugter (wordpress-fremder) Zugriff und exit
if (!defined( 'ABSPATH')) exit;

//Übersetzungen aufrufen
add_action( 'plugins_loaded', 'wp_smart_rate_text_domain' );

function wp_smart_rate_text_domain() {
    load_plugin_textdomain( 'wp-smart-rate', false, plugin_basename( dirname(__FILE__ )) . '/languages' );
}

//Einbinden notwendiger PHP-Dateien
include('inc/scripts.php');
include('inc/metabox.php');
include('inc/shortcodes.php');

?>

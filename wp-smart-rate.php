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

//Einbinden notwendiger PHP-Dateien
include('inc/scripts.php');
include('inc/metabox.php');
include('inc/shortcodes.php');

?>

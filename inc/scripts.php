<?php
//Security
//zunächst prüfen ob die Wordpress- Konstante ABSPATH gesetzt ist, sonst unbefugter (wordpress-fremder) Zugriff und exit
if (!defined( 'ABSPATH')) exit;

//Hinzufügen der Scripte und Styles für das Backend
add_action( 'admin_enqueue_scripts', 'load_admin_scripts');
function load_admin_scripts() {

    //Stylesheet für admin-seite registrieren und einbinden
    wp_register_style( 'custom_admin_css', plugins_url( '../assets/css/admin.css', __FILE__ ));
    wp_enqueue_style( 'custom_admin_css' );

    //mediathek einbinden
    wp_enqueue_media();
    //registrieren des JScrpit-Files
    wp_register_script( 'custom_admin_js', plugins_url('../assets/js/admin.js', __FILE__), array('jquery'));
    //einbinden des JScript-Files
    wp_enqueue_script('custom_admin_js'); 
    //einbinden des Color-Picker
    wp_enqueue_style('wp-color-picker');
    //registrieren des JScrpit-Files für color picker
    wp_register_script( 'color_picker_js', plugins_url('../assets/js/color-picker.js', __FILE__), array('jquery', 'wp-color-picker'));
    //einbinden des JScript-Files
    wp_enqueue_script('color_picker_js'); 
};

//Hinzufügen der Skripte und STyles für das Frontend
add_action( 'wp_enqueue_scripts', 'load_frontend_scripts' );
function load_frontend_scripts() {
   //registrieren des JScrpit-Files für Frontend
   wp_register_script( 'custom_frontend_js', plugins_url('../assets/js/front.js', __FILE__), array('jquery'));
   //einbinden des JScript-Files für Frontend
   wp_enqueue_script('custom_frontend_js'); 

    //Stylesheet für frontend-seite registrieren und einbinden
    wp_register_style( 'custom_frontend_css', plugins_url( '../assets/css/front.css', __FILE__ ));
    wp_enqueue_style( 'custom_frontend_css' );
  
};

?>
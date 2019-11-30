<?php
//Security
//zunächst prüfen ob die Wordpress- Konstante ABSPATH gesetzt ist, sonst unbefugter (wordpress-fremder) Zugriff und exit
if (!defined( 'ABSPATH')) exit;
add_shortcode( 'wp_smart_rate', 'wp_smart_rate_display' );
function wp_smart_rate_display ($atts, $content = null) {
$str_output = 'mein erster shortcode in wordpress: ';
$str_output .= '<strong>' . $content . '</strong>';
return $str_output;
}

?>
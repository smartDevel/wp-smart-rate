<?php
//Security
//zunächst prüfen ob die Wordpress- Konstante ABSPATH gesetzt ist, sonst unbefugter (wordpress-fremder) Zugriff und exit
if (!defined( 'ABSPATH')) exit;
add_shortcode( 'wp_smart_rate', 'wp_smart_rate_display' );

function wp_smart_rate_display ($atts, $content = null) {
$post_id = $atts['id'];
$html_output = '';
$html_output .= '
                    <div class="smart-rate-container">
                        <div class="smart-rate-title-bg">
                            <div class="smart-rate-title">
                            ' . esc_html(get_post_meta( $post_id, 'wp_smart_rate_title', true )) . '
                            </div>
                        </div>

                        ';
                        $src= esc_html(get_post_meta( $post_id, 'wp_smart_rate_image', true ));
                        $html_output .= '
                        <div class="smart-rate-image">
                            <a target= "_blank" href= "' . esc_html(get_post_meta( $post_id, 'wp_smart_rate_buttonlink', true )) . '">
                            <img src="' . $src . '" />
                            </a> 
                        </div>


                    </div>
';
return $html_output;
}
?>
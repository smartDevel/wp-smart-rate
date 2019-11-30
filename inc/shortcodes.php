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
                    </div>
';
return $html_output;
}

?>
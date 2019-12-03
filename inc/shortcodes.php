<?php
//Security
//zunächst prüfen ob die Wordpress- Konstante ABSPATH gesetzt ist, sonst unbefugter (wordpress-fremder) Zugriff und exit
if (!defined( 'ABSPATH')) exit;
add_shortcode( 'wp_smart_rate', 'wp_smart_rate_display' );

function wp_smart_rate_display ($atts, $content = null) {
$post_id = $atts['id'];

//leeren der html-output-variablen
$html_output = '';

//vorbereiten ausgabe smart-rate Titel
$html_output .= '
                    <div class="smart-rate-container">
                        <div class="smart-rate-title-bg">
                            <div class="smart-rate-title">
                            ' . esc_html(get_post_meta( $post_id, 'wp_smart_rate_title', true )) . '
                            </div>
                        </div>

                        ';
                        $src= esc_html(get_post_meta( $post_id, 'wp_smart_rate_image', true )); //vorbereitung output und verlinkung des smart-rate- Bild
                        $html_output .= '
                        <div class="smart-rate-image">
                            <a target= "_blank" href= "' . esc_html(get_post_meta( $post_id, 'wp_smart_rate_buttonlink', true )) . '">
                            <img src="' . $src . '" />
                            </a> 
                        </div>
                    ';
                    //ungeordnete Pro- und Kontra-Listen
                    $html_output .= '
                        <div class="smart-rate-pro">
                            <div class="smart-rate-pro-heading" > ' . __( 'Pro', 'wp-smart-rate') . '</div>
                            <ul>
                            ';
                            $complete = explode("\n", esc_html(get_post_meta( $post_id, 'wp_smart_rate_pro', true )));
                            foreach ($complete as $listitem){
                                if (trim($listitem) == '') {
                                    continue;                                
                                }
                                $html_output .= '<li>' . $listitem . '</li>';
                            }
                            $html_output .= '
                            </ul>
                        </div>';

                        $html_output .= '
                        <div class="smart-rate-con">
                            <div class="smart-rate-con-heading" > ' . __( 'Contra', 'wp-smart-rate') . '</div>
                            <ul>
                            ';
                            $complete = explode("\n", esc_html(get_post_meta( $post_id, 'wp_smart_rate_con', true )));
                            foreach ($complete as $listitem){
                                if (trim($listitem) == '') {
                                    continue;                                
                                }
                                $html_output .= '<li>' . $listitem . '</li>';
                            }
                            $html_output .= '
                            </ul>
                        </div>

                </div>
                    ';
return $html_output;
}
?>
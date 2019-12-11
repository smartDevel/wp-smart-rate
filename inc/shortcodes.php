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
                        ';
                        $percent = (float) get_post_meta( $post_id, 'wp_smart_rate_percent', true );
                        
                        //umrechnung prozent in sterne
                        $stars = round( $percent / 20, 1 );
                        //volle sterne
                        $starsFull = floor($stars);
                        //halbe sterne
                        $starsHalf = round (($stars - $starsFull),0);
                        //leere sterne
                        $starsEmpty = 5 - $starsFull - $starsHalf;
                        //Farbe der Sterne werden entsprechend der Button Backgroundcolor gesetzt
                        $starsColor =  get_post_meta( $post_id, 'wp_smart_rate_button_background_color', true );




                        if (get_post_meta($post_id, 'wp_smart_rate_stars_ck', true ) === null) {
                            //Balkenbewertung
                            $html_output .= 
                            '
                            <div class="smart-rate-bottom">
                                <div class="smart-rate-percent-number">' . $percent . '% </div>
                                    <div class="smart-rate-percent">
                                        <div class="smart-rate-bar-bg">
                                            <div class="smart-rate-bar" style="width:' . $percent . '%"></div>
                                        </div>
                                    </div>
                            </div>
                            ';

                        }
                        else {
                            //Sternebewertung

                            $html_output .= '
                            <div class="smart-rate-bottom">
                            <div class="smart-rate-result">' . __('Result:', 'wp-smart-rate') . 
                                '</div>
                                <div class="smart-rate-star-rating" style="color:'. $starsColor . '" title="' . $stars . __( ' of 5 stars', 'wp-smart-rate' ) . '">
                            ';
                            //volle sterne
                            for ($i = 1; $i<=$starsFull; $i++) {
                                $html_output .= '<div class="star star-full"></div>';
                            };
                            //halbe sterne
                            for ($i = 1; $i<=$starsHalf; $i++) {
                                $html_output .= '<div class="star star-half"></div>';
                            };
                            //leere sterne
                            for ($i = 1; $i<=$starsEmpty; $i++) {
                                $html_output .= '<div class="star star-empty"></div>';
                            };
                            // ende div sterne bewertung
            				$html_output .=
			            	'</div>';

                            //ende div bottom
                            $html_output .= '</div>';
                        }
                    $html_output .= '
                    <div class="smart-rate-button-text">
                        <a target="_blank" href="' . esc_html(get_post_meta( $post_id, 'wp_smart_rate_buttonlink', true )) . '" class="smart-rate-button-btn1">
                        ' . esc_html(get_post_meta( $post_id, 'wp_smart_rate_buttontext', true )) . '
                        </a>
                    
                    </div>'; 

                 // Ende div container
                $html_output .= '
                </div>
                    ';
return $html_output;
}
?>
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


add_action( 'admin_enqueue_scripts', 'load_admin_scripts');
function load_admin_scripts() {
    //mediathek einbinden
    wp_enqueue_media();
    //registrieren des JScrpit-Files
    wp_register_script( 'custom_admin_js', plugins_url('/assets/js/admin.js', __FILE__), array('jquery'));
    //einbinden des JScript-Files
    wp_enqueue_script('custom_admin_js'); 
    //einbinden des Color-Picker
    wp_enqueue_style('wp-color-picker');
    //registrieren des JScrpit-Files für color picker
    wp_register_script( 'color_picker_js', plugins_url('/assets/js/color-picker.js', __FILE__), array('jquery', 'wp-color-picker'));
    //einbinden des JScript-Files
    wp_enqueue_script('color_picker_js'); 
}




// Register Custom Post Type
function wp_smart_rate_add_post_type() {

	$labels = array(
		'name'                  => _x( 'SmartRatings', 'Post Type General Name', 'wp-smart-rate' ),
		'singular_name'         => _x( 'SmartRating', 'Post Type Singular Name', 'wp-smart-rate' ),
		'menu_name'             => __( 'SmartRatings', 'wp-smart-rate' ),
		'name_admin_bar'        => __( 'SmartRatings', 'wp-smart-rate' ),
		'archives'              => __( 'Item Archives', 'wp-smart-rate' ),
		'attributes'            => __( 'Item Attributes', 'wp-smart-rate' ),
		'parent_item_colon'     => __( 'Parent Item:', 'wp-smart-rate' ),
		'all_items'             => __( 'All Items', 'wp-smart-rate' ),
		'add_new_item'          => __( 'Add New Item', 'wp-smart-rate' ),
		'add_new'               => __( 'Add New', 'wp-smart-rate' ),
		'new_item'              => __( 'New Item', 'wp-smart-rate' ),
		'edit_item'             => __( 'Edit Item', 'wp-smart-rate' ),
		'update_item'           => __( 'Update Item', 'wp-smart-rate' ),
		'view_item'             => __( 'View Item', 'wp-smart-rate' ),
		'view_items'            => __( 'View Items', 'wp-smart-rate' ),
		'search_items'          => __( 'Search Item', 'wp-smart-rate' ),
		'not_found'             => __( 'Not found', 'wp-smart-rate' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'wp-smart-rate' ),
		'featured_image'        => __( 'Featured Image', 'wp-smart-rate' ),
		'set_featured_image'    => __( 'Set featured image', 'wp-smart-rate' ),
		'remove_featured_image' => __( 'Remove featured image', 'wp-smart-rate' ),
		'use_featured_image'    => __( 'Use as featured image', 'wp-smart-rate' ),
		'insert_into_item'      => __( 'Insert into item', 'wp-smart-rate' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'wp-smart-rate' ),
		'items_list'            => __( 'Items list', 'wp-smart-rate' ),
		'items_list_navigation' => __( 'Items list navigation', 'wp-smart-rate' ),
		'filter_items_list'     => __( 'Filter items list', 'wp-smart-rate' ),
	);
	$args = array(
		'label'                 => __( 'SmartRating', 'wp-smart-rate' ),
		'description'           => __( 'Add Ratings to your post or Page with a shortcode', 'wp-smart-rate' ),
		'labels'                => $labels,
		'supports'              => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'wp_smart_rate', $args );

}
add_action( 'init', 'wp_smart_rate_add_post_type', 0 );
add_action('add_meta_boxes', 'wp_smart_rate_add_custom_meta_box');
function wp_smart_rate_add_custom_meta_box() {
    add_meta_box(
        'wp_smart_rate_editor',
        __('Smart Rating', 'wp-smart-rate' ),
        'wp_smart_rate_editor',
        'wp_smart_rate', //nur anzeigen bei diesem post-type
        'advanced', //positionierung
        'high' //priorität

    );    
}
function wp_smart_rate_editor ($post){

    //Security: nonce- Field (eindeutige Nummer) wird als hidden-field gesetzt und bei save-funktion abgefragt
    wp_nonce_field( 'wp_smart_rate_meta_box_data','wp_smart_rate_meta_box_nonce');
    
    //Hier wird der Output der metabox vorbereitet
    //Bei den in den JS-Scripten referenzierten Feldern wie wp_smart_rate_uploadButton und wp_smart_rate_image ist 
    // die Angabe einer gleichlautenden id erforderlich.
    $output = '
    <table class="form-table"><tbody>
        
        <!--Shortcode- Textfield -->
        <tr>
            <th scope="row"><label for="wp_smart_rate_shortcode">' . __('Shortcode', 'wp-smart-rate') . '</label></th>
            <td><input type="text" name="wp_smart_rate_shortcode" value="[wp_smart_rate id=\'' . $post->ID . '\']" /></td>            
        </tr>
        
        <!--Title- Textfield -->
        <tr>
            <th scope="row"><label for="wp_smart_rate_title">' . __('Title', 'wp-smart-rate') . '</label></th>
            <td><input type="text" name="wp_smart_rate_title" value="' . esc_html(get_post_meta( $post->ID, 'wp_smart_rate_title', true )) . '" /></td>        
        </tr>
        
        <!--Image- URL & Upload -->
        <tr>
            <th scope="row"><label for="wp_smart_rate_image">' . __('Image', 'wp-smart-rate') . '</label></th>
            <td><input type="text" name="wp_smart_rate_image" id="wp_smart_rate_image" value="' . esc_html(get_post_meta( $post->ID, 'wp_smart_rate_image', true )) . '" />
            <input type="button" id="wp_smart_rate_uploadButton" value="' . __('Upload', 'wp-smart-rate') . '" data-uploader_title="Choose Image" data-uploader_button_text="Save" />  </td>    
        </tr> 
        
        <!--Pro & Kontra Textfields -->
        <tr>
            <th scope="row"><label for="wp_smart_rate_pro">' . __('Pro', 'wp-smart-rate') . '</label></th>
            <td><textarea name="wp_smart_rate_pro" id="wp_smart_rate_pro" rows="6">' . esc_html(get_post_meta( $post->ID, 'wp_smart_rate_pro', true )) . '</textarea></td>    
        </tr>                   
        <tr>
            <th scope="row"><label for="wp_smart_rate_con">' . __('Contra', 'wp-smart-rate') . '</label></th>
            <td><textarea name="wp_smart_rate_con" id="wp_smart_rate_con" rows="6">' . esc_html(get_post_meta( $post->ID, 'wp_smart_rate_con', true )) . '</textarea></td>    
        </tr>
        
        <!--Star- Rating checkbox -->
        <tr>
            <th scope="row"><label for="wp_smart_rate_stars_ck">' . __('Enable *-Rating', 'wp-smart-rate') . '</label></th>';
           // wenn checkbox leer dann ist $check gleich null
            $check = null; //checkbox ist leer
            //prüfen, ob Datenbankwert für checkbox gesetzt ist auf value-wert
            if ( esc_html(get_post_meta( $post->ID, 'wp_smart_rate_stars_ck', true )) === 'wp_smart_rate_stars_ck' ){                
                $check = 'checked'; //checkbox angehakt
            }
            $output .= '
            <!-- checkbox-value wird in DB geschrieben wenn checked, sonst kommt null rein -->
            <td><input type="checkbox" name="wp_smart_rate_stars_ck" value="wp_smart_rate_stars_ck" ' . $check . '/></td>        
        </tr>

        <!--Percent- Rating Text-->
        <tr>
            <th scope="row"><label for="wp_smart_rate_percent">' . __('%-Rating', 'wp-smart-rate') . '</label></th>
            <td><input type="text" name="wp_smart_rate_percent" value="' . esc_html(get_post_meta( $post->ID, 'wp_smart_rate_percent', true )) . '" /></td>  
        </tr>                   

        <!--color- picker -->
        <tr>
            <th scope="row"><label for="wp_smart_rate_button_background_color">' . __('Button Background Color', 'wp-smart-rate') . '</label></th>
            <td><input type="text" class="button_background_color" name="wp_smart_rate_button_background_color" value="' . esc_html(get_post_meta( $post->ID, 'wp_smart_rate_button_background_color', true )) . '" /></td>  
        </tr>  
        
        <!--Button- Text -->
        <tr>
            <th scope="row"><label for="wp_smart_rate_buttontext">' . __('Button- Text', 'wp-smart-rate') . '</label></th>
            <td><input type="text" name="wp_smart_rate_buttontext" value="' . esc_html(get_post_meta( $post->ID, 'wp_smart_rate_buttontext', true )) . '" /></td>  
        </tr>  

        <!--Button- Link -->
        <tr>
            <th scope="row"><label for="wp_smart_rate_buttonlink">' . __('Button- Link', 'wp-smart-rate') . '</label></th>
            <td><input type="text" name="wp_smart_rate_buttonlink" value="' . esc_html(get_post_meta( $post->ID, 'wp_smart_rate_buttonlink', true )) . '" /></td>  
        </tr>  
    </tbody></table>    
    ';
    echo $output;

    //Für Analysezwecke kann der Inhalt der Variable $post wie folgt ausgegeben werden:
    //print_r($post);

}
add_action('save_post', 'wp_smartrate_save');
function wp_smartrate_save( $post_id) {

    //Security

    //prüfen, ob nonce-field im formular gesetzt ist
    if (!isset($_POST['wp_smart_rate_meta_box_nonce'])) {
        return;
    }
    else {
        //überprüfen ob der inhalt des nonce-feldes auch korrekt übergeben wurde
        if (!wp_verify_nonce( $_POST['wp_smart_rate_meta_box_nonce'], 'wp_smart_rate_meta_box_data' )) return;
    }

    //Wenn Autosave aktiv dann nichts machen
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )  return;
    
    //Prüfen, ob der aktuelle POST-TYPE auch passt, hier: wp_smart_rate
    if ('wp_smart_rate' == $_POST['post_type']) {

        //hat der aktuelle user auch rechte zum editieren der Seite/ des posts
        if ( (!current_user_can( 'edit_page', $post_id )) || ( !current_user_can( 'edit_post', $post_id ))) return;
    }



    //Hier beginnen die eigentlichen Save- Routinen
    //save title
    if (isset( $_POST['wp_smart_rate_title'])){
        update_post_meta( $post_id,'wp_smart_rate_title', $_POST['wp_smart_rate_title']);
    }
    
    //save image-url
    if (isset( $_POST['wp_smart_rate_image'])){
        update_post_meta( $post_id,'wp_smart_rate_image', $_POST['wp_smart_rate_image']);
    }
    
    //save Pro-Text
    if (isset( $_POST['wp_smart_rate_pro'])){
        update_post_meta( $post_id,'wp_smart_rate_pro', $_POST['wp_smart_rate_pro']);
    }
    
    //save Con-Text
    if (isset( $_POST['wp_smart_rate_con'])){
        update_post_meta( $post_id,'wp_smart_rate_con', $_POST['wp_smart_rate_con']);
    }
    
    //save Star-rating checkbox
    if (isset( $_POST['wp_smart_rate_stars_ck'])){
        update_post_meta( $post_id,'wp_smart_rate_stars_ck', $_POST['wp_smart_rate_stars_ck']); // wenn checkbox  gesetzt,  wird wp_smart_rate_stars_ck in DB-Feld gesetzt.
    }
    else {
        update_post_meta( $post_id,'wp_smart_rate_stars_ck', null); // wenn checkbox nicht gesetzt, wird null in DB-Feld gesetzt.
    }
    
    //save percent-rating
    if (isset( $_POST['wp_smart_rate_percent'])){
        update_post_meta( $post_id,'wp_smart_rate_percent', $_POST['wp_smart_rate_percent']);
    }
    
    //save color-picker
    if (isset( $_POST['wp_smart_rate_button_background_color'])){
        update_post_meta( $post_id,'wp_smart_rate_button_background_color', $_POST['wp_smart_rate_button_background_color']);
    }
    
    //save Button-Text
    if (isset( $_POST['wp_smart_rate_buttontext'])){
        update_post_meta( $post_id,'wp_smart_rate_buttontext', $_POST['wp_smart_rate_buttontext']);
    }
    
    //save Button-Link
    if (isset( $_POST['wp_smart_rate_buttonlink'])){
        update_post_meta( $post_id,'wp_smart_rate_buttonlink', $_POST['wp_smart_rate_buttonlink']);
    }


}
?>

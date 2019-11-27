<?php
/*
Plugin Name: WP Smart Rating
Plugin URI: https://ways4.eu
Description: Add Ratings to your post or Page with a shortcode
Version: 1.0
Author: Herbert Sablotny
Author URI: https://ways4.eu
Text Domain: wp-smart-rate
Domain Path: /languages
*/
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
    //echo 'Howdy admin, proudly presents our first meta-box!';
    $output = '
    <table class="form-table"><tbody>

        <tr>
            <th scope="row"><label for="wp_smart_rate_shortcode">' . __('Shortcode', 'wp-smart-rate') . '</label></th>
            <td><input type="text" name="wp_smart_rate_shortcode" value="[wp_smart_rate id=\'' . $post->ID . '\']" /></td>            
        </tr>
        <tr>
            <th scope="row"><label for="wp_smart_rate_title">' . __('Title', 'wp-smart-rate') . '</label></th>
            <td><input type="text" name="wp_smart_rate_title" value="' . esc_html(get_post_meta( $post->ID, 'wp_smart_rate_title', true )) . '" /></td>        
        </tr>    
    </tbody></table>    
    ';
    echo $output;
    //print_r($post);

}
?>

<?php
/**
 * Plugin Name:       WP Custom Post Style
 * Plugin URI:        #
 * Description:       Provides Custom Post Style
 * Author:            Team Techvengers
 * Author URI:        https://techvengers.com
 * Text Domain:       wp-custom-post-style
 */

require_once 'register-post-type.php';
a
function add_my_custom_page() {
    // Create post object
    $my_post = array(
      'post_title'    => wp_strip_all_tags( 'My Custom Page' ),
      'post_content'  => '<h3>New Page 1</h3>',
      'post_status'   => 'publish',
      'post_type'     => 'page',
    );
    wp_insert_post( $my_post );
}

register_activation_hook(__FILE__, 'add_my_custom_page');
function on_deactivating_your_plugin() {
    $page = get_page_by_path( 'My Custom Page' );
    wp_delete_post($page->ID);
}
register_deactivation_hook( __FILE__, 'on_deactivating_your_plugin' );
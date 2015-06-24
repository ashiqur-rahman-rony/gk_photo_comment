<?php
/*
Plugin Name: GoodKoding Photo Comment
Plugin URI: http://wordpress.org/extend/plugins/gk-photo-comment/
Description: Import comments to your photo from Flickr and 500px
Author: GoodKoding
Author URI: http://goodkoding.com/
Version: 0.1
Text Domain: gk-photo-comment
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/
defined('ABSPATH') or die("No script kiddies please!");

/*
 * Load the default settings for the plugin
 */
require_once('includes/gk-photo-comment-settings.php');

/*
 * Add the menu for administrative settings of the plugin
 */
add_action( 'admin_menu', 'register_gk_photo_comment_admin_page' );
function register_gk_photo_comment_admin_page() {
    add_menu_page( __('GK Photo Comment Settings', 'gk-photo-comment'), __('GK Photo Comment', 'gk-photo-comment'), 'manage_options', 'gk-photo-comment/gk-photo-comment-admin.php', '', 'dashicons-testimonial' );
}

/*
 * Hook to handle plugin activation
 */
register_activation_hook( __FILE__, 'gk_photo_comment_activate' );
function gk_photo_comment_activate() {

    //Create table to store the log of locally saved comments
    global $wpdb;
    global $gk_photo_comment_log_table;

    $table_name = $wpdb->prefix . $gk_photo_comment_log_table;
    $charset_collate = '';

    if ( ! empty( $wpdb->charset ) ) {
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
    }
    if ( ! empty( $wpdb->collate ) ) {
        $charset_collate .= " COLLATE {$wpdb->collate}";
    }

    $query = "CREATE TABLE IF NOT EXISTS $table_name (
        gk_photo_comment_log_id  bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        post_id bigint(20) unsigned NOT NULL DEFAULT '0',
        flickr_photo_id varchar(255) DEFAULT NULL,
        500px_photo_id varchar(255) DEFAULT NULL,
        flickr_last_update_time varchar(255) DEFAULT NULL,
        flickr_last_update_id varchar(255) DEFAULT NULL,
        500px_last_update_time varchar(255) DEFAULT NULL,
        500px_last_update_id varchar(255) DEFAULT NULL,
        PRIMARY KEY (gk_photo_comment_log_id),
        KEY post_id (post_id)
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $query );
}

/*
 * Hook to handle plugin deactivation
 */
register_deactivation_hook( __FILE__, 'gk_photo_comment_deactivate' );
function gk_photo_comment_deactivate() {
    global $gk_photo_comment_default_values;

    foreach($gk_photo_comment_default_values as $key => $value) {
        unregister_setting( 'gk-photo-comment', 'gk_photo_comment_option_' . $key );
    }
}

/*
 * Register the settings required for this plugin
 */
add_action( 'admin_init', 'register_gk_photo_comment_settings' );
function register_gk_photo_comment_settings() {
    global $gk_photo_comment_default_values;
    foreach($gk_photo_comment_default_values as $key => $value) {
        if($key == 'post_type') {
            register_setting( 'gk-photo-comment', 'gk_photo_comment_option_' . $key, 'serialize_post_types' );
            continue;
        }
        register_setting( 'gk-photo-comment', 'gk_photo_comment_option_' . $key );
    }

    $post_types = get_option('gk_photo_comment_option_post_type');
    if(is_array($post_types)) {
        foreach($post_types as $post_type) {
            //Add meta field
            //More here: http://codex.wordpress.org/Plugin_API/Action_Reference/manage_$post_type_posts_custom_column
        }
    }
}

/*
 * Serialize the list of post types to save in WP option
 */
function serialize_post_types($input) {
    if(is_array($input)) {
        return serialize($input);
    }
    return $input;
}
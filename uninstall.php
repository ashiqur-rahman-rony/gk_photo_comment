<?php
/**
 * Uninstalls the plugin
 * - Remove the tables used by this plugin
 * - Removes the options used by this plugin
 */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit('Are you supposed to be here?');

if(!isset($gk_photo_comment_default_values)) {
    require_once('includes/gk-photo-comment-settings.php');
}

foreach($gk_photo_comment_default_values as $key => $value) {
    delete_option( 'gk-photo-comment', 'gk_photo_comment_option_' . $key );
    delete_site_option( 'gk-photo-comment', 'gk_photo_comment_option_' . $key );
}

//drop a custom db table
global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}$gk_photo_comment_log_table" );
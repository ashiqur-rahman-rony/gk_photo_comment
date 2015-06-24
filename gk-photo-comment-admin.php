<?php
defined('ABSPATH') or die("No script kiddies please!");
?>
<div class="wrap">
    <h2><?php _e('GK Photo Comment Settings', 'gk-photo-comment'); ?></h2>
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php settings_fields( 'gk-photo-comment' ); ?>
        <?php do_settings_sections( 'gk-photo-comment' ); ?>
        <?php
            global $gk_photo_comment_default_values;
            $option_values = array();
            foreach($gk_photo_comment_default_values as $key => $value) {
                $option_values[$key] = get_option('gk_photo_comment_option_' . $key, $value);
                if($key == 'post_type' && !is_array($option_values[$key])) {
                    $option_values[$key] = unserialize($option_values[$key]);
                }
            }
        ?>
        <input type="hidden" name="gk_photo_comment_option_flickr_api_key" value="<?php echo $gk_photo_comment_default_values['flickr_api_key']; ?>" />
        <input type="hidden" name="gk_photo_comment_option_flickr_api_secret" value="<?php echo $gk_photo_comment_default_values['flickr_api_secret']; ?>" />
        <input type="hidden" name="gk_photo_comment_option_500px_api_key" value="<?php echo $gk_photo_comment_default_values['500px_api_key']; ?>" />
        <input type="hidden" name="gk_photo_comment_option_500px_api_secret" value="<?php echo $gk_photo_comment_default_values['500px_api_secret']; ?>" />
        <table class="form-table">
            <tr>
                <th scope="row">
                    <?php _e('Get comments from Flickr', 'gk-photo-comment'); ?>
                </th>
                <td>
                    <input type="checkbox" name="gk_photo_comment_option_flickr_enabled" <?php echo ($option_values['flickr_enabled'] == 1 ? 'checked' : ''); ?> value="1" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <small><?php _e('This will enable fetching comments from the photo on your Flickr profile.', 'gk-photo-comment'); ?></small>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php _e('Get comments from 500px', 'gk-photo-comment'); ?>
                </th>
                <td>
                    <input type="checkbox" name="gk_photo_comment_option_500px_enabled" <?php echo ($option_values['500px_enabled'] == 1 ? 'checked' : ''); ?> value="1" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <small><?php _e('This will enable fetching comments from the photo on your 500px profile.', 'gk-photo-comment'); ?></small>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php _e('Enable comment saving', 'gk-photo-comment'); ?>
                </th>
                <td>
                    <input type="checkbox" name="gk_photo_comment_option_save_comments" <?php echo ($option_values['save_comments'] == 1 ? 'checked' : ''); ?> value="1" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <small><?php _e('Do you want to save the comments fetched from external websites to your database? This will enable faster loading time.', 'gk-photo-comment'); ?> <strong><em><?php _e('The comments will remain in the system even after the plugin uninstall.'); ?></em></strong></small>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <?php _e('Select photo post types', 'gk-photo-comment'); ?>
                </th>
                <td>
                    <?php
                    $post_type_args = array(
                        'public'   => true
                    );
                    $post_types = get_post_types($post_type_args, 'names');
                    foreach($post_types as $post_type) {
                        echo '<label><input type="checkbox" value="' . $post_type . '" ' . (in_array($post_type, $option_values['post_type']) ? 'checked' : '') . ' name="gk_photo_comment_option_post_type[]" />' . ucfirst($post_type) . '</label> ';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <small><?php _e('Select the post types where you want to enable the photo comment fetching.', 'gk-photo-comment'); ?></small>
                </td>
            </tr>

        </table>
        <?php submit_button(); ?>
    </form>
</div>
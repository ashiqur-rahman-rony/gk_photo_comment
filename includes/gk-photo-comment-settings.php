<?php
defined('ABSPATH') or die("No script kiddies please!");
global $gk_photo_comment_default_values;
global $gk_photo_comment_log_table;

$gk_photo_comment_default_values = array(
    'flickr_enabled' => 0,
    '500px_enabled' => 0,
    'save_comments' => 0,
    'post_type' => array(),
    'flickr_api_key' => 'a1f5cdd3516db6617bb49e0665e3dbbd',
    'flickr_api_secret' => '9dd1f84e98b60136',
    '500px_api_key' => '1chK9g6r4SCPaur0XTEE9C91wOW0wsUtE3qNMYl3',
    '500px_api_secret' => 'F15OnNjF1rfDJ2Dj4KkrT2IezztIV3ekhjJmW4Ah',
);

$gk_photo_comment_log_table = 'gk_photo_comment_log';
<?php

/**
 * Plugin Name:       test
 * Description:       test plugin
 * Version:           1
 * Author:            minimal
 * Update URI:        https://www.google.seo/pro
 * Text Domain:       test
 */



function check_for_plugin_update() {
    $current_version = '1.0.0'; // Replace with your current version
    $api_url = 'https://api.github.com/repos/yourusername/test/releases/latest';

    // Make a remote request to your update-check endpoint
    $response = wp_remote_get($api_url);

    if (is_array($response)) {
        $body = $response['body'];
        $data = json_decode($body);

        if ($data && version_compare($data->tag_name, $current_version, '>')) {
            // New version available, notify the user
            add_action('admin_notices', 'display_update_notification');
        }
    }
}

function display_update_notification() {
    ?>
    <div class="notice notice-info is-dismissible">
        <p>Test Plugin has a new version available! <a href="<?php echo esc_url($data->zipball_url); ?>">Update now</a>.</p>
    </div>
    <?php
}

add_action('admin_init', 'check_for_plugin_update');



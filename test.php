<?php

/**
 * Plugin Name:       test
 * Description:       test plugin
 * Version:           1.0.2
 * Author:            minimal
 * GitHub Plugin URI: minimalhustler/test
 * Text Domain:       test
 */


// test.php

function check_for_plugin_update() {
    $current_version = '1.0.2'; // Replace with your current version
    $repo_owner = 'minimalhustler';
    $repo_name = 'test';

    $api_url = "https://api.github.com/repos/{$repo_owner}/{$repo_name}/releases/latest";

    // Make a remote request to your update-check endpoint
    $response = wp_remote_get($api_url);

    if (is_array($response)) {
        $body = $response['body'];
        $data = json_decode($body);

		echo $data->tag_name;
		
        if ($data && version_compare($data->tag_name, $current_version, '>')) {
            // New version available, notify the user
            add_action('admin_notices', function () use ($data) {
                display_update_notification($data);
            });
        }
    }
}

function display_update_notification($data) {
    ?>
    <div class="notice notice-info is-dismissible">
        <p>Your Plugin has a new version available! <a href="<?php echo esc_url($data->zipball_url); ?>">Update now</a>.</p>
    </div>
    <?php
}

add_action('admin_init', 'check_for_plugin_update');


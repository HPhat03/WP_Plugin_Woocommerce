<!-- LOGIC HANDLING -->

<?php

// Yêu cầu phải khai báo header-requirement để WP có thể xem đây là plugin để activate/deactivate 
// Tối thiểu header-requirement phải có Plugin Name

/**
 * Plugin Name: Contact Plugin
 * Description: This is my first test plugin
 * Version: 1.0.0
 * Text Domain: contact-plugin
 * 
*/

// Nếu trường hợp người dùng đi vào direct URL của plugin phải chặn người dùng không cho vào
// Absolute Path được define khi WP sử dụng

if ( !defined('ABSPATH') ) {
    die('405 - Forbidden');
}

// Khởi tạo Plugin Controller class
class ContactPlugin {
    public function activate() {
        echo "The plugin has been activated";
    }

    public function deactivate() {

    }

    public function unistall() {

    }
}

// Khai báo Instance
if (class_exists("ContactPlugin")){
    $contactPlugin = new ContactPlugin();
}

// Activate the plugin hook
register_activation_hook(__FILE__, array($contactPlugin, "activate"));

// Deactivate the plugin hook
register_deactivation_hook(__FILE__, array($contactPlugin, "deactivate"));

// Unistall the plugin hook
register_uninstall_hook(__FILE__, array($contactPlugin, "uninstall"));
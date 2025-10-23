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

    public function __construct()
    {
        add_action('init', array($this, 'custom_post_type'));
    }

    public function register() {
        // Load file static vào trang admin
        add_action('admin_enqueue_scripts', array( $this, "enqueue_static"));
    }

    public function activate() {
        // Tạo custom post type
        $this->custom_post_type();
        // reset rule
        flush_rewrite_rules();        
    }

    public function deactivate() {
        // reset rule
        flush_rewrite_rules();
    }

    // Đăng kí 1 post type (trong dashboard admin)
    public function custom_post_type() {
        register_post_type('contactForm', ['public' => true, 'label' => 'Contact']);
    }

    public function enqueue_static() {
        wp_enqueue_style("contactPluginStyle", plugins_url('/static/css/my_css.css', __FILE__));
        wp_enqueue_script("contactPluginScript", plugins_url('/static/js/my_js.tsx', __FILE__));
    }
}

// Khai báo Instance
if (class_exists("ContactPlugin")){
    $contactPlugin = new ContactPlugin();
    $contactPlugin->register();
}

// Activate the plugin hook
register_activation_hook(__FILE__, array($contactPlugin, "activate"));

// Deactivate the plugin hook
register_deactivation_hook(__FILE__, array($contactPlugin, "deactivate"));

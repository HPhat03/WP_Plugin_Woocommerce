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
require_once plugin_dir_path(__FILE__) . "rest-api-controller.php";
class ContactPlugin {

    private $plugin_name;

    public function __construct()
    {
        $this->plugin_name = plugin_basename(__FILE__);
        // Đăng kí custom post type
        add_action('init', array($this, 'custom_post_type'));
        // Đăng kí Rest API
        add_action('init', ['RestApiController', 'register']);
    }

    public function register() {
        // Load file static vào trang admin
        add_action('admin_enqueue_scripts', array( $this, "enqueue_static"));

        // Đăng kí admin menu
        add_action('admin_menu', array($this, "add_admin_page"));

        // Đăng kí plugin link
        add_filter("plugin_action_links_$this->plugin_name", array($this, "plugin_link_setting"));
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

    public function add_admin_page() {
        // Add menu cha
        add_menu_page(
            "Dylan Contact Plugin",
            "Dylan List",
            "manage_options", //Capability - tìm hiểu thêm
            "dylanContactPlugin", // Menu Slug
            array($this, "admin_setting"),
            "dashicons-format-aside", // icon,
            66  //Xếp sau plugin (pos: 65)
        );

        // Add menu con
        add_submenu_page(
            "dylanContactPlugin",
            "Contact List Submenu",
            "Contact List",
            "manage_options",
            "dylanContactPlugin",  // Nếu không trùng với cha, thì submenu sẽ có menu cha làm submenu đầu tiên, thay vì con-con thì là cha-con-con
            array($this, "admin_setting")
        );

        add_submenu_page(
            "dylanContactPlugin",
            "Contact Report Submenu",
            "Contact Report",
            "manage_options",
            "contactReportSub",
            array($this, "react_embedded")
        );
    }

    public function admin_setting() {
        // lOAD TEMPLATE
        require_once plugin_dir_path(__FILE__) . "templates/admin.php";
    }

    public function plugin_link_setting( $link ) {
        $tmp_link = '<a href=admin.php?page=dylanContactPlugin>Controller</a>';
        array_push($link, $tmp_link);
        return $link;
    }

    // Embedded React
    public function react_embedded() {
        //
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

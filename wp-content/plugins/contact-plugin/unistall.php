<?php

if (! defined( 'WP_UNINSTALL_PLUGIN')) {
    die;
}

// Delete DATA những custom post type trong DB
global $wpdb;  // DB Connector
$custom_post_types = [
    "contactForm"
];

$pt_string = join(",",$custom_post_types);

// Delete Main records
$wpdb->query("DELETE FROM wp_posts WHERE post_type IN ($pt_string)");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT ID FROM wp_posts)");
$wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT ID FROM wp_posts)");
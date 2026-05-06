<?php
/**
 * Plugin Name:       Static Timeline Widget
 * Plugin URI:        https://github.com/Arifur999
 * Description:       A fully customizable vertical timeline plugin – card size, padding, font sizes, responsive controls and scroll animation.
 * Version:           1.1.0
 * Author:            Arif
 * Author URI:        https://github.com/Arifur999
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       static-timeline
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'STW_VERSION',     '1.1.0' );
define( 'STW_PLUGIN_DIR',  plugin_dir_path( __FILE__ ) );
define( 'STW_PLUGIN_URL',  plugin_dir_url( __FILE__ ) );
define( 'STW_PLUGIN_FILE', __FILE__ );

require_once STW_PLUGIN_DIR . 'includes/class-stw-post-type.php';
require_once STW_PLUGIN_DIR . 'includes/class-stw-meta-boxes.php';
require_once STW_PLUGIN_DIR . 'includes/class-stw-shortcode.php';
require_once STW_PLUGIN_DIR . 'admin/class-stw-admin.php';

add_action( 'plugins_loaded', 'stw_init' );
function stw_init() {
    STW_Post_Type::init();
    STW_Meta_Boxes::init();
    STW_Shortcode::init();
    STW_Admin::init();
}

add_action( 'wp_enqueue_scripts', 'stw_enqueue_frontend_assets' );
function stw_enqueue_frontend_assets() {
    wp_enqueue_style(  'stw-frontend', STW_PLUGIN_URL . 'assets/css/frontend.css', array(), STW_VERSION );
    wp_enqueue_script( 'stw-frontend', STW_PLUGIN_URL . 'assets/js/frontend.js',   array(), STW_VERSION, true );
}

add_action( 'admin_enqueue_scripts', 'stw_enqueue_admin_assets' );
function stw_enqueue_admin_assets( $hook ) {
    global $post_type;
    if ( $post_type !== 'stw_timeline' && ! in_array( $hook, array( 'toplevel_page_stw-settings' ), true ) ) { return; }
    wp_enqueue_media();
    wp_enqueue_style(  'stw-admin', STW_PLUGIN_URL . 'assets/css/admin.css', array(), STW_VERSION );
    wp_enqueue_script( 'stw-admin', STW_PLUGIN_URL . 'assets/js/admin.js',   array( 'jquery' ), STW_VERSION, true );
}

register_activation_hook(   STW_PLUGIN_FILE, function() { STW_Post_Type::register(); flush_rewrite_rules(); } );
register_deactivation_hook( STW_PLUGIN_FILE, function() { flush_rewrite_rules(); } );

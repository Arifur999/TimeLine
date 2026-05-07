<?php
/**
 * Plugin Name:  Static Timeline for Elementor
 * Plugin URI:   https://github.com/Arifur999
 * Description:  Beautiful vertical timeline widget for Elementor. Full style control from Elementor panel — colors, fonts, padding, spacing, animation. Multiple timelines per site via Groups.
 * Version:      1.0.0
 * Author:       Arif
 * Author URI:   https://github.com/Arifur999
 * License:      GPL v2 or later
 * Text Domain:  stw-el
 * Elementor tested up to: 3.20
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'STWEL_VER',  '1.0.0' );
define( 'STWEL_DIR',  plugin_dir_path( __FILE__ ) );
define( 'STWEL_URL',  plugin_dir_url(  __FILE__ ) );
define( 'STWEL_FILE', __FILE__ );

/* ── Load dependencies ───────────────────────────── */
require_once STWEL_DIR . 'includes/class-stwel-cpt.php';
require_once STWEL_DIR . 'includes/class-stwel-meta.php';
require_once STWEL_DIR . 'includes/class-stwel-admin.php';

add_action( 'plugins_loaded', function () {
    STWEL_CPT::init();
    STWEL_Meta::init();
    STWEL_Admin::init();

    /* Register Elementor widget after Elementor loads */
    add_action( 'elementor/widgets/register', function ( $manager ) {
        require_once STWEL_DIR . 'widgets/class-stwel-widget.php';
        $manager->register( new STWEL_Widget() );
    } );

    /* Warn if Elementor not active */
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', function () {
            echo '<div class="notice notice-warning"><p>';
            echo '<strong>Static Timeline for Elementor</strong> requires ';
            echo '<a href="https://elementor.com" target="_blank">Elementor</a> to be installed and active.';
            echo '</p></div>';
        } );
    }
} );

/* ── Frontend assets ──────────────────────────────── */
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'stwel-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap',
        [], null
    );
    wp_enqueue_style(  'stwel-css', STWEL_URL . 'assets/css/frontend.css', [ 'stwel-fonts' ], STWEL_VER );
    wp_enqueue_script( 'stwel-js',  STWEL_URL . 'assets/js/frontend.js',  [], STWEL_VER, true );
} );

/* ── Admin assets ─────────────────────────────────── */
add_action( 'admin_enqueue_scripts', function ( $hook ) {
    global $post_type;
    if ( ( isset( $post_type ) && $post_type === 'stwel_item' ) || strpos( $hook, 'stwel' ) !== false ) {
        wp_enqueue_media();
        wp_enqueue_style(  'stwel-admin-css', STWEL_URL . 'assets/css/admin.css', [], STWEL_VER );
        wp_enqueue_script( 'stwel-admin-js',  STWEL_URL . 'assets/js/admin.js',   [ 'jquery' ], STWEL_VER, true );
    }
} );

register_activation_hook(   STWEL_FILE, function () { STWEL_CPT::register(); flush_rewrite_rules(); } );
register_deactivation_hook( STWEL_FILE, function () { flush_rewrite_rules(); } );

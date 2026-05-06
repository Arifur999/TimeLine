<?php
/**
 * Custom Post Type: Timeline Item
 *
 * @package StaticTimeline
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class STW_Post_Type {

    public static function init() {
        add_action( 'init', array( __CLASS__, 'register' ) );
    }

    public static function register() {
        $labels = array(
            'name'               => __( 'Timeline Items', 'static-timeline' ),
            'singular_name'      => __( 'Timeline Item', 'static-timeline' ),
            'add_new'            => __( 'Add New Item', 'static-timeline' ),
            'add_new_item'       => __( 'Add New Timeline Item', 'static-timeline' ),
            'edit_item'          => __( 'Edit Timeline Item', 'static-timeline' ),
            'new_item'           => __( 'New Timeline Item', 'static-timeline' ),
            'view_item'          => __( 'View Timeline Item', 'static-timeline' ),
            'search_items'       => __( 'Search Timeline Items', 'static-timeline' ),
            'not_found'          => __( 'No Timeline Items Found', 'static-timeline' ),
            'not_found_in_trash' => __( 'No Timeline Items in Trash', 'static-timeline' ),
            'menu_name'          => __( 'Timeline', 'static-timeline' ),
        );

        $args = array(
            'labels'              => $labels,
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_icon'           => 'dashicons-editor-ul',
            'capability_type'     => 'post',
            'supports'            => array( 'title', 'thumbnail' ),
            'has_archive'         => false,
            'rewrite'             => false,
        );

        register_post_type( 'stw_timeline', $args );
    }
}

<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class STWEL_CPT {
    public static function init() { add_action( 'init', [ __CLASS__, 'register' ] ); }

    public static function register() {
        /* Post Type */
        register_post_type( 'stwel_item', [
            'labels'      => [
                'name'          => 'Timeline Items',
                'singular_name' => 'Timeline Item',
                'add_new_item'  => 'Add New Timeline Item',
                'edit_item'     => 'Edit Timeline Item',
                'all_items'     => 'All Timeline Items',
                'menu_name'     => 'Timeline',
            ],
            'public'          => false,
            'show_ui'         => true,
            'show_in_menu'    => true,
            'show_in_rest'    => false,
            'menu_icon'       => 'dashicons-editor-ul',
            'capability_type' => 'post',
            'supports'        => [ 'title' ],
            'has_archive'     => false,
            'rewrite'         => false,
        ] );

        /* Taxonomy – Groups */
        register_taxonomy( 'stwel_group', 'stwel_item', [
            'labels' => [
                'name'          => 'Timeline Groups',
                'singular_name' => 'Group',
                'add_new_item'  => 'Add New Group',
                'all_items'     => 'All Groups',
                'menu_name'     => 'Groups',
            ],
            'hierarchical'      => true,
            'public'            => false,
            'show_ui'           => true,
            'show_in_menu'      => true,
            'show_in_rest'      => false,
            'show_admin_column' => true,
            'rewrite'           => false,
        ] );
    }
}

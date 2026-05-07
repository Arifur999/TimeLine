<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class STWEL_Admin {
    public static function init() {
        add_action( 'admin_notices', [ __CLASS__, 'notice' ] );
        add_filter( 'manage_stwel_item_posts_columns',       [ __CLASS__, 'cols' ] );
        add_action( 'manage_stwel_item_posts_custom_column', [ __CLASS__, 'col_render' ], 10, 2 );
    }

    public static function notice() {
        $screen = get_current_screen();
        if ( $screen && $screen->post_type === 'stwel_item' && $screen->base === 'edit' ) {
            echo '<div class="notice notice-info is-dismissible"><p>';
            echo ' <strong>Static Timeline for Elementor</strong> — ';
            echo 'Items add ,then Elementor  <strong>"Static Timeline"</strong> widget can be used to display them in a timeline layout.';
            echo ' | <a href="https://github.com/Arifur999" target="_blank">by Arif</a>';
            echo '</p></div>';
        }
    }

    public static function cols( $cols ) {
        return [
            'cb'         => $cols['cb'],
            'title'      => $cols['title'],
            'stwel_date' => 'Date',
            'stwel_pos'  => 'Position',
            'stwel_ord'  => 'Order',
            'date'       => $cols['date'],
        ];
    }

    public static function col_render( $col, $pid ) {
        switch ( $col ) {
            case 'stwel_date': echo esc_html( get_post_meta( $pid, '_stwel_date',    true ) ); break;
            case 'stwel_pos':  echo esc_html( ucfirst( get_post_meta( $pid, '_stwel_pos', true ) ?: 'left' ) ); break;
            case 'stwel_ord':  echo esc_html( get_post_meta( $pid, '_stwel_order',   true ) ?: '0' ); break;
        }
    }
}

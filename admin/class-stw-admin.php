<?php
/**
 * Admin Page – How to Use (v1.1.0)
 *
 * @package StaticTimeline
 * @author  Arif (https://github.com/Arifur999)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class STW_Admin {

    public static function init() {
        add_action( 'admin_menu',    array( __CLASS__, 'add_menu' ) );
        add_action( 'admin_notices', array( __CLASS__, 'column_notice' ) );
        add_filter( 'manage_stw_timeline_posts_columns',       array( __CLASS__, 'set_columns' ) );
        add_action( 'manage_stw_timeline_posts_custom_column', array( __CLASS__, 'render_column' ), 10, 2 );
    }

    public static function add_menu() {
        add_submenu_page(
            'edit.php?post_type=stw_timeline',
            __( 'How to Use', 'static-timeline' ),
            __( '📖 How to Use', 'static-timeline' ),
            'manage_options',
            'stw-settings',
            array( __CLASS__, 'render_page' )
        );
    }

    public static function render_page() {
        ?>
        <div class="wrap stw-admin-page">
            <h1><?php esc_html_e( '📅 Static Timeline Widget v1.1.0', 'static-timeline' ); ?></h1>
            <p style="color:#555;margin-bottom:20px;">
                <?php esc_html_e( 'By', 'static-timeline' ); ?>
                <a href="https://github.com/Arifur999" target="_blank">Arif</a> &nbsp;|&nbsp;
                <?php esc_html_e( 'Version 1.1.0', 'static-timeline' ); ?>
            </p>

            <div class="stw-admin-grid">

                <div class="stw-admin-card stw-full">
                    <h2><?php esc_html_e( '🔗 Basic Shortcode', 'static-timeline' ); ?></h2>
                    <code class="stw-code">[static_timeline]</code>
                </div>

                <div class="stw-admin-card stw-full">
                    <h2><?php esc_html_e( '⚙️ All Shortcode Options (v1.1.0)', 'static-timeline' ); ?></h2>
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th><?php esc_html_e( 'Option', 'static-timeline' ); ?></th>
                                <th><?php esc_html_e( 'Default', 'static-timeline' ); ?></th>
                                <th><?php esc_html_e( 'Description', 'static-timeline' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="3"><strong><?php esc_html_e( '🎨 Colors', 'static-timeline' ); ?></strong></td></tr>
                            <tr><td><code>accent_color</code></td><td><code>#c9982a</code></td><td><?php esc_html_e( 'Icon circle & sub-heading color', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>line_color</code></td><td><code>#c9982a</code></td><td><?php esc_html_e( 'Vertical line color', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>card_bg</code></td><td><code>#ffffff</code></td><td><?php esc_html_e( 'Card background color', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>card_border_color</code></td><td><code>#e8e8f0</code></td><td><?php esc_html_e( 'Card border color', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>heading_color</code></td><td><code>#1a1a2e</code></td><td><?php esc_html_e( 'Main heading text color', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>paragraph_color</code></td><td><code>#5a6273</code></td><td><?php esc_html_e( 'Paragraph text color', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>date_color</code></td><td><code>#c9982a</code></td><td><?php esc_html_e( 'Date text color', 'static-timeline' ); ?></td></tr>

                            <tr><td colspan="3"><strong><?php esc_html_e( '📐 Card Size', 'static-timeline' ); ?></strong></td></tr>
                            <tr><td><code>card_max_width</code></td><td><code>500</code></td><td><?php esc_html_e( 'Max card width in px (e.g. 400, 600)', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>card_padding_top</code></td><td><code>24</code></td><td><?php esc_html_e( 'Card top padding in px', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>card_padding_right</code></td><td><code>28</code></td><td><?php esc_html_e( 'Card right padding in px', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>card_padding_bottom</code></td><td><code>24</code></td><td><?php esc_html_e( 'Card bottom padding in px', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>card_padding_left</code></td><td><code>28</code></td><td><?php esc_html_e( 'Card left padding in px', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>card_border_radius</code></td><td><code>12</code></td><td><?php esc_html_e( 'Card corner radius in px', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>card_shadow</code></td><td><code>yes</code></td><td><?php esc_html_e( 'Show card drop-shadow? (yes / no)', 'static-timeline' ); ?></td></tr>

                            <tr><td colspan="3"><strong><?php esc_html_e( '🔤 Font Sizes', 'static-timeline' ); ?></strong></td></tr>
                            <tr><td><code>heading_size</code></td><td><code>18</code></td><td><?php esc_html_e( 'Main heading font size in px', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>heading_weight</code></td><td><code>700</code></td><td><?php esc_html_e( 'Heading font weight (400–900)', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>sub_heading_size</code></td><td><code>11</code></td><td><?php esc_html_e( 'Sub-heading font size in px', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>paragraph_size</code></td><td><code>14</code></td><td><?php esc_html_e( 'Paragraph font size in px', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>paragraph_line_height</code></td><td><code>1.75</code></td><td><?php esc_html_e( 'Paragraph line-height (e.g. 1.5, 1.75, 2)', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>date_size</code></td><td><code>13</code></td><td><?php esc_html_e( 'Date font size in px', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>date_weight</code></td><td><code>700</code></td><td><?php esc_html_e( 'Date font weight (400–900)', 'static-timeline' ); ?></td></tr>

                            <tr><td colspan="3"><strong><?php esc_html_e( '🔘 Icon & Line', 'static-timeline' ); ?></strong></td></tr>
                            <tr><td><code>icon_size</code></td><td><code>52</code></td><td><?php esc_html_e( 'Icon circle diameter in px (e.g. 40, 60, 70)', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>line_width</code></td><td><code>2</code></td><td><?php esc_html_e( 'Vertical line thickness in px', 'static-timeline' ); ?></td></tr>

                            <tr><td colspan="3"><strong><?php esc_html_e( '📏 Spacing', 'static-timeline' ); ?></strong></td></tr>
                            <tr><td><code>item_gap</code></td><td><code>20</code></td><td><?php esc_html_e( 'Extra vertical space between items in px', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>wrapper_padding</code></td><td><code>40</code></td><td><?php esc_html_e( 'Top & bottom padding of the whole widget in px', 'static-timeline' ); ?></td></tr>

                            <tr><td colspan="3"><strong><?php esc_html_e( '⚡ Other', 'static-timeline' ); ?></strong></td></tr>
                            <tr><td><code>animate</code></td><td><code>yes</code></td><td><?php esc_html_e( 'Scroll animation on/off (yes / no)', 'static-timeline' ); ?></td></tr>
                            <tr><td><code>limit</code></td><td><code>-1</code></td><td><?php esc_html_e( 'Number of items to show (-1 = all)', 'static-timeline' ); ?></td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="stw-admin-card">
                    <h2><?php esc_html_e( '💡 Example – Gold Theme, Big Cards', 'static-timeline' ); ?></h2>
                    <code class="stw-code">[static_timeline accent_color="#c9982a" heading_size="22" paragraph_size="15" card_padding_top="32" card_padding_bottom="32" card_max_width="560" icon_size="60" date_size="15"]</code>
                </div>

                <div class="stw-admin-card">
                    <h2><?php esc_html_e( '💡 Example – Compact Cards', 'static-timeline' ); ?></h2>
                    <code class="stw-code">[static_timeline card_padding_top="14" card_padding_right="16" card_padding_bottom="14" card_padding_left="16" heading_size="15" paragraph_size="12" icon_size="40" card_max_width="380"]</code>
                </div>

                <div class="stw-admin-card">
                    <h2><?php esc_html_e( '📝 Steps to Add Items', 'static-timeline' ); ?></h2>
                    <ol>
                        <li><?php esc_html_e( 'Dashboard → Timeline → Add New Item', 'static-timeline' ); ?></li>
                        <li><?php esc_html_e( 'Fill: Date, Heading, Sub Heading, Paragraph', 'static-timeline' ); ?></li>
                        <li><?php esc_html_e( 'Upload Image and/or Icon (optional)', 'static-timeline' ); ?></li>
                        <li><?php esc_html_e( 'Set Position (Left / Right) and Order (1, 2, 3…)', 'static-timeline' ); ?></li>
                        <li><?php esc_html_e( 'Publish the item', 'static-timeline' ); ?></li>
                        <li><?php esc_html_e( 'Add [static_timeline] to any page or post', 'static-timeline' ); ?></li>
                    </ol>
                </div>

            </div>
        </div>
        <?php
    }

    public static function set_columns( $columns ) {
        return array(
            'cb'        => $columns['cb'],
            'title'     => $columns['title'],
            'stw_date'  => __( 'Date', 'static-timeline' ),
            'stw_pos'   => __( 'Position', 'static-timeline' ),
            'stw_order' => __( 'Order', 'static-timeline' ),
            'date'      => $columns['date'],
        );
    }

    public static function render_column( $column, $post_id ) {
        switch ( $column ) {
            case 'stw_date':
                echo esc_html( get_post_meta( $post_id, '_stw_date', true ) );
                break;
            case 'stw_pos':
                echo esc_html( ucfirst( get_post_meta( $post_id, '_stw_position', true ) ?: 'left' ) );
                break;
            case 'stw_order':
                echo esc_html( get_post_meta( $post_id, '_stw_order', true ) ?: '0' );
                break;
        }
    }

    public static function column_notice() {
        $screen = get_current_screen();
        if ( $screen && 'stw_timeline' === $screen->post_type && 'edit' === $screen->base ) {
            echo '<div class="notice notice-info is-dismissible"><p>';
            echo '📅 <strong>Static Timeline v1.1.0</strong> — ';
            esc_html_e( 'Add items below, then use shortcode', 'static-timeline' );
            echo ' <code>[static_timeline]</code> ';
            esc_html_e( 'on any page. See', 'static-timeline' );
            echo ' <a href="' . esc_url( admin_url( 'edit.php?post_type=stw_timeline&page=stw-settings' ) ) . '">';
            esc_html_e( 'How to Use', 'static-timeline' );
            echo '</a> ';
            esc_html_e( 'for all options.', 'static-timeline' );
            echo '</p></div>';
        }
    }
}

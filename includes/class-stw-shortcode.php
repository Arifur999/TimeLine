<?php
/**
 * Shortcode: [static_timeline]
 *
 * v1.1.0 – Full size, padding, font-size, spacing, and responsive controls.
 *
 * @package StaticTimeline
 * @author  Arif (https://github.com/Arifur999)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class STW_Shortcode {

    public static function init() {
        add_shortcode( 'static_timeline', array( __CLASS__, 'render' ) );
    }

    public static function render( $atts ) {

        $atts = shortcode_atts( array(
            /* ── Colors ── */
            'accent_color'          => '#c9982a',
            'line_color'            => '#c9982a',
            'card_bg'               => '#ffffff',
            'card_border_color'     => '#e8e8f0',
            'heading_color'         => '#1a1a2e',
            'paragraph_color'       => '#5a6273',
            'date_color'            => '#c9982a',
            'sub_heading_color'     => '#c9982a',

            /* ── Animation ── */
            'animate'               => 'yes',

            /* ── Limit ── */
            'limit'                 => -1,

            /* ── Card Size ── */
            'card_max_width'        => '500',   // px
            'card_padding_top'      => '24',    // px
            'card_padding_right'    => '28',    // px
            'card_padding_bottom'   => '24',    // px
            'card_padding_left'     => '28',    // px
            'card_border_radius'    => '12',    // px
            'card_shadow'           => 'yes',

            /* ── Typography ── */
            'heading_size'          => '18',    // px
            'heading_weight'        => '700',
            'sub_heading_size'      => '11',    // px
            'paragraph_size'        => '14',    // px
            'paragraph_line_height' => '1.75',
            'date_size'             => '13',    // px
            'date_weight'           => '700',

            /* ── Icon & Line ── */
            'icon_size'             => '52',    // px circle diameter
            'line_width'            => '2',     // px

            /* ── Spacing ── */
            'item_gap'              => '20',    // px between items
            'wrapper_padding'       => '40',    // px top & bottom of widget

        ), $atts, 'static_timeline' );

        /* ── Sanitize colors ── */
        $accent_color      = sanitize_hex_color( $atts['accent_color'] )     ?: '#c9982a';
        $line_color        = sanitize_hex_color( $atts['line_color'] )        ?: '#c9982a';
        $card_bg           = sanitize_hex_color( $atts['card_bg'] )           ?: '#ffffff';
        $card_border_color = sanitize_hex_color( $atts['card_border_color'] ) ?: '#e8e8f0';
        $heading_color     = sanitize_hex_color( $atts['heading_color'] )     ?: '#1a1a2e';
        $paragraph_color   = sanitize_hex_color( $atts['paragraph_color'] )   ?: '#5a6273';
        $date_color        = sanitize_hex_color( $atts['date_color'] )        ?: '#c9982a';
        $sub_heading_color = sanitize_hex_color( $atts['sub_heading_color'] ) ?: '#c9982a';

        /* ── Sanitize booleans ── */
        $animate     = ( 'yes' === strtolower( $atts['animate'] ) );
        $card_shadow = ( 'yes' === strtolower( $atts['card_shadow'] ) );
        $limit       = intval( $atts['limit'] );

        /* ── Sanitize numeric ── */
        $ni = function( $v, $min = 0, $max = 9999 ) { return max( $min, min( $max, intval( $v ) ) ); };
        $nf = function( $v, $min = 0.5, $max = 5  ) { return max( $min, min( $max, floatval( $v ) ) ); };

        $card_max_width   = $ni( $atts['card_max_width'],        100, 1200 );
        $card_pt          = $ni( $atts['card_padding_top'],        0,  200 );
        $card_pr          = $ni( $atts['card_padding_right'],      0,  200 );
        $card_pb          = $ni( $atts['card_padding_bottom'],     0,  200 );
        $card_pl          = $ni( $atts['card_padding_left'],       0,  200 );
        $card_radius      = $ni( $atts['card_border_radius'],      0,  100 );
        $heading_size     = $ni( $atts['heading_size'],            8,   72 );
        $heading_weight   = $ni( $atts['heading_weight'],        100,  900 );
        $sub_size         = $ni( $atts['sub_heading_size'],        8,   48 );
        $para_size        = $ni( $atts['paragraph_size'],          8,   48 );
        $para_lh          = $nf( $atts['paragraph_line_height'],   1,    3 );
        $date_size        = $ni( $atts['date_size'],               8,   72 );
        $date_weight      = $ni( $atts['date_weight'],           100,  900 );
        $icon_size        = $ni( $atts['icon_size'],              20,  200 );
        $line_width       = $ni( $atts['line_width'],              1,   20 );
        $item_gap         = $ni( $atts['item_gap'],                0,  300 );
        $wrap_pad         = $ni( $atts['wrapper_padding'],         0,  300 );

        $icon_img_size  = intval( $icon_size * 0.5 );
        $icon_ring      = intval( $icon_size * 0.12 );
        $shadow_base    = $card_shadow ? '0 2px 16px rgba(0,0,0,.07)' : 'none';
        $shadow_hover   = $card_shadow ? '0 8px 30px rgba(0,0,0,.13)' : 'none';

        /* ── Query ── */
        $query = new WP_Query( array(
            'post_type'      => 'stw_timeline',
            'post_status'    => 'publish',
            'posts_per_page' => $limit,
            'meta_key'       => '_stw_order',
            'orderby'        => array( 'meta_value_num' => 'ASC', 'date' => 'ASC' ),
        ) );

        if ( ! $query->have_posts() ) {
            return '<p class="stw-no-items">' . esc_html__( 'No timeline items found. Add items from Dashboard → Timeline.', 'static-timeline' ) . '</p>';
        }

        $uid = 'stw-' . wp_rand( 1000, 9999 );

        ob_start();
        ?>
        <style>
        #<?php echo esc_attr( $uid ); ?> {
            --stw-accent:        <?php echo esc_attr( $accent_color ); ?>;
            --stw-line-col:      <?php echo esc_attr( $line_color ); ?>;
            --stw-line-w:        <?php echo esc_attr( $line_width ); ?>px;
            --stw-card-bg:       <?php echo esc_attr( $card_bg ); ?>;
            --stw-card-border:   <?php echo esc_attr( $card_border_color ); ?>;
            --stw-h-color:       <?php echo esc_attr( $heading_color ); ?>;
            --stw-p-color:       <?php echo esc_attr( $paragraph_color ); ?>;
            --stw-date-color:    <?php echo esc_attr( $date_color ); ?>;
            --stw-sub-color:     <?php echo esc_attr( $sub_heading_color ); ?>;
            --stw-card-max:      <?php echo esc_attr( $card_max_width ); ?>px;
            --stw-card-pt:       <?php echo esc_attr( $card_pt ); ?>px;
            --stw-card-pr:       <?php echo esc_attr( $card_pr ); ?>px;
            --stw-card-pb:       <?php echo esc_attr( $card_pb ); ?>px;
            --stw-card-pl:       <?php echo esc_attr( $card_pl ); ?>px;
            --stw-card-radius:   <?php echo esc_attr( $card_radius ); ?>px;
            --stw-h-size:        <?php echo esc_attr( $heading_size ); ?>px;
            --stw-h-weight:      <?php echo esc_attr( $heading_weight ); ?>;
            --stw-sub-size:      <?php echo esc_attr( $sub_size ); ?>px;
            --stw-p-size:        <?php echo esc_attr( $para_size ); ?>px;
            --stw-p-lh:          <?php echo esc_attr( $para_lh ); ?>;
            --stw-date-size:     <?php echo esc_attr( $date_size ); ?>px;
            --stw-date-weight:   <?php echo esc_attr( $date_weight ); ?>;
            --stw-icon-size:     <?php echo esc_attr( $icon_size ); ?>px;
            --stw-icon-img:      <?php echo esc_attr( $icon_img_size ); ?>px;
            --stw-icon-ring:     <?php echo esc_attr( $icon_ring ); ?>px;
            --stw-item-gap:      <?php echo esc_attr( $item_gap ); ?>px;
            --stw-wrap-pad:      <?php echo esc_attr( $wrap_pad ); ?>px;
            --stw-shadow:        <?php echo esc_attr( $shadow_base ); ?>;
            --stw-shadow-hover:  <?php echo esc_attr( $shadow_hover ); ?>;
        }
        </style>

        <div id="<?php echo esc_attr( $uid ); ?>" class="stw-timeline-wrapper<?php echo $animate ? ' stw-animate' : ''; ?>">
            <div class="stw-timeline-inner">
                <div class="stw-line-track">
                    <div class="stw-line"></div>
                </div>

                <?php while ( $query->have_posts() ) : $query->the_post();
                    $pid         = get_the_ID();
                    $date        = get_post_meta( $pid, '_stw_date',        true );
                    $heading     = get_post_meta( $pid, '_stw_heading',     true );
                    $sub_heading = get_post_meta( $pid, '_stw_sub_heading', true );
                    $paragraph   = get_post_meta( $pid, '_stw_paragraph',   true );
                    $image_url   = get_post_meta( $pid, '_stw_image_url',   true );
                    $icon_url    = get_post_meta( $pid, '_stw_icon_url',    true );
                    $position    = get_post_meta( $pid, '_stw_position',    true ) ?: 'left';
                ?>
                <div class="stw-item stw-item--<?php echo esc_attr( $position ); ?><?php echo $animate ? ' stw-hidden' : ''; ?>">

                    <div class="stw-card-wrap">
                        <div class="stw-card">
                            <?php if ( $image_url ) : ?>
                                <div class="stw-card-image">
                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $heading ); ?>" loading="lazy" />
                                </div>
                            <?php endif; ?>
                            <?php if ( $sub_heading ) : ?>
                                <span class="stw-sub-heading"><?php echo esc_html( $sub_heading ); ?></span>
                            <?php endif; ?>
                            <?php if ( $heading ) : ?>
                                <h3 class="stw-heading"><?php echo esc_html( $heading ); ?></h3>
                            <?php endif; ?>
                            <?php if ( $paragraph ) : ?>
                                <p class="stw-paragraph"><?php echo esc_html( $paragraph ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="stw-center">
                        <div class="stw-icon-circle">
                            <?php if ( $icon_url ) : ?>
                                <img src="<?php echo esc_url( $icon_url ); ?>" alt="icon" class="stw-icon-img" />
                            <?php else : ?>
                                <svg class="stw-default-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12L10 17L19 7" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="stw-date-wrap">
                        <?php if ( $date ) : ?>
                            <span class="stw-date"><?php echo esc_html( $date ); ?></span>
                        <?php endif; ?>
                    </div>

                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

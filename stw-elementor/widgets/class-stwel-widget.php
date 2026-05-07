<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Typography as Scheme_Typography;

class STWEL_Widget extends Widget_Base {

    public function get_name()        { return 'static_timeline'; }
    public function get_title()       { return ' Static Timeline'; }
    public function get_icon()        { return 'eicon-time-line'; }
    public function get_categories()  { return [ 'general' ]; }
    public function get_keywords()    { return [ 'timeline', 'history', 'events', 'static', 'vertical' ]; }

    /* ── Build the groups dropdown options ─────────── */
    private function get_group_options() {
        $opts  = [ '' => '— All Items —' ];
        $terms = get_terms( [ 'taxonomy' => 'stwel_group', 'hide_empty' => false ] );
        if ( ! is_wp_error( $terms ) ) {
            foreach ( $terms as $t ) {
                $opts[ (string) $t->term_id ] = $t->name;
            }
        }
        return $opts;
    }

    /* ══════════════════════════════════════════════════
       CONTROLS  (Elementor panel)
    ══════════════════════════════════════════════════ */
    protected function register_controls() {

        /* ─── SECTION: Content ─────────────────────── */
        $this->start_controls_section( 'sec_content', [
            'label' => ' Content & Group',
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'group_id', [
            'label'   => 'Timeline Group',
            'type'    => Controls_Manager::SELECT,
            'options' => $this->get_group_options(),
            'default' => '',
            'description' => 'Go to <strong>Dashboard → Timeline → Groups</strong> to create groups. Each page can show a different group.',
        ] );

        $this->add_control( 'limit', [
            'label'   => 'Max items to show',
            'type'    => Controls_Manager::NUMBER,
            'default' => -1,
            'min'     => -1,
            'max'     => 100,
            'description' => '-1 = show all',
        ] );

        $this->add_control( 'animate', [
            'label'        => 'Scroll Animation',
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => 'Yes',
            'label_off'    => 'No',
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->end_controls_section();

        /* ─── SECTION STYLE: Timeline Line ─────────── */
        $this->start_controls_section( 'sec_line', [
            'label' => '〡 Vertical Line',
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'line_color', [
            'label'     => 'Line Color',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#c9982a',
            'selectors' => [ '{{WRAPPER}} .stwel-line' => 'background: {{VALUE}};' ],
        ] );

        $this->add_control( 'line_width', [
            'label'      => 'Line Thickness',
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 1, 'max' => 16 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 2 ],
            'selectors'  => [ '{{WRAPPER}} .stwel-track' => 'width: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        /* ─── SECTION STYLE: Icon Circle ───────────── */
        $this->start_controls_section( 'sec_icon', [
            'label' => ' Icon Circle',
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'icon_bg', [
            'label'     => 'Circle Background',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#c9982a',
            'selectors' => [ '{{WRAPPER}} .stwel-dot' => 'background: {{VALUE}}; border-color: {{VALUE}};' ],
        ] );

        $this->add_control( 'icon_size', [
            'label'      => 'Circle Size',
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 24, 'max' => 120 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 56 ],
            'selectors'  => [
                '{{WRAPPER}} .stwel-dot'    => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .stwel-mid'    => 'width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .stwel-item'   => 'grid-template-columns: 1fr {{SIZE}}{{UNIT}} 1fr;',
                '{{WRAPPER}} .stwel-ico'    => 'width: calc({{SIZE}}{{UNIT}} * 0.46); height: calc({{SIZE}}{{UNIT}} * 0.46);',
                '{{WRAPPER}} .stwel-ico-df' => 'width: calc({{SIZE}}{{UNIT}} * 0.44); height: calc({{SIZE}}{{UNIT}} * 0.44);',
            ],
        ] );

        $this->add_control( 'icon_ring_color', [
            'label'     => 'Ring / Glow Color',
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(201,152,42,0.20)',
            'selectors' => [
                '{{WRAPPER}} .stwel-dot' => 'box-shadow: 0 0 0 7px {{VALUE}}, 0 4px 16px rgba(0,0,0,.18);',
            ],
        ] );

        $this->end_controls_section();

        /* ─── SECTION STYLE: Card ───────────────────── */
        $this->start_controls_section( 'sec_card', [
            'label' => ' Card',
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_max_width', [
            'label'      => 'Card Max Width',
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px','%' ],
            'range'      => [ 'px' => [ 'min' => 160, 'max' => 900 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 520 ],
            'selectors'  => [ '{{WRAPPER}} .stwel-card' => 'max-width: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->add_control( 'card_bg', [
            'label'     => 'Background',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [ '{{WRAPPER}} .stwel-card' => 'background: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'label'    => 'Border',
            'selector' => '{{WRAPPER}} .stwel-card',
            'fields_options' => [
                'border' => [ 'default' => 'solid' ],
                'width'  => [ 'default' => [ 'top'=>'1','right'=>'1','bottom'=>'1','left'=>'1','unit'=>'px','isLinked'=>true ] ],
                'color'  => [ 'default' => '#e8e8f0' ],
            ],
        ] );

        $this->add_control( 'card_radius', [
            'label'      => 'Border Radius',
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'default'    => [ 'top'=>12,'right'=>12,'bottom'=>12,'left'=>12,'unit'=>'px','isLinked'=>true ],
            'selectors'  => [ '{{WRAPPER}} .stwel-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow',
            'label'    => 'Box Shadow',
            'selector' => '{{WRAPPER}} .stwel-card',
            'fields_options' => [
                'box_shadow_type' => [ 'default' => 'yes' ],
                'box_shadow'      => [
                    'default' => [
                        'horizontal' => 0, 'vertical' => 4,
                        'blur' => 20, 'spread' => 0,
                        'color' => 'rgba(0,0,0,0.08)',
                    ],
                ],
            ],
        ] );

        $this->add_control( 'card_padding', [
            'label'      => 'Padding',
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px','em' ],
            'default'    => [ 'top'=>28,'right'=>32,'bottom'=>28,'left'=>32,'unit'=>'px','isLinked'=>false ],
            'selectors'  => [ '{{WRAPPER}} .stwel-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        /* Hover */
        $this->add_control( 'card_hover_heading', [
            'label'     => 'Hover State',
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'card_hover_border', [
            'label'     => 'Hover Border Color',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#c9982a',
            'selectors' => [ '{{WRAPPER}} .stwel-card:hover' => 'border-color: {{VALUE}};' ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow_hover',
            'label'    => 'Hover Shadow',
            'selector' => '{{WRAPPER}} .stwel-card:hover',
        ] );

        $this->end_controls_section();

        /* ─── SECTION STYLE: Heading ────────────────── */
        $this->start_controls_section( 'sec_heading', [
            'label' => ' Heading',
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'heading_color', [
            'label'     => 'Color',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#1a1a2e',
            'selectors' => [ '{{WRAPPER}} .stwel-h' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'heading_typo',
            'label'    => 'Typography',
            'selector' => '{{WRAPPER}} .stwel-h',
            'fields_options' => [
                'typography'  => [ 'default' => 'yes' ],
                'font_family' => [ 'default' => 'Playfair Display' ],
                'font_size'   => [ 'default' => [ 'unit'=>'px','size'=>22 ] ],
                'font_weight' => [ 'default' => '700' ],
                'line_height' => [ 'default' => [ 'unit'=>'em','size'=>1.35 ] ],
            ],
        ] );

        $this->add_control( 'heading_margin', [
            'label'      => 'Bottom Margin',
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 10 ],
            'selectors'  => [ '{{WRAPPER}} .stwel-h' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        /* ─── SECTION STYLE: Sub Heading ────────────── */
        $this->start_controls_section( 'sec_sub', [
            'label' => '🏷 Sub Heading',
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'sub_color', [
            'label'     => 'Text Color',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#c9982a',
            'selectors' => [ '{{WRAPPER}} .stwel-sub' => 'color: {{VALUE}};' ],
        ] );

        $this->add_control( 'sub_bg', [
            'label'     => 'Background Color',
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(201,152,42,0.10)',
            'selectors' => [ '{{WRAPPER}} .stwel-sub' => 'background: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'sub_typo',
            'label'    => 'Typography',
            'selector' => '{{WRAPPER}} .stwel-sub',
            'fields_options' => [
                'typography'     => [ 'default' => 'yes' ],
                'font_family'    => [ 'default' => 'Lato' ],
                'font_size'      => [ 'default' => [ 'unit'=>'px','size'=>11 ] ],
                'font_weight'    => [ 'default' => '700' ],
                'text_transform' => [ 'default' => 'uppercase' ],
                'letter_spacing' => [ 'default' => [ 'unit'=>'px','size'=>1 ] ],
            ],
        ] );

        $this->add_control( 'sub_padding', [
            'label'      => 'Padding',
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px' ],
            'default'    => [ 'top'=>3,'right'=>10,'bottom'=>3,'left'=>10,'unit'=>'px','isLinked'=>false ],
            'selectors'  => [ '{{WRAPPER}} .stwel-sub' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->add_control( 'sub_radius', [
            'label'      => 'Border Radius',
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 20 ],
            'selectors'  => [ '{{WRAPPER}} .stwel-sub' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();

        /* ─── SECTION STYLE: Paragraph ──────────────── */
        $this->start_controls_section( 'sec_para', [
            'label' => ' Paragraph',
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'para_color', [
            'label'     => 'Color',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#5a6273',
            'selectors' => [ '{{WRAPPER}} .stwel-p' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'para_typo',
            'label'    => 'Typography',
            'selector' => '{{WRAPPER}} .stwel-p',
            'fields_options' => [
                'typography'  => [ 'default' => 'yes' ],
                'font_family' => [ 'default' => 'Lato' ],
                'font_size'   => [ 'default' => [ 'unit'=>'px','size'=>15 ] ],
                'font_weight' => [ 'default' => '400' ],
                'line_height' => [ 'default' => [ 'unit'=>'em','size'=>1.8 ] ],
            ],
        ] );

        $this->end_controls_section();

        /* ─── SECTION STYLE: Date ───────────────────── */
        $this->start_controls_section( 'sec_date', [
            'label' => ' Date',
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'date_color', [
            'label'     => 'Color',
            'type'      => Controls_Manager::COLOR,
            'default'   => '#c9982a',
            'selectors' => [ '{{WRAPPER}} .stwel-date' => 'color: {{VALUE}};' ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'date_typo',
            'label'    => 'Typography',
            'selector' => '{{WRAPPER}} .stwel-date',
            'fields_options' => [
                'typography'  => [ 'default' => 'yes' ],
                'font_family' => [ 'default' => 'Lato' ],
                'font_size'   => [ 'default' => [ 'unit'=>'px','size'=>15 ] ],
                'font_weight' => [ 'default' => '700' ],
            ],
        ] );

        $this->end_controls_section();

        /* ─── SECTION STYLE: Spacing ────────────────── */
        $this->start_controls_section( 'sec_spacing', [
            'label' => ' Spacing',
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'item_gap', [
            'label'      => 'Gap Between Items',
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 160 ] ],
            'default'    => [ 'unit' => 'px', 'size' => 20 ],
            'selectors'  => [ '{{WRAPPER}} .stwel-item' => 'padding-top: calc({{SIZE}}{{UNIT}} / 2); padding-bottom: calc({{SIZE}}{{UNIT}} / 2);' ],
        ] );

        $this->add_control( 'wrap_padding', [
            'label'      => 'Widget Padding',
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px','em','%' ],
            'default'    => [ 'top'=>40,'right'=>20,'bottom'=>40,'left'=>20,'unit'=>'px','isLinked'=>false ],
            'selectors'  => [ '{{WRAPPER}} .stwel-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ] );

        $this->end_controls_section();
    }

    /* ══════════════════════════════════════════════════
       RENDER  (frontend HTML)
    ══════════════════════════════════════════════════ */
    protected function render() {
        $s = $this->get_settings_for_display();

        $group_id = absint( $s['group_id'] ?? 0 );
        $limit    = intval( $s['limit'] ?? -1 );
        $animate  = ( ( $s['animate'] ?? 'yes' ) === 'yes' );

        $args = [
            'post_type'      => 'stwel_item',
            'post_status'    => 'publish',
            'posts_per_page' => ( $limit === 0 ? -1 : $limit ),
            'meta_key'       => '_stwel_order',
            'orderby'        => [ 'meta_value_num' => 'ASC', 'date' => 'ASC' ],
        ];
        if ( $group_id > 0 ) {
            $args['tax_query'] = [[
                'taxonomy' => 'stwel_group',
                'field'    => 'term_id',
                'terms'    => $group_id,
            ]];
        }

        $q = new WP_Query( $args );

        if ( ! $q->have_posts() ) {
            echo '<div class="stwel-empty"> No timeline items found.<br><small>Go to <strong>Dashboard → Timeline → Add New Item</strong></small></div>';
            return;
        }
        ?>
        <div class="stwel-wrap<?php echo $animate ? ' stwel-anim' : ''; ?>">
            <div class="stwel-inner">
                <div class="stwel-track"><div class="stwel-line"></div></div>

                <?php while ( $q->have_posts() ) : $q->the_post();
                    $pid  = get_the_ID();
                    $date = get_post_meta( $pid, '_stwel_date',    true );
                    $head = get_post_meta( $pid, '_stwel_heading', true );
                    $sub  = get_post_meta( $pid, '_stwel_sub',     true );
                    $para = get_post_meta( $pid, '_stwel_para',    true );
                    $img  = get_post_meta( $pid, '_stwel_img',     true );
                    $icon = get_post_meta( $pid, '_stwel_icon',    true );
                    $pos  = get_post_meta( $pid, '_stwel_pos',     true ) ?: 'left';
                ?>
                <div class="stwel-item stwel-<?php echo esc_attr($pos); ?><?php echo $animate ? ' stwel-hide' : ''; ?>">

                    <div class="stwel-card-wrap">
                        <div class="stwel-card">
                            <?php if ( $img ) : ?>
                                <div class="stwel-img-wrap">
                                    <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($head); ?>" loading="lazy"/>
                                </div>
                            <?php endif; ?>
                            <?php if ( $sub ) : ?>
                                <span class="stwel-sub"><?php echo esc_html($sub); ?></span>
                            <?php endif; ?>
                            <?php if ( $head ) : ?>
                                <h3 class="stwel-h"><?php echo esc_html($head); ?></h3>
                            <?php endif; ?>
                            <?php if ( $para ) : ?>
                                <p class="stwel-p"><?php echo esc_html($para); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="stwel-mid">
                        <div class="stwel-dot">
                            <?php if ( $icon ) : ?>
                                <img src="<?php echo esc_url($icon); ?>" class="stwel-ico" alt=""/>
                            <?php else : ?>
                                <svg viewBox="0 0 24 24" class="stwel-ico-df" fill="none">
                                    <path d="M5 12l5 5L19 7" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="stwel-date-wrap">
                        <?php if ( $date ) : ?>
                            <span class="stwel-date"><?php echo esc_html($date); ?></span>
                        <?php endif; ?>
                    </div>

                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
        <?php
    }
}

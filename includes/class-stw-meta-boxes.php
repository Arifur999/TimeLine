<?php
/**
 * Meta Boxes for Timeline Item
 * Fields: date, image, heading, paragraph, sub-heading, icon (upload)
 *
 * @package StaticTimeline
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class STW_Meta_Boxes {

    public static function init() {
        add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
        add_action( 'save_post_stw_timeline', array( __CLASS__, 'save_meta' ), 10, 2 );
    }

    public static function add_meta_boxes() {
        add_meta_box(
            'stw_timeline_fields',
            __( 'Timeline Item Details', 'static-timeline' ),
            array( __CLASS__, 'render_meta_box' ),
            'stw_timeline',
            'normal',
            'high'
        );
    }

    public static function render_meta_box( $post ) {
        // Nonce for security
        wp_nonce_field( 'stw_save_meta_' . $post->ID, 'stw_meta_nonce' );

        // Get saved values
        $date        = get_post_meta( $post->ID, '_stw_date',        true );
        $heading     = get_post_meta( $post->ID, '_stw_heading',     true );
        $sub_heading = get_post_meta( $post->ID, '_stw_sub_heading', true );
        $paragraph   = get_post_meta( $post->ID, '_stw_paragraph',   true );
        $image_url   = get_post_meta( $post->ID, '_stw_image_url',   true );
        $icon_url    = get_post_meta( $post->ID, '_stw_icon_url',    true );
        $position    = get_post_meta( $post->ID, '_stw_position',    true );
        $order       = get_post_meta( $post->ID, '_stw_order',       true );

        if ( empty( $position ) ) {
            $position = 'left';
        }
        ?>
        <div class="stw-meta-wrap">

            <!-- Date -->
            <div class="stw-field-row">
                <label for="stw_date"><?php esc_html_e( 'Date / Label', 'static-timeline' ); ?></label>
                <input
                    type="text"
                    id="stw_date"
                    name="stw_date"
                    value="<?php echo esc_attr( $date ); ?>"
                    placeholder="e.g. 02 September 2019"
                    class="stw-input-full"
                />
            </div>

            <!-- Heading -->
            <div class="stw-field-row">
                <label for="stw_heading"><?php esc_html_e( 'Main Heading', 'static-timeline' ); ?></label>
                <input
                    type="text"
                    id="stw_heading"
                    name="stw_heading"
                    value="<?php echo esc_attr( $heading ); ?>"
                    placeholder="e.g. How to Include Elementor Template"
                    class="stw-input-full"
                />
            </div>

            <!-- Sub Heading -->
            <div class="stw-field-row">
                <label for="stw_sub_heading"><?php esc_html_e( 'Sub Heading / Tag', 'static-timeline' ); ?></label>
                <input
                    type="text"
                    id="stw_sub_heading"
                    name="stw_sub_heading"
                    value="<?php echo esc_attr( $sub_heading ); ?>"
                    placeholder="e.g. Tutorial | WordPress"
                    class="stw-input-full"
                />
            </div>

            <!-- Paragraph -->
            <div class="stw-field-row">
                <label for="stw_paragraph"><?php esc_html_e( 'Description / Paragraph', 'static-timeline' ); ?></label>
                <textarea
                    id="stw_paragraph"
                    name="stw_paragraph"
                    rows="4"
                    class="stw-input-full"
                    placeholder="Write a short description..."
                ><?php echo esc_textarea( $paragraph ); ?></textarea>
            </div>

            <!-- Image Upload -->
            <div class="stw-field-row stw-media-row">
                <label><?php esc_html_e( 'Content Image (optional)', 'static-timeline' ); ?></label>
                <div class="stw-media-preview">
                    <?php if ( $image_url ) : ?>
                        <img src="<?php echo esc_url( $image_url ); ?>" id="stw_image_preview" style="max-width:150px;height:auto;" />
                    <?php else : ?>
                        <img src="" id="stw_image_preview" style="max-width:150px;height:auto;display:none;" />
                    <?php endif; ?>
                </div>
                <input type="hidden" id="stw_image_url" name="stw_image_url" value="<?php echo esc_attr( $image_url ); ?>" />
                <button type="button" class="button stw-upload-btn" data-target="stw_image_url" data-preview="stw_image_preview">
                    <?php esc_html_e( 'Upload / Select Image', 'static-timeline' ); ?>
                </button>
                <?php if ( $image_url ) : ?>
                    <button type="button" class="button stw-remove-btn" data-target="stw_image_url" data-preview="stw_image_preview">
                        <?php esc_html_e( 'Remove', 'static-timeline' ); ?>
                    </button>
                <?php else : ?>
                    <button type="button" class="button stw-remove-btn" data-target="stw_image_url" data-preview="stw_image_preview" style="display:none;">
                        <?php esc_html_e( 'Remove', 'static-timeline' ); ?>
                    </button>
                <?php endif; ?>
            </div>

            <!-- Icon Upload -->
            <div class="stw-field-row stw-media-row">
                <label><?php esc_html_e( 'Timeline Icon (center circle icon)', 'static-timeline' ); ?></label>
                <p class="stw-help"><?php esc_html_e( 'Recommended: 40×40px PNG/SVG icon (will appear inside the circle on the timeline line)', 'static-timeline' ); ?></p>
                <div class="stw-media-preview">
                    <?php if ( $icon_url ) : ?>
                        <img src="<?php echo esc_url( $icon_url ); ?>" id="stw_icon_preview" style="max-width:60px;height:auto;" />
                    <?php else : ?>
                        <img src="" id="stw_icon_preview" style="max-width:60px;height:auto;display:none;" />
                    <?php endif; ?>
                </div>
                <input type="hidden" id="stw_icon_url" name="stw_icon_url" value="<?php echo esc_attr( $icon_url ); ?>" />
                <button type="button" class="button stw-upload-btn" data-target="stw_icon_url" data-preview="stw_icon_preview">
                    <?php esc_html_e( 'Upload / Select Icon', 'static-timeline' ); ?>
                </button>
                <?php if ( $icon_url ) : ?>
                    <button type="button" class="button stw-remove-btn" data-target="stw_icon_url" data-preview="stw_icon_preview">
                        <?php esc_html_e( 'Remove', 'static-timeline' ); ?>
                    </button>
                <?php else : ?>
                    <button type="button" class="button stw-remove-btn" data-target="stw_icon_url" data-preview="stw_icon_preview" style="display:none;">
                        <?php esc_html_e( 'Remove', 'static-timeline' ); ?>
                    </button>
                <?php endif; ?>
            </div>

            <!-- Position -->
            <div class="stw-field-row">
                <label><?php esc_html_e( 'Card Position', 'static-timeline' ); ?></label>
                <select name="stw_position" id="stw_position">
                    <option value="left"  <?php selected( $position, 'left' );  ?>><?php esc_html_e( 'Left side', 'static-timeline' ); ?></option>
                    <option value="right" <?php selected( $position, 'right' ); ?>><?php esc_html_e( 'Right side', 'static-timeline' ); ?></option>
                </select>
            </div>

            <!-- Order -->
            <div class="stw-field-row">
                <label for="stw_order"><?php esc_html_e( 'Display Order (1, 2, 3...)', 'static-timeline' ); ?></label>
                <input
                    type="number"
                    id="stw_order"
                    name="stw_order"
                    value="<?php echo esc_attr( $order ); ?>"
                    min="0"
                    class="small-text"
                />
            </div>

        </div>
        <?php
    }

    public static function save_meta( $post_id, $post ) {
        // Verify nonce
        if (
            ! isset( $_POST['stw_meta_nonce'] ) ||
            ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['stw_meta_nonce'] ) ), 'stw_save_meta_' . $post_id )
        ) {
            return;
        }

        // Prevent autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // Check capability
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Check post type
        if ( $post->post_type !== 'stw_timeline' ) {
            return;
        }

        // Sanitize & Save each field
        $fields = array(
            'stw_date'        => '_stw_date',
            'stw_heading'     => '_stw_heading',
            'stw_sub_heading' => '_stw_sub_heading',
            'stw_position'    => '_stw_position',
        );

        foreach ( $fields as $field => $meta_key ) {
            if ( isset( $_POST[ $field ] ) ) {
                update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
            }
        }

        // Paragraph - allow basic text
        if ( isset( $_POST['stw_paragraph'] ) ) {
            update_post_meta( $post_id, '_stw_paragraph', sanitize_textarea_field( wp_unslash( $_POST['stw_paragraph'] ) ) );
        }

        // URLs - sanitize as URLs
        $url_fields = array(
            'stw_image_url' => '_stw_image_url',
            'stw_icon_url'  => '_stw_icon_url',
        );

        foreach ( $url_fields as $field => $meta_key ) {
            if ( isset( $_POST[ $field ] ) ) {
                update_post_meta( $post_id, $meta_key, esc_url_raw( wp_unslash( $_POST[ $field ] ) ) );
            }
        }

        // Order - integer
        if ( isset( $_POST['stw_order'] ) ) {
            update_post_meta( $post_id, '_stw_order', absint( $_POST['stw_order'] ) );
        }
    }
}

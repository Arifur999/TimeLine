<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class STWEL_Meta {
    public static function init() {
        add_action( 'add_meta_boxes',         [ __CLASS__, 'add'  ] );
        add_action( 'save_post_stwel_item',   [ __CLASS__, 'save' ], 10, 2 );
    }

    public static function add() {
        add_meta_box( 'stwel_fields', '📅 Timeline Item Details',
            [ __CLASS__, 'render' ], 'stwel_item', 'normal', 'high' );
    }

    public static function render( $post ) {
        wp_nonce_field( 'stwel_save_' . $post->ID, 'stwel_nonce' );
        $g = fn( $k ) => get_post_meta( $post->ID, $k, true );
        $pos = $g('_stwel_pos') ?: 'left';
        ?>
        <div class="stw-meta-wrap">

            <div class="stw-row">
                <label><strong>Date / Label</strong></label>
                <input type="text" name="stwel_date"
                       value="<?php echo esc_attr( $g('_stwel_date') ); ?>"
                       placeholder="e.g. 2016–2028  or  02 September 2019"
                       class="stw-full" />
            </div>

            <div class="stw-row">
                <label><strong>Main Heading</strong></label>
                <input type="text" name="stwel_heading"
                       value="<?php echo esc_attr( $g('_stwel_heading') ); ?>"
                       placeholder="Growing Our Reach"
                       class="stw-full" />
            </div>

            <div class="stw-row">
                <label><strong>Sub Heading / Tag</strong></label>
                <input type="text" name="stwel_sub"
                       value="<?php echo esc_attr( $g('_stwel_sub') ); ?>"
                       placeholder="Milestone | Award | Tutorial"
                       class="stw-full" />
            </div>

            <div class="stw-row">
                <label><strong>Description</strong></label>
                <textarea name="stwel_para" rows="4" class="stw-full"
                    placeholder="Write a short description..."><?php echo esc_textarea( $g('_stwel_para') ); ?></textarea>
            </div>

            <!-- Image -->
            <div class="stw-row stw-media-row">
                <label><strong>Content Image</strong> <span class="stw-help">(optional)</span></label>
                <div class="stw-preview">
                    <img id="stwel_img_prev" src="<?php echo esc_url( $g('_stwel_img') ); ?>"
                         style="max-width:150px;border-radius:6px;<?php echo $g('_stwel_img') ? '' : 'display:none'; ?>" />
                </div>
                <input type="hidden" id="stwel_img" name="stwel_img" value="<?php echo esc_attr( $g('_stwel_img') ); ?>" />
                <button type="button" class="button stw-upload-btn" data-target="stwel_img" data-preview="stwel_img_prev">📁 Upload Image</button>
                <button type="button" class="button stw-remove-btn" data-target="stwel_img" data-preview="stwel_img_prev"
                        style="<?php echo $g('_stwel_img') ? '' : 'display:none'; ?>">✕ Remove</button>
            </div>

            <!-- Icon -->
            <div class="stw-row stw-media-row">
                <label><strong>Center Icon</strong> <span class="stw-help">(circle icon — white PNG/SVG recommended, 40×40px)</span></label>
                <div class="stw-preview">
                    <img id="stwel_icon_prev" src="<?php echo esc_url( $g('_stwel_icon') ); ?>"
                         style="max-width:60px;<?php echo $g('_stwel_icon') ? '' : 'display:none'; ?>" />
                </div>
                <input type="hidden" id="stwel_icon" name="stwel_icon" value="<?php echo esc_attr( $g('_stwel_icon') ); ?>" />
                <button type="button" class="button stw-upload-btn" data-target="stwel_icon" data-preview="stwel_icon_prev">📁 Upload Icon</button>
                <button type="button" class="button stw-remove-btn" data-target="stwel_icon" data-preview="stwel_icon_prev"
                        style="<?php echo $g('_stwel_icon') ? '' : 'display:none'; ?>">✕ Remove</button>
            </div>

            <!-- Position & Order -->
            <div class="stw-row stw-two-col">
                <div>
                    <label><strong>Card Position</strong></label>
                    <select name="stwel_pos" style="width:100%;">
                        <option value="left"  <?php selected($pos,'left');  ?>>← Left</option>
                        <option value="right" <?php selected($pos,'right'); ?>>Right →</option>
                    </select>
                </div>
                <div>
                    <label><strong>Display Order</strong> <span class="stw-help">(1, 2, 3…)</span></label>
                    <input type="number" name="stwel_order"
                           value="<?php echo esc_attr( $g('_stwel_order') ); ?>"
                           min="0" class="small-text" placeholder="1" />
                </div>
            </div>

        </div>
        <?php
    }

    public static function save( $post_id, $post ) {
        if ( ! isset( $_POST['stwel_nonce'] ) ||
             ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['stwel_nonce'] ) ), 'stwel_save_' . $post_id ) ) return;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
        if ( ! current_user_can( 'edit_post', $post_id ) ) return;
        if ( $post->post_type !== 'stwel_item' ) return;

        $text = [ 'stwel_date'=>'_stwel_date', 'stwel_heading'=>'_stwel_heading',
                  'stwel_sub'=>'_stwel_sub',   'stwel_pos'=>'_stwel_pos' ];
        foreach ( $text as $k => $m ) {
            if ( isset( $_POST[$k] ) ) update_post_meta( $post_id, $m, sanitize_text_field( wp_unslash( $_POST[$k] ) ) );
        }
        if ( isset( $_POST['stwel_para'] ) )
            update_post_meta( $post_id, '_stwel_para', sanitize_textarea_field( wp_unslash( $_POST['stwel_para'] ) ) );
        foreach ( [ 'stwel_img'=>'_stwel_img', 'stwel_icon'=>'_stwel_icon' ] as $k => $m ) {
            if ( isset( $_POST[$k] ) ) update_post_meta( $post_id, $m, esc_url_raw( wp_unslash( $_POST[$k] ) ) );
        }
        if ( isset( $_POST['stwel_order'] ) )
            update_post_meta( $post_id, '_stwel_order', absint( $_POST['stwel_order'] ) );
    }
}

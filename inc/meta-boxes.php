<?php
defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   Narrative Sections — custom repeater meta box (ACF Free compatible)
   Post type : work
   Meta key  : _cs_narrative_sections
   Structure : array of rows {
       label, headline, body,
       gallery: [ { type: 'single'|'pair', ids: [att_id, ...] }, ... ]
   }
   ========================================================================== */


// ── Register meta box ────────────────────────────────────────────────────────

add_action( 'add_meta_boxes', function (): void {
    add_meta_box(
        'cs_narrative_sections',
        'Narrative Sections',
        'cs_render_narrative_meta_box',
        'work',
        'normal',
        'high'
    );
} );


// ── Admin assets ─────────────────────────────────────────────────────────────

add_action( 'admin_enqueue_scripts', function ( string $hook ): void {
    global $post;
    if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) return;
    if ( ! $post || get_post_type( $post ) !== 'work' ) return;

    wp_enqueue_media();

    wp_enqueue_script(
        'cs-narrative-admin',
        MONTOYA_URI . '/assets/js/admin-narrative.js',
        [ 'jquery', 'media-upload' ],
        MONTOYA_VERSION,
        true
    );

    wp_enqueue_style(
        'cs-narrative-admin',
        MONTOYA_URI . '/assets/css/admin-narrative.css',
        [],
        MONTOYA_VERSION
    );
} );


// ── Render meta box ──────────────────────────────────────────────────────────

function cs_render_narrative_meta_box( WP_Post $post ): void {
    wp_nonce_field( 'cs_save_narrative_sections', 'cs_narrative_nonce' );

    $sections = get_post_meta( $post->ID, '_cs_narrative_sections', true );
    if ( ! is_array( $sections ) ) $sections = [];
    ?>
    <div id="cs-narrative-wrap">
        <div id="cs-narrative-rows">
            <?php foreach ( $sections as $i => $section ) :
                cs_narrative_row( $i, $section );
            endforeach; ?>
        </div>
        <button type="button" id="cs-narrative-add" class="button button-primary">+ Add Section</button>
    </div>

    <?php /* ── JS templates ── */ ?>

    <script type="text/html" id="cs-narrative-tpl">
        <?php cs_narrative_row( '__IDX__', [] ); ?>
    </script>

    <script type="text/html" id="cs-gallery-row-single-tpl">
        <?php cs_gallery_row( '__IDX__', '__GDX__', 'single', [] ); ?>
    </script>

    <script type="text/html" id="cs-gallery-row-pair-tpl">
        <?php cs_gallery_row( '__IDX__', '__GDX__', 'pair', [] ); ?>
    </script>
    <?php
}


// ── Narrative section row ────────────────────────────────────────────────────

function cs_narrative_row( $index, array $row ): void {
    $label    = esc_attr( $row['label']    ?? '' );
    $headline = esc_attr( $row['headline'] ?? '' );
    $body     = esc_textarea( $row['body'] ?? '' );
    $gallery  = is_array( $row['gallery'] ?? null ) ? $row['gallery'] : [];
    ?>
    <div class="cs-row" data-index="<?php echo esc_attr( $index ); ?>">

        <div class="cs-row__header">
            <span class="cs-row__drag" title="Drag to reorder">⠿</span>
            <span class="cs-row__label"><?php echo $headline ? esc_html( $headline ) : 'New Section'; ?></span>
            <button type="button" class="cs-row__remove button-link-delete">Remove</button>
        </div>

        <div class="cs-row__body">
            <p>
                <label>Label <em>(rendered in parentheses)</em></label>
                <input class="widefat" type="text"
                    name="cs_narrative[<?php echo esc_attr( $index ); ?>][label]"
                    value="<?php echo $label; ?>">
            </p>
            <p>
                <label>Headline</label>
                <input class="widefat" type="text"
                    name="cs_narrative[<?php echo esc_attr( $index ); ?>][headline]"
                    value="<?php echo $headline; ?>">
            </p>
            <p>
                <label>Body</label>
                <textarea class="widefat" rows="6"
                    name="cs_narrative[<?php echo esc_attr( $index ); ?>][body]"><?php echo $body; ?></textarea>
            </p>
            <div class="cs-gallery-wrap">
                <label>Images</label>
                <div class="cs-gallery-rows">
                    <?php foreach ( $gallery as $gi => $g_row ) :
                        $type = ( ( $g_row['type'] ?? 'single' ) === 'pair' ) ? 'pair' : 'single';
                        $ids  = array_filter( array_map( 'absint', (array) ( $g_row['ids'] ?? [] ) ) );
                        cs_gallery_row( $index, $gi, $type, array_values( $ids ) );
                    endforeach; ?>
                </div>
                <span class="cs-gallery-actions">
                    <button type="button" class="button cs-add-gallery-single">+ Single image</button>
                    <button type="button" class="button cs-add-gallery-pair">+ Row of 2</button>
                </span>
            </div>
        </div>

    </div>
    <?php
}


// ── Gallery row (single or pair) ─────────────────────────────────────────────

function cs_gallery_row( $section_idx, $gallery_idx, string $type, array $ids ): void {
    $slots = $type === 'pair' ? 2 : 1;
    ?>
    <div class="cs-gallery-row cs-gallery-row--<?php echo $type; ?>">

        <div class="cs-gallery-row__header">
            <span class="cs-gallery-row__label"><?php echo $type === 'pair' ? 'Row of 2' : 'Single image'; ?></span>
            <button type="button" class="cs-gallery-row__remove button-link-delete">Remove row</button>
        </div>

        <div class="cs-gallery-row__slots">
            <?php for ( $s = 0; $s < $slots; $s++ ) :
                $att_id = $ids[ $s ] ?? 0;
                $thumb  = $att_id ? wp_get_attachment_image_src( $att_id, 'thumbnail' ) : null;
            ?>
            <div class="cs-gallery-slot"
                data-section="<?php echo esc_attr( $section_idx ); ?>"
                data-grow="<?php echo esc_attr( $gallery_idx ); ?>">

                <?php if ( $thumb ) : ?>
                <span class="cs-slot-img">
                    <img src="<?php echo esc_url( $thumb[0] ); ?>" width="80" height="80">
                    <input type="hidden"
                        name="cs_narrative[<?php echo esc_attr( $section_idx ); ?>][gallery][<?php echo esc_attr( $gallery_idx ); ?>][ids][]"
                        value="<?php echo $att_id; ?>">
                    <button type="button" class="cs-slot-img__remove" aria-label="Remove">&times;</button>
                </span>
                <?php else : ?>
                <button type="button" class="button cs-slot__add">Add Image</button>
                <?php endif; ?>

            </div>
            <?php endfor; ?>
        </div>

        <input type="hidden"
            name="cs_narrative[<?php echo esc_attr( $section_idx ); ?>][gallery][<?php echo esc_attr( $gallery_idx ); ?>][type]"
            value="<?php echo $type; ?>">

    </div>
    <?php
}


// ── Save ─────────────────────────────────────────────────────────────────────

add_action( 'save_post', function ( int $post_id ): void {
    if ( ! isset( $_POST['cs_narrative_nonce'] ) ||
         ! wp_verify_nonce( $_POST['cs_narrative_nonce'], 'cs_save_narrative_sections' ) ) return;

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( get_post_type( $post_id ) !== 'work' )           return;
    if ( ! current_user_can( 'edit_post', $post_id ) )    return;

    $sections = [];
    $raw      = isset( $_POST['cs_narrative'] ) && is_array( $_POST['cs_narrative'] )
                ? $_POST['cs_narrative'] : [];

    foreach ( $raw as $row ) {
        $label    = sanitize_text_field( $row['label']    ?? '' );
        $headline = sanitize_text_field( $row['headline'] ?? '' );
        $body     = sanitize_textarea_field( $row['body'] ?? '' );

        $gallery = [];
        foreach ( (array) ( $row['gallery'] ?? [] ) as $g_row ) {
            $type = ( ( $g_row['type'] ?? 'single' ) === 'pair' ) ? 'pair' : 'single';
            $ids  = array_values( array_filter( array_map( 'absint', (array) ( $g_row['ids'] ?? [] ) ) ) );
            if ( ! $ids ) continue;
            $gallery[] = [ 'type' => $type, 'ids' => $ids ];
        }

        if ( ! $label && ! $headline && ! $body && ! $gallery ) continue;

        $sections[] = compact( 'label', 'headline', 'body', 'gallery' );
    }

    update_post_meta( $post_id, '_cs_narrative_sections', $sections );
} );

<?php
defined( 'ABSPATH' ) || exit;

/* ==========================================================================
   Narrative Sections — custom repeater meta box
   Works with ACF Free — no Pro required.
   Post type : work
   Meta key  : _cs_narrative_sections
   Structure : array of rows { label, headline, body, image_ids[] }
   ========================================================================== */


// ── Register meta box ────────────────────────────────────────────────────────

add_action( 'add_meta_boxes', function (): void {
    add_meta_box(
        'cs_narrative_sections',
        'Narrative Sections (2 onwards)',
        'cs_render_narrative_meta_box',
        'work',
        'normal',
        'high'
    );
} );


// ── Admin assets — only on work edit screens ─────────────────────────────────

add_action( 'admin_enqueue_scripts', function ( string $hook ): void {
    global $post;
    if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) return;
    if ( ! $post || get_post_type( $post ) !== 'work' ) return;

    wp_enqueue_media(); // required for wp.media()

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
        <button type="button" id="cs-narrative-add" class="button button-primary">
            + Add Section
        </button>
    </div>

    <?php /* JS template — __INDEX__ is replaced client-side */ ?>
    <script type="text/html" id="cs-narrative-tpl">
        <?php cs_narrative_row( '__INDEX__', [] ); ?>
    </script>
    <?php
}


// ── Single row markup (used for both existing rows and JS template) ──────────

function cs_narrative_row( $index, array $row ): void {
    $label    = esc_attr( $row['label']    ?? '' );
    $headline = esc_attr( $row['headline'] ?? '' );
    $body     = esc_textarea( $row['body'] ?? '' );
    $ids      = array_filter( array_map( 'absint', (array) ( $row['image_ids'] ?? [] ) ) );
    ?>
    <div class="cs-row" data-index="<?php echo esc_attr( $index ); ?>">

        <div class="cs-row__header">
            <span class="cs-row__drag" title="Drag to reorder">⠿</span>
            <span class="cs-row__label"><?php echo $headline ? esc_html( $headline ) : 'New Section'; ?></span>
            <button type="button" class="cs-row__remove button-link-delete">Remove</button>
        </div>

        <div class="cs-row__body">

            <p>
                <label>Label <em>(rendered in parentheses — e.g. "The Approach")</em></label>
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

            <p>
                <label>Images <em>(1 image → full width · 2+ → paired rows of 2)</em></label>
                <span class="cs-images" data-index="<?php echo esc_attr( $index ); ?>">
                    <?php foreach ( $ids as $att_id ) :
                        $thumb = wp_get_attachment_image_src( $att_id, 'thumbnail' );
                        if ( ! $thumb ) continue;
                    ?>
                    <span class="cs-img">
                        <img src="<?php echo esc_url( $thumb[0] ); ?>" width="60" height="60"
                            alt="<?php echo esc_attr( get_post_meta( $att_id, '_wp_attachment_image_alt', true ) ); ?>">
                        <input type="hidden"
                            name="cs_narrative[<?php echo esc_attr( $index ); ?>][image_ids][]"
                            value="<?php echo $att_id; ?>">
                        <button type="button" class="cs-img__remove" aria-label="Remove image">&times;</button>
                    </span>
                    <?php endforeach; ?>
                    <button type="button" class="button cs-images__add">Add Images</button>
                </span>
            </p>

        </div><!-- .cs-row__body -->

    </div><!-- .cs-row -->
    <?php
}


// ── Save ─────────────────────────────────────────────────────────────────────

add_action( 'save_post', function ( int $post_id ): void {
    if ( ! isset( $_POST['cs_narrative_nonce'] ) ||
         ! wp_verify_nonce( $_POST['cs_narrative_nonce'], 'cs_save_narrative_sections' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( get_post_type( $post_id ) !== 'work' )           return;
    if ( ! current_user_can( 'edit_post', $post_id ) )    return;

    $sections = [];
    $raw      = isset( $_POST['cs_narrative'] ) && is_array( $_POST['cs_narrative'] )
                ? $_POST['cs_narrative']
                : [];

    foreach ( $raw as $row ) {
        $label    = sanitize_text_field( $row['label']    ?? '' );
        $headline = sanitize_text_field( $row['headline'] ?? '' );
        $body     = sanitize_textarea_field( $row['body'] ?? '' );
        $ids      = array_values( array_filter( array_map( 'absint', (array) ( $row['image_ids'] ?? [] ) ) ) );

        if ( ! $label && ! $headline && ! $body && ! $ids ) continue;

        $sections[] = [
            'label'     => $label,
            'headline'  => $headline,
            'body'      => $body,
            'image_ids' => $ids,
        ];
    }

    update_post_meta( $post_id, '_cs_narrative_sections', $sections );
} );

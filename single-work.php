<?php
/**
 * Template Name: Case Study
 * Template Post Type: work
 *
 * ACF fields expected:
 *
 *  TOP BLOCK (do not modify):
 *  hero_image   — image
 *  client       — text
 *  industry     — textarea (one value per line)
 *  scope        — textarea (one value per line)
 *  statement    — textarea
 *  website_url  — url (optional)
 *
 *  SECTION 1 (ACF Free flat fields):
 *  section_1_label    — text
 *  section_1_headline — text
 *  section_1_body     — wysiwyg
 *  section_1_images   — gallery   1 image → full-width · 2+ → paired rows of 2
 *
 *  SECTIONS 2+ (custom repeater meta box — inc/meta-boxes.php):
 *  _cs_narrative_sections  — post meta, array of { label, headline, body, image_ids[] }
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( have_posts() ) : the_post();

$has_acf = function_exists( 'get_field' );

// ── Helper: split ACF textarea into trimmed lines ────────────────────────────
function cs_lines( string $field ): array {
    global $has_acf;
    if ( ! $has_acf ) return [];
    $raw = get_field( $field );
    if ( ! $raw ) return [];
    return array_filter( array_map( 'trim', explode( "\n", $raw ) ) );
}

$hero_img    = $has_acf ? get_field( 'hero_image' )   : null;
$client      = $has_acf ? get_field( 'client' )       : '';
$industry    = cs_lines( 'industry' );
$scope       = cs_lines( 'scope' );
$statement   = $has_acf ? get_field( 'statement' )    : '';
$website_url = $has_acf ? get_field( 'website_url' )  : '';
// ── Section 1 — ACF flat fields ─────────────────────────────────────────────
$sections = [];
if ( $has_acf ) {
    $sections[] = [
        'label'    => get_field( 'section_1_label' ),
        'headline' => get_field( 'section_1_headline' ),
        'body'     => get_field( 'section_1_body' ),    // WYSIWYG — already HTML
        'images'   => get_field( 'section_1_images' ) ?: [],
        'acf'      => true,
    ];
}

// ── Sections 2+ — custom repeater (inc/meta-boxes.php) ──────────────────────
$meta_rows = get_post_meta( get_the_ID(), '_cs_narrative_sections', true );
if ( is_array( $meta_rows ) ) {
    foreach ( $meta_rows as $meta_row ) {
        // Resolve attachment IDs → image arrays matching the ACF image format
        $images = [];
        foreach ( array_filter( array_map( 'absint', (array) ( $meta_row['image_ids'] ?? [] ) ) ) as $att_id ) {
            $src = wp_get_attachment_image_src( $att_id, 'full' );
            if ( ! $src ) continue;
            $images[] = [
                'url'    => $src[0],
                'width'  => $src[1],
                'height' => $src[2],
                'alt'    => (string) get_post_meta( $att_id, '_wp_attachment_image_alt', true ),
            ];
        }
        $sections[] = [
            'label'    => $meta_row['label']    ?? '',
            'headline' => $meta_row['headline'] ?? '',
            'body'     => $meta_row['body']     ?? '',  // plain textarea — needs wpautop
            'images'   => $images,
            'acf'      => false,
        ];
    }
}
?>

<main id="main" class="site-main">

    <!-- ══════════════════════════════════════════════════════════
         § 1  HERO — scope + statement + metas + full-bleed image
         ══════════════════════════════════════════════════════════ -->
    <section class="cs-hero">

        <div class="cs-overview__inner">

            <div class="cs-overview__scope">
                <span class="cs-label">(Scope)</span>
                <?php if ( $scope ) : ?>
                <ul class="cs-overview__scope-list">
                    <?php foreach ( $scope as $item ) : ?>
                        <li class="cs-overview__scope-item"><?php echo esc_html( $item ); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>

            <div class="cs-hero__right">

                <?php if ( $statement ) : ?>
                <p class="cs-overview__statement"><?php echo esc_html( $statement ); ?></p>
                <?php endif; ?>

                <div class="cs-hero__metas">

                    <?php if ( $client ) : ?>
                    <div class="cs-hero__meta-group">
                        <span class="hp-project__tax-label">Client</span>
                        <span class="cs-hero__meta-value"><?php echo esc_html( $client ); ?></span>
                    </div>
                    <?php endif; ?>

                    <?php if ( $industry ) : ?>
                    <div class="cs-hero__meta-group">
                        <span class="hp-project__tax-label">Industry</span>
                        <ul class="cs-hero__meta-list">
                            <?php foreach ( $industry as $tag ) : ?>
                                <li><?php echo esc_html( $tag ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                </div><!-- .cs-hero__metas -->

                <?php if ( $website_url ) : ?>
                <a href="<?php echo esc_url( $website_url ); ?>" class="hp-work__all-link" target="_blank" rel="noopener noreferrer">
                    <span class="hp-work__all-link-arrow" aria-hidden="true">
                        <img src="<?php echo esc_url( MONTOYA_URI . '/assets/images/arrow.svg' ); ?>" alt="" width="15" height="16">
                    </span>
                    <?php esc_html_e( 'Visit Website', 'montoya-portfolio' ); ?>
                </a>
                <?php endif; ?>

            </div><!-- .cs-hero__right -->

        </div><!-- .cs-overview__inner -->

        <figure class="cs-hero__image breakout">
            <?php if ( $hero_img ) : ?>
                <img
                    src="<?php echo esc_url( $hero_img['url'] ); ?>"
                    alt="<?php echo esc_attr( $hero_img['alt'] ); ?>"
                    width="<?php echo esc_attr( $hero_img['width'] ); ?>"
                    height="<?php echo esc_attr( $hero_img['height'] ); ?>"
                    loading="eager"
                    decoding="async"
                >
            <?php else : ?>
                <div class="cs-placeholder" aria-hidden="true"></div>
            <?php endif; ?>
        </figure>

    </section><!-- .cs-hero -->


    <!-- ══════════════════════════════════════════════════════════
         NARRATIVE SECTIONS — flat ACF fields, up to 5
         Fields: section_N_label, section_N_headline, section_N_body, section_N_images
         Empty rows are skipped automatically
         ══════════════════════════════════════════════════════════ -->
    <?php if ( $sections ) : foreach ( $sections as $row ) :

        $label    = trim( $row['label']    ?? '' );
        $headline = trim( $row['headline'] ?? '' );
        $raw_body =       $row['body']     ?? '';
        $images   =       $row['images']   ?? [];
        $is_acf   =       $row['acf']      ?? false;

        // ACF WYSIWYG returns formatted HTML; textarea output needs wpautop
        $body_html = $is_acf
            ? wp_kses_post( $raw_body )
            : wp_kses_post( wpautop( wp_unslash( $raw_body ) ) );

        // Skip entirely empty rows
        if ( ! $label && ! $headline && ! $raw_body && ! $images ) continue;

    ?>
    <section class="cs-narrative">

        <div class="cs-narrative__inner">

            <span class="cs-label"><?php echo $label ? '(' . esc_html( $label ) . ')' : ''; ?></span>

            <div class="cs-narrative__content">

                <?php if ( $headline ) : ?>
                    <h2 class="cs-narrative__headline"><?php echo esc_html( $headline ); ?></h2>
                <?php endif; ?>

                <?php if ( $body_html ) : ?>
                    <div class="cs-narrative__body">
                        <?php echo $body_html; ?>
                    </div>
                <?php endif; ?>

            </div><!-- .cs-narrative__content -->

        </div><!-- .cs-narrative__inner -->

        <?php if ( $images ) :
            // Group into rows of 2; a lone image renders full-width
            foreach ( array_chunk( $images, 2 ) as $row_imgs ) :
                $is_pair = count( $row_imgs ) === 2;
        ?>
        <div class="cs-narrative__img-row<?php echo $is_pair ? ' cs-narrative__img-row--pair' : ''; ?>">
            <?php foreach ( $row_imgs as $img ) : ?>
            <figure>
                <img
                    src="<?php echo esc_url( $img['url'] ); ?>"
                    alt="<?php echo esc_attr( $img['alt'] ); ?>"
                    width="<?php echo esc_attr( $img['width'] ); ?>"
                    height="<?php echo esc_attr( $img['height'] ); ?>"
                    loading="lazy"
                    decoding="async"
                >
            </figure>
            <?php endforeach; ?>
        </div>
        <?php endforeach; endif; ?>

    </section><!-- .cs-narrative -->

    <?php endforeach; endif; ?>


</main><!-- #main -->

<?php
endif; // have_posts
get_footer();

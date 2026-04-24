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
 *  NARRATIVE SECTIONS (custom repeater meta box — inc/meta-boxes.php):
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
// ── All narrative sections — custom repeater (inc/meta-boxes.php) ───────────
$sections  = [];
$meta_rows = get_post_meta( get_the_ID(), '_cs_narrative_sections', true );

if ( is_array( $meta_rows ) ) {
    foreach ( $meta_rows as $meta_row ) {
        // Resolve each gallery row's attachment IDs → image arrays
        $gallery = [];
        foreach ( (array) ( $meta_row['gallery'] ?? [] ) as $g_row ) {
            $type = ( ( $g_row['type'] ?? 'single' ) === 'pair' ) ? 'pair' : 'single';
            $imgs = [];
            foreach ( array_filter( array_map( 'absint', (array) ( $g_row['ids'] ?? [] ) ) ) as $att_id ) {
                $src = wp_get_attachment_image_src( $att_id, 'full' );
                if ( ! $src ) continue;
                $imgs[] = [
                    'url'    => $src[0],
                    'width'  => $src[1],
                    'height' => $src[2],
                    'alt'    => (string) get_post_meta( $att_id, '_wp_attachment_image_alt', true ),
                ];
            }
            if ( $imgs ) $gallery[] = [ 'type' => $type, 'images' => $imgs ];
        }
        $sections[] = [
            'label'    => $meta_row['label']    ?? '',
            'headline' => $meta_row['headline'] ?? '',
            'body'     => $meta_row['body']     ?? '',
            'gallery'  => $gallery,
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
        $gallery  =       $row['gallery']  ?? [];
        $body_html = wp_kses_post( wpautop( wp_unslash( $raw_body ) ) );

        // Skip entirely empty rows
        if ( ! $label && ! $headline && ! $raw_body && ! $gallery ) continue;

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

        <?php if ( $gallery ) : ?>
        <div class="cs-narrative__gallery">
            <?php foreach ( $gallery as $g_row ) :
                $is_pair = $g_row['type'] === 'pair';
            ?>
            <div class="cs-narrative__img-row<?php echo $is_pair ? ' cs-narrative__img-row--pair' : ''; ?>">
                <?php foreach ( $g_row['images'] as $img ) : ?>
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
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </section><!-- .cs-narrative -->

    <?php endforeach; endif; ?>


</main><!-- #main -->

<?php
endif; // have_posts
get_footer();

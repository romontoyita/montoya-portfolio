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
 *
 *  NARRATIVE SECTIONS (up to 5, flat fields — ACF Free compatible):
 *  section_1_label    — text      e.g. "The Situation"   → rendered as (The Situation)
 *  section_1_headline — text      large IvyPresto heading
 *  section_1_body     — wysiwyg   rich-text paragraphs
 *  section_1_image    — image     optional, full-bleed after body
 *  …repeat for section_2_ through section_5_
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

$hero_img  = $has_acf ? get_field( 'hero_image' ) : null;
$client    = $has_acf ? get_field( 'client' )     : '';
$industry  = cs_lines( 'industry' );
$scope     = cs_lines( 'scope' );
$statement = $has_acf ? get_field( 'statement' )  : '';
// Build flat narrative sections array — works with ACF Free (no Repeater needed)
$sections = [];
if ( $has_acf ) {
    for ( $i = 1; $i <= 5; $i++ ) {
        $sections[] = [
            'label'    => get_field( "section_{$i}_label" ),
            'headline' => get_field( "section_{$i}_headline" ),
            'body'     => get_field( "section_{$i}_body" ),
            'image'    => get_field( "section_{$i}_image" ),
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
         Fields: section_N_label, section_N_headline, section_N_body, section_N_image
         Empty rows are skipped; first rendered row gets cs-narrative--first
         ══════════════════════════════════════════════════════════ -->
    <?php if ( $sections ) : foreach ( $sections as $row ) :

        $label    = trim( $row['label']    ?? '' );
        $headline = trim( $row['headline'] ?? '' );
        $body     =       $row['body']     ?? '';
        $img      =       $row['image']    ?? null;

        // Skip entirely empty rows
        if ( ! $label && ! $headline && ! $body && ! $img ) continue;

    ?>
    <section class="cs-narrative">

        <div class="cs-narrative__inner">

            <span class="cs-label"><?php echo $label ? '(' . esc_html( $label ) . ')' : ''; ?></span>

            <div class="cs-narrative__content">

                <?php if ( $headline ) : ?>
                    <h2 class="cs-narrative__headline"><?php echo esc_html( $headline ); ?></h2>
                <?php endif; ?>

                <?php if ( $body ) : ?>
                    <div class="cs-narrative__body">
                        <?php echo wp_kses_post( $body ); ?>
                    </div>
                <?php endif; ?>

            </div><!-- .cs-narrative__content -->

        </div><!-- .cs-narrative__inner -->

        <?php if ( $img ) : ?>
            <figure class="cs-narrative__image">
                <img
                    src="<?php echo esc_url( $img['url'] ); ?>"
                    alt="<?php echo esc_attr( $img['alt'] ); ?>"
                    width="<?php echo esc_attr( $img['width'] ); ?>"
                    height="<?php echo esc_attr( $img['height'] ); ?>"
                    loading="lazy"
                    decoding="async"
                >
            </figure>
        <?php endif; ?>

    </section><!-- .cs-narrative -->

    <?php endforeach; endif; ?>


</main><!-- #main -->

<?php
endif; // have_posts
get_footer();

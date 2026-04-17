<?php
/**
 * Template Name: Case Study
 * Template Post Type: work
 *
 * ACF fields expected:
 *  hero_image      — image
 *  client          — text
 *  industry        — textarea (one value per line)
 *  scope           — textarea (one value per line)
 *  statement       — textarea
 *  problem_title   — text
 *  problem_body    — textarea
 *  problem_image   — image
 *  approach_title  — text
 *  approach_body   — textarea
 *  approach_image  — image
 *  outcome         — textarea
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

$hero_img        = $has_acf ? get_field( 'hero_image' )        : null;
$client          = $has_acf ? get_field( 'client' )             : '';
$industry        = cs_lines( 'industry' );
$scope           = cs_lines( 'scope' );
$statement       = $has_acf ? get_field( 'statement' )          : '';
$problem_img     = $has_acf ? get_field( 'problem_image' )      : null;
$approach_img    = $has_acf ? get_field( 'approach_image' )     : null;
$outcome         = $has_acf ? get_field( 'outcome' )            : '';
$gallery_full    = $has_acf ? get_field( 'gallery_image_full' ) : null;
$gallery_left    = $has_acf ? get_field( 'gallery_image_left' ) : null;
$gallery_right   = $has_acf ? get_field( 'gallery_image_right' ): null;
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
         § 4  THE PROBLEM — content left, image right
         ══════════════════════════════════════════════════════════ -->
    <section class="cs-section cs-section--problem">

        <div class="cs-section__inner">
            <span class="cs-label">(The Problem / Challenge)</span>
            <div class="cs-section__text">
                <?php if ( $has_acf && get_field( 'problem_title' ) ) : ?>
                    <h2 class="cs-section__title"><?php echo esc_html( get_field( 'problem_title' ) ); ?></h2>
                <?php endif; ?>
                <?php if ( $has_acf && get_field( 'problem_body' ) ) : ?>
                    <p class="cs-section__body"><?php echo nl2br( esc_html( get_field( 'problem_body' ) ) ); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <figure class="cs-section__image">
            <?php if ( $problem_img ) : ?>
                <img
                    src="<?php echo esc_url( $problem_img['url'] ); ?>"
                    alt="<?php echo esc_attr( $problem_img['alt'] ); ?>"
                    loading="lazy"
                    decoding="async"
                >
            <?php else : ?>
                <div class="cs-placeholder" aria-hidden="true"></div>
            <?php endif; ?>
        </figure>

    </section><!-- .cs-section--problem -->


    <!-- ══════════════════════════════════════════════════════════
         § 4  THE APPROACH
         ══════════════════════════════════════════════════════════ -->
    <section class="cs-section cs-section--approach">

        <div class="cs-section__inner">
            <span class="cs-label">(The Approach)</span>
            <div class="cs-section__text">
                <?php if ( $has_acf && get_field( 'approach_title' ) ) : ?>
                    <h2 class="cs-section__title"><?php echo esc_html( get_field( 'approach_title' ) ); ?></h2>
                <?php endif; ?>
                <?php if ( $has_acf && get_field( 'approach_body' ) ) : ?>
                    <p class="cs-section__body"><?php echo nl2br( esc_html( get_field( 'approach_body' ) ) ); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <figure class="cs-section__image">
            <?php if ( $approach_img ) : ?>
                <img
                    src="<?php echo esc_url( $approach_img['url'] ); ?>"
                    alt="<?php echo esc_attr( $approach_img['alt'] ); ?>"
                    loading="lazy"
                    decoding="async"
                >
            <?php else : ?>
                <div class="cs-placeholder" aria-hidden="true"></div>
            <?php endif; ?>
        </figure>

    </section><!-- .cs-section--approach -->


    <!-- ══════════════════════════════════════════════════════════
         § 5  THE OUTCOME — large display text
         ══════════════════════════════════════════════════════════ -->
    <section class="cs-outcome">
        <span class="cs-label">(The Outcome)</span>
        <?php if ( $outcome ) : ?>
            <p class="cs-outcome__text"><?php echo esc_html( $outcome ); ?></p>
        <?php endif; ?>
    </section><!-- .cs-outcome -->


    <!-- ══════════════════════════════════════════════════════════
         § 6  GALLERY — full-width + two-up pair
         ══════════════════════════════════════════════════════════ -->
    <?php if ( $gallery_full || $gallery_left || $gallery_right ) : ?>
    <section class="cs-gallery">

        <?php if ( $gallery_full ) : ?>
        <figure class="cs-gallery__full">
            <img
                src="<?php echo esc_url( $gallery_full['url'] ); ?>"
                alt="<?php echo esc_attr( $gallery_full['alt'] ); ?>"
                loading="lazy"
                decoding="async"
            >
        </figure>
        <?php else : ?>
        <div class="cs-gallery__full cs-placeholder" aria-hidden="true"></div>
        <?php endif; ?>

        <div class="cs-gallery__pair">

            <figure class="cs-gallery__item">
                <?php if ( $gallery_left ) : ?>
                    <img
                        src="<?php echo esc_url( $gallery_left['url'] ); ?>"
                        alt="<?php echo esc_attr( $gallery_left['alt'] ); ?>"
                        loading="lazy"
                        decoding="async"
                    >
                <?php else : ?>
                    <div class="cs-placeholder" aria-hidden="true"></div>
                <?php endif; ?>
            </figure>

            <figure class="cs-gallery__item">
                <?php if ( $gallery_right ) : ?>
                    <img
                        src="<?php echo esc_url( $gallery_right['url'] ); ?>"
                        alt="<?php echo esc_attr( $gallery_right['alt'] ); ?>"
                        loading="lazy"
                        decoding="async"
                    >
                <?php else : ?>
                    <div class="cs-placeholder" aria-hidden="true"></div>
                <?php endif; ?>
            </figure>

        </div><!-- .cs-gallery__pair -->

    </section><!-- .cs-gallery -->
    <?php endif; ?>


</main><!-- #main -->

<?php
endif; // have_posts
get_footer();

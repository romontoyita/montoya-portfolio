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
 *  overview_image_a — image
 *  overview_image_b — image
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
$overview_img_a  = $has_acf ? get_field( 'overview_image_a' )   : null;
$overview_img_b  = $has_acf ? get_field( 'overview_image_b' )   : null;
$problem_img     = $has_acf ? get_field( 'problem_image' )      : null;
$approach_img    = $has_acf ? get_field( 'approach_image' )     : null;
$outcome         = $has_acf ? get_field( 'outcome' )            : '';
?>

<main id="main" class="site-main">

    <!-- ══════════════════════════════════════════════════════════
         § 1  HERO — title + meta + full-bleed image
         ══════════════════════════════════════════════════════════ -->
    <section class="cs-hero">

        <div class="cs-hero__top">

            <h1 class="cs-hero__title"><?php the_title(); ?></h1>

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

        </div><!-- .cs-hero__top -->

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
         § 2  OVERVIEW — scope list + statement paragraph
         ══════════════════════════════════════════════════════════ -->
    <section class="cs-overview">
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

            <?php if ( $statement ) : ?>
            <p class="cs-overview__statement"><?php echo esc_html( $statement ); ?></p>
            <?php endif; ?>

        </div>
    </section><!-- .cs-overview -->


    <!-- ══════════════════════════════════════════════════════════
         § 3  OVERVIEW IMAGES — small left + large right
         ══════════════════════════════════════════════════════════ -->
    <?php if ( $overview_img_a || $overview_img_b ) : ?>
    <div class="hp-project__images hp-project__images--standard">

        <figure class="hp-project__image hp-project__image--a">
            <?php if ( $overview_img_a ) : ?>
                <img
                    src="<?php echo esc_url( $overview_img_a['url'] ); ?>"
                    alt="<?php echo esc_attr( $overview_img_a['alt'] ); ?>"
                    loading="lazy"
                    decoding="async"
                >
            <?php else : ?>
                <div class="cs-placeholder" aria-hidden="true"></div>
            <?php endif; ?>
        </figure>

        <figure class="hp-project__image hp-project__image--b">
            <?php if ( $overview_img_b ) : ?>
                <img
                    src="<?php echo esc_url( $overview_img_b['url'] ); ?>"
                    alt="<?php echo esc_attr( $overview_img_b['alt'] ); ?>"
                    loading="lazy"
                    decoding="async"
                >
            <?php else : ?>
                <div class="cs-placeholder" aria-hidden="true"></div>
            <?php endif; ?>
        </figure>

    </div>
    <?php endif; ?>


    <!-- ══════════════════════════════════════════════════════════
         § 4  THE PROBLEM — content left, image right
         ══════════════════════════════════════════════════════════ -->
    <section class="cs-section cs-section--problem">
        <div class="cs-section__inner">

            <div class="cs-section__content">
                <span class="cs-label">(The Problem / Challenge)</span>
                <?php if ( $has_acf && get_field( 'problem_title' ) ) : ?>
                    <h2 class="cs-section__title"><?php echo esc_html( get_field( 'problem_title' ) ); ?></h2>
                <?php endif; ?>
                <?php if ( $has_acf && get_field( 'problem_body' ) ) : ?>
                    <p class="cs-section__body"><?php echo nl2br( esc_html( get_field( 'problem_body' ) ) ); ?></p>
                <?php endif; ?>
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

        </div>
    </section><!-- .cs-section--problem -->


    <!-- ══════════════════════════════════════════════════════════
         § 4  THE APPROACH — image left, content right
         ══════════════════════════════════════════════════════════ -->
    <section class="cs-section cs-section--approach">
        <div class="cs-section__inner">

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

            <div class="cs-section__content">
                <span class="cs-label">(The Approach)</span>
                <?php if ( $has_acf && get_field( 'approach_title' ) ) : ?>
                    <h2 class="cs-section__title"><?php echo esc_html( get_field( 'approach_title' ) ); ?></h2>
                <?php endif; ?>
                <?php if ( $has_acf && get_field( 'approach_body' ) ) : ?>
                    <p class="cs-section__body"><?php echo nl2br( esc_html( get_field( 'approach_body' ) ) ); ?></p>
                <?php endif; ?>
            </div>

        </div>
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


</main><!-- #main -->

<?php
endif; // have_posts
get_footer();

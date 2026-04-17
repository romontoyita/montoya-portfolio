<?php
defined( 'ABSPATH' ) || exit;

/**
 * Template Name: About
 * Applies automatically to any page with slug "about".
 */

get_header();

$uri     = get_template_directory_uri();
$has_acf = function_exists( 'get_field' );

// ── ACF fields with fallback defaults ────────────────────────────────────────
$label    = ( $has_acf && get_field( 'ab_intro_label' ) )    ? get_field( 'ab_intro_label' )    : 'ABOUT';
$headline = ( $has_acf && get_field( 'ab_intro_headline' ) ) ? get_field( 'ab_intro_headline' ) : 'Design shaped through clarity, restraint, and long-term thinking.';
$body_raw = ( $has_acf && get_field( 'ab_intro_body' ) )     ? get_field( 'ab_intro_body' )
    : "Founded and directed by Rocío Montoya, Montoya Studio is an independent creative practice working across identity, digital design, and development.\n\nWe partner with brands seeking thoughtful execution, aesthetic precision, and systems built to endure.";
$image    = $has_acf ? get_field( 'ab_intro_image' ) : null;


?>

    <!-- =============================================
         ABOUT — § 1  INTRO
         asymmetric: portrait image left | label + headline + body right
    ============================================= -->
    <section class="ab-intro" aria-label="<?php esc_attr_e( 'About the studio', 'montoya-portfolio' ); ?>">

        <div class="ab-intro__inner container">

            <div class="ab-intro__image-col" data-js="ab-intro-image">
                <figure class="ab-intro__figure">
                    <?php if ( $image ) : ?>
                        <img
                            src="<?php echo esc_url( $image['url'] ); ?>"
                            alt="<?php echo esc_attr( $image['alt'] ); ?>"
                            class="ab-intro__image"
                            width="<?php echo esc_attr( $image['width'] ); ?>"
                            height="<?php echo esc_attr( $image['height'] ); ?>"
                            loading="lazy"
                        >
                    <?php else : ?>
                        <img
                            src="<?php echo esc_url( $uri . '/assets/images/about-portrait.jpg' ); ?>"
                            alt=""
                            class="ab-intro__image"
                            width="684"
                            height="808"
                            loading="lazy"
                        >
                    <?php endif; ?>
                </figure>
            </div>

            <div class="ab-intro__content-col">
                <span class="ab-intro__label">(<?php echo esc_html( $label ); ?>)</span>
                <h1 class="ab-intro__headline" data-js="ab-intro-headline">
                    <?php echo esc_html( $headline ); ?>
                </h1>
                <div class="ab-intro__body" data-js="ab-intro-body">
                    <?php echo wp_kses_post( wpautop( $body_raw ) ); ?>
                </div>
            </div>

        </div>

    </section><!-- .ab-intro -->

<?php get_footer(); ?>

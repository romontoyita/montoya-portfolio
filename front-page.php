<?php
/**
 * Template Name: Homepage
 * Homepage template — static Phase 1 content.
 * DOM structured for GSAP/Lenis integration in Phase 2.
 */
defined( 'ABSPATH' ) || exit;
get_header();
$uri = get_template_directory_uri();
?>

<article class="home-page">

    <!-- =============================================
         § 1  HERO
         disciplines bar → large display heading → full-bleed image
    ============================================= -->
    <section class="hp-hero" aria-label="<?php esc_attr_e( 'Studio introduction', 'montoya-portfolio' ); ?>">

        <div class="hp-hero__inner container">

            <div class="hp-hero__top">

                <div class="hp-hero__left">
                    <span class="hp-hero__label">(A STUDIO)</span>
                    <div class="hp-hero__disciplines">
                        <span class="hp-hero__discipline">Creative Direction</span>
                        <span class="hp-hero__discipline">Art Direction</span>
                        <span class="hp-hero__discipline">Design</span>
                        <span class="hp-hero__discipline">Development</span>
                    </div>
                </div>

                <h1 class="hp-hero__heading">
                    For brands with quiet ambition. <br>
                    We design with precision, sensibility and cultural permanence.
                </h1>

            </div>

        </div>

        <div class="hp-hero__media" data-js="hero-image">
            <img
                src="<?php echo esc_url( $uri . '/assets/images/hero.jpg' ); ?>"
                alt="<?php esc_attr_e( 'Montoya Studio — creative direction', 'montoya-portfolio' ); ?>"
                class="hp-hero__image"
                width="1440"
                height="830"
                loading="eager"
                fetchpriority="high"
            >
        </div>

    </section><!-- .hp-hero -->


    <!-- =============================================
         § 2  INTRO
         asymmetric: portrait image left | quote + body right
    ============================================= -->
    <section class="hp-intro" aria-label="<?php esc_attr_e( 'Studio philosophy', 'montoya-portfolio' ); ?>">

        <div class="hp-intro__inner container">

            <div class="hp-intro__image-col" data-js="intro-image">
                <figure class="hp-intro__figure">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/intro-portrait.jpg' ); ?>"
                        alt=""
                        class="hp-intro__image"
                        width="684"
                        height="808"
                        loading="lazy"
                    >
                </figure>
            </div>

            <div class="hp-intro__content-col">
                <span class="hp-intro__label">(WHAT WE BELIEVE)</span>
                <blockquote class="hp-intro__quote" data-js="intro-quote">
                    Design is not styling. Identity is structure, meaning, and time.
                </blockquote>
                <p class="hp-intro__body" data-js="intro-body">
                    We think of brands as cultural systems — composed through image, language, material and sound. Built not for impact, but for permanence.<br><br>
                    Our work sits at the intersection of direction, design and technology, shaping experiences that feel intelligent, sensorial and coherent.
                </p>
            </div>

        </div>

    </section><!-- .hp-intro -->


    <!-- =============================================
         § 3  SELECTED WORK
         section label → three project entries
    ============================================= -->
    <section class="hp-work" aria-label="<?php esc_attr_e( 'Selected work', 'montoya-portfolio' ); ?>">

        <div class="hp-work__header container">
            <span class="hp-work__label"><?php esc_html_e( '(SELECTED WORK)', 'montoya-portfolio' ); ?></span>
            <a href="<?php echo esc_url( home_url( '/work' ) ); ?>" class="hp-work__all-link">
                <span class="hp-work__all-link-arrow" aria-hidden="true">
                    <img src="<?php echo esc_url( $uri . '/assets/images/arrow.svg' ); ?>" alt="" width="15" height="16">
                </span>
                <?php esc_html_e( 'All Commissions', 'montoya-portfolio' ); ?>
            </a>
        </div>

        <?php
        $hp_query = new WP_Query( [
            'post_type'      => 'work',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'meta_query'     => [
                [
                    'key'   => 'show_on_homepage',
                    'value' => '1',
                ],
            ],
        ] );

        if ( $hp_query->have_posts() ) :
            $card_index = 0;
            while ( $hp_query->have_posts() ) :
                $hp_query->the_post();
                get_template_part( 'template-parts/project-card', null, [ 'card_index' => $card_index ] );
                $card_index++;
            endwhile;
            wp_reset_postdata();
        endif;
        ?>

    </section><!-- .hp-work -->


    <!-- =============================================
         § 4  PROFILE
         large heading left | portrait right | bio below portrait | offset tall portrait
    ============================================= -->
    <section class="hp-profile" aria-label="<?php esc_attr_e( 'About the studio', 'montoya-portfolio' ); ?>">

        <div class="hp-profile__inner container">

            <!-- col 1: heading + detail portrait stacked -->
            <div class="hp-profile__left">
                <h2 class="hp-profile__heading" data-js="profile-heading">
                    Montoya Studio works at the intersection of identity, editorial culture, and digital craft.
                </h2>
                <figure class="hp-profile__detail" data-js="profile-detail">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/profile-detail.jpg' ); ?>"
                        alt=""
                        loading="lazy"
                    >
                </figure>
            </div>

            <!-- col 2: portrait then bio (right ~41%, offset by 10% gap) -->
            <div class="hp-profile__right">
                <figure class="hp-profile__portrait" data-js="profile-portrait">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/profile-portrait.jpg' ); ?>"
                        alt="<?php esc_attr_e( 'Rocío Montoya — Studio Director', 'montoya-portfolio' ); ?>"
                        loading="lazy"
                    >
                </figure>
                <div class="hp-profile__bio" data-js="profile-bio">
                    <p>Founded and directed by Rocío Montoya, our practice treats design as a cultural artifact—meant to be precise, quiet, and enduring.</p>
                    <p>We collaborate with architects, perfumers, chefs, artists, and independent luxury brands to build identities and environments that are coherent across product and digital touchpoints.</p>
                    <p>Our work prioritizes clarity of thought, material restraint, and a contemporary sense of elegance.</p>
                </div>
            </div>

        </div>

    </section><!-- .hp-profile -->



</article><!-- .home-page -->

<?php get_footer(); ?>

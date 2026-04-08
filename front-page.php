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
                <span class="hp-hero__label">(A Studio)</span>
                <h1 class="hp-hero__heading">
                    For brands with quiet ambition. We design with precision, sensibility and cultural permanence.
                </h1>
            </div>

            <div class="hp-hero__disciplines">
                <span class="hp-hero__discipline">Creative Direction, Art Direction</span>
                <span class="hp-hero__discipline">Design</span>
                <span class="hp-hero__discipline">Development</span>
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
            <span class="hp-work__label"><?php esc_html_e( 'Selected Work', 'montoya-portfolio' ); ?></span>
            <a href="<?php echo esc_url( home_url( '/work' ) ); ?>" class="hp-work__all-link">
                <span class="hp-work__all-link-arrow" aria-hidden="true">
                    <img src="<?php echo esc_url( $uri . '/assets/images/arrow.svg' ); ?>" alt="" width="15" height="16">
                </span>
                <?php esc_html_e( 'All Commissions', 'montoya-portfolio' ); ?>
            </a>
        </div>

        <!-- Project 01: Casa La Merced -->
        <article class="hp-project" data-js="project">
            <div class="hp-project__header container">
                <div class="hp-project__title-col">
                    <h2 class="hp-project__title" data-js="project-title">Casa La&nbsp;Merced</h2>
                </div>
                <div class="hp-project__meta">
                    <div class="hp-project__taxonomy">
                        <div class="hp-project__tax-group">
                            <span class="hp-project__tax-label">Industry</span>
                            <ul class="hp-project__tax-items">
                                <li>Architecture</li>
                                <li>Interior</li>
                                <li>Hospitality</li>
                            </ul>
                        </div>
                        <div class="hp-project__tax-group">
                            <span class="hp-project__tax-label">Scope</span>
                            <ul class="hp-project__tax-items">
                                <li>Creative Direction</li>
                                <li>Brand Identity</li>
                                <li>Editorial System</li>
                                <li>Website</li>
                            </ul>
                        </div>
                    </div>
                    <div class="hp-project__details">
                        <div class="hp-project__desc-wrap">
                            <span class="hp-project__tax-label">Description</span>
                            <p class="hp-project__description">
                                A discreet identity for an architecture practice rooted in material research and contextual sensitivity.
                            </p>
                        </div>
                        <a href="#" class="hp-project__link">
                            <span class="hp-project__link-arrow" aria-hidden="true">
                                <img src="<?php echo esc_url( $uri . '/assets/images/arrow.svg' ); ?>" alt="" width="15" height="16">
                            </span>
                            <?php esc_html_e( 'Full Commission', 'montoya-portfolio' ); ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="hp-project__images hp-project__images--standard container">
                <figure class="hp-project__image hp-project__image--a" data-js="project-img-a">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/project-casa-primary.jpg' ); ?>"
                        alt="Casa La Merced — interior detail"
                        loading="lazy"
                    >
                </figure>
                <figure class="hp-project__image hp-project__image--b" data-js="project-img-b">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/project-casa-secondary.jpg' ); ?>"
                        alt="Casa La Merced — architecture"
                        loading="lazy"
                    >
                </figure>
            </div>
        </article><!-- .hp-project -->

        <!-- Project 02: Vela Parfums -->
        <article class="hp-project" data-js="project">
            <div class="hp-project__header container">
                <div class="hp-project__title-col">
                    <h2 class="hp-project__title" data-js="project-title">Vela&nbsp;Parfums</h2>
                </div>
                <div class="hp-project__meta">
                    <div class="hp-project__taxonomy">
                        <div class="hp-project__tax-group">
                            <span class="hp-project__tax-label">Industry</span>
                            <ul class="hp-project__tax-items">
                                <li>Fragrance</li>
                                <li>Fashion</li>
                                <li>Cultural</li>
                            </ul>
                        </div>
                        <div class="hp-project__tax-group">
                            <span class="hp-project__tax-label">Scope</span>
                            <ul class="hp-project__tax-items">
                                <li>Art Direction</li>
                                <li>Packaging</li>
                                <li>Brand Identity</li>
                                <li>Website</li>
                            </ul>
                        </div>
                    </div>
                    <div class="hp-project__details">
                        <div class="hp-project__desc-wrap">
                            <span class="hp-project__tax-label">Description</span>
                            <p class="hp-project__description">
                                A restrained brand for a perfumer working with time, memory and botanical elements.
                            </p>
                        </div>
                        <a href="#" class="hp-project__link">
                            <span class="hp-project__link-arrow" aria-hidden="true">
                                <img src="<?php echo esc_url( $uri . '/assets/images/arrow.svg' ); ?>" alt="" width="15" height="16">
                            </span>
                            <?php esc_html_e( 'Full Commission', 'montoya-portfolio' ); ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="hp-project__images hp-project__images--reversed container">
                <figure class="hp-project__image hp-project__image--a" data-js="project-img-a">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/project-vela-primary.jpg' ); ?>"
                        alt="Vela Parfums — bottle"
                        loading="lazy"
                    >
                </figure>
                <figure class="hp-project__image hp-project__image--b" data-js="project-img-b">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/project-vela-secondary.jpg' ); ?>"
                        alt="Vela Parfums — detail"
                        loading="lazy"
                    >
                </figure>
            </div>
        </article><!-- .hp-project -->

        <!-- Project 03: Mesa -->
        <article class="hp-project" data-js="project">
            <div class="hp-project__header container">
                <div class="hp-project__title-col">
                    <h2 class="hp-project__title" data-js="project-title">Mesa</h2>
                </div>
                <div class="hp-project__meta">
                    <div class="hp-project__taxonomy">
                        <div class="hp-project__tax-group">
                            <span class="hp-project__tax-label">Industry</span>
                            <ul class="hp-project__tax-items">
                                <li>Culinary</li>
                                <li>Hospitality</li>
                                <li>Objects</li>
                            </ul>
                        </div>
                        <div class="hp-project__tax-group">
                            <span class="hp-project__tax-label">Scope</span>
                            <ul class="hp-project__tax-items">
                                <li>Naming</li>
                                <li>Brand Identity</li>
                                <li>Editorial System</li>
                                <li>Website</li>
                            </ul>
                        </div>
                    </div>
                    <div class="hp-project__details">
                        <div class="hp-project__desc-wrap">
                            <span class="hp-project__tax-label">Description</span>
                            <p class="hp-project__description">
                                A culinary studio exploring provenance, craft and contemporary technique.
                            </p>
                        </div>
                        <a href="#" class="hp-project__link">
                            <span class="hp-project__link-arrow" aria-hidden="true">
                                <img src="<?php echo esc_url( $uri . '/assets/images/arrow.svg' ); ?>" alt="" width="15" height="16">
                            </span>
                            <?php esc_html_e( 'Full Commission', 'montoya-portfolio' ); ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="hp-project__images hp-project__images--standard container">
                <figure class="hp-project__image hp-project__image--a" data-js="project-img-a">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/project-mesa-primary.jpg' ); ?>"
                        alt="Mesa — culinary"
                        loading="lazy"
                    >
                </figure>
                <figure class="hp-project__image hp-project__image--b" data-js="project-img-b">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/project-mesa-secondary.jpg' ); ?>"
                        alt="Mesa — detail"
                        loading="lazy"
                    >
                </figure>
            </div>
        </article><!-- .hp-project -->

    </section><!-- .hp-work -->


    <!-- =============================================
         § 4  PROFILE
         large heading left | portrait right | bio below portrait | offset tall portrait
    ============================================= -->
    <section class="hp-profile" aria-label="<?php esc_attr_e( 'About the studio', 'montoya-portfolio' ); ?>">

        <div class="hp-profile__inner container">

            <!-- col 1: heading (left ~49%) -->
            <h2 class="hp-profile__heading" data-js="profile-heading">
                Montoya Studio works at the intersection of identity, editorial culture, and digital craft.
            </h2>

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

            <!-- detail portrait: absolutely positioned at left 14.6%, top ~255px, mirrored -->
            <figure class="hp-profile__detail" data-js="profile-detail">
                <img
                    src="<?php echo esc_url( $uri . '/assets/images/profile-detail.jpg' ); ?>"
                    alt=""
                    loading="lazy"
                >
            </figure>

        </div>

    </section><!-- .hp-profile -->


    <!-- =============================================
         § 5  FULL-BLEED IMAGE
         large landscape image, full width
    ============================================= -->
    <section class="hp-landscape" aria-label="<?php esc_attr_e( 'Studio imagery', 'montoya-portfolio' ); ?>">
        <figure class="hp-landscape__image" data-js="values-image">
            <img
                src="<?php echo esc_url( $uri . '/assets/images/values-landscape.jpg' ); ?>"
                alt=""
                width="1396"
                height="830"
                loading="lazy"
            >
        </figure>
    </section><!-- .hp-landscape -->


    <!-- =============================================
         § 6  CONTACT CTA
         label → heading → two columns: image left | description + contact right
    ============================================= -->
    <section class="hp-cta" aria-label="<?php esc_attr_e( 'Commission inquiry', 'montoya-portfolio' ); ?>">

        <div class="hp-cta__inner container">

            <p class="hp-cta__label"><?php esc_html_e( 'Practice & Commissions', 'montoya-portfolio' ); ?></p>

            <h2 class="hp-cta__heading" data-js="cta-heading">
                Our practice spans creative direction, identity, editorial design, and digital environments.
            </h2>

            <div class="hp-cta__cols">

                <!-- Image: left column -->
                <figure class="hp-cta__image" data-js="cta-image">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/cta-portrait.jpg' ); ?>"
                        alt=""
                        loading="lazy"
                    >
                </figure>

                <!-- Text: right column, space-between -->
                <div class="hp-cta__content" data-js="cta-body">
                    <p>Our work involves cultural research and ongoing commissions with ateliers, independent brands, and exploratory ventures.</p>
                    <div class="hp-cta__contact">
                        <p>For new projects, collaborations or private commissions:</p>
                        <a href="mailto:hello@montoyastudio.com" class="hp-cta__email">hello@montoyastudio.com</a>
                    </div>
                </div>

            </div>

        </div><!-- .hp-cta__inner -->

    </section><!-- .hp-cta -->

</article><!-- .home-page -->

<?php get_footer(); ?>

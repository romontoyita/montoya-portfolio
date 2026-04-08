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

        <div class="hp-hero__disciplines container">
            <span class="hp-hero__discipline">Creative Direction, Art Direction</span>
            <span class="hp-hero__discipline">Design</span>
            <span class="hp-hero__discipline">Development</span>
        </div>

        <div class="hp-hero__content container">
            <h1 class="hp-hero__heading">
                A studio for brands with quiet ambition.
                We design with precision, sensibility
                and cultural permanence.
            </h1>
        </div>

        <div class="hp-hero__media" data-js="hero-image">
            <img
                src="<?php echo esc_url( $uri . '/assets/images/hero.jpg' ); ?>"
                alt="<?php esc_attr_e( 'Montoya Studio — creative direction', 'montoya-portfolio' ); ?>"
                class="hp-hero__image"
                width="1440"
                height="900"
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

        <div class="hp-intro__image-col" data-js="intro-image">
            <figure class="hp-intro__figure">
                <img
                    src="<?php echo esc_url( $uri . '/assets/images/intro-portrait.jpg' ); ?>"
                    alt=""
                    class="hp-intro__image"
                    width="720"
                    height="960"
                    loading="lazy"
                >
            </figure>
        </div>

        <div class="hp-intro__content-col">
            <blockquote class="hp-intro__quote" data-js="intro-quote">
                Design is not styling.
                Design is structure,
                material and time.
            </blockquote>
            <div class="hp-intro__body" data-js="intro-body">
                <p>We think of brands as cultural systems — expressed through image, language, material and sound. Built not for impact, but for permanence.</p>
                <p>Our work sits at the intersection of direction, design and development, shaping organisations so they are intelligent, sensorial and coherent.</p>
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
                <?php esc_html_e( 'All Commissions', 'montoya-portfolio' ); ?> &rarr;
            </a>
        </div>

        <!-- Project 01: Casa La Merced -->
        <article class="hp-project" data-js="project">
            <div class="hp-project__header container">
                <div class="hp-project__title-col">
                    <h2 class="hp-project__title" data-js="project-title">Casa La&nbsp;Merced</h2>
                </div>
                <div class="hp-project__meta">
                    <ul class="hp-project__tags" aria-label="<?php esc_attr_e( 'Project disciplines', 'montoya-portfolio' ); ?>">
                        <li>Architecture</li>
                        <li>Interior Design</li>
                        <li>Photography</li>
                    </ul>
                    <p class="hp-project__description">
                        A residential identity for a rural Mexican property rooted in material authenticity and architectural restraint.
                    </p>
                    <a href="#" class="hp-project__link">
                        <?php esc_html_e( 'Full Commission', 'montoya-portfolio' ); ?> &rarr;
                    </a>
                </div>
            </div>
            <div class="hp-project__images">
                <figure class="hp-project__image hp-project__image--primary" data-js="project-img-primary">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/project-casa-primary.jpg' ); ?>"
                        alt="Casa La Merced — interior"
                        width="960"
                        height="720"
                        loading="lazy"
                    >
                </figure>
                <figure class="hp-project__image hp-project__image--secondary" data-js="project-img-secondary">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/project-casa-secondary.jpg' ); ?>"
                        alt="Casa La Merced — detail"
                        width="480"
                        height="640"
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
                    <ul class="hp-project__tags" aria-label="<?php esc_attr_e( 'Project disciplines', 'montoya-portfolio' ); ?>">
                        <li>Fragrance</li>
                        <li>Brand Identity</li>
                        <li>Photography</li>
                        <li>Art Direction</li>
                    </ul>
                    <p class="hp-project__description">
                        A scent-led luxury brand conceived at the crossroads of perfumery, place and slow luxury.
                    </p>
                    <a href="#" class="hp-project__link">
                        <?php esc_html_e( 'Full Commission', 'montoya-portfolio' ); ?> &rarr;
                    </a>
                </div>
            </div>
            <div class="hp-project__images">
                <figure class="hp-project__image hp-project__image--primary" data-js="project-img-primary">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/project-vela-primary.jpg' ); ?>"
                        alt="Vela Parfums — bottle"
                        width="960"
                        height="720"
                        loading="lazy"
                    >
                </figure>
                <figure class="hp-project__image hp-project__image--secondary" data-js="project-img-secondary">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/project-vela-secondary.jpg' ); ?>"
                        alt="Vela Parfums — detail"
                        width="480"
                        height="640"
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
                    <ul class="hp-project__tags" aria-label="<?php esc_attr_e( 'Project disciplines', 'montoya-portfolio' ); ?>">
                        <li>Food Brand</li>
                        <li>Identity</li>
                        <li>Photography</li>
                    </ul>
                    <p class="hp-project__description">
                        A culinary studio honouring contemporary craft, ritual and the permanence of a well-set table.
                    </p>
                    <a href="#" class="hp-project__link">
                        <?php esc_html_e( 'Full Commission', 'montoya-portfolio' ); ?> &rarr;
                    </a>
                </div>
            </div>
            <div class="hp-project__images">
                <figure class="hp-project__image hp-project__image--primary" data-js="project-img-primary">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/project-mesa-primary.jpg' ); ?>"
                        alt="Mesa — restaurant"
                        width="960"
                        height="720"
                        loading="lazy"
                    >
                </figure>
                <figure class="hp-project__image hp-project__image--secondary" data-js="project-img-secondary">
                    <img
                        src="<?php echo esc_url( $uri . '/assets/images/project-mesa-secondary.jpg' ); ?>"
                        alt="Mesa — detail"
                        width="480"
                        height="640"
                        loading="lazy"
                    >
                </figure>
            </div>
        </article><!-- .hp-project -->

    </section><!-- .hp-work -->


    <!-- =============================================
         § 4  PROFILE
         large portrait left | heading + bio right | offset detail image
    ============================================= -->
    <section class="hp-profile" aria-label="<?php esc_attr_e( 'About the studio', 'montoya-portfolio' ); ?>">

        <div class="hp-profile__main container">

            <figure class="hp-profile__portrait" data-js="profile-portrait">
                <img
                    src="<?php echo esc_url( $uri . '/assets/images/profile-portrait.jpg' ); ?>"
                    alt="<?php esc_attr_e( 'Rocio Montoya — Studio Director', 'montoya-portfolio' ); ?>"
                    width="720"
                    height="960"
                    loading="lazy"
                >
            </figure>

            <div class="hp-profile__content">
                <h2 class="hp-profile__heading" data-js="profile-heading">
                    Montoya Studio works at the intersection of identity, editorial culture, and digital craft.
                </h2>
                <div class="hp-profile__bio" data-js="profile-bio">
                    <p>Founded and directed by Rocio Montoya, our practice treats design as a cultural artifact — meant to be precise, quiet, and enduring.</p>
                    <p>We collaborate with architects, perfumers, chefs, artists, and independent luxury brands to build identities that hold meaning and consistency across product and digital touchpoints.</p>
                    <p>Our work prioritises clarity of thought, material restraint, and a contemporary sense of elegance.</p>
                </div>
            </div>

        </div><!-- .hp-profile__main -->

        <div class="hp-profile__offset-wrap">
            <figure class="hp-profile__offset-image" data-js="profile-offset">
                <img
                    src="<?php echo esc_url( $uri . '/assets/images/profile-detail.jpg' ); ?>"
                    alt=""
                    width="360"
                    height="480"
                    loading="lazy"
                >
            </figure>
        </div>

    </section><!-- .hp-profile -->


    <!-- =============================================
         § 5  VALUES
         statement heading | two-column body | full-bleed landscape
    ============================================= -->
    <section class="hp-values" aria-label="<?php esc_attr_e( 'Studio values', 'montoya-portfolio' ); ?>">

        <div class="hp-values__inner container">
            <h2 class="hp-values__heading" data-js="values-heading">
                Our practice spans creative direction, identity, editorial design, and digital environments.
            </h2>
            <div class="hp-values__body">
                <div class="hp-values__col" data-js="values-col">
                    <p>We build for brands that understand the long game — where strategy and sensibility are inseparable, and form follows intention.</p>
                </div>
                <div class="hp-values__col" data-js="values-col">
                    <p>Each commission is a full-system engagement: from naming and visual identity to digital presence and art direction of all materials.</p>
                </div>
            </div>
        </div>

        <figure class="hp-values__image" data-js="values-image">
            <img
                src="<?php echo esc_url( $uri . '/assets/images/values-landscape.jpg' ); ?>"
                alt=""
                width="1440"
                height="720"
                loading="lazy"
            >
        </figure>

    </section><!-- .hp-values -->


    <!-- =============================================
         § 6  CONTACT CTA
         large IvyPresto heading left | portrait image right
    ============================================= -->
    <section class="hp-cta" aria-label="<?php esc_attr_e( 'Commission inquiry', 'montoya-portfolio' ); ?>">

        <div class="hp-cta__inner container">

            <div class="hp-cta__content">
                <h2 class="hp-cta__heading" data-js="cta-heading">
                    And we are open to new commissions.
                </h2>
                <div class="hp-cta__body" data-js="cta-body">
                    <p>If you are building something that demands precision and cultural intelligence, we would like to hear from you.</p>
                    <p>Write to us at <a href="mailto:studio@montoyastudio.com">studio@montoyastudio.com</a> or submit a brief below.</p>
                </div>
                <a href="<?php echo esc_url( home_url( '/inquiries' ) ); ?>" class="hp-cta__link">
                    <?php esc_html_e( 'Begin a Commission', 'montoya-portfolio' ); ?> &rarr;
                </a>
            </div>

            <figure class="hp-cta__image" data-js="cta-image">
                <img
                    src="<?php echo esc_url( $uri . '/assets/images/cta-portrait.jpg' ); ?>"
                    alt=""
                    width="480"
                    height="640"
                    loading="lazy"
                >
            </figure>

        </div><!-- .hp-cta__inner -->

    </section><!-- .hp-cta -->

</article><!-- .home-page -->

<?php get_footer(); ?>

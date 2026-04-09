<?php
/**
 * Template Name: Work
 * Full commissions archive — all projects listed.
 */
defined( 'ABSPATH' ) || exit;
get_header();
$uri = get_template_directory_uri();
?>

<article class="work-page">

    <!-- Project 01: Casa La Merced -->
    <div class="hp-project" data-js="project">
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
    </div><!-- .hp-project -->

    <!-- Project 02: Vela Parfums -->
    <div class="hp-project" data-js="project">
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
    </div><!-- .hp-project -->

    <!-- Project 03: Mesa -->
    <div class="hp-project" data-js="project">
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
    </div><!-- .hp-project -->

    <!-- Project 04: Atelier Forme -->
    <div class="hp-project" data-js="project">
        <div class="hp-project__header container">
            <div class="hp-project__title-col">
                <h2 class="hp-project__title" data-js="project-title">Atelier&nbsp;Forme</h2>
            </div>
            <div class="hp-project__meta">
                <div class="hp-project__taxonomy">
                    <div class="hp-project__tax-group">
                        <span class="hp-project__tax-label">Industry</span>
                        <ul class="hp-project__tax-items">
                            <li>Fashion</li>
                            <li>Objects</li>
                        </ul>
                    </div>
                    <div class="hp-project__tax-group">
                        <span class="hp-project__tax-label">Scope</span>
                        <ul class="hp-project__tax-items">
                            <li>Brand Identity</li>
                            <li>Art Direction</li>
                            <li>Lookbook</li>
                        </ul>
                    </div>
                </div>
                <div class="hp-project__details">
                    <div class="hp-project__desc-wrap">
                        <span class="hp-project__tax-label">Description</span>
                        <p class="hp-project__description">
                            A visual language for a slow-fashion atelier grounded in textile heritage and minimal form.
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
                    src="<?php echo esc_url( $uri . '/assets/images/project-forme-primary.jpg' ); ?>"
                    alt="Atelier Forme — textile"
                    loading="lazy"
                >
            </figure>
            <figure class="hp-project__image hp-project__image--b" data-js="project-img-b">
                <img
                    src="<?php echo esc_url( $uri . '/assets/images/project-forme-secondary.jpg' ); ?>"
                    alt="Atelier Forme — detail"
                    loading="lazy"
                >
            </figure>
        </div>
    </div><!-- .hp-project -->

    <!-- Project 05: Salón Negro -->
    <div class="hp-project" data-js="project">
        <div class="hp-project__header container">
            <div class="hp-project__title-col">
                <h2 class="hp-project__title" data-js="project-title">Salón&nbsp;Negro</h2>
            </div>
            <div class="hp-project__meta">
                <div class="hp-project__taxonomy">
                    <div class="hp-project__tax-group">
                        <span class="hp-project__tax-label">Industry</span>
                        <ul class="hp-project__tax-items">
                            <li>Cultural</li>
                            <li>Arts</li>
                        </ul>
                    </div>
                    <div class="hp-project__tax-group">
                        <span class="hp-project__tax-label">Scope</span>
                        <ul class="hp-project__tax-items">
                            <li>Creative Direction</li>
                            <li>Print</li>
                            <li>Website</li>
                        </ul>
                    </div>
                </div>
                <div class="hp-project__details">
                    <div class="hp-project__desc-wrap">
                        <span class="hp-project__tax-label">Description</span>
                        <p class="hp-project__description">
                            Identity and printed materials for an independent arts venue with a program rooted in performance and sound.
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
                    src="<?php echo esc_url( $uri . '/assets/images/project-salon-primary.jpg' ); ?>"
                    alt="Salón Negro — print"
                    loading="lazy"
                >
            </figure>
            <figure class="hp-project__image hp-project__image--b" data-js="project-img-b">
                <img
                    src="<?php echo esc_url( $uri . '/assets/images/project-salon-secondary.jpg' ); ?>"
                    alt="Salón Negro — venue"
                    loading="lazy"
                >
            </figure>
        </div>
    </div><!-- .hp-project -->

</article><!-- .work-page -->

<?php get_footer(); ?>

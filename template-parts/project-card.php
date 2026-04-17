<?php
/**
 * Template Part: Project Card
 * * Se asegura de cargar el tamaño 'full' de las imágenes de ACF.
 */

defined( 'ABSPATH' ) || exit;

$has_acf     = function_exists( 'get_field' );
$post_id     = get_the_ID();

$industry    = montoya_acf_lines( 'industry',    $post_id );
$scope       = montoya_acf_lines( 'scope',       $post_id );
$description = $has_acf ? get_field( 'description',     $post_id ) : '';
$img_a       = $has_acf ? get_field( 'listing_image_a', $post_id ) : null;
$img_b       = $has_acf ? get_field( 'listing_image_b', $post_id ) : null;
$layout_raw  = $has_acf ? get_field( 'image_layout',    $post_id ) : '';

// Definir el tamaño de imagen deseado (puedes usar 'full', 'large', o uno personalizado)
$image_size = 'full'; 

if ( ! $layout_raw ) {
    $layout_raw = ( isset( $card_index ) && $card_index % 2 !== 0 ) ? 'reversed' : 'standard';
}
$layout_class = ( $layout_raw === 'reversed' ) ? 'hp-project__images--reversed' : 'hp-project__images--standard';

$uri = get_template_directory_uri();
?>

<article class="hp-project" data-js="project">

    <div class="hp-project__header container">
        <div class="hp-project__title-col">
            <h2 class="hp-project__title" data-js="project-title">
                <?php echo esc_html( get_the_title() ); ?>
            </h2>
        </div>

        <div class="hp-project__meta">
            <div class="hp-project__taxonomy">
                <?php if ( $industry ) : ?>
                <div class="hp-project__tax-group">
                    <span class="hp-project__tax-label">Industry</span>
                    <ul class="hp-project__tax-items">
                        <?php foreach ( $industry as $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if ( $scope ) : ?>
                <div class="hp-project__tax-group">
                    <span class="hp-project__tax-label">Scope</span>
                    <ul class="hp-project__tax-items">
                        <?php foreach ( $scope as $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>

            <div class="hp-project__details">
                <?php if ( $description ) : ?>
                <div class="hp-project__desc-wrap">
                    <span class="hp-project__tax-label">Description</span>
                    <p class="hp-project__description"><?php echo esc_html( $description ); ?></p>
                </div>
                <?php endif; ?>

                <a href="<?php echo esc_url( get_permalink() ); ?>" class="hp-project__link">
                    <span class="hp-project__link-arrow" aria-hidden="true">
                        <img src="<?php echo esc_url( $uri . '/assets/images/arrow.svg' ); ?>" alt="" width="15" height="16">
                    </span>
                    <?php esc_html_e( 'Full Commission', 'montoya-portfolio' ); ?>
                </a>
            </div>
        </div>
    </div>

    <div class="hp-project__images <?php echo esc_attr( $layout_class ); ?> container">

        <figure class="hp-project__image hp-project__image--a" data-js="project-img-a">
            <?php if ( $img_a ) : 
                // Extraemos la URL del tamaño específico del array de ACF
                $url_a = isset($img_a['sizes'][$image_size]) ? $img_a['sizes'][$image_size] : $img_a['url'];
            ?>
                <img
                    src="<?php echo esc_url( $url_a ); ?>"
                    alt="<?php echo esc_attr( $img_a['alt'] ); ?>"
                    loading="lazy"
                    decoding="async"
                >
            <?php endif; ?>
        </figure>

        <figure class="hp-project__image hp-project__image--b" data-js="project-img-b">
            <?php if ( $img_b ) : 
                $url_b = isset($img_b['sizes'][$image_size]) ? $img_b['sizes'][$image_size] : $img_b['url'];
            ?>
                <img
                    src="<?php echo esc_url( $url_b ); ?>"
                    alt="<?php echo esc_attr( $img_b['alt'] ); ?>"
                    loading="lazy"
                    decoding="async"
                >
            <?php endif; ?>
        </figure>

    </div>
</article>
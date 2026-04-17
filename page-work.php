<?php
/**
 * Template Name: Work
 * Full commissions archive — all work posts.
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<article class="work-page">

    <div class="hp-work__header container">
        <span class="hp-work__label"><?php esc_html_e( '(ALL COMMISSIONS)', 'montoya-portfolio' ); ?></span>
    </div>

    <?php
    $work_query = new WP_Query( [
        'post_type'      => 'work',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ] );

    if ( $work_query->have_posts() ) :
        $card_index = 0;
        while ( $work_query->have_posts() ) :
            $work_query->the_post();
            get_template_part( 'template-parts/project-card', null, [ 'card_index' => $card_index ] );
            $card_index++;
        endwhile;
        wp_reset_postdata();
    endif;
    ?>

</article><!-- .work-page -->

<?php get_footer(); ?>

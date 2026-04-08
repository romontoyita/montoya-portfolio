<?php get_header(); ?>

<div class="container">
    <?php if ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endif; ?>
</div>

<?php get_footer();

</main><!-- #main -->

<?php if ( ! is_front_page() ) : ?>
<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="site-footer__inner container">

        <p class="site-footer__copy">
            &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
            <?php bloginfo( 'name' ); ?>.
            <?php esc_html_e( 'All rights reserved.', 'montoya-portfolio' ); ?>
        </p>

    </div><!-- .site-footer__inner -->
</footer><!-- #colophon -->
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>

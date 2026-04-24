</main><!-- #main -->

<?php $uri = get_template_directory_uri(); ?>

<footer id="colophon" class="site-footer" role="contentinfo">

    <div class="site-footer__inner container">
        <h2 class="site-footer__heading">
            Our practice spans creative direction, identity, editorial design, and digital environments.
        </h2>

        <div class="site-footer__cols">

            <figure class="site-footer__image">
                <img
                    src="<?php echo esc_url( $uri . '/assets/images/cta-portrait.jpg' ); ?>"
                    alt=""
                    loading="lazy"
                >
            </figure>

            <div class="site-footer__content">
                <p>Our work involves cultural research and ongoing commissions with ateliers, independent brands, and exploratory ventures.</p>
                <div class="site-footer__contact">
                    <p>For new commissions, collaborations, or exploratory conversations:</p>
                    <a href="mailto:hello@montoyastudio.com" class="site-footer__email">hello@montoyastudio.com</a>
                </div>
            </div>

        </div><!-- .site-footer__cols -->

    </div><!-- .site-footer__inner -->

    <div class="site-footer__bar container">
        <p class="site-footer__copy">&copy; 2026 Montoya Studio. All rights reserved.</p>
        <a href="#" class="site-footer__back-top" aria-label="<?php esc_attr_e( 'Back to top', 'montoya-portfolio' ); ?>">
            Back to top &uarr;
        </a>
    </div>

</footer><!-- #colophon -->

<?php wp_footer(); ?>
</body>
</html>

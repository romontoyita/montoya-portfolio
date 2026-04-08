// main scripts

// =============================================================================
// PAGE LOADER — Hero Logo FLIP Transition
// =============================================================================
(function () {
    const loader     = document.querySelector('.page-loader');
    const loaderLogo = loader && loader.querySelector('.page-loader__logo');
    const headerLogo = document.querySelector('.site-header__logo');

    if (!loader || !loaderLogo || !headerLogo) return;

    const MIN_MS  = 1500; // minimum brand-presence duration
    const startTs = Date.now();

    // Hide header logo immediately so the FLIP starts clean
    document.body.classList.add('is-loading');

    function runFlip() {
        const elapsed   = Date.now() - startTs;
        const remaining = Math.max(0, MIN_MS - elapsed);

        setTimeout(function () {
            // FLIP — First: loader logo bounds
            const first = loaderLogo.getBoundingClientRect();
            // FLIP — Last: header logo bounds (invisible but still laid out)
            const last  = headerLogo.getBoundingClientRect();

            const sx = first.width  / last.width;
            const sy = first.height / last.height;
            const tx = (first.left + first.width  / 2) - (last.left + last.width  / 2);
            const ty = (first.top  + first.height / 2) - (last.top  + last.height / 2);

            // Apply inverted transform instantly — no transition yet
            headerLogo.style.willChange     = 'transform, opacity';
            headerLogo.style.transformOrigin = 'center center';
            headerLogo.style.transition     = 'none';
            headerLogo.style.transform      = 'translate(' + tx + 'px, ' + ty + 'px) scale(' + sx + ', ' + sy + ')';
            headerLogo.style.opacity        = '1';

            // Remove .is-loading so CSS no longer forces opacity:0 on the logo
            document.body.classList.remove('is-loading');

            // Fade out the loader logo so it doesn't overlap during PLAY
            loaderLogo.style.opacity = '0';

            // Force reflow — locks in the inverted transform before transition starts
            headerLogo.getBoundingClientRect(); // eslint-disable-line no-unused-expressions

            // FLIP — Play: transition to natural position
            headerLogo.style.transition = 'transform 1.5s cubic-bezier(0.16, 1, 0.3, 1)';
            headerLogo.style.transform  = 'none';

            // Fade out the loader overlay slightly after the logo begins moving
            loader.style.opacity = '0';

            // Clean up after fade
            loader.addEventListener('transitionend', function onEnd(e) {
                if (e.target !== loader) return;
                loader.remove();
                headerLogo.style.willChange      = '';
                headerLogo.style.transformOrigin = '';
                headerLogo.style.transition      = '';
                loader.removeEventListener('transitionend', onEnd);
            });

        }, remaining);
    }

    if (document.readyState === 'complete') {
        runFlip();
    } else {
        window.addEventListener('load', runFlip);
    }
}());

// Header — add .is-scrolled once the user scrolls past the initial position
(function () {
    const header = document.querySelector('.site-header');
    if (!header) return;

    const sentinel = document.createElement('div');
    sentinel.style.cssText = 'position:absolute;top:0;height:1px;pointer-events:none;';
    document.body.prepend(sentinel);

    const obs = new IntersectionObserver(
        ([entry]) => header.classList.toggle('is-scrolled', !entry.isIntersecting),
        { threshold: 0 }
    );
    obs.observe(sentinel);
}());

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

// =============================================================================
// LENIS — Smooth Scroll  (integrado con GSAP ticker)
// =============================================================================
(function () {
    if (typeof window.Lenis === 'undefined' || typeof gsap === 'undefined') return;

    gsap.registerPlugin(ScrollTrigger);

    const lenis = new window.Lenis({ smoothWheel: true });

    // Lenis notifica a ScrollTrigger en cada frame de scroll
    lenis.on('scroll', ScrollTrigger.update);

    // GSAP ticker conduce el RAF de Lenis (time viene en segundos → raf espera ms)
    gsap.ticker.add((time) => lenis.raf(time * 1000));
    gsap.ticker.lagSmoothing(0);

    // Evitar conflicto con scroll-behavior: smooth nativo
    document.documentElement.style.scrollBehavior = 'auto';

    window.__lenis = lenis;
}());


// =============================================================================
// Utilidad compartida para ambas transiciones
// =============================================================================
function makeImageTransition(sourceEl, targetEl, sourceImg, targetImg, proxyTransform) {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    gsap.registerPlugin(ScrollTrigger);

    // ── Proxy ──────────────────────────────────────────────────────────────
    const proxy = document.createElement('div');
    proxy.className = 'hero-intro-proxy';
    proxy.setAttribute('aria-hidden', 'true');

    const pImg = document.createElement('img');
    pImg.src = sourceImg.src;
    pImg.alt = '';
    if (proxyTransform) pImg.style.transform = proxyTransform;
    proxy.appendChild(pImg);
    document.body.appendChild(proxy);

    function lerp(a, b, t) { return a + (b - a) * t; }

    // Lee posiciones en vivo en cada frame — nunca pre-capturadas.
    // Esto evita el desfase que ocurre cuando el header sticky cambia de tamaño
    // (al añadirse .is-scrolled) y desplaza todos los elementos del DOM.
    function setProxy(p) {
        const sR = sourceEl.getBoundingClientRect();
        const tR = targetEl.getBoundingClientRect();
        proxy.style.left   = lerp(sR.left,   tR.left,   p) + 'px';
        proxy.style.top    = lerp(sR.top,    tR.top,    p) + 'px';
        proxy.style.width  = lerp(sR.width,  tR.width,  p) + 'px';
        proxy.style.height = lerp(sR.height, tR.height, p) + 'px';
    }

    function snapTo(el) {
        const r = el.getBoundingClientRect();
        proxy.style.left   = r.left   + 'px';
        proxy.style.top    = r.top    + 'px';
        proxy.style.width  = r.width  + 'px';
        proxy.style.height = r.height + 'px';
    }

    window.addEventListener('load', function () {
        ScrollTrigger.create({
            trigger:    sourceEl,
            start:      'bottom bottom',
            endTrigger: targetEl,
            end:        'top 50%',
            scrub:      true,

            onEnter() {
                targetImg.src = sourceImg.src;
                setProxy(0);
                proxy.style.opacity     = '1';
                sourceImg.style.opacity = '0';
                targetImg.style.opacity = '0';
            },

            onUpdate(self) {
                setProxy(self.progress);
            },

            onLeave() {
                gsap.killTweensOf([proxy, targetImg]);
                snapTo(targetEl);               // snap exacto al destino final
                proxy.style.opacity     = '0';
                targetImg.style.opacity = '1';
            },

            onEnterBack() {
                gsap.killTweensOf([proxy, targetImg]);
                snapTo(targetEl);               // proxy parte desde el destino
                proxy.style.opacity     = '1';
                targetImg.style.opacity = '0';
            },

            onLeaveBack() {
                gsap.killTweensOf([proxy, sourceImg]);
                snapTo(sourceEl);               // snap exacto al origen
                proxy.style.opacity     = '0';
                sourceImg.style.opacity = '1';
            },
        });
    });
}

// =============================================================================
// HERO → INTRO IMAGE TRANSITION
// =============================================================================
(function () {
    const heroMedia = document.querySelector('[data-js="hero-image"]');
    const introCol  = document.querySelector('[data-js="intro-image"]');
    if (!heroMedia || !introCol) return;

    const heroImg  = heroMedia.querySelector('.hp-hero__image');
    const introFig = introCol.querySelector('.hp-intro__figure');
    const introImg = introCol.querySelector('.hp-intro__image');
    if (!heroImg || !introFig || !introImg) return;

    makeImageTransition(heroMedia, introFig, heroImg, introImg, null);
}());


// =============================================================================
// PROFILE-DETAIL → LANDSCAPE IMAGE TRANSITION  (inversa: pequeño → grande)
// =============================================================================
(function () {
    const detailFig    = document.querySelector('[data-js="profile-detail"]');
    const landscapeFig = document.querySelector('[data-js="values-image"]');
    if (!detailFig || !landscapeFig) return;

    const detailImg    = detailFig.querySelector('img');
    const landscapeImg = landscapeFig.querySelector('img');
    if (!detailImg || !landscapeImg) return;

    // Ambas imágenes tienen scaleX(-1) en CSS; el proxy img debe igualarlo
    makeImageTransition(detailFig, landscapeFig, detailImg, landscapeImg, 'scaleX(-1)');
}());


// =============================================================================
// PARALLAX — Vertical image shift on scroll via GSAP ScrollTrigger
// Applies to all content images (excludes hero which has its own transition).
// Each image overflows its clipped container and shifts at ~30 % scroll speed.
// =============================================================================
(function () {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    gsap.registerPlugin(ScrollTrigger);

    const SELECTORS = [
        '.hp-intro__image',
        '.hp-project__image img',
        '.hp-profile__detail img',
        '.hp-profile__portrait img',
        '.hp-landscape__image img',
        '.hp-cta__image img',
    ];

    const images = document.querySelectorAll(SELECTORS.join(', '));

    images.forEach(function (img) {
        // The parent (figure or wrapper) must clip the overflowing image.
        // We expand the image slightly so the shift never reveals a gap.
        gsap.set(img, { yPercent: -8, scale: 1.18, transformOrigin: 'center center' });

        gsap.to(img, {
            yPercent: 8,
            ease: 'none',
            scrollTrigger: {
                trigger:        img.closest('figure') || img.parentElement,
                start:          'top bottom',
                end:            'bottom top',
                scrub:          true,
            },
        });
    });
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

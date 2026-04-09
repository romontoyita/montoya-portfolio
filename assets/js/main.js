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
// HERO → INTRO IMAGE TRANSITION
// La imagen del hero escala y se traslada hasta la posición de la imagen intro
// al hacer scroll, reemplazándola con la misma imagen recortada en portrait.
// =============================================================================
(function () {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    gsap.registerPlugin(ScrollTrigger);

    const heroMedia = document.querySelector('[data-js="hero-image"]');
    const introCol  = document.querySelector('[data-js="intro-image"]');
    if (!heroMedia || !introCol) return;

    const heroImg  = heroMedia.querySelector('.hp-hero__image');
    const introFig = introCol.querySelector('.hp-intro__figure');
    const introImg = introCol.querySelector('.hp-intro__image');
    if (!heroImg || !introFig || !introImg) return;

    // En mobile el proxy cambia width/height cada frame → layout reflow → traba el scroll.
    // En touch devices se omite: ambas imágenes son visibles de forma natural.
    if (window.matchMedia('(hover: none) and (pointer: coarse)').matches) return;

    // ── 1. Proxy element (position: fixed, viaja entre las dos posiciones) ────
    const proxy = document.createElement('div');
    proxy.className = 'hero-intro-proxy';
    proxy.setAttribute('aria-hidden', 'true');

    const pImg = document.createElement('img');
    pImg.src = heroImg.src;
    pImg.alt = '';
    proxy.appendChild(pImg);
    document.body.appendChild(proxy);

    // ── 2. Posiciones absolutas de página (se capturan una vez por layout) ───
    // Se usan coordenadas de página para calcular posición en viewport sin
    // llamar a getBoundingClientRect en cada frame (evita forced layout).
    let abs = { hero: null, intro: null };

    function captureAbsPositions() {
        const sy = window.scrollY;
        const hR = heroMedia.getBoundingClientRect();
        const iR = introFig.getBoundingClientRect();   // usamos la figure, más precisa
        abs = {
            hero:  { left: hR.left, top: hR.top  + sy, width: hR.width,  height: hR.height  },
            intro: { left: iR.left, top: iR.top  + sy, width: iR.width,  height: iR.height  },
        };
    }

    // ── 3. Helpers ────────────────────────────────────────────────────────────
    function lerp(a, b, t) { return a + (b - a) * t; }

    // Posiciona el proxy interpolando entre hero y intro según el progreso p ∈ [0,1]
    // Usa transform para la posición (GPU-composited, sin layout reflow) y
    // width/height para el tamaño (inevitables al cambiar forma).
    function placeProxy(p) {
        const sy = window.scrollY;

        const x = lerp(abs.hero.left,   abs.intro.left,   p);
        const y = lerp(abs.hero.top,    abs.intro.top,    p) - sy;
        const w = lerp(abs.hero.width,  abs.intro.width,  p);
        const h = lerp(abs.hero.height, abs.intro.height, p);

        proxy.style.transform = 'translate(' + x + 'px,' + y + 'px)';
        proxy.style.width     = w + 'px';
        proxy.style.height    = h + 'px';

        const currentScale   = lerp(1, 1.18, p);
        const currentYPercent = lerp(0, -2, p);

        // pImg está cacheada en el scope externo — evitamos querySelector cada frame
        pImg.style.transform      = 'scale(' + currentScale + ') translateY(' + currentYPercent + '%)';
        pImg.style.transformOrigin = 'center center';
    }

    // ── 4. ScrollTrigger ──────────────────────────────────────────────────────
    window.addEventListener('load', function () {
        captureAbsPositions();

        ScrollTrigger.create({
            trigger:    heroMedia,
            start:      'bottom bottom',   // hero image bottom toca fondo del viewport
            endTrigger: introFig,
            end:        'top 50%',         // intro figure top llega al 50% del viewport
            scrub:      true,              // sin lag extra: Lenis ya suaviza el scroll

            onEnter() {
                // Pre-swap src mientras dura la animación → ya estará en caché al llegar al final
                introImg.src = heroImg.src;
                // Snap proxy exactamente sobre el hero y revela
                placeProxy(0);
                proxy.style.opacity    = '1';
                heroImg.style.opacity  = '0';
                introImg.style.opacity = '0';
            },

            onUpdate(self) {
                placeProxy(self.progress);
            },

            onLeave() {
                gsap.killTweensOf([proxy, introImg]);
                placeProxy(1);
                proxy.style.opacity = '0';
                introImg.style.opacity = '1';
            },

            onEnterBack() {
                gsap.killTweensOf([proxy, introImg]);
                placeProxy(1);              // proxy parte exactamente desde progress=1
                proxy.style.opacity    = '1';
                introImg.style.opacity = '0';
            },

            onLeaveBack() {
                gsap.killTweensOf([proxy, heroImg]);
                placeProxy(0);              // garantiza posición exacta antes del swap
                proxy.style.opacity   = '0';
                heroImg.style.opacity = '1';
            },
        });
    });

    // ── 5. Resize ─────────────────────────────────────────────────────────────
    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            captureAbsPositions();
            ScrollTrigger.refresh();
        }, 250);
    });

}());


// =============================================================================
// PROFILE-DETAIL → LANDSCAPE IMAGE TRANSITION  (inversa: pequeño → grande)
// La imagen profile-detail escala y se traslada hasta la posición de la imagen
// landscape al hacer scroll, reemplazándola con la imagen real al llegar.
// =============================================================================
(function () {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    gsap.registerPlugin(ScrollTrigger);

    const detailFig    = document.querySelector('[data-js="profile-detail"]');
    const landscapeFig = document.querySelector('[data-js="values-image"]');
    if (!detailFig || !landscapeFig) return;

    const detailImg    = detailFig.querySelector('img');
    const landscapeImg = landscapeFig.querySelector('img');
    if (!detailImg || !landscapeImg) return;

    // Mismo motivo que la transición hero→intro: omitir en touch devices.
    if (window.matchMedia('(hover: none) and (pointer: coarse)').matches) return;

    // ── 1. Proxy ──────────────────────────────────────────────────────────────
    const proxy = document.createElement('div');
    proxy.className = 'hero-intro-proxy';   // reutiliza los mismos estilos base
    proxy.setAttribute('aria-hidden', 'true');

    const pImg = document.createElement('img');
    pImg.src = detailImg.src;
    pImg.alt = '';
    proxy.appendChild(pImg);
    document.body.appendChild(proxy);

    // ── 2. Posiciones absolutas de página ─────────────────────────────────────
    let abs2 = { source: null, target: null };

    function captureAbs2() {
        const sy = window.scrollY;
        const dR = detailFig.getBoundingClientRect();
        const lR = landscapeFig.getBoundingClientRect();
        abs2 = {
            source: { left: dR.left, top: dR.top + sy, width: dR.width,  height: dR.height  },
            target: { left: lR.left, top: lR.top + sy, width: lR.width,  height: lR.height  },
        };
    }

    // ── 3. Helpers ────────────────────────────────────────────────────────────
    function lerp(a, b, t) { return a + (b - a) * t; }

    function placeProxy2(p) {
        const sy = window.scrollY;
        const x  = lerp(abs2.source.left,   abs2.target.left,   p);
        const y  = lerp(abs2.source.top,    abs2.target.top,    p) - sy;
        const w  = lerp(abs2.source.width,  abs2.target.width,  p);
        const h  = lerp(abs2.source.height, abs2.target.height, p);

        proxy.style.transform = 'translate(' + x + 'px,' + y + 'px)';
        proxy.style.width     = w + 'px';
        proxy.style.height    = h + 'px';
    }

    // ── 4. ScrollTrigger ──────────────────────────────────────────────────────
    window.addEventListener('load', function () {
        captureAbs2();

        ScrollTrigger.create({
            trigger:    detailFig,
            start:      'bottom bottom',
            endTrigger: landscapeFig,
            end:        'top 50%',
            scrub:      true,

            onEnter() {
                placeProxy2(0);
                proxy.style.opacity       = '1';
                detailImg.style.opacity   = '0';
                landscapeImg.style.opacity = '0';
            },

            onUpdate(self) {
                placeProxy2(self.progress);
            },

            onLeave() {
                gsap.killTweensOf([proxy, landscapeImg]);
                placeProxy2(1);             // garantiza posición exacta antes del swap
                proxy.style.opacity        = '0';
                landscapeImg.style.opacity = '1';
            },

            onEnterBack() {
                gsap.killTweensOf([proxy, landscapeImg]);
                placeProxy2(1);             // proxy parte exactamente desde progress=1
                proxy.style.opacity        = '1';
                landscapeImg.style.opacity = '0';
            },

            onLeaveBack() {
                gsap.killTweensOf([proxy, detailImg]);
                placeProxy2(0);             // garantiza posición exacta antes del swap
                proxy.style.opacity     = '0';
                detailImg.style.opacity = '1';
            },
        });
    });

    // ── 5. Resize ─────────────────────────────────────────────────────────────
    let resizeTimer2;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer2);
        resizeTimer2 = setTimeout(function () {
            captureAbs2();
            ScrollTrigger.refresh();
        }, 250);
    });

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


// =============================================================================
// SECTION PARALLAX — section containers move at a different speed than scroll
//
// Sections with a distinct background (.hp-work #EEE) or isolated content
// (.hp-cta, .hp-hero__inner) are safe to transform: they contain no element
// whose getBoundingClientRect() is cached by the image-transition animations.
//
// .hp-intro / .hp-profile / .hp-landscape are excluded — their [data-js]
// image-transition elements are direct descendants, so any translateY on those
// section roots would shift the cached absolute positions and break the proxy
// placement.
// =============================================================================
(function () {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    gsap.registerPlugin(ScrollTrigger);

    // ── .hp-hero__inner ───────────────────────────────────────────────────────
    // Sibling of .hp-hero__media ([data-js="hero-image"]) — safe to transform.
    // Hero text scrolls ~40 % slower than the page, pulling apart from the image.
    const heroInner = document.querySelector('.hp-hero__inner');
    if (heroInner) {
        gsap.to(heroInner, {
            y: -60,
            ease: 'none',
            scrollTrigger: {
                trigger: heroInner,
                start:   'top top',
                end:     'bottom top',
                scrub:   true,
            },
        });
    }

    // ── .hp-work ──────────────────────────────────────────────────────────────
    // No image-transition anchors inside. Gray #EEE background makes the
    // depth shift clearly visible: the section rises from below at ~60 % speed.
    const work = document.querySelector('.hp-work');
    if (work) {
        gsap.fromTo(work,
            { y: 180 },
            {
                y: 0,
                ease: 'none',
                scrollTrigger: {
                    trigger: work,
                    start:   'top bottom',
                    end:     'top 40%',
                    scrub:   true,
                },
            }
        );
    }

    // ── .hp-cta ───────────────────────────────────────────────────────────────
    // No image-transition anchors inside.
    const cta = document.querySelector('.hp-cta');
    if (cta) {
        gsap.fromTo(cta,
            { y: 80 },
            {
                y: 0,
                ease: 'none',
                scrollTrigger: {
                    trigger: cta,
                    start:   'top bottom',
                    end:     'top 40%',
                    scrub:   true,
                },
            }
        );
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

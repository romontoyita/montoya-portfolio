// main scripts

// =============================================================================
// PAGE LOADER — Hero Logo FLIP Transition
// =============================================================================
(function () {
    const loader = document.querySelector('.page-loader');
    const loaderLogo = loader && loader.querySelector('.page-loader__logo');
    const headerLogo = document.querySelector('.site-header__logo');

    if (!loader || !loaderLogo || !headerLogo) return;

    const MIN_MS = 1500;
    const startTs = Date.now();

    // Aseguramos que el header logo esté oculto inicialmente pero ocupe espacio
    headerLogo.style.opacity = '0';

    function runFlip() {
        const elapsed = Date.now() - startTs;
        const remaining = Math.max(0, MIN_MS - elapsed);

        setTimeout(function () {
            // 1. FIRST: Posición inicial (Loader)
            const first = loaderLogo.getBoundingClientRect();
            
            // 2. LAST: Posición final (Header)
            // Quitamos temporalmente cualquier restricción para medir bien
            headerLogo.style.display = 'inline-block'; 
            const last = headerLogo.getBoundingClientRect();

            // 3. INVERT: Calculamos la diferencia
            const dx = first.left - last.left;
            const dy = first.top - last.top;
            const dw = first.width / last.width;
            const dh = first.height / last.height;

            // Aplicamos la transformación inversa al logo del HEADER
            // para que se mueva exactamente sobre el logo del LOADER
            headerLogo.style.transition = 'none';
            headerLogo.style.transformOrigin = '0 0'; // Importante para que el scale coincida
            headerLogo.style.transform = `translate(${dx}px, ${dy}px) scale(${dw}, ${dh})`;
            headerLogo.style.opacity = '1';

            // Ocultamos el logo del loader (el del header ya lo está cubriendo)
            loaderLogo.style.opacity = '0';
            loaderLogo.style.transition = 'opacity 0.2s ease';

            // 4. PLAY: Animamos hacia el estado natural (transform: none)
            requestAnimationFrame(() => {
                // Forzamos el reflow
                headerLogo.getBoundingClientRect();
                
                headerLogo.style.transition = 'transform 1.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease';
                headerLogo.style.transform = 'none';
                
                // Quitamos el loader de fondo poco después
                setTimeout(() => {
                    loader.classList.add('is-hidden');
                }, 600);
            });

            // Limpieza
            setTimeout(() => {
                if (loader.parentNode) loader.remove();
                headerLogo.style.transition = '';
                headerLogo.style.transformOrigin = '';
                document.body.classList.remove('is-loading');
            }, 2000);

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ==================== Counter Animation ====================
        const counters = document.querySelectorAll('.counter');
        let animated = false;

        const animateCounter = (counter) => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };

            updateCounter();
        };

        const observerOptions = { threshold: 0.5, rootMargin: '0px' };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !animated) {
                    animated = true;
                    counters.forEach(counter => animateCounter(counter));
                }
            });
        }, observerOptions);

        counters.forEach(counter => observer.observe(counter));

        // ==================== Carousel Utility ====================
        function initCarousel(config) {
            const { carouselId, prevBtnId, nextBtnId, dotsId, getCardsPerPage, dotActiveClass, dotInactiveClass } = config;
            const carousel = document.getElementById(carouselId);
            const prevBtn = document.getElementById(prevBtnId);
            const nextBtn = document.getElementById(nextBtnId);
            const dotsContainer = document.getElementById(dotsId);

            if (!carousel || !prevBtn || !nextBtn) return;

            const articles = Array.from(carousel.querySelectorAll('article'));
            const totalArticles = articles.length;
            let currentPage = 0;

            const getTotalPages = () => Math.ceil(totalArticles / getCardsPerPage());

            const createDots = () => {
                dotsContainer.innerHTML = '';
                const totalPages = getTotalPages();
                for (let i = 0; i < totalPages; i++) {
                    const dot = document.createElement('button');
                    dot.className = 'w-2.5 h-2.5 rounded-full transition-all duration-300';
                    dot.onclick = () => goToPage(i);
                    dotsContainer.appendChild(dot);
                }
                updateDots();
            };

            const updateDots = () => {
                const dots = dotsContainer.querySelectorAll('button');
                dots.forEach((dot, index) => {
                    dot.className = index === currentPage ? dotActiveClass : dotInactiveClass;
                });
            };

            const goToPage = (page) => {
                const totalPages = getTotalPages();
                currentPage = Math.max(0, Math.min(page, totalPages - 1));
                const cardsPerPage = getCardsPerPage();
                const cardIndex = currentPage * cardsPerPage;
                const targetCard = articles[cardIndex];

                if (targetCard) {
                    targetCard.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
                }

                setTimeout(() => { updateDots(); updateButtons(); }, 100);
            };

            const updateButtons = () => {
                const totalPages = getTotalPages();
                prevBtn.style.opacity = currentPage === 0 ? '0.5' : '1';
                prevBtn.style.cursor = currentPage === 0 ? 'not-allowed' : 'pointer';
                nextBtn.style.opacity = currentPage >= totalPages - 1 ? '0.5' : '1';
                nextBtn.style.cursor = currentPage >= totalPages - 1 ? 'not-allowed' : 'pointer';
            };

            const updateCurrentPage = () => {
                const scrollLeft = carousel.scrollLeft;
                const cardsPerPage = getCardsPerPage();
                let closestIndex = 0;
                let minDistance = Infinity;

                articles.forEach((article, index) => {
                    const cardLeft = article.offsetLeft - carousel.offsetLeft;
                    const distance = Math.abs(scrollLeft - cardLeft);
                    if (distance < minDistance) {
                        minDistance = distance;
                        closestIndex = index;
                    }
                });

                const newPage = Math.floor(closestIndex / cardsPerPage);
                if (newPage !== currentPage) {
                    currentPage = newPage;
                    updateDots();
                    updateButtons();
                }
            };

            prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                if (currentPage > 0) goToPage(currentPage - 1);
            });

            nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const totalPages = getTotalPages();
                if (currentPage < totalPages - 1) goToPage(currentPage + 1);
            });

            let scrollTimeout;
            carousel.addEventListener('scroll', () => {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(updateCurrentPage, 150);
            });

            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    currentPage = 0;
                    carousel.scrollLeft = 0;
                    createDots();
                    updateButtons();
                }, 250);
            });

            createDots();
            updateButtons();
        }

        // ==================== Initialize Carousels ====================
        initCarousel({
            carouselId: 'beritaCarousel',
            prevBtnId: 'prevBerita',
            nextBtnId: 'nextBerita',
            dotsId: 'beritaDots',
            getCardsPerPage: () => window.innerWidth >= 1024 ? 3 : 1,
            dotActiveClass: 'w-9 h-2.5 rounded-full bg-white shadow-lg shadow-white/35 transition-all duration-300',
            dotInactiveClass: 'w-2.5 h-2.5 rounded-full bg-white/35 hover:bg-white/60 transition-all duration-300'
        });

        if (window.innerWidth < 1024) {
            initCarousel({
                carouselId: 'galleryCarousel',
                prevBtnId: 'prevGallery',
                nextBtnId: 'nextGallery',
                dotsId: 'galleryDots',
                getCardsPerPage: () => 1,
                dotActiveClass: 'w-9 h-2.5 rounded-full bg-blue-700 shadow-lg shadow-blue-400/40 transition-all duration-300',
                dotInactiveClass: 'w-2.5 h-2.5 rounded-full bg-gray-300 hover:bg-gray-400 transition-all duration-300'
            });
        }

        // ==================== Hero Image Slider ====================
        document.querySelectorAll('[data-hero-slider-card]').forEach((card) => {
            const heroSlides = Array.from(card.querySelectorAll('.hero-slide'));
            const heroDots = Array.from(card.querySelectorAll('.hero-dot'));
            if (heroSlides.length <= 1) return;

            let currentHeroSlide = heroSlides.findIndex((slide) => slide.classList.contains('opacity-100'));
            if (currentHeroSlide < 0) currentHeroSlide = 0;

            const showHeroSlide = (index) => {
                heroSlides.forEach((slide, i) => {
                    const isActive = i === index;
                    slide.classList.toggle('hero-slide-active', isActive);
                    slide.classList.toggle('opacity-100', isActive);
                    slide.classList.toggle('z-10', isActive);
                    slide.classList.toggle('opacity-0', !isActive);
                    slide.classList.toggle('z-0', !isActive);
                });

                heroDots.forEach((dot, i) => {
                    const isActive = i === index;
                    dot.classList.toggle('bg-white', isActive);
                    dot.classList.toggle('bg-white/40', !isActive);
                });
            };

            const isVisible = () => card.offsetParent !== null;
            const nextHeroSlide = () => {
                if (!isVisible()) return;
                currentHeroSlide = (currentHeroSlide + 1) % heroSlides.length;
                showHeroSlide(currentHeroSlide);
            };

            showHeroSlide(currentHeroSlide);
            const intervalId = setInterval(nextHeroSlide, 5000);

            heroDots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentHeroSlide = index;
                    showHeroSlide(currentHeroSlide);
                });
            });

            void intervalId;
        });

        // ==================== Search Functionality ====================
        const searchInput = document.getElementById('searchInput');
        const cameraBtn = document.getElementById('cameraBtn');
        const micBtn = document.getElementById('micBtn');

        if (searchInput) {
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    const query = searchInput.value.trim();
                    if (query) {
                        window.location.href = `{{ route('posts.berita') }}?search=${encodeURIComponent(query)}`;
                    }
                }
            });
        }

        // ==================== Microphone / Voice Input ====================
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        let isListening = false;

        if (micBtn && SpeechRecognition) {
            const recognition = new SpeechRecognition();
            recognition.language = 'id-ID';
            recognition.continuous = false;
            recognition.interimResults = false;

            micBtn.addEventListener('click', (e) => {
                e.preventDefault();
                if (!isListening) {
                    isListening = true;
                    micBtn.classList.add('bg-red-600', 'hover:bg-red-700');
                    micBtn.classList.remove('bg-black', 'hover:bg-gray-900');
                    recognition.start();
                }
            });

            recognition.onresult = (event) => {
                const transcript = Array.from(event.results).map(result => result[0].transcript).join('');
                if (searchInput) searchInput.value = transcript;
            };

            recognition.onerror = (event) => console.error('Speech recognition error:', event.error);

            recognition.onend = () => {
                isListening = false;
                micBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
                micBtn.classList.add('bg-black', 'hover:bg-gray-900');
            };
        } else if (micBtn) {
            micBtn.addEventListener('click', () => alert('Speech recognition tidak didukung di browser ini'));
        }

        // ==================== Camera Button ====================
        if (cameraBtn) {
            cameraBtn.addEventListener('click', (e) => {
                e.preventDefault();
                alert('Fitur kamera akan segera tersedia');
            });
        }

        // ==================== Data Kader Placeholder ====================
        ['dataKader', 'dataKaderDesktop'].forEach((id) => {
            const element = document.getElementById(id);
            if (!element) return;
            element.addEventListener('click', (e) => {
                e.preventDefault();
                alert('Fitur ini akan segera tersedia');
            });
        });

        // ==================== Reveal Animations ====================
        const revealTargets = [
            ...document.querySelectorAll('[data-reveal]'),
            ...document.querySelectorAll('[data-reveal-card]')
        ];

        if (revealTargets.length > 0) {
            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -8% 0px',
            });

            revealTargets.forEach((el) => revealObserver.observe(el));
        }

        // ==================== Cinematic Section Enter ====================
        const cinematicTargets = document.querySelectorAll('[data-cinematic]');
        if (cinematicTargets.length > 0) {
            const cinematicObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-cinematic-visible');
                    observer.unobserve(entry.target);
                });
            }, {
                threshold: 0.16,
                rootMargin: '0px 0px -10% 0px',
            });

            cinematicTargets.forEach((el) => cinematicObserver.observe(el));
        }

        // ==================== Scroll Progress + Title Parallax ====================
        const parallaxTitles = Array.from(document.querySelectorAll('[data-parallax-title]'));
        const reduceMotionPref = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (!reduceMotionPref && parallaxTitles.length > 0) {
            let ticking = false;

            const updateMotion = () => {
                parallaxTitles.forEach((title) => {
                    const rect = title.getBoundingClientRect();
                    const viewportCenter = window.innerHeight * 0.5;
                    const delta = (rect.top + (rect.height * 0.5)) - viewportCenter;
                    const offset = Math.max(Math.min(delta * -0.035, 14), -14);
                    title.style.setProperty('--parallax-y', `${offset.toFixed(2)}px`);
                });

                ticking = false;
            };

            window.addEventListener('scroll', () => {
                if (ticking) return;
                ticking = true;
                requestAnimationFrame(updateMotion);
            }, { passive: true });

            window.addEventListener('resize', () => {
                requestAnimationFrame(updateMotion);
            }, { passive: true });

            updateMotion();
        }

        // ==================== Premium Motion (Desktop Only) ====================
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const desktopFinePointer = window.matchMedia('(min-width: 1024px) and (pointer: fine)').matches;

        if (!reduceMotion && desktopFinePointer) {
            const premiumRoot = document.querySelector('[data-premium-root]');
            if (premiumRoot) {
                const layers = Array.from(premiumRoot.querySelectorAll('[data-premium-layer]'));
                const tilts = Array.from(premiumRoot.querySelectorAll('[data-premium-tilt]'));
                let rafId = null;
                let targetX = 0;
                let targetY = 0;

                const render = () => {
                    layers.forEach((layer) => {
                        const depth = Number(layer.getAttribute('data-premium-layer') || 0);
                        const x = (targetX * depth).toFixed(2);
                        const y = (targetY * depth).toFixed(2);
                        layer.style.setProperty('--px', `${x}px`);
                        layer.style.setProperty('--py', `${y}px`);
                    });

                    tilts.forEach((card) => {
                        const rx = (-targetY * 1.9).toFixed(2);
                        const ry = (targetX * 2.2).toFixed(2);
                        card.style.setProperty('--rx', `${rx}deg`);
                        card.style.setProperty('--ry', `${ry}deg`);
                    });

                    rafId = null;
                };

                premiumRoot.addEventListener('mousemove', (event) => {
                    const rect = premiumRoot.getBoundingClientRect();
                    const normalizedX = ((event.clientX - rect.left) / rect.width) - 0.5;
                    const normalizedY = ((event.clientY - rect.top) / rect.height) - 0.5;
                    targetX = normalizedX * 1.2;
                    targetY = normalizedY * 1.2;

                    if (!rafId) {
                        rafId = requestAnimationFrame(render);
                    }
                }, { passive: true });

                premiumRoot.addEventListener('mouseleave', () => {
                    targetX = 0;
                    targetY = 0;
                    if (!rafId) {
                        rafId = requestAnimationFrame(render);
                    }
                }, { passive: true });
            }

            // Magnetic hover for key CTA buttons
            document.querySelectorAll('[data-magnetic]').forEach((el) => {
                let raf = null;
                let mx = 0;
                let my = 0;

                const render = () => {
                    el.style.setProperty('--mx', `${mx.toFixed(2)}px`);
                    el.style.setProperty('--my', `${my.toFixed(2)}px`);
                    raf = null;
                };

                el.addEventListener('mousemove', (event) => {
                    const rect = el.getBoundingClientRect();
                    const relX = ((event.clientX - rect.left) / rect.width) - 0.5;
                    const relY = ((event.clientY - rect.top) / rect.height) - 0.5;
                    mx = relX * 7;
                    my = relY * 5;
                    if (!raf) raf = requestAnimationFrame(render);
                }, { passive: true });

                el.addEventListener('mouseleave', () => {
                    mx = 0;
                    my = 0;
                    if (!raf) raf = requestAnimationFrame(render);
                }, { passive: true });
            });
        }
    });
</script>

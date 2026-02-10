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
            dotActiveClass: 'w-8 h-2.5 rounded-full bg-white transition-all duration-300',
            dotInactiveClass: 'w-2.5 h-2.5 rounded-full bg-white/40 hover:bg-white/60 transition-all duration-300'
        });

        if (window.innerWidth < 1024) {
            initCarousel({
                carouselId: 'galleryCarousel',
                prevBtnId: 'prevGallery',
                nextBtnId: 'nextGallery',
                dotsId: 'galleryDots',
                getCardsPerPage: () => 1,
                dotActiveClass: 'w-8 h-2.5 rounded-full bg-blue-700 transition-all duration-300',
                dotInactiveClass: 'w-2.5 h-2.5 rounded-full bg-gray-300 hover:bg-gray-400 transition-all duration-300'
            });
        }

        // ==================== Hero Image Slider ====================
        const heroSlides = document.querySelectorAll('.hero-slide');
        const heroDots = document.querySelectorAll('.hero-dot');

        if (heroSlides.length > 1) {
            let currentHeroSlide = 0;

            function showHeroSlide(index) {
                heroSlides.forEach((slide, i) => {
                    if (i === index) {
                        slide.classList.remove('opacity-0', 'z-0');
                        slide.classList.add('opacity-100', 'z-10');
                    } else {
                        slide.classList.remove('opacity-100', 'z-10');
                        slide.classList.add('opacity-0', 'z-0');
                    }
                });

                heroDots.forEach((dot, i) => {
                    if (i === index) {
                        dot.classList.remove('bg-white/50');
                        dot.classList.add('bg-white');
                    } else {
                        dot.classList.remove('bg-white');
                        dot.classList.add('bg-white/50');
                    }
                });
            }

            function nextHeroSlide() {
                currentHeroSlide = (currentHeroSlide + 1) % heroSlides.length;
                showHeroSlide(currentHeroSlide);
            }

            setInterval(nextHeroSlide, 5000);

            heroDots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentHeroSlide = index;
                    showHeroSlide(currentHeroSlide);
                });
            });
        }

        // ==================== Search Functionality ====================
        const searchInput = document.getElementById('searchInput');
        const cameraBtn = document.getElementById('cameraBtn');
        const micBtn = document.getElementById('micBtn');

        if (searchInput) {
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    const query = searchInput.value.trim();
                    if (query) {
                        window.location.href = `<?php echo e(route('posts.berita')); ?>?search=${encodeURIComponent(query)}`;
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
    });
</script>
<?php /**PATH /var/www/resources/views/components/home/home-scripts.blade.php ENDPATH**/ ?>
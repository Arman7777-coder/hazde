@extends('client.layout.app')

@section('title', 'Home')

@section('content')
    <section class="hero-section">
        <div class="hero-wrapper">
            <div class="texts-hero">
                <h1 class="title-hero"><span class="font-letter">С</span>вадебный <span
                        class="not-italic">агрегатор</span></h1>
                <p class="description-hero">Планирование свадьбы стало проще и быстрее. Все необходимое для подготовки
                    теперь собрано в одном месте</p>
            </div>
            <div class="slider-hero">
                <div class="slider-header">
                    <div class="slider-index"><span id="slideIndex">01</span></div>
                    <div class="swiper-pagination"></div>

                </div>
                <div class="swiper">

                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('images/bentley.jpg') }}" class="image-hero-slider" alt="">
                            <p class="hero-services">Авто</p>
                        </div>
                        <div class="swiper-slide"><img src="{{ asset('images/photographer.png') }}" class="image-hero-slider" alt="">
                            <p class="hero-services">Фото & Видео</p>
                        </div>
                        <div class="swiper-slide"><img src="{{ asset('images/house.png') }}" class="image-hero-slider" alt="">
                            <p class="hero-services">Дома торжеств</p>
                        </div>
                        <div class="swiper-slide"><img src="{{ asset('images/music.png') }}" class="image-hero-slider" alt="">
                            <p class="hero-services">Ведущие & Музыка</p>
                        </div>
                        <div class="swiper-slide"><img src="{{ asset('images/flower.png') }}" class="image-hero-slider" alt="">
                            <p class="hero-services">Флористика</p>
                        </div>
                        <div class="swiper-slide"><img src="{{ asset('images/keytering.png') }}" class="image-hero-slider" alt="">
                            <p class="hero-services">Кейтеринг</p>
                        </div>
                    </div>
                </div>
                <!-- Init Swiper -->
                <script>
                    const swiper = new Swiper('.swiper', {
                        spaceBetween: 0,
                        loop: true,
                        grabCursor: true,
                        autoplay: {
                            delay: 3500,
                            disableOnInteraction: false,
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            type: 'progressbar',
                        },
                        navigation: false,
                        scrollbar: false,
                        slidesPerView: 'auto',
                        centeredSlides: false,

                    });

                    // Update the left index to show 01, 02 ... based on real slide position (1-based)
                    function pad(num) { return String(num).padStart(2, '0'); }
                    function updateIndex() {
                        // realIndex is 0-based for slides in Swiper when loop:true, but swiper.realIndex is reliable
                        const idx = swiper.realIndex + 1;
                        document.getElementById('slideIndex').textContent = pad(idx);
                    }

                    // initial
                    updateIndex();

                    // update index on slide change
                    swiper.on('slideChange', updateIndex);
                    swiper.on('autoplay', updateIndex);
                </script>
            </div>
        </div>
    </section>
    <script>

        (function () {
            const MOBILE_MAX = 768;
            const selector = '.left-section-about.second-ab-section';
if(window.innerWidth >= MOBILE_MAX) return;
            function setup() {
                const root = document.querySelector(selector);
                if (!root) return;

                const slidesWrap = root;
                const slides = Array.from(root.querySelectorAll('.content-block-about'));
                if (!slides.length) return;

                slidesWrap.style.display = slidesWrap.style.display || 'flex';
                slidesWrap.style.overflow = 'hidden';
                slidesWrap.style.scrollBehavior = 'smooth';
                slides.forEach(s => {
                    s.style.flex = '0 0 100%';
                    s.style.maxWidth = '100%';
                    s.style.boxSizing = 'border-box';
                });

                // create or reuse pagination (progress bar)
                let pagination = root.querySelector('.lsa-pagination-js');
                if (!pagination) {
                    pagination = document.createElement('div');
                    pagination.className = 'lsa-pagination-js';
                    pagination.style.marginTop = '12px';
                    pagination.style.padding = '6px 12%';

                    const track = document.createElement('div');
                    track.className = 'lsa-progress-track';
                    const fill = document.createElement('div');
                    fill.className = 'lsa-progress-fill';
                    track.appendChild(fill);
                    pagination.appendChild(track);
                    root.parentNode.insertBefore(pagination, root.nextSibling);

                    track.addEventListener('click', (e) => {
                        const rect = track.getBoundingClientRect();
                        const ratio = Math.min(Math.max((e.clientX - rect.left) / rect.width, 0), 1);
                        const targetIndex = Math.round(ratio * (slides.length - 1));
                        goTo(targetIndex);
                        resetAutoplay();
                    });
                }

                let index = 0;
                let autoplayInterval = null;
                let isEnabled = false;

                function updatePagination() {
                    const fill = pagination.querySelector('.lsa-progress-fill');
                    if (!fill) return;
                    let pct = 0;
                    if (slides.length > 1) pct = (index / (slides.length - 1)) * 100;
                    else pct = index ? 100 : 0;
                    fill.style.width = pct + '%';
                }

                function goTo(i, instant = false) {
                    index = ((i % slides.length) + slides.length) % slides.length;
                    const slideWidth = slides[0].clientWidth || slidesWrap.clientWidth;
                    const left = index * slideWidth;
                    if (instant) slidesWrap.scrollLeft = left;
                    else slidesWrap.scrollTo({ left, behavior: 'smooth' });
                    updatePagination();
                }

                function startAutoplay() {
                    stopAutoplay();
                    autoplayInterval = setInterval(() => goTo(index + 1), 4500);
                }
                function stopAutoplay() {
                    if (autoplayInterval) {
                        clearInterval(autoplayInterval);
                        autoplayInterval = null;
                    }
                }
                function resetAutoplay() {
                    stopAutoplay();
                    startAutoplay();
                }

                // touch / drag handlers
                function addTouchHandlers() {
                    let startX = 0;
                    let currentX = 0;
                    let isDown = false;
                    const threshold = 40;

                    slidesWrap.addEventListener('touchstart', (e) => {
                        stopAutoplay();
                        isDown = true;
                        startX = e.touches[0].clientX;
                        currentX = startX;
                    }, { passive: true });

                    slidesWrap.addEventListener('touchmove', (e) => {
                        if (!isDown) return;
                        currentX = e.touches[0].clientX;
                    }, { passive: true });

                    slidesWrap.addEventListener('touchend', () => {
                        if (!isDown) return;
                        isDown = false;
                        const diff = currentX - startX;
                        if (Math.abs(diff) > threshold) {
                            if (diff < 0) goTo(index + 1);
                            else goTo(index - 1);
                        } else {
                            goTo(index);
                        }
                        resetAutoplay();
                    });

                    // mouse drag support for desktop testing
                    let mouseDown = false;
                    slidesWrap.addEventListener('mousedown', (e) => {
                        stopAutoplay();
                        mouseDown = true;
                        startX = e.clientX;
                        currentX = startX;
                        e.preventDefault();
                    });
                    window.addEventListener('mousemove', (e) => {
                        if (!mouseDown) return;
                        currentX = e.clientX;
                    });
                    window.addEventListener('mouseup', () => {
                        if (!mouseDown) return;
                        mouseDown = false;
                        const diff = currentX - startX;
                        if (Math.abs(diff) > threshold) {
                            if (diff < 0) goTo(index + 1);
                            else goTo(index - 1);
                        } else {
                            goTo(index);
                        }
                        resetAutoplay();
                    });
                }

                function enableSlider() {
                    if (isEnabled) return;
                    isEnabled = true;
                    slidesWrap.style.overflow = 'hidden';
                    slidesWrap.style.touchAction = 'pan-y';
                    updatePagination();
                    addTouchHandlers();
                    goTo(0, true);
                    startAutoplay();
                    window.addEventListener('orientationchange', () => setTimeout(() => goTo(index, true), 300));
                }

                function disableSlider() {
                    if (!isEnabled) return;
                    isEnabled = false;
                    stopAutoplay();
                    if (pagination) pagination.innerHTML = '';
                    slidesWrap.scrollLeft = 0;
                    slidesWrap.style.overflow = '';
                    slidesWrap.style.touchAction = '';
                }

                const mq = window.matchMedia(`(max-width: ${MOBILE_MAX}px)`);
                function handleMatch(e) {
                    if (e.matches) enableSlider();
                    else disableSlider();
                }
                handleMatch(mq);
                mq.addEventListener ? mq.addEventListener('change', handleMatch) : mq.addListener(handleMatch);
            }

            if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', setup);
            else setup();
        })();
    </script>
    <!-- About section with anchor -->
    <section class="about-platform-section" id="about">
        <div class="title-about-platform">
            <div class="image-container-title">
                <img src="{{ asset('images/flower-about.png') }}" class="image-title" alt="">
            </div>
            <h2 class="title-about-platform-text"> <span class="font-letter">Ч</span>ем полезна <span>данная
                    платформа</span>
                для покупателя-клиента?</h2>
        </div>
        <div class="content-about-platform">
            <div class="left-section-about">
                <div class="content-block-about">
                    <h4 class="title-content-block">Гарантия <span class="italic">качества</span></h4>
                    <p class="desc-content-block">Только проверенные профессионалы с реальными отзывами и высоким
                        рейтингом. Вся информация о поставщиках открыта и прозрачна, а каждый шаг — подтверждён
                        гарантией качества.</p>
                </div>
                <div class="content-block-about">
                    <h4 class="title-content-block">Экономия <span class="italic">времени и усилий</span></h4>
                    <p class="desc-content-block">С нашим агрегатором всё, что вам нужно для планирования свадьбы,
                        доступно в одном месте. Сравнивайте цены, читайте отзывы, просматривайте портфолио — всё за
                        несколько минут. Больше не нужно тратить часы на поиски и звонки</p>
                </div>
                <div class="content-block-about">
                    <h4 class="title-content-block">Легкость <span class="italic">в планировании</span></h4>
                    <p class="desc-content-block">Мы сделали процесс выбора максимально простым, собрав в одном месте
                        все необходимые услуги. Здесь можно будет в режиме реального времени проверить свободные даты
                        для бронирования, найти подходящего по стилю фотографа, сборщиков приданого и многих других
                        исполнителей</p>
                </div>
                <div class="content-block-about">
                    <h4 class="title-content-block">Контроль <span class="italic">бюджета</span></h4>
                    <p class="desc-content-block">Легко сравнивайте цены на различные услуги, от кейтеринга до
                        фотосессий, и выбирайте те, которые идеально соответствуют вашим финансовым возможностям</p>
                </div>
            </div>
            <script>(function () {
                    const MOBILE_MAX = 768;
                    // run this initializer only on small viewports
                    if (window.innerWidth >= MOBILE_MAX) return;
                    const root = document.querySelector('.left-section-about');
                    if (!root) return;

                    const slidesWrap = root;
                    const slides = Array.from(root.querySelectorAll('.content-block-about'));
                    if (!slides.length) return;

                    // create a container around slides for smooth scroll if not already
                    // (we'll use the existing root as the scroll container)
                    slidesWrap.style.display = slidesWrap.style.display || 'flex';
                    slidesWrap.style.overflow = 'hidden';
                    slidesWrap.style.scrollBehavior = 'smooth';
                    slides.forEach(s => {
                        s.style.flex = '0 0 100%';
                        s.style.maxWidth = '100%';
                        s.style.boxSizing = 'border-box';
                    });

                    // progress-bar element (create or reuse)
                    let pagination = root.querySelector('.lsa-pagination-js');
                    if (!pagination) {
                        pagination = document.createElement('div');
                        pagination.className = 'lsa-pagination-js';
                        pagination.style.marginTop = '12px';
                        pagination.style.padding = '6px 12%';

                        const track = document.createElement('div');
                        track.className = 'lsa-progress-track';
                        track.style.position = 'relative';
                        track.style.height = '8px';
                        track.style.background = '#eee';
                        track.style.borderRadius = '8px';
                        track.style.cursor = 'pointer';
                        track.style.boxShadow = 'inset 0 0 0 1px rgba(0,0,0,0.03)';

                        const fill = document.createElement('div');
                        fill.className = 'lsa-progress-fill';
                        fill.style.position = 'absolute';
                        fill.style.left = '0';
                        fill.style.top = '0';
                        fill.style.bottom = '0';
                        fill.style.width = '0%';
                        fill.style.background = '#8b2b2b';
                        fill.style.borderRadius = '8px';

                        track.appendChild(fill);
                        pagination.appendChild(track);
                        root.parentNode.insertBefore(pagination, root.nextSibling);

                        track.addEventListener('click', (e) => {
                            const rect = track.getBoundingClientRect();
                            const ratio = Math.min(Math.max((e.clientX - rect.left) / rect.width, 0), 1);
                            const targetIndex = Math.round(ratio * (slides.length - 1));
                            goTo(targetIndex);
                            resetAutoplay();
                        });
                    }

                    let index = 0;
                    let autoplayInterval = null;
                    let isEnabled = false;

                    function buildPagination() {
                        // track already exists; just refresh fill
                        updatePagination();
                    }

                    function updatePagination() {
                        const fill = pagination.querySelector('.lsa-progress-fill');
                        if (!fill) return;
                        let pct = 0;
                        if (slides.length > 1) pct = (index / (slides.length - 1)) * 100;
                        else pct = index ? 100 : 0;
                        fill.style.width = pct + '%';
                    }

                    function goTo(i, instant = false) {
                        index = ((i % slides.length) + slides.length) % slides.length;
                        const slideWidth = slides[0].clientWidth || slidesWrap.clientWidth;
                        const left = index * slideWidth;
                        if (instant) slidesWrap.scrollLeft = left;
                        else slidesWrap.scrollTo({ left, behavior: 'smooth' });
                        updatePagination();
                    }

                    function startAutoplay() {
                        stopAutoplay();
                        autoplayInterval = setInterval(() => goTo(index + 1), 4500);
                    }
                    function stopAutoplay() {
                        if (autoplayInterval) {
                            clearInterval(autoplayInterval);
                            autoplayInterval = null;
                        }
                    }
                    function resetAutoplay() {
                        stopAutoplay();
                        startAutoplay();
                    }

                    // touch / drag handlers
                    function addTouchHandlers() {
                        let startX = 0;
                        let currentX = 0;
                        let isDown = false;
                        const threshold = 40;

                        slidesWrap.addEventListener('touchstart', (e) => {
                            stopAutoplay();
                            isDown = true;
                            startX = e.touches[0].clientX;
                            currentX = startX;
                        }, { passive: true });

                        slidesWrap.addEventListener('touchmove', (e) => {
                            if (!isDown) return;
                            currentX = e.touches[0].clientX;
                        }, { passive: true });

                        slidesWrap.addEventListener('touchend', () => {
                            if (!isDown) return;
                            isDown = false;
                            const diff = currentX - startX;
                            if (Math.abs(diff) > threshold) {
                                if (diff < 0) goTo(index + 1);
                                else goTo(index - 1);
                            } else {
                                goTo(index);
                            }
                            resetAutoplay();
                        });

                        // mouse drag support for desktop testing (optional)
                        let mouseDown = false;
                        slidesWrap.addEventListener('mousedown', (e) => {
                            stopAutoplay();
                            mouseDown = true;
                            startX = e.clientX;
                            currentX = startX;
                            e.preventDefault();
                        });
                        window.addEventListener('mousemove', (e) => {
                            if (!mouseDown) return;
                            currentX = e.clientX;
                        });
                        window.addEventListener('mouseup', () => {
                            if (!mouseDown) return;
                            mouseDown = false;
                            const diff = currentX - startX;
                            if (Math.abs(diff) > threshold) {
                                if (diff < 0) goTo(index + 1);
                                else goTo(index - 1);
                            } else {
                                goTo(index);
                            }
                            resetAutoplay();
                        });
                    }

                    function enableSlider() {
                        if (isEnabled) return;
                        isEnabled = true;
                        slidesWrap.style.overflow = 'hidden';
                        slidesWrap.style.touchAction = 'pan-y';
                        buildPagination();
                        addTouchHandlers();
                        goTo(0, true);
                        startAutoplay();
                        window.addEventListener('orientationchange', () => setTimeout(() => goTo(index, true), 300));
                    }

                    function disableSlider() {
                        if (!isEnabled) return;
                        isEnabled = false;
                        stopAutoplay();
                        pagination.innerHTML = '';
                        slidesWrap.scrollLeft = 0;
                        slidesWrap.style.overflow = '';
                        slidesWrap.style.touchAction = '';
                    }

                    let resizeTimer;
                    function checkEnable() {
                        const w = window.innerWidth;
                        if (w < MOBILE_MAX) enableSlider();
                        else disableSlider();
                    }

                    window.addEventListener('resize', () => {
                        clearTimeout(resizeTimer);
                        resizeTimer = setTimeout(() => {
                            checkEnable();
                            if (isEnabled) goTo(index, true);
                        }, 120);
                    });

                    // initial
                    checkEnable();
                })();
            </script>

            <div class="right-section-about">
                <div class="image-container-about"><img src="{{ asset('images/about-car.png') }}" class="image-btn-ab" alt="">
                </div>
                <a href="{{ route('login') }}" class="button-container-about">
                    <p class="btn-text-ab">Войти</p>
                    <div class="container-arrow"><img src="{{ asset('images/icon-arrow.png') }}" alt=""></div>
                </a>
            </div>
        </div>
    </section>
    <section class="how-it-works-section">
        <div class="wrapper-how-works-sec">
            <h1 class="title-how-it-works"><span class="font-letter">К</span>ак работает платформа?</h1>
            <div class="for-clients-how">
                <p class="title-cl-mini">Клиентам</p>
                <div class="blocks-how-it-works">
                    <div class="block-how-it-works">
                        <!-- <p class="number-block-hw">(1)</p> -->
                         <img src="{{ asset('images/registration-step.jpg') }}" class="block-hwt-img" alt="">
                        <h5 class="title-how-it-works">Регистрация</h5>
                        <p class="desc-it-works">Зарегистрируйтесь и создайте свой профиль, укажите свои данные</p>
                    </div>
                    <div class="block-how-it-works">
                        <!-- <p class="number-block-hw">(2)</p> -->                         <img src="{{ asset('images/chosing-step.jpg') }}" class="block-hwt-img" alt="">

                        <h5 class="title-how-it-works">Поиск и выбор</h5>
                        <p class="desc-it-works">Легко находите поставщиков по категории, услугам, ценам и отзывам</p>
                    </div>
                    <div class="block-how-it-works">
                        <!-- <p class="number-block-hw">(3)</p> -->                         <img src="{{ asset('images/dogovor-step.png') }}" class="block-hwt-img" alt="">

                        <h5 class="title-how-it-works">Бронь и договор</h5>
                        <p class="desc-it-works">При необходимости свяжитесь с поставщиком и обсудите детали, далее
                            осуществите бронирование</p>
                    </div>
                </div>
            </div>
            <script>
                (function () {
                    const MOBILE_MAX = 768;
                    const rootSelector = '.blocks-how-it-works';
                    const slideSelector = '.block-how-it-works';
                    const dotsClass = 'slider-dots';

                    function createProgressBar(container, slides, scrollToSlide) {
                        // Remove old progress bar if it exists
                        const old = container.parentNode.querySelector('.lsa-pagination-js');
                        if (old) old.remove();

                        // Create progress bar container
                        const pagination = document.createElement('div');
                        pagination.className = 'lsa-pagination-js';

                        // Create track
                        const track = document.createElement('div');
                        track.className = 'lsa-progress-track';

                        // Create fill element
                        const fill = document.createElement('div');
                        fill.className = 'lsa-progress-fill';

                        // Assemble progress bar
                        track.appendChild(fill);
                        pagination.appendChild(track);
                        container.parentNode.insertBefore(pagination, container.nextSibling);

                        // Add click handler
                        track.addEventListener('click', (e) => {
                            const rect = track.getBoundingClientRect();
                            const ratio = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                            const targetIndex = Math.round(ratio * (slides.length - 1));
                            scrollToSlide(targetIndex);
                        });

                        return pagination;
                    }

                    function updateProgress(progressBar, activeIndex, totalSlides) {
                        if (!progressBar) return;
                        const fill = progressBar.querySelector('.lsa-progress-fill');
                        if (!fill) return;
                        const progress = totalSlides > 1 ? (activeIndex / (totalSlides - 1)) * 100 : activeIndex ? 100 : 0;
                        fill.style.width = `${progress}%`;
                    }

                    function enableSlider(container) {
                        const slides = Array.from(container.querySelectorAll(slideSelector));
                        if (!slides.length) return;

                        // Base styles for centered horizontal slider
                        container.style.display = 'flex';
                        container.style.overflowX = 'auto';
                        container.style.scrollSnapType = 'x mandatory';
                        container.style.scrollBehavior = 'smooth';
                        container.style.webkitOverflowScrolling = 'touch';
                        container.style.gap = '1rem';
                        container.style.justifyContent = 'center'; // Center content
                        container.style.scrollPadding = '0 10px';

                        slides.forEach((s) => {
                            s.style.flex = '0 0 100%';
                            s.style.scrollSnapAlign = 'center';
                            s.style.maxWidth = '100%';
                            s.style.boxSizing = 'border-box';
                            s.style.margin = '0 auto'; // helps center slide content visually
                        });

                        const scrollToSlide = (index) => {
                            if (!slides[index]) return;
                            const left =
                                slides[index].offsetLeft -
                                container.offsetLeft -
                                (container.clientWidth - slides[index].clientWidth) / 2;
                            container.scrollTo({ left, behavior: 'smooth' });
                        };

                        const progressBar = createProgressBar(container, slides, scrollToSlide);

                        const io = new IntersectionObserver(
                            (entries) => {
                                for (const entry of entries) {
                                    if (entry.isIntersecting) {
                                        const idx = slides.indexOf(entry.target);
                                        if (idx !== -1) {
                                            slides.forEach((s, i) => s.classList.toggle('active', i === idx));
                                            updateProgress(progressBar, idx, slides.length);
                                        }
                                    }
                                }
                            },
                            { root: container, threshold: 0.6 }
                        );

                        slides.forEach((s) => io.observe(s));

                        // Scroll to first slide when enabling
                        requestAnimationFrame(() => scrollToSlide(0));

                        let scrollTimeout;
                        container.addEventListener(
                            'scroll',
                            () => {
                                clearTimeout(scrollTimeout);
                                scrollTimeout = setTimeout(() => {
                                    const center = container.scrollLeft + container.clientWidth / 2;
                                    let best = 0;
                                    let bestDist = Infinity;
                                    slides.forEach((s, i) => {
                                        const slideCenter = s.offsetLeft + s.offsetWidth / 2 - container.offsetLeft;
                                        const dist = Math.abs(center - slideCenter);
                                        if (dist < bestDist) {
                                            bestDist = dist;
                                            best = i;
                                        }
                                    });
                                    slides.forEach((s, i) => s.classList.toggle('active', i === best));
                                    updateProgress(progressBar, best, slides.length);
                                }, 120);
                            },
                            { passive: true }
                        );

                        return () => {
                            container.style.overflowX = '';
                            container.style.scrollSnapType = '';
                            container.style.webkitOverflowScrolling = '';
                            container.style.scrollBehavior = '';
                            slides.forEach((s) => {
                                s.style.flex = '';
                                s.style.scrollSnapAlign = '';
                                s.style.maxWidth = '';
                                s.style.margin = '';
                            });
                            io.disconnect();
                            if (progressBar) progressBar.remove();
                        };
                    }

                    function init() {
                        const sliders = Array.from(document.querySelectorAll(rootSelector));
                        if (!sliders.length) return;

                        const activeSliders = new Map();

                        const mq = window.matchMedia(`(max-width: ${MOBILE_MAX}px)`);

                        function handleMatch(e) {
                            sliders.forEach((container) => {
                                const enabled = activeSliders.has(container);
                                if (e.matches && !enabled) {
                                    const cleanup = enableSlider(container);
                                    activeSliders.set(container, cleanup);
                                } else if (!e.matches && enabled) {
                                    const cleanup = activeSliders.get(container);
                                    if (cleanup) cleanup();
                                    activeSliders.delete(container);
                                }
                            });
                        }

                        handleMatch(mq);
                        mq.addEventListener
                            ? mq.addEventListener('change', handleMatch)
                            : mq.addListener(handleMatch);
                    }

                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', init);
                    } else {
                        init();
                    }
                })();
            </script>
            <div class="for-clients-how">
                <p class="title-cl-mini second-title">Поставщикам свадебных услуг</p>
                <div class="blocks-how-it-works">
                    <div class="block-how-it-works">
                        <!-- <p class="number-block-hw">(1)</p> -->                         <img src="{{ asset('images/register-step-postavshik.png') }}" class="block-hwt-img" alt="">

                        <h5 class="title-how-it-works">Регистрация</h5>
                        <p class="desc-it-works">Зарегистрируйтесь и создайте профиль для вас или вашей компании</p>
                    </div>
                    <div class="block-how-it-works">
                        <!-- <p class="number-block-hw">(2)</p> --><img src="{{ asset('images/add-service-step.jpg') }}" class="block-hwt-img" alt="">
                        <h5 class="title-how-it-works">Размещение</h5>                         

                        <p class="desc-it-works">Разместите услуги с подробным описанием, ценами, фото и актуальной
                            информацией</p>
                    </div>
                    <div class="block-how-it-works">
                        <!-- <p class="number-block-hw">(3)</p> --> <img src="{{ asset('images/sdelka-step.png') }}" class="block-hwt-img"  alt="">
                        <h5 class="title-how-it-works">Сделка</h5>                        

                        <p class="desc-it-works">Получайте клиентов, узнаваемость, заключайте сделки, анализируйте
                            конкурентов</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        img.block-hwt-img {
    width: 100%;
        min-height: 201px;
    object-fit: cover;
        max-height: 201px;
}
    </style>
    <section class="about-platform-section second-ab-section">
        <div class="title-about-platform second-ab-section">
            <div class="image-container-title second-ab-section">
                <img src="{{ asset('images/about-cofe.png') }}" class="image-title " alt="">
            </div>
            <h2 class="title-about-platform-text second-ab-section"> <span class="font-letter">З</span><span>ачем
                    поставщикам свадебных услуг наша платформа?</span></h2>
        </div>
        <div class="content-about-platform second-ab-section">
            <div class="left-section-about second-ab-section">
                <div class="content-block-about second-ab-section">
                    <h4 class="title-content-block second-ab-section">Узнаваемость <span class="italic">бренда</span>
                    </h4>
                    <p class="desc-content-block second-ab-section">Наша платформа предоставляет вам возможность заявить о себе и своих услугах широкой аудитории. Увеличьте свою узнаваемость среди целевой аудитории и привлекайте больше клиентов благодаря профессиональному представлению вашего бренда.</p>
                </div>
                <div class="content-block-about second-ab-section">
                    <h4 class="title-content-block second-ab-section">Привлечение <span class="italic">клиентов</span>
                    </h4>
                    <p class="desc-content-block second-ab-section">Получайте новых клиентов из разных регионов и возрастных групп. Наша платформа объединяет будущих молодоженов и поставщиков свадебных услуг, что позволяет вам находить клиентов круглый год, а не только в свадебный сезон.</p>
                </div>
                <div class="content-block-about second-ab-section">
                    <h4 class="title-content-block second-ab-section">Маркетинговая <span
                            class="italic">поддержка</span></h4>
                    <p class="desc-content-block second-ab-section">Мы предлагаем профессиональную маркетинговую поддержку для продвижения ваших услуг. Наши специалисты помогут вам правильно презентовать свои услуги, создать привлекательные описания и увеличить конверсию посетителей в клиенты.</p>
                </div>
                <div class="content-block-about second-ab-section">
                    <h4 class="title-content-block second-ab-section">Простота <span class="italic">и удобство </span>
                    </h4>
                    <p class="desc-content-block second-ab-section">Работа с нашей платформой не требует специальных навыков. Интуитивно понятный интерфейс позволяет легко управлять вашим профилем, обновлять информацию об услугах и отслеживать статистику. Всё, что нужно - уже у вас под рукой.</p>
                </div>
            </div>
            <div class="right-section-about second-ab-section">
                <div class="image-container-about"><img src="{{ asset('images/about-flower.png') }}" class="image-btn-ab" alt="">
                </div>
                <a href="{{ route('login') }}" class="button-container-about second-ab-section">
                    <p class="btn-text-ab">Войти</p>
                    <div class="container-arrow"><img src="{{ asset('images/icon-arrow.png') }}" alt=""></div>
                </a>
            </div>
        </div>
    </section>
    <!-- Blog section with anchor -->
    <section class="faq-homepage" id="blog">
        <div class="title-container-faq">
            <h1 class="faq-title"><span class="font-letter">О</span>тветы на вопросы</h1>
        </div>
        <div class="faq-blocks">
            <div class="faq-block">
                <h1 class="title-faq">С чего начать подготовку к свадьбе?</h1>
                <p class="desc-faq">Начните с выбора даты и концепции свадьбы. После этого можно подобрать площадку,
                    платье и специалистов. Мы поможем на каждом этапе.</p>
            </div>
            <div class="faq-block">
                <h1 class="title-faq">Можно ли забронировать услуги заранее?</h1>
                <p class="desc-faq">Да, рекомендуется бронировать услуги как минимум за 6-12 месяцев до свадьбы, особенно в высокий сезон (май-октябрь). Популярные поставщики часто бронируются задолго до даты события.</p>
            </div>
            <div class="faq-block">
                <h1 class="title-faq">Сколько стоит организация свадьбы?</h1>
                <p class="desc-faq">Стоимость организации свадьбы зависит от масштаба мероприятия, количества гостей и выбранных услуг. В среднем бюджет может варьироваться от 100 000 до 1 000 000 рублей. Мы предлагаем различные пакеты услуг под любой бюджет.</p>
            </div>
            <div class="faq-block">
                <h1 class="title-faq">Можно ли внести изменения после бронирования?</h1>
                <p class="desc-faq">Да, изменения возможны, но зависят от условий конкретного поставщика услуг. Рекомендуем обсуждать все детали заранее. Некоторые изменения могут повлечь дополнительные расходы или быть невозможными в преддверии даты события.</p>
            </div>
            <div class="faq-block">
                <h1 class="title-faq">Работаете ли вы в других городах?</h1>
                <p class="desc-faq">Да, мы сотрудничаем с поставщиками услуг в разных городах России и СНГ. Организация свадьбы в другом городе возможна с нашими координаторами, которые обеспечат контроль на всех этапах подготовки и проведения мероприятия.</p>
            </div>
            <div class="faq-block">
                <h1 class="title-faq">Как выбрать подходящее платье?</h1>
                <p class="desc-faq">Выбор свадебного платья зависит от силуэта фигуры, стиля свадьбы и личных предпочтений. Рекомендуем записаться на примерку нескольких вариантов, прийти с поддержкой близких людей и учитывать время года и место проведения церемонии.</p>
            </div>
            <script>document.querySelectorAll('.faq-block').forEach(block => {
                    const title = block.querySelector('.title-faq');

                    title.addEventListener('click', () => {
                        document.querySelectorAll('.faq-block').forEach(b => {
                            if (b !== block) b.classList.remove('active');
                        });
                        block.classList.toggle('active');
                    });
                });
            </script>
        </div>
    </section>
    <!-- HTML -->
    <section class="contacts-block" id="contacts">
        <div class="contacts-inner">
            <div class="contacts-left">
                <h2 class="contacts-heading">
                    <span class="font-letter mobile">Х</span><span class="desktop-only">Х</span>очешь с нами,<br> но остались<br> вопросы?
                </h2>
            </div>

            <form class="contacts-form" action="/contact" method="POST" novalidate>
                @csrf
                <div class="form-col form-col--main">
                    <label class="field">
                        <span class="field-label">Имя</span>
                        <input class="field-input" type="text" name="firstName" placeholder="Введите ваше имя" value="{{ old('firstName') }}" required />
                    </label>
                    <label class="field mobile">
                        <span class="field-label">Фамилия</span>
                        <input class="field-input" type="text" name="lastName" placeholder="Введите вашу фамилию" value="{{ old('lastName') }}" required />
                    </label>

                    <label class="field mobile">
                        <span class="field-label">Номер телефона</span>
                        <input class="field-input" type="tel" name="phone" placeholder="Введите ваш номер телефона" value="{{ old('phone') }}" />
                    </label>
                    <label class="field">
                        <span class="field-label">Электронная почта</span>
                        <input class="field-input" type="email" name="email" placeholder="Введите ваш e-mail" value="{{ old('email') }}" required />
                    </label>

                    <label class="field">
                        <span class="field-label">Дата свадьбы (необязательно)</span>
                        <input class="field-input" type="date" name="weddingDate" placeholder="Выберете дату свадьбы (необязательно" value="{{ old('weddingDate') }}" />
                    </label>


                </div>

                <div class="form-col form-col--side">
                    <label class="field only-desktop">
                        <span class="field-label">Фамилия</span>
                        <input class="field-input" type="text" name="lastName" placeholder="Введите вашу фамилию" value="{{ old('lastName') }}" required />
                    </label>

                    <label class="field only-desktop">
                        <span class="field-label">Номер телефона</span>
                        <input class="field-input" type="tel" name="phone" placeholder="Введите ваш номер телефона" value="{{ old('phone') }}" />
                    </label>
                </div>
                <div class="col-last">
                    <label class="field message">
                        <span class="field-label">Ваше сообщение / комментарий</span>
                        <input class="field-input" type="text" name="message"
                               placeholder="Напишите ваш вопрос или пожелание" value="{{ old('message') }}" required />

                    </label>
                    <div class="submit-wrap">
                        <button class="btn-submit" type="submit">Отправить</button>
                    </div>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </section>

    <script>
        // Example: focus first invalid field on submit
        (function () {
            const form = document.querySelector('.contacts-form');
            if (!form) return;
            
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                // Get form data
                const formData = new FormData(form);
                
                // Submit form via AJAX
                fetch('/contact', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Show success message
                        alert('Ваше сообщение успешно отправлено!');
                        form.reset();
                    } else {
                        // Show validation errors
                        let errorMessages = '';
                        for (const key in data.errors) {
                            if (data.errors.hasOwnProperty(key)) {
                                if (Array.isArray(data.errors[key])) {
                                    errorMessages += data.errors[key].join('\n') + '\n';
                                } else {
                                    errorMessages += data.errors[key] + '\n';
                                }
                            }
                        }
                        alert('Произошли ошибки:\n' + errorMessages);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Произошла ошибка при отправке сообщения. Пожалуйста, попробуйте еще раз.');
                });
            });
        })();
    </script>
@endsection
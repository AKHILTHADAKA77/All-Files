<!DOCTYPE html>
<head>
<?php include('header_links.php');?>
   <style>
        :root {
            --hero-radius: 22px;
            --card-w: min(1040px, 88vw);
            --card-h: min(588px, 58vw);
            --side-scale: .86;
            /* Updated side-shift calculation - more responsive */
            --side-shift: clamp(180px, 20vw, 280px);
        }
        html,
        body {
            height: 100%;
        }
        body {
            background: #0b1120;
            color: #e9eefc;
            font-synthesis-weight: none;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
            position: relative;
        }
        /* soft radial glow behind hero */
        body::before {
            content: "";
            position: fixed;
            inset: -20% -10% auto -10%;
            height: 80vh;
            background: radial-gradient(60% 60% at 50% 30%, rgba(28, 74, 255, .35), transparent 60%), radial-gradient(40% 40% at 70% 20%, rgba(0, 228, 255, .25), transparent 70%);
            filter: blur(40px);
            z-index: -1;
            opacity: .8;
        }
        /* Header */
        .new-pill {
            font-weight: 600;
            padding: .25rem .6rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, .1);
            color: #cfe1ff;
            border: 1px solid rgba(255, 255, 255, .18);
            backdrop-filter: blur(4px);
        }
        .hero-title {
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -.02em;
            text-align: center;
        }
        /* Showcase stage */
        .stage {
            position: relative;
            height: calc(var(--card-h) + 24px);
            margin: 18px auto 8px;
            width: 100%;
            /* Updated max-width calculation */
            max-width: calc(var(--card-w) + var(--side-shift) * 1.8);
            overflow: visible;
        }
        
        /* Slides */
        .slide {
            position: absolute;
            top: 0;
            left: 50%;
            width: var(--card-w);
            height: var(--card-h);
            transform: translateX(-50%);
            border-radius: var(--hero-radius);
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .45), inset 0 0 0 1px rgba(255, 255, 255, .06);
            transition: transform .7s cubic-bezier(.2, .8, .2, 1), filter .7s, opacity .5s, box-shadow .7s, width .7s, height .7s;
            background: #0f172a;
        }
        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        /* Positions (center / sides) */
        .slide.center {
            z-index: 3;
            transform: translateX(-50%) scale(1);
            filter: none;
            opacity: 1;
        }
        .slide.left {
            z-index: 2;
            transform: translateX(calc(-50% - var(--side-shift))) scale(var(--side-scale));
            filter: blur(2px) saturate(.7) brightness(.75);
            opacity: .8;
        }
        .slide.right {
            z-index: 2;
            transform: translateX(calc(-50% + var(--side-shift))) scale(var(--side-scale));
            filter: blur(2px) saturate(.7) brightness(.75);
            opacity: .8;
        }
        .slide.hidden {
            opacity: 0;
            pointer-events: none;
            transform: translateX(-50%) scale(.8);
        }
        /* Overlay controls */
        .overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            pointer-events: none;
            padding: 14px;
            background: linear-gradient(to bottom, rgba(0, 0, 0, .35), transparent 28%, transparent 70%, rgba(0, 0, 0, .35));
        }
        .badge-top {
            pointer-events: auto;
        }
        /* New arrow styles */
        .arrow {
            pointer-events: auto;
            position: absolute;
            top: 50%;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .35);
            background: rgba(255, 255, 255, .08);
            display: grid;
            place-items: center;
            backdrop-filter: blur(6px);
            transition: background .2s, transform .2s, border-color .2s;
            transform: translateY(-50%);
            z-index: 10;
        }
        .arrow:hover {
            background: rgba(255, 255, 255, .15);
            transform: translateY(-50%) scale(1.06);
            border-color: rgba(255, 255, 255, .6);
        }
        .arrow i {
            font-size: 24px;
            color: #e9eefc;
        }
        .arrow.prev {
            left: 20px;
        }
        .arrow.next {
            right: 20px;
        }
        /* Caption & dots */
        .caption-small {
            font-size: .9rem;
            color: #b8c7ff;
            opacity: .9;
            text-align: center;
            margin-top: 10px;
        }
        .dots {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
            margin-top: 12px;
        }
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #6474a6;
            opacity: .6;
            transition: transform .2s, opacity .2s;
        }
        .dot.active {
            opacity: 1;
            transform: scale(1.4);
            background: #dbe6ff;
        }
        .main{
            overflow-x: hidden;
            width: 100vw !important;
        }
        /* Responsive tweaks */
        @media (max-width: 1200px) {
            :root {
                --side-shift: clamp(140px, 18vw, 220px);
                --side-scale: 0.82;
            }
            .hero-title {
                font-size: clamp(1.8rem, 4.2vw, 3.2rem);
            }
            .arrow.prev,
            .arrow.next {
                width: 50px;
                height: 50px;
            }
            .arrow.prev i,
            .arrow.next i {
                font-size: 20px;
            }
        }
        @media (max-width: 992px) {
            :root {
                --side-shift: clamp(100px, 15vw, 180px);
                --side-scale: 0.78;
            }
            .stage {
                max-width: calc(var(--card-w) + var(--side-shift) * 1.6);
            }
        }
        @media (max-width: 768px) {
            :root {
                --card-w: 90vw;
                --card-h: 52vw;
                --side-shift: clamp(80px, 12vw, 140px);
                --side-scale: 0.75;
            }
            .stage {
                max-width: calc(var(--card-w) + var(--side-shift) * 1.4);
            }
            .arrow.prev {
                left: 10px;
            }
            .arrow.next {
                right: 10px;
            }
        }
        @media (max-width: 576px) {
            :root {
                --card-w: 94vw;
                --card-h: 54vw;
                --side-shift: clamp(60px, 10vw, 100px);
                --side-scale: 0.72;
            }
            .stage {
                max-width: calc(var(--card-w) + var(--side-shift) * 1.2);
            }
            .arrow.prev,
            .arrow.next {
                width: 40px;
                height: 40px;
            }
            .arrow.prev i,
            .arrow.next i {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <header class="py-4">
        <div class="container text-center">
            <!-- <span class="new-pill">New</span> -->
            <h1 class="hero-title mt-3">Trusted innovation. We deliver products <br>  that build stronger, smarter businesses.</h1>
        </div>
    </header>
    <main class="container banner_container">
        <section class="stage" id="stage" aria-label="Image showcase carousel">
            <div class="slide center" data-index="0" aria-hidden="false">
                <img src="assets/images/banner1.jpg"
                    alt="Cinematic landscape photography">
                <!-- <div class="overlay">
                    <span class="badge-top new-pill">Prompt</span>
                </div> -->
                <button class="arrow prev" aria-label="Previous"><i class="bi bi-chevron-left"></i></button>
                <button class="arrow next" aria-label="Next"><i class="bi bi-chevron-right"></i></button>
            </div>
            <div class="slide right" data-index="1" aria-hidden="true">
                <img src="assets/images/banner2.jpg"
                    alt="Cinematic landscape photography">
                <div class="overlay"></div>
                <button class="arrow prev" aria-label="Previous"><i class="bi bi-chevron-left"></i></button>
                <button class="arrow next" aria-label="Next"><i class="bi bi-chevron-right"></i></button>
            </div>
            <div class="slide left" data-index="2" aria-hidden="true">
                <img src="assets/images/banner3.jpg"
                    alt="Cinematic landscape photography">
                <div class="overlay"></div>
                <button class="arrow prev" aria-label="Previous"><i class="bi bi-chevron-left"></i></button>
                <button class="arrow next" aria-label="Next"><i class="bi bi-chevron-right"></i></button>
            </div>
            <div class="slide hidden" data-index="3" aria-hidden="true">
                <img src="assets/images/banner4.jpg"
                    alt="Cinematic landscape photography">
                <div class="overlay"></div>
                <button class="arrow prev" aria-label="Previous"><i class="bi bi-chevron-left"></i></button>
                <button class="arrow next" aria-label="Next"><i class="bi bi-chevron-right"></i></button>
            </div>
            <div class="slide hidden" data-index="4" aria-hidden="true">
                <img src="assets/images/banner5.jpg"
                    alt="Cinematic landscape photography">
                <div class="overlay"></div>
                <button class="arrow prev" aria-label="Previous"><i class="bi bi-chevron-left"></i></button>
                <button class="arrow next" aria-label="Next"><i class="bi bi-chevron-right"></i></button>
            </div>
        </section>
      
        <div class="dots" id="dots" aria-hidden="false" aria-label="Slide indicators">
            <span class="dot active" data-go="0"></span>
            <span class="dot" data-go="1"></span>
            <span class="dot" data-go="2"></span>
            <span class="dot" data-go="3"></span>
            <span class="dot" data-go="4"></span>
        </div>

        <section class="toolsection">
       <div class="container-fluid">
        <div class="row">
        
        </div>
       </div>
   
   
    </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // --- Minimal custom slider logic (center + side previews) ---
        (function () {
            const stage = document.getElementById('stage');
            const slides = Array.from(stage.querySelectorAll('.slide'));
            const dotsWrap = document.getElementById('dots');
            const dots = Array.from(dotsWrap.querySelectorAll('.dot'));
            let current = 0;
            let autoTimer = null;
            
            // Update dots to match the number of slides
            if (dots.length !== slides.length) {
                dotsWrap.innerHTML = '';
                for (let i = 0; i < slides.length; i++) {
                    const dot = document.createElement('span');
                    dot.className = 'dot';
                    if (i === 0) dot.classList.add('active');
                    dot.setAttribute('data-go', i);
                    dotsWrap.appendChild(dot);
                }
                dots.length = 0;
                dots.push(...dotsWrap.querySelectorAll('.dot'));
            }
            
            const applyClasses = () => {
                slides.forEach((s, i) => {
                    s.classList.remove('left', 'right', 'center', 'hidden');
                    s.setAttribute('aria-hidden', 'true');
                });
                
                const left = (current - 1 + slides.length) % slides.length;
                const right = (current + 1) % slides.length;
                
                slides[current].classList.add('center');
                slides[current].setAttribute('aria-hidden', 'false');
                
                // Only show side previews if we have more than 2 slides
                if (slides.length > 2) {
                    slides[left].classList.add('left');
                    slides[right].classList.add('right');
                    
                    // Hide non-neighbors for performance
                    slides.forEach((s, i) => {
                        if (i !== current && i !== left && i !== right) s.classList.add('hidden');
                    });
                } else {
                    // For 2 or fewer slides, just hide non-current
                    slides.forEach((s, i) => {
                        if (i !== current) s.classList.add('hidden');
                    });
                }
                
                dots.forEach((d, i) => {
                    d.classList.toggle('active', i === current);
                });
            };
            
            const goTo = (idx) => {
                current = (idx + slides.length) % slides.length;
                applyClasses();
            };
            
            const next = () => goTo(current + 1);
            const prev = () => goTo(current - 1);
            
            // Hook arrows (event delegation)
            stage.addEventListener('click', (e) => {
                const prevBtn = e.target.closest('.arrow.prev');
                const nextBtn = e.target.closest('.arrow.next');
                if (prevBtn) {
                    prev();
                }
                if (nextBtn) {
                    next();
                }
            });
            
            // Dots
            dots.forEach(d => d.addEventListener('click', () => goTo(parseInt(d.dataset.go, 10))));
            
            // Auto-advance with hover pause
            const startAuto = () => {
                stopAuto();
                autoTimer = setInterval(next, 5500); // Changed from 55000 to 5500 (5.5 seconds)
            };
            
            const stopAuto = () => {
                if (autoTimer) {
                    clearInterval(autoTimer);
                    autoTimer = null;
                }
            };
            
            stage.addEventListener('mouseenter', stopAuto);
            stage.addEventListener('mouseleave', startAuto);
            
            // Keyboard support
            window.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowRight') next();
                if (e.key === 'ArrowLeft') prev();
            });
            
            // Handle window resize
            window.addEventListener('resize', () => {
                applyClasses();
            });
            
            // First layout
            applyClasses();
            startAuto();
        })();
    </script>

    
       <?php include('footer.php'); ?>
</body>
</html>
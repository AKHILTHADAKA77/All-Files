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
            
            /* Responsive font sizes */
            --logo-size: clamp(40px, 5vw, 60px);
            --nav-font-size: clamp(14px, 1.8vw, 18px);
            --hero-title-size: clamp(28px, 4vw, 48px);
            --section-title-size: clamp(24px, 3.5vw, 36px);
            --section-text-size: clamp(14px, 1.8vw, 18px);
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
        
        /* Side light effects */
        body::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                rgba(79, 159, 255, 0.05) 0%, 
                transparent 10%, 
                transparent 90%, 
                rgba(0, 212, 255, 0.05) 100%);
            z-index: -1;
            pointer-events: none;
        }
        
        /* Navbar Styles */
        .navbar {
            background-color: rgba(11, 17, 32, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand img {
            height: var(--logo-size);
            width: auto;
            transition: height 0.3s ease;
        }
        
        .navbar-nav .nav-link {
            font-size: var(--nav-font-size);
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: #4f9fff;
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
            font-size: clamp(12px, 1.5vw, 16px);
        }
        .hero-title {
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -.02em;
            text-align: center;
            font-size: var(--hero-title-size);
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
        
        /* New Section Styles */
        .section-padding {
            padding: clamp(40px, 8vw, 80px) 0;
            position: relative;
        }
        
        /* Section background patterns */
        .section-pattern-1 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle at 10% 20%, rgba(79, 159, 255, 0.05) 0%, transparent 50%),
                             radial-gradient(circle at 90% 80%, rgba(0, 212, 255, 0.05) 0%, transparent 50%);
            z-index: -1;
        }
        
        .section-pattern-2 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(45deg, rgba(79, 159, 255, 0.03) 25%, transparent 25%, transparent 50%, 
                rgba(79, 159, 255, 0.03) 50%, rgba(79, 159, 255, 0.03) 75%, transparent 75%, transparent);
            background-size: 20px 20px;
            z-index: -1;
        }
        
        .section-title {
            font-size: var(--section-title-size);
            font-weight: 700;
            margin-bottom: clamp(15px, 3vw, 30px);
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }
        
        .section-title::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #4f9fff, #00d4ff);
            border-radius: 3px;
        }
        
        .section-text {
            font-size: var(--section-text-size);
            line-height: 1.6;
            margin-bottom: 30px;
            text-align: center;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Services Section */
        .service-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 30px;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .service-card::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(79, 159, 255, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }
        
        .service-card:hover::before {
            opacity: 1;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .service-icon {
            font-size: clamp(30px, 4vw, 50px);
            color: #4f9fff;
            margin-bottom: 20px;
        }
        
        .service-title {
            font-size: clamp(18px, 2.5vw, 24px);
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .service-description {
            font-size: clamp(14px, 1.8vw, 16px);
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.8);
        }
        
        /* Projects Section */
        .project-card {
            width: 200px;
            height: 200px;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            margin: 0 auto;
        }
        
        .project-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }
        
        .project-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .project-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 15px;
            background: linear-gradient(to top, rgba(11, 17, 32, 0.9), transparent);
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }
        
        .project-card:hover .project-overlay {
            transform: translateY(0);
        }
        
        .project-name {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            color: #e9eefc;
        }
        
        .project-logo {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .project-logo img {
            width: 70%;
            height: 70%;
            object-fit: contain;
        }
        
        /* About Section */
        .about-image {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }
        
        .about-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .about-content {
            padding: 0 20px;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }
        
        .feature-list li {
            padding: 10px 0;
            font-size: clamp(14px, 1.8vw, 16px);
            position: relative;
            padding-left: 30px;
        }
        
        .feature-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #4f9fff;
            font-weight: bold;
        }
        
        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, rgba(79, 159, 255, 0.1), rgba(0, 212, 255, 0.1));
            border-radius: 16px;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
        }
        
        .stats-section::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(79, 159, 255, 0.05) 0%, transparent 70%);
            z-index: -1;
        }
        
        .stat-item {
            text-align: center;
            padding: 20px;
            position: relative;
        }
        
        .stat-number {
            font-size: clamp(30px, 5vw, 60px);
            font-weight: 700;
            color: #4f9fff;
            margin-bottom: 10px;
        }
        
        .stat-label {
            font-size: clamp(14px, 1.8vw, 18px);
            color: rgba(255, 255, 255, 0.8);
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, rgba(79, 159, 255, 0.2), rgba(0, 212, 255, 0.2));
            border-radius: 16px;
            padding: 60px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(79, 159, 255, 0.1) 0%, transparent 70%);
            z-index: -1;
        }
        
        .cta-title {
            font-size: clamp(24px, 3.5vw, 36px);
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .btn-custom {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(90deg, #4f9fff, #00d4ff);
            color: white;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: clamp(14px, 1.8vw, 18px);
        }
        
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(79, 159, 255, 0.3);
            color: white;
        }
        
        /* Footer Styles */
        footer {
            background: rgba(11, 17, 32, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 60px 0 20px;
            position: relative;
        }
        
        footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(79, 159, 255, 0.05), rgba(0, 212, 255, 0.05));
            z-index: -1;
        }
        
        .footer-logo {
            margin-bottom: 20px;
        }
        
        .footer-logo img {
            height: 50px;
            width: auto;
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .footer-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-title::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, #4f9fff, #00d4ff);
            border-radius: 2px;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 14px;
        }
        
        .footer-links a:hover {
            color: #4f9fff;
        }
        
        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: rgba(79, 159, 255, 0.2);
            transform: translateY(-3px);
        }
        
        .social-icon i {
            color: #e9eefc;
            font-size: 18px;
        }
        
        .copyright {
            text-align: center;
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
        }
        
        /* Responsive tweaks */
        @media (max-width: 1200px) {
            :root {
                --side-shift: clamp(140px, 18vw, 220px);
                --side-scale: 0.82;
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
    </main>
    
    <!-- Services Section -->
    <section class="section-padding">
        <div class="section-pattern-1"></div>
        <div class="container">
            <h2 class="section-title">Our Services</h2>
            <p class="section-text">We offer a comprehensive range of IT solutions tailored to meet your business needs.</p>
            
            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-icon">
                            <i class="bi bi-code-slash"></i>
                        </div>
                        <h3 class="service-title">Web Development</h3>
                        <p class="service-description">Custom web applications built with modern technologies to deliver exceptional user experiences.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-icon">
                            <i class="bi bi-phone"></i>
                        </div>
                        <h3 class="service-title">Mobile Apps</h3>
                        <p class="service-description">Native and cross-platform mobile applications that engage users and drive business growth.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>
                        <h3 class="service-title">Cloud Solutions</h3>
                        <p class="service-description">Scalable cloud infrastructure and services to optimize your business operations.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h3 class="service-title">Digital Marketing</h3>
                        <p class="service-description">Strategic digital marketing solutions to increase your online presence and reach.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="service-title">Cybersecurity</h3>
                        <p class="service-description">Comprehensive security solutions to protect your business from digital threats.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="service-card h-100">
                        <div class="service-icon">
                            <i class="bi bi-gear"></i>
                        </div>
                        <h3 class="service-title">IT Consulting</h3>
                        <p class="service-description">Expert IT consulting to help you make informed technology decisions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Projects Section -->
    <section class="section-padding">
        <div class="section-pattern-2"></div>
        <div class="container">
            <h2 class="section-title">Our Projects</h2>
            <p class="section-text">Explore our portfolio of successful projects that showcase our expertise and innovation.</p>
            
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="project-card">
                        <img src="assets/images/project1.jpg" alt="Project 1">
                        <div class="project-logo">
                            <img src="assets/images/logo1.png" alt="Logo">
                        </div>
                        <div class="project-overlay">
                            <h4 class="project-name">E-commerce Platform</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="project-card">
                        <img src="assets/images/project2.jpg" alt="Project 2">
                        <div class="project-logo">
                            <img src="assets/images/logo2.png" alt="Logo">
                        </div>
                        <div class="project-overlay">
                            <h4 class="project-name">Mobile Banking App</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="project-card">
                        <img src="assets/images/project3.jpg" alt="Project 3">
                        <div class="project-logo">
                            <img src="assets/images/logo3.png" alt="Logo">
                        </div>
                        <div class="project-overlay">
                            <h4 class="project-name">Healthcare Portal</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="project-card">
                        <img src="assets/images/project4.jpg" alt="Project 4">
                        <div class="project-logo">
                            <img src="assets/images/logo4.png" alt="Logo">
                        </div>
                        <div class="project-overlay">
                            <h4 class="project-name">Education Platform</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="project-card">
                        <img src="assets/images/project5.jpg" alt="Project 5">
                        <div class="project-logo">
                            <img src="assets/images/logo5.png" alt="Logo">
                        </div>
                        <div class="project-overlay">
                            <h4 class="project-name">Real Estate App</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="project-card">
                        <img src="assets/images/project6.jpg" alt="Project 6">
                        <div class="project-logo">
                            <img src="assets/images/logo6.png" alt="Logo">
                        </div>
                        <div class="project-overlay">
                            <h4 class="project-name">Travel Booking System</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="project-card">
                        <img src="assets/images/project7.jpg" alt="Project 7">
                        <div class="project-logo">
                            <img src="assets/images/logo7.png" alt="Logo">
                        </div>
                        <div class="project-overlay">
                            <h4 class="project-name">IoT Dashboard</h4>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="project-card">
                        <img src="assets/images/project8.jpg" alt="Project 8">
                        <div class="project-logo">
                            <img src="assets/images/logo8.png" alt="Logo">
                        </div>
                        <div class="project-overlay">
                            <h4 class="project-name">Social Media Platform</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section class="section-padding">
        <div class="section-pattern-1"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                    <div class="about-image">
                        <img src="assets/images/aboutimg.jpg" alt="About our company">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="about-content">
                        <h2 class="section-title text-start">About Our Company</h2>
                        <p class="section-text text-start">We are a team of passionate professionals dedicated to delivering innovative technology solutions that drive business success.</p>
                        
                        <ul class="feature-list">
                            <li>Over 10 years of industry experience</li>
                            <li>Team of certified professionals</li>
                            <li>Client-centric approach</li>
                            <li>Cutting-edge technology solutions</li>
                            <li>24/7 support and maintenance</li>
                        </ul>
                        
                        <a href="#" class="btn-custom">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="section-padding">
        <div class="container">
            <div class="stats-section">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <div class="stat-item">
                            <div class="stat-number" data-count="250">0</div>
                            <div class="stat-label">Projects Completed</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-item">
                            <div class="stat-number" data-count="180">0</div>
                            <div class="stat-label">Happy Clients</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-item">
                            <div class="stat-number" data-count="50">0</div>
                            <div class="stat-label">Team Members</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-item">
                            <div class="stat-number" data-count="15">0</div>
                            <div class="stat-label">Years Experience</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="section-padding">
        <div class="section-pattern-2"></div>
        <div class="container">
            <h2 class="section-title">Client Testimonials</h2>
            <p class="section-text">What our clients say about our services</p>
            
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="service-card h-100">
                        <div class="d-flex mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="service-description">"The team delivered exceptional results that exceeded our expectations. Their professionalism and expertise are unmatched."</p>
                        <div class="d-flex align-items-center mt-3">
                            <div class="flex-shrink-0">
                                <img src="assets/images/client1.jpg" class="rounded-circle" width="50" height="50" alt="Client">
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-0">John Smith</h5>
                                <p class="mb-0 text-muted">CEO, TechCorp</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="service-card h-100">
                        <div class="d-flex mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="service-description">"Working with this team has been a game-changer for our business. Their innovative solutions helped us streamline our operations."</p>
                        <div class="d-flex align-items-center mt-3">
                            <div class="flex-shrink-0">
                                <img src="assets/images/client2.jpg" class="rounded-circle" width="50" height="50" alt="Client">
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-0">Sarah Johnson</h5>
                                <p class="mb-0 text-muted">Marketing Director, InnovateCo</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="service-card h-100">
                        <div class="d-flex mb-3">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <p class="service-description">"The attention to detail and commitment to quality is impressive. I highly recommend their services to any business looking to grow."</p>
                        <div class="d-flex align-items-center mt-3">
                            <div class="flex-shrink-0">
                                <img src="assets/images/client3.jpg" class="rounded-circle" width="50" height="50" alt="Client">
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-0">Michael Brown</h5>
                                <p class="mb-0 text-muted">CTO, StartupHub</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="section-padding">
        <div class="container">
            <div class="cta-section">
                <h2 class="cta-title">Ready to Transform Your Business?</h2>
                <p class="section-text">Get in touch with our team today to discuss your project requirements.</p>
                <a href="#" class="btn-custom mt-3">Contact Us</a>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="footer-logo">
                        <img src="assets/images/logo.png" alt="Company Logo">
                    </div>
                    <p class="footer-text">We are a team of passionate professionals dedicated to delivering innovative technology solutions that drive business success.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-3 col-lg-2 mb-4 mb-md-0">
                    <h3 class="footer-title">Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Projects</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-3 col-lg-2 mb-4 mb-md-0">
                    <h3 class="footer-title">Services</h3>
                    <ul class="footer-links">
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Mobile Apps</a></li>
                        <li><a href="#">Cloud Solutions</a></li>
                        <li><a href="#">Digital Marketing</a></li>
                        <li><a href="#">IT Consulting</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <h3 class="footer-title">Contact Us</h3>
                    <ul class="footer-links">
                        <li><i class="bi bi-geo-alt me-2"></i> 123 Tech Street, Silicon Valley, CA 94000</li>
                        <li><i class="bi bi-telephone me-2"></i> +1 (123) 456-7890</li>
                        <li><i class="bi bi-envelope me-2"></i> info@company.com</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2023 Company Name. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

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
        
        // Stats Counter Animation
        (function () {
            const statNumbers = document.querySelectorAll('.stat-number');
            
            const animateValue = (element, start, end, duration) => {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    element.textContent = Math.floor(progress * (end - start) + start);
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            };
            
            // Create an Intersection Observer to trigger the animation when stats are visible
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = parseInt(entry.target.getAttribute('data-count'));
                        animateValue(entry.target, 0, target, 2000);
                        observer.unobserve(entry.target);
                    }
                });
            });
            
            statNumbers.forEach(stat => {
                observer.observe(stat);
            });
        })();
    </script>

    
       <?php include('footer.php'); ?>
</body>
</html>
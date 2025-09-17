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
            background-color: transparent;
            backdrop-filter: none;
            transition: all 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            width: 100%;
        }
        
        .navbar.scrolled {
            background-color: rgba(11, 17, 32, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
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
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .service-card:hover .service-icon {
            transform: translateY(-10px) rotate(10deg);
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
        
        /* Partners Section */
        .partners-container {
            overflow: hidden;
            position: relative;
            margin-top: 30px;
        }
        
        .partners-track {
            display: flex;
            animation: scrollPartners 30s linear infinite;

        }
        
        .partner-logo {
            flex: 0 0 auto;
            width: 150px;
            height: 80px;
            margin: 0 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 25px;
            /* padding: 10px; */
            transition: all 0.3s ease;
        }
        
        .partner-logo:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-5px);
        }
        
        .partner-logo img {
            max-width: 100%;
            max-height: 100%;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: all 0.3s ease;
               border-radius: 25px;
        }
        
        .partner-logo:hover img {
            filter: grayscale(0%);
            opacity: 1;
        }
        
        @keyframes scrollPartners {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
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
            position: relative;
            z-index: 2;
        }
        
        .stat-number-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: clamp(80px, 10vw, 120px);
            font-weight: 800;
            color: rgba(79, 159, 255, 0.1);
            z-index: 1;
            opacity: 0.5;
        }
        
        .stat-label {
            font-size: clamp(14px, 1.8vw, 18px);
            color: rgba(255, 255, 255, 0.8);
        }
        
        /* Testimonials Section */
        .testimonials-container {
            position: relative;
            overflow: hidden;
            padding: 20px 0;
        }
        
        .testimonials-track {
            display: flex;
            transition: transform 0.5s ease;
        }
        
        .testimonial-card {
            min-width: 100%;
            padding: 0 15px;
        }
        
        @media (min-width: 768px) {
            .testimonial-card {
                min-width: 50%;
            }
        }
        
        @media (min-width: 992px) {
            .testimonial-card {
                min-width: 33.333%;
            }
        }
        
        .testimonial-content {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 30px;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .testimonial-content::before {
            content: """;
            position: absolute;
            top: 10px;
            left: 15px;
            font-size: 80px;
            color: rgba(79, 159, 255, 0.2);
            font-family: serif;
            line-height: 1;
        }
        
        .testimonial-content:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        
        .testimonial-rating {
            display: flex;
            margin-bottom: 15px;
        }
        
        .testimonial-rating i {
            color: #ffc107;
            font-size: 16px;
        }
        
        .testimonial-text {
            font-size: clamp(14px, 1.8vw, 16px);
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .author-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
        }
        
        .author-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .author-info h5 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            color: #e9eefc;
        }
        
        .author-info p {
            font-size: 14px;
            margin: 0;
            color: rgba(255, 255, 255, 0.6);
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
            text-align: center;
        }
        
        .footer-logo img {
            height: 60px;
            width: auto;
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.6;
            text-align: center;
        }
        
        .footer-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
            text-align: center;
        }
        
        .footer-title::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, #4f9fff, #00d4ff);
            border-radius: 2px;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: center;
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
            justify-content: center;
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
        
        /* Map in footer */
        .map-container {
            height: 250px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }
        
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
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
    
    <!-- Separate CSS for Projects Section -->
    <style>
        /* ===========================================
           PROJECTS GRID SECTION STYLES
           =========================================== */
        
        /* Main container for the projects section */
        .projects-section {
            position: relative;
            padding: 80px 0;
            overflow: hidden;
        }
        
        /* Background pattern for visual appeal */
        .projects-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle at 10% 20%, rgba(79, 159, 255, 0.05) 0%, transparent 50%),
                             radial-gradient(circle at 90% 80%, rgba(0, 212, 255, 0.05) 0%, transparent 50%);
            z-index: -1;
        }
        
        /* Section title styling */
        .projects-title {
            font-size: clamp(28px, 4vw, 48px);
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }
        
        /* Underline for section title */
        .projects-title::after {
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
        
        /* Section description text */
        .projects-description {
            font-size: clamp(14px, 1.8vw, 18px);
            line-height: 1.6;
            margin-bottom: 40px;
            text-align: center;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            color: rgba(255, 255, 255, 0.8);
        }
        
        /* Filter buttons container */
        .projects-filter {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 40px;
        }
        
        /* Individual filter button styling */
        .filter-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        /* Hover effect for filter buttons */
        .filter-btn:hover {
            background: rgba(79, 159, 255, 0.2);
            border-color: rgba(79, 159, 255, 0.4);
        }
        
        /* Active state for filter buttons */
        .filter-btn.active {
            background: rgba(79, 159, 255, 0.3);
            border-color: #4f9fff;
            color: #ffffff;
        }
        
        /* Projects grid container */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }
        
        /* Responsive grid adjustments */
        @media (min-width: 576px) {
            .projects-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (min-width: 992px) {
            .projects-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (min-width: 1200px) {
            .projects-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        
        /* Individual project card styling */
        .project-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        /* Hover effect for project cards */
        .project-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(79, 159, 255, 0.3);
        }
        
        /* Project image container */
        .project-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }
        
        /* Project image styling */
        .project-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        /* Zoom effect on image during hover */
        .project-card:hover .project-image img {
            transform: scale(1.1);
        }
        
        /* Project content container */
        .project-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        /* Project name styling */
        .project-name {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 10px 0;
            color: #ffffff;
        }
        
        /* Project description styling */
        .project-description-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            margin: 0 0 15px 0;
            line-height: 1.4;
            flex-grow: 1;
        }
        
        /* Technology tags container */
        .project-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }
        
        /* Individual technology tag styling */
        .project-tag {
            background: rgba(79, 159, 255, 0.2);
            color: #a5c8ff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        /* Hover effect for technology tags */
        .project-tag:hover {
            background: rgba(79, 159, 255, 0.3);
            color: #ffffff;
        }
        
        /* View project button styling */
        .project-link {
            display: inline-flex;
            align-items: center;
            color: #4f9fff;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
            margin-top: auto;
        }
        
        /* Hover effect for project link */
        .project-link:hover {
            color: #00d4ff;
            transform: translateX(5px);
        }
        
        /* Arrow icon for project link */
        .project-link i {
            margin-left: 5px;
            transition: transform 0.2s ease;
        }
        
        /* Move arrow on link hover */
        .project-link:hover i {
            transform: translateX(3px);
        }
        
        /* View more button container */
        .projects-view-more {
            text-align: center;
            margin-top: 20px;
        }
        
        /* View more button styling */
        .view-more-btn {
            display: inline-flex;
            align-items: center;
            padding: 12px 30px;
            background: linear-gradient(90deg, #4f9fff, #00d4ff);
            color: white;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        
        /* Hover effect for view more button */
        .view-more-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(79, 159, 255, 0.3);
            color: white;
        }
        
        /* Arrow icon for view more button */
        .view-more-btn i {
            margin-left: 8px;
            transition: transform 0.2s ease;
        }
        
        /* Move arrow on button hover */
        .view-more-btn:hover i {
            transform: translateX(3px);
        }
        
        /* Project count text */
        .projects-count {
            text-align: center;
            margin-bottom: 30px;
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* Highlight for the number */
        .projects-count strong {
            color: #4f9fff;
            font-weight: 600;
        }
    </style>
    
    <!-- Enhanced Offcanvas CSS -->
    <style>
        /* ===========================================
           OFFCANVAS STYLES
           =========================================== */
        
        /* Offcanvas container styling */
        .offcanvas {
            background-color: rgba(11, 17, 32, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-left: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Offcanvas header styling */
        .offcanvas-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px;
        }
        
        /* Offcanvas title styling */
        .offcanvas-title {
            color: #ffffff;
            font-weight: 600;
            font-size: 1.5rem;
        }
        
        /* Offcanvas close button styling */
        .btn-close {
            filter: invert(1);
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        
        .btn-close:hover {
            opacity: 1;
        }
        
        /* Offcanvas body styling */
        .offcanvas-body {
            padding: 0;
        }
        
        /* Navigation links in offcanvas */
        .offcanvas-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        /* Individual navigation item */
        .offcanvas-nav-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        /* Navigation link styling */
        .offcanvas-nav-link {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        /* Hover effect for navigation links */
        .offcanvas-nav-link:hover {
            color: #4f9fff;
            background: rgba(79, 159, 255, 0.1);
            padding-left: 25px;
        }
        
        /* Icon styling for navigation links */
        .offcanvas-nav-link i {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }
        
        /* Dropdown menu styling */
        .offcanvas-dropdown {
            list-style: none;
            padding: 0;
            margin: 0;
            background: rgba(0, 0, 0, 0.2);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        /* Show dropdown when parent is active */
        .offcanvas-nav-item.active .offcanvas-dropdown {
            max-height: 300px;
        }
        
        /* Dropdown item styling */
        .offcanvas-dropdown-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .offcanvas-dropdown-item:last-child {
            border-bottom: none;
        }
        
        /* Dropdown link styling */
        .offcanvas-dropdown-link {
            display: block;
            padding: 12px 20px 12px 56px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        /* Hover effect for dropdown links */
        .offcanvas-dropdown-link:hover {
            color: #4f9fff;
            background: rgba(79, 159, 255, 0.1);
        }
        
        /* Dropdown toggle icon */
        .dropdown-toggle-icon {
            margin-left: auto;
            transition: transform 0.3s ease;
        }
        
        /* Rotate icon when dropdown is open */
        .offcanvas-nav-item.active .dropdown-toggle-icon {
            transform: rotate(180deg);
        }
        
        /* Social media links in offcanvas */
        .offcanvas-social {
            display: flex;
            gap: 15px;
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Social media icon styling */
        .offcanvas-social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        /* Hover effect for social media icons */
        .offcanvas-social-icon:hover {
            background: rgba(79, 159, 255, 0.2);
            transform: translateY(-3px);
        }
        
        .offcanvas-social-icon i {
            color: #e9eefc;
            font-size: 18px;
        }
        
        /* Contact info in offcanvas */
        .offcanvas-contact {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .offcanvas-contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }
        
        .offcanvas-contact-item:last-child {
            margin-bottom: 0;
        }
        
        .offcanvas-contact-item i {
            margin-right: 12px;
            color: #4f9fff;
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
    
    <!-- New Projects Grid Section -->
    <section class="projects-section">
        <div class="container">
            <h2 class="projects-title">Our Projects</h2>
            <p class="projects-description">Explore our portfolio of successful projects that showcase our expertise and innovation.</p>
            
            <!-- Project count display -->
            <div class="projects-count">
                Showing <strong>8</strong> of <strong>24</strong> projects
            </div>
            
            <!-- Filter buttons -->
            <div class="projects-filter">
                <button class="filter-btn active" data-filter="all">All Projects</button>
                <button class="filter-btn" data-filter="web">Web Development</button>
                <button class="filter-btn" data-filter="mobile">Mobile Apps</button>
                <button class="filter-btn" data-filter="cloud">Cloud Solutions</button>
                <button class="filter-btn" data-filter="ai">AI & ML</button>
            </div>
            
            <!-- Projects grid -->
            <div class="projects-grid" id="projectsGrid">
                <!-- Project 1 -->
                <div class="project-card" data-category="web">
                    <div class="project-image">
                        <img src="https://picsum.photos/seed/ecommerce/400/200.jpg" alt="E-commerce Platform">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">E-commerce Platform</h3>
                        <p class="project-description-text">Modern online shopping experience with advanced features and seamless checkout process.</p>
                        <div class="project-tags">
                            <span class="project-tag">React</span>
                            <span class="project-tag">Node.js</span>
                            <span class="project-tag">MongoDB</span>
                        </div>
                        <a href="#" class="project-link">View Project <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- Project 2 -->
                <div class="project-card" data-category="mobile">
                    <div class="project-image">
                        <img src="https://picsum.photos/seed/banking/400/200.jpg" alt="Mobile Banking App">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">Mobile Banking App</h3>
                        <p class="project-description-text">Secure financial transactions with biometric authentication and real-time notifications.</p>
                        <div class="project-tags">
                            <span class="project-tag">React Native</span>
                            <span class="project-tag">Firebase</span>
                            <span class="project-tag">Security</span>
                        </div>
                        <a href="#" class="project-link">View Project <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- Project 3 -->
                <div class="project-card" data-category="web">
                    <div class="project-image">
                        <img src="https://picsum.photos/seed/healthcare/400/200.jpg" alt="Healthcare Portal">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">Healthcare Portal</h3>
                        <p class="project-description-text">Comprehensive patient management system for hospitals with appointment scheduling.</p>
                        <div class="project-tags">
                            <span class="project-tag">Vue.js</span>
                            <span class="project-tag">Laravel</span>
                            <span class="project-tag">MySQL</span>
                        </div>
                        <a href="#" class="project-link">View Project <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- Project 4 -->
                <div class="project-card" data-category="ai">
                    <div class="project-image">
                        <img src="https://picsum.photos/seed/analytics/400/200.jpg" alt="AI Analytics Dashboard">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">AI Analytics Dashboard</h3>
                        <p class="project-description-text">Real-time data visualization with predictive analytics and machine learning insights.</p>
                        <div class="project-tags">
                            <span class="project-tag">Python</span>
                            <span class="project-tag">TensorFlow</span>
                            <span class="project-tag">D3.js</span>
                        </div>
                        <a href="#" class="project-link">View Project <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- Project 5 -->
                <div class="project-card" data-category="cloud">
                    <div class="project-image">
                        <img src="https://picsum.photos/seed/cloud/400/200.jpg" alt="Cloud Infrastructure">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">Cloud Infrastructure</h3>
                        <p class="project-description-text">Scalable cloud solution for enterprise applications with auto-scaling capabilities.</p>
                        <div class="project-tags">
                            <span class="project-tag">AWS</span>
                            <span class="project-tag">Docker</span>
                            <span class="project-tag">Kubernetes</span>
                        </div>
                        <a href="#" class="project-link">View Project <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- Project 6 -->
                <div class="project-card" data-category="mobile">
                    <div class="project-image">
                        <img src="https://picsum.photos/seed/travel/400/200.jpg" alt="Travel Booking App">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">Travel Booking App</h3>
                        <p class="project-description-text">Complete travel planning and booking solution with integrated payment system.</p>
                        <div class="project-tags">
                            <span class="project-tag">Flutter</span>
                            <span class="project-tag">Django</span>
                            <span class="project-tag">Maps API</span>
                        </div>
                        <a href="#" class="project-link">View Project <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- Project 7 -->
                <div class="project-card" data-category="web">
                    <div class="project-image">
                        <img src="https://picsum.photos/seed/education/400/200.jpg" alt="Education Platform">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">Education Platform</h3>
                        <p class="project-description-text">Interactive learning management system with video streaming and assessments.</p>
                        <div class="project-tags">
                            <span class="project-tag">Next.js</span>
                            <span class="project-tag">GraphQL</span>
                            <span class="project-tag">PostgreSQL</span>
                        </div>
                        <a href="#" class="project-link">View Project <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                
                <!-- Project 8 -->
                <div class="project-card" data-category="ai">
                    <div class="project-image">
                        <img src="https://picsum.photos/seed/chatbot/400/200.jpg" alt="AI Chatbot">
                    </div>
                    <div class="project-content">
                        <h3 class="project-name">AI Chatbot</h3>
                        <p class="project-description-text">Intelligent customer support chatbot with natural language processing capabilities.</p>
                        <div class="project-tags">
                            <span class="project-tag">Python</span>
                            <span class="project-tag">NLP</span>
                            <span class="project-tag">Dialogflow</span>
                        </div>
                        <a href="#" class="project-link">View Project <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- View more button -->
            <div class="projects-view-more">
                <a href="projects-all.html" class="view-more-btn">
                    View All Projects <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Partners Section -->
    <section class="section-padding">
        <div class="section-pattern-1"></div>
        <div class="container">
            <h2 class="section-title">Our Partners</h2>
            <p class="section-text">We are proud to collaborate with industry leaders</p>
            
            <div class="partners-container">
                <div class="partners-track">
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/tcs/150/80.jpg" alt="TCS">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/godaddy/150/80.jpg" alt="GoDaddy">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/amazon/150/80.jpg" alt="Amazon Cloud">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/zoho/150/80.jpg" alt="Zoho">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/meta/150/80.jpg" alt="Meta">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/billdesk/150/80.jpg" alt="BillDesk">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/google/150/80.jpg" alt="Google">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/microsoft/150/80.jpg" alt="Microsoft">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/oracle/150/80.jpg" alt="Oracle">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/salesforce/150/80.jpg" alt="Salesforce">
                    </div>
                    <!-- Duplicate for seamless scrolling -->
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/tcs/150/80.jpg" alt="TCS">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/godaddy/150/80.jpg" alt="GoDaddy">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/amazon/150/80.jpg" alt="Amazon Cloud">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/zoho/150/80.jpg" alt="Zoho">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/meta/150/80.jpg" alt="Meta">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/billdesk/150/80.jpg" alt="BillDesk">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/google/150/80.jpg" alt="Google">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/microsoft/150/80.jpg" alt="Microsoft">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/oracle/150/80.jpg" alt="Oracle">
                    </div>
                    <div class="partner-logo">
                        <img src="https://picsum.photos/seed/salesforce/150/80.jpg" alt="Salesforce">
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
                            <div class="stat-number-bg">250</div>
                            <div class="stat-number" data-count="250">0</div>
                            <div class="stat-label">Projects Completed</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-item">
                            <div class="stat-number-bg">180</div>
                            <div class="stat-number" data-count="180">0</div>
                            <div class="stat-label">Happy Clients</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-item">
                            <div class="stat-number-bg">50</div>
                            <div class="stat-number" data-count="50">0</div>
                            <div class="stat-label">Team Members</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-item">
                            <div class="stat-number-bg">15</div>
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
            
            <div class="testimonials-container" id="testimonials-container">
                <div class="testimonials-track" id="testimonials-track">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-text">"The team delivered exceptional results that exceeded our expectations. Their professionalism and expertise are unmatched."</p>
                            <div class="testimonial-author">
                                <div class="author-image">
                                    <img src="https://picsum.photos/seed/client1/100/100.jpg" alt="Client">
                                </div>
                                <div class="author-info">
                                    <h5>John Smith</h5>
                                    <p>CEO, TechCorp</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-text">"Working with this team has been a game-changer for our business. Their innovative solutions helped us streamline our operations."</p>
                            <div class="testimonial-author">
                                <div class="author-image">
                                    <img src="https://picsum.photos/seed/client2/100/100.jpg" alt="Client">
                                </div>
                                <div class="author-info">
                                    <h5>Sarah Johnson</h5>
                                    <p>Marketing Director, InnovateCo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-text">"The attention to detail and commitment to quality is impressive. I highly recommend their services to any business looking to grow."</p>
                            <div class="testimonial-author">
                                <div class="author-image">
                                    <img src="https://picsum.photos/seed/client3/100/100.jpg" alt="Client">
                                </div>
                                <div class="author-info">
                                    <h5>Michael Brown</h5>
                                    <p>CTO, StartupHub</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-text">"Their technical expertise and customer service are outstanding. They delivered our project on time and within budget."</p>
                            <div class="testimonial-author">
                                <div class="author-image">
                                    <img src="https://picsum.photos/seed/client4/100/100.jpg" alt="Client">
                                </div>
                                <div class="author-info">
                                    <h5>Emily Davis</h5>
                                    <p>Product Manager, DataTech</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-text">"We've been working with them for three years now, and they continue to exceed our expectations with every project."</p>
                            <div class="testimonial-author">
                                <div class="author-image">
                                    <img src="https://picsum.photos/seed/client5/100/100.jpg" alt="Client">
                                </div>
                                <div class="author-info">
                                    <h5>Robert Wilson</h5>
                                    <p>Operations Director, GlobalCorp</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-text">"Their innovative approach to problem-solving helped us overcome challenges we thought were insurmountable."</p>
                            <div class="testimonial-author">
                                <div class="author-image">
                                    <img src="https://picsum.photos/seed/client6/100/100.jpg" alt="Client">
                                </div>
                                <div class="author-info">
                                    <h5>Lisa Anderson</h5>
                                    <p>Founder, GreenTech</p>
                                </div>
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
                <div class="col-12 col-lg-8">
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
                                  <li class="dropdown">
                  <a href="#demos">Services <i class="fas fa-chevron-down"></i></a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#web">Web Development</a></li>
                    <li><a class="dropdown-item" href="#mobile">Mobile Apps</a></li>
                    <li><a class="dropdown-item" href="#cloud">Cloud Solutions</a></li>
                    <li><a class="dropdown-item" href="#consulting">Consulting</a></li>
                  </ul>
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
                </div>
                <div class="col-12 col-lg-4">
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.2799160891!2d-74.25987368715491!3d40.69767006416587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQxJzUxLjYiTiA3NMKwMTUnMzUuNCJX!5e0!3m2!1sen!2sus!4v1629886789422!5m2!1sen!2sus" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2023 Company Name. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <!-- Enhanced Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="offcanvas-nav">
                <li class="offcanvas-nav-item">
                    <a href="#" class="offcanvas-nav-link">
                        <i class="bi bi-house-door"></i>
                        Home
                    </a>
                </li>
                <li class="offcanvas-nav-item">
                    <a href="#" class="offcanvas-nav-link">
                        <i class="bi bi-info-circle"></i>
                        About Us
                    </a>
                </li>
                <li class="offcanvas-nav-item">
                    <a href="#" class="offcanvas-nav-link dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#servicesDropdown" role="button" aria-expanded="false">
                        <i class="bi bi-briefcase"></i>
                        Services
                        <i class="bi bi-chevron-down dropdown-toggle-icon"></i>
                    </a>
                    <ul class="offcanvas-dropdown collapse" id="servicesDropdown">
                        <li class="offcanvas-dropdown-item">
                            <a href="#" class="offcanvas-dropdown-link">Web Development</a>
                        </li>
                        <li class="offcanvas-dropdown-item">
                            <a href="#" class="offcanvas-dropdown-link">Mobile Apps</a>
                        </li>
                        <li class="offcanvas-dropdown-item">
                            <a href="#" class="offcanvas-dropdown-link">Cloud Solutions</a>
                        </li>
                        <li class="offcanvas-dropdown-item">
                            <a href="#" class="offcanvas-dropdown-link">Digital Marketing</a>
                        </li>
                        <li class="offcanvas-dropdown-item">
                            <a href="#" class="offcanvas-dropdown-link">Cybersecurity</a>
                        </li>
                    </ul>
                </li>
                <li class="offcanvas-nav-item">
                    <a href="#" class="offcanvas-nav-link">
                        <i class="bi bi-folder"></i>
                        Projects
                    </a>
                </li>
                <li class="offcanvas-nav-item">
                    <a href="#" class="offcanvas-nav-link">
                        <i class="bi bi-people"></i>
                        Partners
                    </a>
                </li>
                <li class="offcanvas-nav-item">
                    <a href="#" class="offcanvas-nav-link">
                        <i class="bi bi-envelope"></i>
                        Contact
                    </a>
                </li>
            </ul>
            
            <div class="offcanvas-contact">
                <div class="offcanvas-contact-item">
                    <i class="bi bi-geo-alt"></i>
                    123 Tech Street, Silicon Valley, CA 94000
                </div>
                <div class="offcanvas-contact-item">
                    <i class="bi bi-telephone"></i>
                    +1 (123) 456-7890
                </div>
                <div class="offcanvas-contact-item">
                    <i class="bi bi-envelope"></i>
                    info@company.com
                </div>
            </div>
            
            <div class="offcanvas-social">
                <a href="#" class="offcanvas-social-icon">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="#" class="offcanvas-social-icon">
                    <i class="bi bi-twitter"></i>
                </a>
                <a href="#" class="offcanvas-social-icon">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="#" class="offcanvas-social-icon">
                    <i class="bi bi-linkedin"></i>
                </a>
                <a href="#" class="offcanvas-social-icon">
                    <i class="bi bi-youtube"></i>
                </a>
            </div>
        </div>
    </div>
    
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
        
        // Testimonials Auto-Scroll
        (function () {
            const testimonialsContainer = document.getElementById('testimonials-container');
            const testimonialsTrack = document.getElementById('testimonials-track');
            let scrollAmount = 0;
            let scrollTimer = null;
            let isPaused = false;
            
            // Clone testimonials for infinite scroll
            const testimonials = Array.from(testimonialsTrack.children);
            testimonials.forEach(testimonial => {
                const clone = testimonial.cloneNode(true);
                testimonialsTrack.appendChild(clone);
            });
            
            const scrollTestimonials = () => {
                if (!isPaused) {
                    scrollAmount += 1;
                    testimonialsTrack.style.transform = `translateX(-${scrollAmount}px)`;
                    
                    // Reset scroll position when we've scrolled through all original testimonials
                    if (scrollAmount >= testimonialsTrack.scrollWidth / 2) {
                        scrollAmount = 0;
                        testimonialsTrack.style.transition = 'none';
                        testimonialsTrack.style.transform = `translateX(0)`;
                        
                        // Force reflow
                        void testimonialsTrack.offsetWidth;
                        
                        testimonialsTrack.style.transition = 'transform 0.5s ease';
                    }
                }
                
                scrollTimer = requestAnimationFrame(scrollTestimonials);
            };
            
            // Start scrolling
            scrollTimer = requestAnimationFrame(scrollTestimonials);
            
            // Pause on hover
            testimonialsContainer.addEventListener('mouseenter', () => {
                isPaused = true;
            });
            
            // Resume on mouse leave
            testimonialsContainer.addEventListener('mouseleave', () => {
                isPaused = false;
            });
        })();
        
        // Projects Filter Functionality
        (function () {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const projectCards = document.querySelectorAll('.project-card');
            const projectsCount = document.querySelector('.projects-count');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    button.classList.add('active');
                    
                    // Get filter value
                    const filterValue = button.getAttribute('data-filter');
                    
                    // Count visible projects
                    let visibleCount = 0;
                    
                    // Show/hide projects based on filter
                    projectCards.forEach(item => {
                        if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                            item.style.display = 'block';
                            visibleCount++;
                        } else {
                            item.style.display = 'none';
                        }
                    });
                    
                    // Update projects count display
                    const totalProjects = filterValue === 'all' ? 24 : visibleCount;
                    projectsCount.innerHTML = `Showing <strong>${Math.min(visibleCount, 8)}</strong> of <strong>${totalProjects}</strong> projects`;
                });
            });
        })();
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Offcanvas Dropdown Toggle
        (function () {
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    const parent = toggle.parentElement;
                    const dropdown = parent.querySelector('.offcanvas-dropdown');
                    
                    // Toggle active class on parent
                    parent.classList.toggle('active');
                    
                    // Toggle dropdown collapse
                    const bsCollapse = new bootstrap.Collapse(dropdown, {
                        toggle: false
                    });
                    bsCollapse.toggle();
                });
            });
        })();
    </script>
    
       <?php include('footer.php'); ?>
</body>
</html>
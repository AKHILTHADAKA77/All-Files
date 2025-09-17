<style>
    *{
        margin: 0px;
        padding: 0px;
    }
    :root {
      --primary-color: #000000;
      --secondary-color: #5512c0ff;
      --accent-color: #ff0800;
      --light-color: #ecf0f1;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding-top: 70px;
    }

    .cno-header {
      /* box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1); */
      padding: 10px 0;
      transition: all 0.3s ease;
      /* background-color: white !important; */
      /* background-color: rgba(255, 255, 255, 0.5);  */
      /* border-bottom: 1px solid black; */
    }

    .header--sticky {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
    }

    .logo-container {
      display: flex;
      align-items: center;
      height: 100%;
    }

    .logo img {
      height: 70px;
    }

    .navbar-container {
      display: flex;
      width: 100%;
      justify-content: space-between;
      align-items: center;
    padding: 0px 50px;
    }

    .mainmenu-nav {
      flex-grow: 1;
      display: flex;
      justify-content: center;
    }

    .mainmenu {
      display: flex;
      gap: 25px;
      margin: 0;
      padding: 0;
    }

    .mainmenu li {
      list-style: none;
      position: relative;
    }

    .mainmenu li a {
      color: var(--light-color);
      font-weight: 600;
      text-decoration: none;
      padding: 8px 0;
      position: relative;
      font-size: 18px;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: all 0.3s ease;
    }

    .mainmenu li a:hover {
      color: var(--secondary-color);
         box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    /* Dropdown Menu */
    .dropdown-menu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      opacity: 0;
      transform: translateY(10px);
      transition: all 0.3s ease;
      background: white;
      min-width: 200px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      z-index: 1050;
    }

    .dropdown:hover .dropdown-menu {
      display: block;
      opacity: 1;
      transform: translateY(0);
    }

    .dropdown-menu li {
      list-style: none;
    }

    .dropdown-menu .dropdown-item {
      padding: 10px 20px;
      display: block;
      text-decoration: none;
      color: var(--primary-color);
      font-weight: 500;
    }

    .dropdown-menu .dropdown-item:hover {
      background-color: var(--light-color);
      color: var(--secondary-color);
    }

    .mobile-menu-btn {
      background-color: var(--primary-color);
      color: white;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      border: none;
      font-size: 18px;
      margin-left: 15px;
    }

    .offcanvas {
      background-color: var(--primary-color);
      color: white;
    }

    .offcanvas-header {
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .offcanvas-title .logo-main {
      color: white;
      font-size: 24px;
    }

    .offcanvas-title .logo-sub {
      color: var(--accent-color);
      font-size: 14px;
    }

    .btn-close {
      filter: invert(1);
    }

    .mobile-menu li {
      list-style: none;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .mobile-menu li a {
      color: white;
      text-decoration: none;
      padding: 15px 20px;
      display: block;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .mobile-menu li a:hover {
      color: var(--accent-color);
      background-color: rgba(56, 55, 55, 0.05);
    }

    /* Search Bar */
    .search-container {
      position: absolute;
      top: 50%;
      right: 60px;
      transform: translateY(-50%);
      background: white;
      border-radius: 30px;
      padding: 8px 12px;
      display: flex;
      align-items: center;
      transition: box-shadow 0.3s ease;
      z-index: 999;
    }

    .search-container.expanded {
      box-shadow: 0 4px 12px rgba(89, 101, 207, 0.2);
    }

    .search-container input {
      border: none;
      outline: none;
      width: 0;
      transition: width 0.4s ease;
      font-size: 16px;
      background: transparent;
      color: #333;
    }

    .search-container.expanded input {
      width: 220px;
      padding-left: 8px;
    }

    .icon-area {
      cursor: pointer;
      color: var(--primary-color);
    }
    .cno-header-parent {
    position: absolute;
    z-index: 99;
    width: 100%;
}

    @media (max-width: 991.98px) {
      .mainmenu-nav {
        display: none !important;
      }

      .search-container {
        right: 100px;
      }
    }

    @media (max-width: 767.98px) {
      .search-container {
        display: none;
      }
    }
  </style>
</head>

<body>
  <header class="cno-header-parent header--sticky">
    <div class="cno-header">
      <div class="container-fluid">
        <div class="navbar-container">
          <!-- Logo -->
          <div class="header-left">
            <div class="logo-container">
              <a href="#" class="logo">
                <img src="assets/images/logo.png" alt="logo">
              </a>
            </div>
          </div>

          <!-- Desktop Menu -->
          <div class="cno-main-navigation d-none d-lg-block">
            <nav class="mainmenu-nav">
              <ul class="mainmenu">
                <li><a href="#hero">Home</a></li>
                <li><a href="#feature">About Us</a></li>
                <li class="dropdown">
                  <a href="#demos">Services <i class="fas fa-chevron-down"></i></a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#web">Web Development</a></li>
                    <li><a class="dropdown-item" href="#mobile">Mobile Apps</a></li>
                    <li><a class="dropdown-item" href="#cloud">Cloud Solutions</a></li>
                    <li><a class="dropdown-item" href="#consulting">Consulting</a></li>
                  </ul>
                </li>
                <li><a href="#faq">FAQ's</a></li>
                <li><a href="#contact">Clients</a></li>
                <li><a href="#contact">Contact</a></li>
              </ul>
            </nav>
          </div>

          <!-- Right Side: Search & Mobile Menu -->
          <div class="header-right position-relative d-flex align-items-center">
            <div class="search-container" id="searchBox">
              <input type="text" class="custom-input" placeholder="What are you looking for …" />
              <a href="#" class="icon-area"><i class="fa fa-search"></i></a>
            </div>

            <!-- Mobile Button -->
            <button class="mobile-menu-btn d-lg-none" type="button" data-bs-toggle="offcanvas"
              data-bs-target="#mobileMenu" aria-controls="mobileMenu">
              <i class="fas fa-bars"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Mobile Offcanvas Menu -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <div class="offcanvas-header">
      <div class="offcanvas-title">
        <span class="logo-main">Kakatiya</span>
        <span class="logo-sub">Solutions</span>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="mobile-menu">
        <li><a href="#hero" data-bs-dismiss="offcanvas"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="#feature" data-bs-dismiss="offcanvas"><i class="fas fa-star"></i> About Us</a></li>
        <li><a href="#demos" data-bs-dismiss="offcanvas"><i class="fas fa-laptop-code"></i> Services</a></li>
        <li><a href="#faq" data-bs-dismiss="offcanvas"><i class="fas fa-question-circle"></i> FAQ's</a></li>
        <li><a href="#contact" data-bs-dismiss="offcanvas"><i class="fas fa-envelope"></i> Clients</a></li>
        <li><a href="#contact" data-bs-dismiss="offcanvas"><i class="fas fa-envelope"></i> Contact</a></li>
      </ul>
    </div>
  </div>

 

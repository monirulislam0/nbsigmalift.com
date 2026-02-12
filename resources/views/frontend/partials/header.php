<?php 
$site_settings = \app\http\models\SiteSettings::all()->first()->get();
$baseUrl = rtrim(getenv('SITE_URL'), '/');

// Get current path without query parameters
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$canonicalUrl = $baseUrl . $currentPath;  // Fixed canonical source
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- SEO Information -->
  <meta name="description" content="<?= !empty($page['meta_description']) ? htmlspecialchars($page['meta_description']) : htmlspecialchars($page['og_description'] ?? '') ?>">
  <meta name="keywords" content="<?= htmlspecialchars($page['meta_tags'] ?? '') ?>">
  <title><?= htmlspecialchars($page['page_title'] ?? '') ?></title>
  
  <!-- Allow indexing (use this for most pages) -->
  <meta name="robots" content="index, follow">
  
  <!-- Canonical URL (Fixed and Consistent) -->
  <link rel="canonical" href="<?= $canonicalUrl ?>" />
  
  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="<?= $page['og_title'] ?? $page['page_title'] ?>">
  <meta property="og:description" content="<?= trim($page['og_description']) ?>">
  <meta property="og:type" content="website">
  <meta property="og:image" content="<?= $baseUrl . (assets("/uploads/".($page['og_image'] ?? $page['banner_image']))) ?>">
  <meta property="og:url" content="<?= $canonicalUrl ?>">
  <meta property="og:site_name" content="Ningbo Sigma Elevator">
  
  <!-- Twitter Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= $page['og_title'] ?? $page['page_title'] ?>">
  <meta name="twitter:description" content="<?= trim($page['og_description']) ?>">
  <meta name="twitter:image" content="<?= $baseUrl . (assets("/uploads/".($page['og_image'] ?? $page['banner_image']))) ?>?v=1">
  <meta name="twitter:url" content="<?= $canonicalUrl ?>">
  
  <!-- ========= SCHEMA MARKUP ========= -->
  <!-- Organization Schema -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": ["Organization"],
    "name": "Ningbo Sigma Elevator Company Limited",
    "url": "https://www.nbsigmalift.com/",
    "logo": "https://nbsigmalift.com/uploads/1837145317519620.webp",
    "foundingDate": "2002",
    "founder": {
      "@type": "Person",
      "name": "Ring Lai"
    },
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "1507 Chunchi Road, Gaoqiao Town, Haishu District",
      "addressLocality": "Ningbo",
      "addressRegion": "Zhejiang",
      "postalCode": "315000",
      "addressCountry": "CN"
    },
    "contactPoint": {
      "@type": "ContactPoint",
      "contactType": "Sales Director",
      "telephone": "+8618657970560",
      "availableLanguage": ["Chinese", "English", "Bangla", "Arabic", "Hindi", "Urdu"]
    },
    "sameAs": [
      "https://www.facebook.com/ningbosigma",
      "https://www.instagram.com/ningbosigma/",
      "https://www.youtube.com/@nbsigmalift",
      "https://api.whatsapp.com/send/?phone=8618657970560"
    ]
  }
  </script>
  
  
  <!-- Favicon -->
  <link rel="shortcut icon" href="<?= assets('/uploads/').$site_settings['icon'] ?>" type="image/x-icon">
  
  <!-- CSS -->
  
  <link rel="stylesheet" type="text/css" href="<?= assets("/frontend/assets/bootstrap.min.css") ?>">
  
  <script src="<?= assets("/frontend/assets/bootstrap.bundle.min.js") ?>"></script>
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= assets("/frontend/assets/style.css") ?>">
  
  <style>
        .contact-bar {
            color: white;
        }
        .contact-bar a {
            color: black;
            text-decoration: none;
            margin: 0 5px;
        }
        .social-icons a {
            font-size: 20px;
            margin: 0 8px;
            position: relative;
        }
        .search-icon {
            cursor: pointer;
            font-size: 20px;
            color: white;
            transition: 0.3s;
        }
        /* Search Bar */
        .search-container {
            width: 100%;
            background: blue;
            padding: 10px;
        }
        .search-container input {
            width: 100%;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            outline: none;
            font-size: 1rem;
            max-width: 300px;
        }
        
        .social-icons a:first-child{
            color: #0A66C2;
        }
          .social-icons a:nth-child(2){
            color: #000000;
        }
        .social-icons a:nth-child(3){
            color: #FF0000;
        } 
        .social-icons a:nth-child(4){
              background: linear-gradient(135deg, #F58529, #DD2A7B, #8134AF, #515BD4);
                  -webkit-background-clip: text;
                  -webkit-text-fill-color: transparent;
                  display: inline-block;
        }
        .social-icons a:last-child{
            color: #1877F2;
        }
        
        /* Accessibility improvements */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
        }
        
        .nav-link.dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }
        
        /* Mobile Responsive Styles */
        @media (max-width: 991px) {
            /* Hide social icons on mobile */
            .social-icons {
                display: none !important;
            }
            
            /* Stack contact items vertically */
            .contact-bar .d-flex {
                flex-wrap: wrap;
                justify-content: center !important;
            }
            
            /* Add spacing between contact items */
            .contact-bar a {
                margin: 5px 8px;
            }
            
            /* Make search input full width */
            .contact-bar .col-md-4 .container {
                padding: 0;
            }
            
            /* Center navbar items */
            .navbar-nav {
                text-align: center;
            }
            
            /* Adjust dropdown arrows */
            .nav-link.dropdown-toggle::after {
                float: right;
                margin-top: 8px;
            }
            
            /* Make contact info column full width */
            .contact-bar .col-md-4 {
                width: 100%;
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        @media (max-width: 767px) {
            /* Stack contact bar columns */
            .contact-bar .row > div {
                width: 100%;
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            /* Center brand logo */
            .navbar-brand {
                margin: 0 auto;
                width: 200px !important;
            }
            
            /* Add spacing to mobile menu items */
            .navbar-nav .nav-item {
                margin: 5px 0;
            }
            
            /* Improve contact items layout */
            .contact-bar .d-flex {
                justify-content: center !important;
                margin: 5px 0;
            }
            
            /* Adjust contact text size */
            .contact-item span {
                font-size: 14px;
            }
        }
        
        .nav-item.dropdown:hover > .dropdown-menu {
            display: block;
        }
        .dropdown-submenu .dropdown-menu {
            display: none;
            left: 100%;
            top: 0;
            margin-top: -1px;
        }
        .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }
        .dropdown-menu {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        /* Accessibility improvements */
        .dropdown-submenu > .dropdown-menu {
            display: none;
        }
        
        .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }
        
        @media (max-width: 991px) {
            .dropdown-submenu .dropdown-menu {
                left: 0;
                top: 100%;
                margin-top: 0;
            }
        }
        
        /* CONTACT BAR WIDTH ADJUSTMENT */
        .contact-bar > .container-fluid {
            max-width: 1600px; /* Reduced from default full width */
            margin: 0 auto; /* Center the contact bar */
            padding: 0 15px; /* Maintain side padding */
        }
        
        /* Prevent header expansion in single product view */
        .navbar {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }
        .navbar-brand {
            height: 56px !important; /* Fixed height */
        }
        .navbar-brand img {
            max-height: 100%; /* Ensure logo fits */
        }
    </style>
</head>
<body>

<!-- Contact Bar - Updated for Mobile Responsiveness -->
<div class="contact-bar position-relative">
  <div class="container-fluid">
    <div class="row align-items-center">
      <!-- Social Icons (Hidden on Mobile) -->
      <div class="col-md-4 d-none d-md-flex justify-content-between align-items-center">
        <div class="social-icons">
          <a href="https://www.linkedin.com/company/108418213/" target="_blank" aria-label="LinkedIn">
            <i class="fab fa-linkedin" aria-hidden="true"></i>
            <span class="sr-only">LinkedIn</span>
          </a>
          <a href="https://www.facebook.com/ningbosigma" target="_blank" aria-label="Twitter">
            <i class="fab fa-twitter" aria-hidden="true"></i>
            <span class="sr-only">Twitter</span>
          </a>
          <a href="https://www.youtube.com/@nbsigmalift" target="_blank" aria-label="YouTube">
            <i class="fab fa-youtube" aria-hidden="true"></i>
            <span class="sr-only">YouTube</span>
          </a>
          <a href="https://www.instagram.com/ningbosigma" target="_blank" aria-label="Instagram">
            <i class="fab fa-instagram" aria-hidden="true"></i>
            <span class="sr-only">Instagram</span>
          </a>
          <a href="https://www.facebook.com/ningbosigma"target="_blank" aria-label="Facebook">
            <i class="fab fa-facebook" aria-hidden="true"></i>
            <span class="sr-only">Facebook</span>
          </a>
        </div>
      </div>
      
      <!-- Contact Info - Updated -->
      <div class="col-12 col-md-4">
        <div class="d-flex flex-wrap justify-content-center align-items-center">
          <!-- Hidden on mobile -->
          <a href="https://wa.me/8618657970560" target="_blank" class="d-flex align-items-center justify-content-center d-none d-md-flex me-3" aria-label="WeChat">
            <i class="fa-brands fa-weixin" aria-hidden="true"></i>
            <span class="sr-only">WeChat</span>
          </a>
          <a href="https://wa.me/8618657970560" target="_blank" class="d-flex align-items-center justify-content-center d-none d-md-flex me-3" aria-label="WhatsApp">
            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
            <span class="sr-only">WhatsApp</span>
          </a>
          
          <!-- Phone (visible on all devices) -->
          <a href="tel:+8618657970560" class="d-flex align-items-center justify-content-center contact-item me-3" aria-label="Call us">
            <i class="fa-solid fa-phone" aria-hidden="true"></i>
            <span class="ms-2">+8618657970560</span>
          </a>
          
          <!-- Email (always visible) -->
          <a href="mailto:sales@nbsigmalift.com" class="d-flex align-items-center justify-content-center contact-item" aria-label="Email us">
            <i class="fas fa-envelope" aria-hidden="true"></i>
            <span class="ms-2" style="color: black">sales@nbsigmalift.com</span>
          </a>
        </div>
      </div>
      
      <!-- Search Form - Made larger -->
      <div class="col-12 col-md-4">
       <div class="container px-0">
         <form class="d-flex justify-content-end" action="/search/content" method="GET">
           <input 
             type="text" 
             class="form-control" 
             placeholder="Search..." 
             aria-label="Search website content"
             name="search_key"
             style="width: 100%; max-width: 300px; padding: 0.375rem 0.75rem;"
           >
         </form>
       </div>
      </div>
    </div>
  </div>
</div>

<!-- Collapsible Search Bar -->
<div class="collapse" id="searchContainer">
  <div class="search-container">
    <div class="container">
      <form class="d-flex" action="/search/content" method="GET">
        <input 
          type="text" 
          class="form-control" 
          placeholder="Search..." 
          aria-label="Search website content"
          name="search_key"
        >
      </form>
    </div>
  </div>
</div>

<nav class="navbar navbar-expand-lg sticky-top" style="padding-top:0px; padding-bottom:0px;">
  <div class="container-fluid">
    <a class="navbar-brand" href="/" aria-label="Home">
      <img 
        src="<?= assets("/uploads/".$site_settings['logo']) ?>" 
        alt="Ningbo Sigma Elevator Logo"
        style="
          height:56px;
          width: 250px;
          object-fit: contain;
        ">
    </a>
    <button 
      class="navbar-toggler" 
      type="button" 
      data-bs-toggle="collapse" 
      data-bs-target="#navbarNav" 
      aria-controls="navbarNav" 
      aria-expanded="false" 
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a 
            class="nav-link dropdown-toggle" 
            href="/about" 
            id="aboutDropdown" 
            role="button" 
            aria-haspopup="true" 
            aria-expanded="false"
          >
            About
          </a>
          <ul class="dropdown-menu" style="border-radius:0;" aria-labelledby="aboutDropdown">
            <li><a href="/why-choose-us" class="dropdown-item">Why Choose Us</a></li>
            <li><a href="/factory-tours" class="dropdown-item">Factory Tours</a></li>
            <li><a href="/projects" class="dropdown-item">Projects</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a 
            class="nav-link dropdown-toggle" 
            href="/products" 
            id="productsDropdown" 
            role="button" 
            aria-haspopup="true" 
            aria-expanded="false"
          >
            Products
          </a>
          <?php 
            $categories = \app\http\models\Categories::all()->get();
            if(count($categories)):
          ?>
          <ul class="dropdown-menu" aria-labelledby="productsDropdown" style="border-radius:0;">
            <?php foreach($categories as $category) : 
              $subcategories = \app\http\models\SubCategories::where($category['id'],'category_id')->get();
              $has_subcategories = count($subcategories);
            ?>
            <li class="dropdown-submenu position-relative">
              <a 
                class="dropdown-item 
                <?php if($has_subcategories) echo " dropdown-toggle" ?>
                " 
                href="/products-categories/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $category['category_name']), '-'))."-".$category['id'] ?>"
                <?php if($has_subcategories): ?>
                  role="button" 
                  data-bs-toggle="dropdown" 
                  aria-expanded="false"
                <?php endif; ?>
              >
                <?= $category['category_name'] ?>
              </a>
             <?php 
                if($has_subcategories):
             ?>
              <ul class="dropdown-menu" style="border-radius:0;">
                <?php foreach($subcategories as $subcategory) : ?>
                <li><a class="dropdown-item" href="/products-subcategories/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $subcategory['subcategory_name']), '-'))."-".$subcategory['id'] ?>"><?= $subcategory['subcategory_name']; ?></a></li>
                <?php endforeach; ?>
              </ul>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/distributor">Distributor</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/blog">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/faq">FAQs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/contact-us">Contacts</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Fix for Bootstrap JS error -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Enhance dropdown accessibility for touch devices
  document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        if (window.innerWidth < 992) {
          e.preventDefault();
          const dropdownMenu = this.nextElementSibling;
          const isOpen = dropdownMenu.style.display === 'block';
          
          // Close all dropdowns first
          document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.style.display = 'none';
          });
          
          // Toggle current dropdown
          dropdownMenu.style.display = isOpen ? 'none' : 'block';
        }
      });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
      if (!e.target.matches('.dropdown-toggle') && window.innerWidth < 992) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
          menu.style.display = 'none';
        });
      }
    });
  });
</script>
</body>
</html>
<?php 
    $site_settings = \app\http\models\SiteSettings::all()->first()->get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Scroll to Top Button Styles - Positioned above WhatsApp */
        .scroll-to-top {
            position: fixed;
            bottom: 110px; /* Positioned above WhatsApp icon */
            right: 40px; /* Same right alignment as WhatsApp */
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: rgba(0, 123, 255, 0.7); /* Blue with transparency */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            z-index: 99;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px); /* Adds a blur effect to the background */
            border: 2px solid rgba(255, 255, 255, 0.5);
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
        }
        
        .scroll-to-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .scroll-to-top:hover {
            background-color: rgba(0, 86, 214, 0.9); /* Darker blue on hover */
            transform: translateY(-5px);
        }
        
        /* WhatsApp Floating Icon */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .whatsapp-float:hover {
            background-color: #128C7E;
        }
        
        /* Messenger Floating Icon */
        .messenger-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            left: 40px;
            background-color: #006AFF;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .messenger-float:hover {
            background-color: #0052CC;
        }
        
        @media (max-width: 768px) {
            .scroll-to-top {
                bottom: 100px;
                right: 25px;
                width: 55px;
                height: 55px;
                font-size: 22px;
            }
            
            .whatsapp-float, .messenger-float {
                bottom: 25px;
            }
            .whatsapp-float {
                right: 25px;
            }
            .messenger-float {
                left: 25px;
            }
        }
        
        @media (max-width: 480px) {
            .scroll-to-top {
                bottom: 90px;
                right: 15px;
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
            
            .whatsapp-float, .messenger-float {
                bottom: 20px;
            }
            .whatsapp-float {
                right: 15px;
            }
            .messenger-float {
                left: 15px;
            }
        }
    </style>
</head>
<body>

<!-- WhatsApp Floating Icon -->
<a href="https://wa.me/8618657970560" class="whatsapp-float" target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- Messenger Floating Icon - Opens Facebook Page -->
<a href="https://www.facebook.com/ningbosigma" class="messenger-float" target="_blank">
    <i class="fab fa-facebook-messenger"></i>
</a>

<!-- Scroll to Top Button -->
<button id="scrollToTop" class="scroll-to-top" aria-label="Scroll to top">
    <i class="fas fa-arrow-up"></i>
</button>

<footer class="footer mt-5" style="
    background: linear-gradient(15deg, #ffffff 0%, #f8f9ff 100%);
    border-top: 3px solid #007bff;
">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="logo-container mb-4" style="
                    background-image: url('<?= assets("/uploads/".$site_settings['logo']) ?>');
                    max-width: 200px;
                    height: 60px;
                    background-size: contain;
                    background-repeat: no-repeat;
                "></div>
                <p class="text-muted" style="line-height: 1.6; font-size: 0.9rem;">
                    NINGBO SIGMA ELEVATOR COMPANY LIMITED, A Leading elevator manufacturer & global exporter of premium, customizable elevators for residential, commercial, and industrial needs.
                    <a href="https://nbsigmalift.com/about" target="_blank" class="text-primary text-decoration-none">Read more...</a>
                </p>
            </div>

            <div class="col-md-4">
                <h2 class="mb-4" style="font-size: 20px; font-weight: bold;color: #333; font-weight: 600; border-left: 4px solid #007bff; padding-left: 1rem;">QUICK LINKS</h2>
                <ul class="list-unstyled">
                    <?php 
                    $categories = \app\http\models\Categories::all()->get();
                    foreach($categories as $keys => $category) :
                        if($keys == 7) break;
                    ?>
                    <li class="mb-2">
                        <a href="/products-categories/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $category['category_name']), '-'))."-".$category['id'] ?>" 
                           class="text-dark text-decoration-none hover-primary"
                           style="transition: color 0.3s ease;">
                           <i class="fas fa-chevron-right me-2 small text-primary"></i>
                           <?= $category['category_name'] ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-md-4">
                <h2 class="mb-4" style="font-size: 20px; font-weight: bold;color: #333; font-weight: 600; border-left: 4px solid #007bff; padding-left: 1rem;">CONTACT US</h2>
                <div class="contact-info">
                    <p class="text-muted mb-3">
                        <i class="fas fa-phone-alt me-2 text-primary"></i>
                        +8618657970560
                    </p>
                    <p class="text-muted mb-3">
                        <i class="fas fa-envelope me-2 text-primary"></i>
                        sales@nbsigmalift.com
                    </p>
                    <p class="text-muted mb-4">
                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                        1507 Chunchi Road, Gaoqiao Town, Haishu District,<br>
                        Ningbo City, Zhejiang Province, China
                    </p>
                    <div class="social-icons d-flex gap-3">
                        <a href="https://www.linkedin.com/company/108418213/" class="text-primary hover-primary" target="_blank" style="font-size: 1.2rem;">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://twitter.com/nbsigmalift" class="text-primary hover-primary" target="_blank" style="font-size: 1.2rem;">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.youtube.com/@nbsigmalift" target="_blank" class="text-primary hover-primary" style="font-size: 1.2rem;">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://www.instagram.com/ningbosigma" target="_blank" class="text-primary hover-primary" style="font-size: 1.2rem;">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.facebook.com/ningbosigma" target="_blank" class="text-primary hover-primary" style="font-size: 1.2rem;">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4" style="border-color: #007bff;">

        <div class="row">
            <div class="col-12">
                <p class="text-muted mb-0" style="font-size: 0.85rem;">
                    <?= $site_settings['copywrite_text'] ?>
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Scroll to top functionality
    document.addEventListener('DOMContentLoaded', function() {
        const scrollToTopButton = document.getElementById('scrollToTop');
        
        // Show button when user scrolls down 300px
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopButton.classList.add('show');
            } else {
                scrollToTopButton.classList.remove('show');
            }
        });
        
        // Scroll to top when clicked
        scrollToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>

</body>
</html>
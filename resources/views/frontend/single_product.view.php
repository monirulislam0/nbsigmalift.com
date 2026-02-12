<?php 
    $route = "/product/".strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $product['product_title']), '-'))."-".$product['id'];

    template_include("/frontend/partials/header",compact('page','route'));

?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "<?= $product['product_title'] ?>",
  "description": "<?= addslashes($product['short_description']) ?>",
  "image": "<?= assets('/uploads/'.$product['product_thumbnail']) ?>",
  "brand": {
    "@type": "Brand",
    "name": "NINGBO SIGMA"
  },
  "sku": "<?= addslashes($product['product_model']) ?>",
  "productID": "<?= $product['id'] ?>",
  "url": "<?= $route ?>",
  
  "offers": {
    "@type": "Offer",
    "url": "<?= $route ?>",
    "priceCurrency": "USD",
    "price": "10000",
    "priceValidUntil": "2025-12-31",  // Example date
    "availability": "https://schema.org/InStock",
    "seller": {
      "@type": "Organization",
      "name": "NINGBO SIGMA Elevator CO., LTD."
    },
    "shippingDetails": {
      "@type": "OfferShippingDetails",
      "shippingMethod": "https://schema.org/SeaCargo",
      "shippingDestination": {
        "@type": "DefinedRegion",
        "name": "Worldwide"  // Shipping destination (e.g., worldwide or specific regions)
      }
    }
  },

  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "reviewCount": "150"  
  },

  "review": [
    {
      "@type": "Review",
      "author": {
        "@type": "Person",
        "name": "Mr. Miah"  // Review author name (use actual name from database)
      },
      "reviewRating": {
        "@type": "Rating",
        "ratingValue": "5",
        "bestRating": "5",
        "worstRating": "0"
      },
      "reviewBody": "This is a great product! Highly recommend it."
    }
  ]
}
</script>


<style>
    .p-4{
        padding: 0px !important;
    }
    /* Added styles for smaller buttons */
    .btn-compact {
        padding: 0.375rem 0.75rem !important;
        font-size: 0.875rem !important;
    }
    .social-btn-sm {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.75rem !important;
    }
    /* Fix for inquiry form alignment */
    #inquiry-section {
        scroll-margin-top: 30px; /* Add space above when scrolling to section */
        padding-top: 30px; /* Add padding to the top of the section */
    }
    /* Image container */
    .thumbnail-image {
        min-height:380px; 
        width: 100%;
        background-color: rgba(0,0,0,0.15);
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center center;
        cursor: pointer;
    }
    
    /* Lightbox/modal styles */
    .image-lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 2000;
        cursor: pointer;
    }
    
    .lightbox-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 90%;
        max-height: 90%;
        overflow: auto;
    }
    
    .lightbox-image {
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
    }
    
    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 20px;
        color: white;
        font-size: 30px;
        cursor: pointer;
        z-index: 2001;
    }
</style>
 <!-- Product Section -->
 <div class="container py-5" style="padding-bottom:0px !important;">
        <div class="row">
                <div class="col-md-3">
                <!-- Vertical Navigation Menu -->
                <div class="nav flex-column nav-pills" aria-orientation="vertical">
                    <style>
                        .category_active{
                            border-bottom: 2px solid #0d6efd;
                            border-radius: 0px !important;
                        }
                    </style>
                    <a class="nav-link active" href="#">Categories</a>
                    <?php
                        foreach($categoreis as $category):
                    ?>
                    <a class="nav-link <?= $category['id'] == $product['product_category'] ? 'category_active' : '' ?>" href="/products-categories/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $category['category_name']), '-'))."-".$category['id'] ?>"><?= $category['category_name'] ?></a>
                    <?php 
                        endforeach;
                    ?>
                </div>
                </div>
                <div class="col-md-4">
                        <div class="card">
                            <!-- UPDATED: Main thumbnail now calls openLightbox() without parameters -->
                            <div class="thumbnail-image" 
                                 style="background-image: url('<?= assets("/uploads/".$product['product_thumbnail']) ?>');"
                                 id="thumb_image"
                                 onclick="openLightbox()">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <style>
                            
                            .box {
                              position: relative;
                              width: 80px;
                              height: 80px;
                              background: #fff;
                              box-shadow:  0 2px 8px rgb(0 0 0 / 57%);
                              overflow: hidden;
                              cursor: pointer;
                              transition: transform .2s;
                            }
                        
                            /* your product image */
                            .box img {
                              display: block;
                              width: 100%;
                              height: 100%;
                              object-fit: cover;
                            }
                        
                            /* SVG border overlay */
                            .box svg {
                              position: absolute;
                              top: 0; left: 0;
                              width: 100%; height: 100%;
                              pointer-events: none;       /* let clicks pass through */
                              transform: rotate(-90deg);
                            }
                        
                            .box rect {
                              fill: none;
                              stroke: #007BFF;
                              stroke-width: 4;
                              stroke-dasharray: 480;
                              stroke-dashoffset: 480;
                              transition: none;
                            }
                        
                            .box:hover {
                              transform: scale(1.05);
                            }
                            .box:hover rect {
                              animation: draw 0.3s forwards ease-in-out;
                            }
                        
                            @keyframes draw {
                              to { stroke-dashoffset: 0; }
                            }
                          </style>
                            
                            <div class="row">
                            <?php 
                                    $unserial = unserialize($product['product_galleries']);
                                    if(! $unserial){
                                        $unserial = [];
                                    }
                                    foreach($unserial as $image):
                                ?>
                            <div class="col-3">
                                <!-- Gallery thumbnails - NO lightbox here -->
                                <div class="box">
                                  <img src="<?= assets("/uploads/".$image) ?>" alt="Product 1" 
                                       onclick="changeImage('<?= assets("/uploads/".$image) ?>')">
                                  <svg viewBox="0 0 120 120">
                                    <rect x="2" y="2" width="116" height="116" rx="8" ry="8"/>
                                  </svg>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            </div>
                        </div>
                </div>
            <!-- Product Details -->
            <div class="col-md-5">
                <h1 class="fw-bold text-primary" style="font-size: 20px;"><?= $product['product_title'] ?></h1>
                <p class="text-muted">Model: <?= $product['product_model'] ?></p>

                <p class="mt-4"> <?= $product['short_description']?></p>

               

                <!-- Catalog Button - UPDATED PATH -->
                <a href="<?= assets('/frontend/media/nbsigma-elevator-catalogue.pdf')?>" 
                class="btn btn-primary btn-compact mt-4" target="_blank" 
                rel="noopener noreferrer">Catalog <i class="fas fa-download ms-2 fs-6"></i></a>
                
                <!-- Inquiry Button -->
                <a href="#inquiry-section" class="btn btn-primary btn-compact mt-4">Send Inquiry</a>
                
                <!--Share On Social Media-->
                    <style>
                        .btn-facebook { background-color: #1877F2; color: white; }
                        .btn-instagram { background: #E4405F; color: white; }
                        .btn-twitter { background: #1DA1F2; color: white; }
                        .btn-pinterest { background: #BD081C; color: white; }
                
                        .btn-facebook:hover { background-color: #1877F2; }
                        .btn-instagram:hover { background: #C13584; }
                        .btn-twitter:hover { background: #0C85D0; }
                        .btn-pinterest:hover { background: #8C0615; }
                    </style>
                   <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s); js.id = id;
                    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                    fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                    
                    <!-- Your share button code -->
                    
                <div class="container  mt-5">
                    <h2 style="font-size: 16px; font-weight: bold">Share this Post</h2>
                    <div class="d-flex justify-content-left gap-2 mt-3">
                        <a href="#"  class="btn btn-facebook social-btn-sm" id="facebookShare">
                            <div class="fb-share-button" 
                            data-href="<?= $route ?>" 
                            data-layout="button">
                            </div>
                        </a>
                        <a href="https://instagram.com/create/story?media_url=<?= rtrim(getenv('SITE_URL'),'/').'/uploads/'.$product['product_thumbnail'] ?>" target="_blank"" target="_blank" class="btn btn-instagram social-btn-sm">
                            <i class="fab fa-instagram"></i> Share
                        </a>
                        <a href="void:0;" target="_blank" class="btn btn-twitter social-btn-sm" onclick="shareOnX()">
                            <i class="fab fa-twitter"></i> Tweet
                        </a>
                        <?php 
                            $base_url = rtrim(getenv('SITE_URL'), '/');
                        ?>
                        <a href="https://pinterest.com/pin/create/button/?url=<?= $base_url.'/'.$route?>&media=<?= $base_url.'/uploads/'.$product['product_thumbnail']?>&description=<?= $product['og_description'] ?? $product['short_description'] ?>" data-pin-do="buttonPin" data-pin-config="above" target="_blank" class="btn btn-pinterest social-btn-sm">
                            <i class="fab fa-pinterest"></i> Pin
                        </a>
                    </div>
                </div>

            <script async defer src="https://assets.pinterest.com/js/pinit.js"></script>
                <!--Share on Social Media -->
                

                <script>
                  function shareOnX() {
                    var url = encodeURIComponent(window.location.href);
                    var text = encodeURIComponent(document.title);
                    window.open('https://twitter.com/intent/tweet?url=' + url + '&text=' + text, '_blank');
                  }
                </script>
               
            </div>
        </div>
    </div>
    <div class="container py-0">
        <div class="row">
            <div class="col-md-3"></div>
            <style>
                .p-5 img{
                    width:100% !important;
                }
            </style>
            <div class="col-md-9" style="overflow:hidden;">
                <h2 class="fw-bold text-primary">
                    Product Details
                </h2>
                <hr class="hr">
                <div class="p-4">
                 <?= $product['long_description'] ?>
                </div>
                <?php 
             $faqs = \app\http\models\Faq::where($product['id'],'product_id')->get();
                if(count($faqs)):
            ?>
            <h2>Q/A: Elevator Industry Insights</h2>
            <?php endif; ?>
            
            
            <!--Implementation Faqs-->
             <style>
                .faq-container {
                  width: 80%;
                  margin-top: 50px;
                  margin-bottom: 50px;
                  font-family: Arial, sans-serif;
                }
            
                .faq-item {
                  border-bottom: 1px solid #0d6efd;
                  padding: 15px 0;
                  position: relative;
                }
            
                .faq-question {
                  display: flex;
                  justify-content: space-between;
                  cursor: pointer;
                  font-weight: bold;
                  font-size: 18px;
                }
            
                .faq-toggle {
                  font-size: 22px;
                  transition: transform 0.3s ease;
                }
            
                .faq-item.active .faq-toggle {
                  transform: rotate(45deg);
                }
            
                .faq-answer {
                  display: none;
                  padding: 10px 0;
                  font-size: 16px;
                  color: #333;
                }
            
                .faq-item.active .faq-answer {
                  display: block;
                }
            
                .faq-actions {
                  margin-top: 10px;
                }
            
                .faq-actions button {
                  margin-right: 10px;
                  padding: 5px 10px;
                  font-size: 14px;
                }
            
                .add-btn {
                  display: block;
                  margin: 20px auto;
                  padding: 10px 20px;
                  font-size: 16px;
                }
              </style>
              
            <div class="faq-container" id="faqList">
            <?php
                
                foreach($faqs as $faq):
            ?>
              <div class="faq-item" data-id="1">
                    <div class="faq-question">
                      <span class="faq-title"><?= $faq['question']?> </span>
                      <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                     <?= $faq['answer']?> 
                    </div>
              </div>
            <?php endforeach; ?>
            </div>
            <script>
              document.addEventListener('DOMContentLoaded', function () {
                const faqContainer = document.getElementById('faqList');
            
                faqContainer.addEventListener('click', function (e) {
                  const questionEl = e.target.closest('.faq-question');
                  if (questionEl) {
                    const clickedItem = questionEl.parentElement;
            
                    faqContainer.querySelectorAll('.faq-item').forEach(item => {
                      if (item !== clickedItem) {
                        item.classList.remove('active');
                      }
                    });
            
                    clickedItem.classList.toggle('active');
                    return;
                  }
            
                });
              });
            
            
            </script>
            
            <!--Implementations Faqs Ends-->
                
                
            </div>
        </div>
    </div>
    
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="fw-bold text-primary" style="font-size: 22px; font-weight: 500;">
    Related Products
</h3>

            <hr class="hr">
            <style>
                .related-products .product-image-container {
                    height: 100px;
                    width: 100%;
                    background-color: rgba(0,0,0,0.15);
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center center;
                    margin: 0 auto;
                }
                .related-products .product-title {
                    font-size: 0.9rem;
                    height: 2.8em; /* Exactly 2 lines height */
                    overflow: hidden;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    line-height: 1.4;
                    margin-bottom: 0;
                }
            </style>
            <div class="row mb-5 product-list related-products">
                <?php 
                    foreach($related_products as $rows => $rel_product):
                        if(12 == $rows ) break;
                ?>
                <div class="col-md-2 mb-4 product-item">
                    <a href="/product/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $rel_product['product_title']), '-'))."-".$rel_product['id'] ?>">
                        <div class="card h-100">
                            <div class="product-image-container" 
                                 style="background-image: url('<?= assets("/uploads/".$rel_product['product_thumbnail']) ?>');">
                            </div>
                            <div class="card-body p-2 text-center">
                                <p class="card-title product-title"><?= $rel_product['product_title'] ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
    <!-- Quote Form Section - UPDATED -->
    <div id="inquiry-section" name="inquiry-section" class="container py-5 bg-light">
            <h3 class="text-primary" style="font-size: 22px; font-weight: 510;">Send Inquiry</h3>



                <hr class="hr">
                <div>
                    <?php if(session_get('message')):?>
                        <p style="padding:7px; background-color: green; color: white; "><?= session_get('message')?></p>
                    <?php endif; ?>
                </div>

        <!-- UPDATED FORM ACTION WITH ANCHOR -->
        <form action="/admin/contact-us/store#inquiry-section" id="query_form" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <?php if(error('name')): ?>
                    <p class="text-danger"> <?= error('name') ?></p>
                <?php endif; ?>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your full name" >
            </div>
            <div class="mb-3">
            <?php if(error('email')): ?>
                    <p class="text-danger"> <?= error('email') ?></p>
                <?php endif; ?>
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email">
            </div>
            <div class="mb-3">
            <?php if(error('message')): ?>
                    <p class="text-danger"> <?= error('message') ?></p>
                <?php endif; ?>
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" rows="5" placeholder="Enter your message" name="message"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-compact">Submit</button>
        </form>
    </div>
    
    <!-- Lightbox/modal for viewing images -->
    <div id="imageLightbox" class="image-lightbox">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <div class="lightbox-content">
            <img id="lightboxImage" class="lightbox-image" src="" alt="Product image">
        </div>
    </div>
    
    <script>
        // Function to change the main image when a thumbnail is clicked
        function changeImage(imgUrl) {
            document.getElementById("thumb_image").style.backgroundImage = "url('" + imgUrl + "')";
        }
        
        // UPDATED: Function to open the lightbox with current thumbnail
        function openLightbox() {
            const thumb = document.getElementById("thumb_image");
            // Extract URL from CSS background property
            const bgImage = thumb.style.backgroundImage;
            const imgUrl = bgImage.replace(/url\(['"]?/, '').replace(/['"]?\)/, '');
            
            const lightbox = document.getElementById('imageLightbox');
            const lightboxImg = document.getElementById('lightboxImage');
            
            lightboxImg.src = imgUrl;
            lightbox.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        // Function to close the lightbox
        function closeLightbox() {
            document.getElementById('imageLightbox').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        // Close lightbox when clicking anywhere
        document.getElementById('imageLightbox').addEventListener('click', function(e) {
            closeLightbox();
        });
        
        // Close lightbox with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
        
        // Prevent clicks on the image from closing the lightbox
        document.getElementById('lightboxImage').addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>
<?php 

    template_include("/frontend/partials/footer");

?>
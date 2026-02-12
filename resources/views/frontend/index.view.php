<?php 
// Fix: Pass the meta description through $page array to match header expectations
$page['meta_description'] = "NINGBO SIGMA ELEVATOR COMPANY LIMITED, A Leading elevator manufacturer & global exporter of lifts/elevators
for residential, commercial, and industrial needs.";

template_include("/frontend/partials/header", compact('page'));
?>

<!-- Bootstrap Carousel -->
<style>
    .carousel-indicators {
        display: none;
    }
</style>
<div id="HayashimuCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?= assets("/uploads/".$sliders[0]['slider_image']) ?>" class="d-block w-100" alt="<?= $slides[0]['alternative_text'] ?>">
        </div>
        <?php 
          foreach($sliders as $keys => $slide):
            if(0 == $keys) continue;
        ?>
        <div class="carousel-item">
            <img src="<?= assets("/uploads/".$slide['slider_image']) ?>" class="d-block w-100" alt="<?= $slide['alternative_text'] ?>">
        </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#HayashimuCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#HayashimuCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<script>
    // Automatically change carousel every 4 second
    var myCarousel = document.getElementById('HayashimuCarousel');
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 4000, // Change slide every 4 second
        ride: 'carousel' // Enable automatic slide transition
    });
</script>
<!-- Slider End -->
<!-- Product Categories -->
<div class="container">
    <h1 class="text-center my-4" style="font-size: 22px;font-weight: 700;text-decoration: underline;">Category of Products</h1>
    <div class="row">
        <?php 
            $categories = \app\http\models\Categories::all()->get();
            foreach($categories as $key => $category):
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mt-2">
            <a href="/products-categories/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $category['category_name']), '-'))."-".$category['id'] ?>">
                <div class="card border-0" style="width:100%; height: auto;">
                    <div style="
                        height: 240px; 
                        width: 100%;
                        background-color: rgba(0,0,0,0.15);
                        background-image: url('<?= assets("/uploads/".$category['category_image'])?>');
                        background-size: contain;
                        background-repeat: no-repeat;
                        background-position: center center;
                    "></div>
                    <div class="card-body">
                        <a href="/products-categories/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $category['category_name']), '-'))."-".$category['id'] ?>" style="text-decoration: none;" class="card-text text-center text-black">
                            <p class="card-text text-center"><?= $category['category_name']?></p>
                        </a>
                    </div>
                </div>
            </a>
        </div>
        <?php 
            if($key == 7) break;
        endforeach; ?>
    </div>
</div>

<!-- Top Products -->
<div class="container">
    <h2 class="text-center my-4" style="font-size: 22px; font-weight:700;text-decoration: underline;">Top Products</h2>
    <div class="row">
        <?php 
            $products = \app\http\models\Products::where(1, 'trending')->get();
            foreach($products as $key => $product):
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mt-2">
            <a href="/product/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $product['product_title']), '-'))."-".$product['id'] ?>">
                <div class="card border-0" style="width:100%; height: auto;">
                    <div style="
                        height: 350px; 
                        width: 100%;
                        background-color: rgba(0,0,0,0.15);
                        background-image: url('<?= assets("/uploads/".$product['product_thumbnail'])?>');
                        background-size: contain;
                        background-repeat: no-repeat;
                        background-position: center center;
                    "></div>
                    <div class="card-body">
                        <a href="/product/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $product['product_title']), '-'))."-".$product['id'] ?>" style="text-decoration: none;" class="card-text text-left text-black"> 
                            <p class="card-text"><?= substr($product['product_title'], 0, 30)."...." ?></p>
                        </a>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Why Choose Us Section -->
<style>
    .benefits-section {
        padding: 80px 0;
        background: #ffffff;
    }
    
    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .section-title h2 {
        font-size: 2.2rem;
        color: #000000;
        position: relative;
        display: inline-block;
        padding-bottom: 15px;
    }
    
    .section-title h2:after {
        content: '';
        position: absolute;
        width: 70px;
        height: 3px;
        background: #3498db;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .benefits-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }
    
    .benefit-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .benefit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .benefit-icon {
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
        color: white;
        font-size: 3rem;
    }
    
    .benefit-content {
        padding: 25px;
    }
    
    .benefit-content h3 {
        color: #000000;
        margin-bottom: 15px;
        font-size: 1.4rem;
    }
    
    .benefit-content p {
        color: #000000;
        line-height: 1.6;
    }
    
    .stats-container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        margin: 50px 0;
        text-align: center;
    }
    
    .stat-box {
        padding: 20px;
        min-width: 200px;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #000000;
        margin-bottom: 5px;
    }
    
    .stat-label {
        color: #000000;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>

<section class="benefits-section">
    <div class="container">
        <div class="section-title">
            <h2 style="font-size: 26px;font-weight: 700;color: #000000;">NINGBO SIGMA ELEVATOR COMPANY LIMITED</h2>
        </div>
        
        <div class="benefits-container">
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="benefit-content">
                    <h3 style="font-weight: bold; font-size: 20px;">Advanced Technology</h3>
                    <p>We integrate cutting-edge technology in all our elevator systems, ensuring smart operation, energy efficiency and superior performance.</p>
                </div>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="benefit-content">
                    <h3 style="font-weight: bold; font-size: 20px;">Quality Assurance</h3>
                    <p>Fully certified to EN 81-20, EN 81-50, and EN 115 standards, with all critical components—motors, controllers, safety systems, and cables</p>
                </div>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="benefit-content">
                    <h3 style="font-weight: bold; font-size: 20px;">Global Standards</h3>
                    <p>All our products meet international quality and safety standards, with certifications for operation in multiple countries worldwide.</p>
                </div>
            </div>
        </div>
        
        <div class="stats-container">
            <div class="stat-box">
                <div class="stat-number">22+</div>
                <div class="stat-label">Years Experience</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">60+</div>
                <div class="stat-label">Expert Engineers</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">25+</div>
                <div class="stat-label">Countries Served</div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <p style="max-width: 800px; margin: 0 auto; color: #000000; line-height: 1.7;">
                NINGBO SIGMA ELEVATOR COMPANY LIMITED is a leading elevator manufacturer based in Ningbo, Zhejiang, China. Founded with a
                strategic focus on global expansion, the company combines cutting-edge technology, advanced manufacturing practices, and a 
                commitment to customization to deliver superior elevator solutions worldwide. Zhejiang province, a hub for elevator manufacturing, 
                provides a robust ecosystem of suppliers, technical expertise, and innovation, positioning Ningbo Sigma as a key player in China's 
                elevator industry.
            </p>
        </div>
    </div>
</section>

<!-- Latest Blog Section -->
<div class="container">
    <h2 class="text-center my-4" style="font-size: 22px; font-weight:700;text-decoration: underline;">Blogs</h2>
    <div class="row">
        <?php 
        $news = \app\http\models\News::where(1,'featured')->get();
        foreach($news as $key => $item):
        ?>
        <div class="col-md-3 news-item mb-4">
            <a href="/blog/<?= makeSlug($item['news_title'])."-".$item['id'] ?>" style="display: block; position: relative; height: 300px; overflow: hidden;">
                <div style="
                    height: 100%; 
                    width: 100%;
                    background-color: rgba(0,0,0,0.15);
                    background-image: url('<?= assets("/uploads/".$item['news_image'])?>');
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center center;
                    transition: all 0.4s ease;
                " class="news-image-hover"></div>
                
                <!-- Date at top -->
                <div style="
                    position: absolute;
                    top: 15px;
                    left: 15px;
                    background-color: rgba(0,0,0,0.7);
                    color: white;
                    padding: 5px 10px;
                    font-size: 12px;
                    border-radius: 3px;
                ">
                    <?= date('d M, Y', strtotime($item['date_time'])) ?>
                </div>
                
                <!-- Title at bottom with transparent background -->
                <div style="
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    padding: 15px;
                    background-color: rgba(0,0,0,0.6);
                ">
                    <p style="
                        margin: 0;
                        font-size: 16px;
                        font-weight: bold;
                        color: white;
                        display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        min-height: 2.8em;
                    "><?= substr($item['news_title'],0,100)?></p>
                </div>
            </a>
            <div class="text-center mt-2">
                <a href="/blog/<?= makeSlug($item['news_title'])."-".$item['id'] ?>" class="btn btn-primary btn-sm">Read more</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-5">
        <a href="/blog" class="btn btn-secondary">View All Blogs</a>
    </div>
</div>

<style>
    .news-item:hover .news-image-hover {
        transform: scale(1.05);
        filter: brightness(0.9);
    }
    
    .news-item:hover .btn-primary {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
<?php 
template_include("/frontend/partials/footer");
?>
<?php 
// Initialize page variables
$route = '/products';
template_include("/frontend/partials/header", compact('page','route'));
?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "<?= $baseUrl . '/' ?>"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Products",
      "item": "<?= $baseUrl . '/products' ?>"
    }
  ]
}
</script>


<!-- Shop Page -->
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="nav flex-column nav-pills" aria-orientation="vertical">
                <a class="nav-link active" href="#">Categories</a>
                <?php
                    $categories = \app\http\models\Categories::all()->get();
                    foreach($categories as $category):
                ?>
                <a class="nav-link" href="/products-categories/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $category['category_name']), '-'))."-".$category['id'] ?>"><?= $category['category_name'] ?></a>
                <?php 
                    endforeach;
                ?>
            </div>
        </div>
        
        <!-- Products Section -->
        <div class="col-md-9">
            <!-- Only changed the H1 tag style -->
            <h1 class="p-3" style="font-size: 22px; border-bottom: 2px solid #0d6efd; display: inline-block; padding-bottom: 10px; margin-bottom: 20px;">Products</h1>
            
            <style>
                .product-card {
                    height: 100%;
                }
                .product-image {
                    height: 200px; /* Reduced height */
                    width: 100%;
                    background-color: rgba(0,0,0,0.15);
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center center;
                }
                .product-title {
                    font-size: 0.9rem;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    margin-bottom: 0.5rem;
                    text-align: center;
                    font-weight: bold;
                }
            </style>
            <div class="row" id="product-list">
                <?php foreach($products as $product): ?>
                <!-- Product Cards - 4 per row -->
                <div class="col-md-3 mb-4 product-item" data-category="electronics">
                    <a style="text-decoration:none;" href="/product/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $product['product_title']), '-'))."-".$product['id'] ?>">
                        <div class="card product-card">
                            <div class="product-image" 
                                 style="background-image: url('<?= assets("/uploads/".$product['product_thumbnail'])?>');">
                            </div>
                            <div class="card-body p-2">
                                <p class="product-title"><?= $product['product_title'] ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Pagination -->
        <style>
            .pagination {
                justify-content: center;
                margin-top: 20px;
            }
            .page-item.active .page-link {
                background-color: #007bff;
                border-color: #007bff;
            }
            .page-link {
                border-radius: 50px;
                padding: 10px 20px;
                font-size: 16px;
            }
            .page-item:hover .page-link {
                background-color: #e9ecef;
            }
            .page-item:first-child .page-link,
            .page-item:last-child .page-link {
                padding: 10px 16px;
            }
        </style>
        <?php if(count($products)): ?>
        <div class="col-md-9 offset-md-3"> <!-- Offset to align with products -->
            <div class="py-5">
                <nav>
                    <ul class="pagination">
                        <?php $pageNumbers = $_GET['page'] ?? 1; ?>
                        <!--<li class="page-item <?= $pageNumbers > 1 ? '' : 'disabled' ?>">-->
                        <!--    <a class="page-link" href="/products?page=<?= $pageNumbers - 1 ?>" tabindex="-1" aria-disabled="true">Previous</a>-->
                        <!--</li>-->
                        <li class="page-item <?= $pageNumbers == 1 ? 'active' : '' ?> ">
                            <a class="page-link" href="/products">1</a>
                        </li>
                        <?php for($i = 2; $i <= $rows ; $i++): ?>
                            <li class="page-item <?= $pageNumbers == $i ? 'active' : '' ?>">
                                <a class="page-link" href="products?page=<?= $i?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <!--<li class="page-item <?= $pageNumbers == $rows ? 'disabled' : '' ?>">-->
                        <!--    <a class="page-link" href="/products?page=<?= $pageNumbers + 1 ?>">Next</a>-->
                        <!--</li>-->
                    </ul>
                </nav>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php template_include("/frontend/partials/footer"); ?>
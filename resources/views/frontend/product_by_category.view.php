<?php 
    template_include("/frontend/partials/header");
?>

<style>
    /* Added title styling */
    .page-title {
        font-size: 22px;
        font-weight: 600;
        color: #000000;
        border-bottom: 2px solid #0d6efd;
        padding-bottom: 10px;
        display: inline-block;
        margin: 15px 0 25px 0;
        letter-spacing: 0.5px;
    }
    
    /* Added model number styling */
    .product-model {
        font-size: 0.8rem;
        color: #666;
        text-align: center;
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<!-- Shop Page -->
<div class="container py-5">
    <div class="row">
        <!-- Categories Sidebar -->
        <div class="col-md-3">
            <div class="nav flex-column nav-pills" aria-orientation="vertical">
                <a class="nav-link active" href="#">Categories</a>
                 <style>
                        .category_active {
                            border-bottom: 2px solid #0d6efd;
                            border-radius: 0px !important;
                        }
                </style>
                <?php
                    $categories = \app\http\models\Categories::all()->get();
                    foreach($categories as $category):
                ?>
                <a class="nav-link <?= $category['id'] == $searched['id'] ? 'category_active' : '' ?>" href="/products-categories/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $category['category_name']), '-'))."-".$category['id'] ?>"><?= $category['category_name'] ?></a>
                <?php endforeach; ?>
            </div>
        </div>
          
        <!-- Products Section -->
        <div class="col-md-9">
            <!-- Updated to H1 with styling -->
            <h1 class="page-title">"<?= $searched['category_name'] ?? $searched['subcategory_name'] ?>"</h1>
            
            <style>
                .product-card {
                    height: 100%;
                }
                .product-image {
                    height: 200px;
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
                    margin-bottom: 0.2rem; /* Reduced for model number */
                    text-align: center;
                    font-weight: bold;
                }
            </style>
            
            <div class="row" id="product-list">
                <?php if(empty($products)): ?>
                    <h2 class="p-3">No Products Found !</h2>
                <?php else: ?>
                    <!-- Products will be rendered by JavaScript -->
                <?php endif; ?>
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
        <div class="col-md-9 offset-md-3">
            <div class="py-5">
                <nav>
                    <ul class="pagination" id="pagination-controls">
                        <!-- Pagination will be rendered by JavaScript -->
                    </ul>
                </nav>
            </div>
        </div>
        
        <script>
            let arr = <?php echo json_encode($products); ?> 
            const itemsPerPage = 16;
            const itemList = document.getElementById('product-list');
            const paginationControls = document.getElementById('pagination-controls');
            
            const totalPages = Math.ceil(arr.length / itemsPerPage);
            let currentPage = 1;
            
            function renderItems(page) {
                itemList.innerHTML = '';
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
            
                const currentItems = arr.slice(start, end);
                currentItems.forEach(item => {
                    const div = document.createElement('div');
                    div.classList.add('col-md-3', 'mb-4', 'product-item');
                    
                    const a = document.createElement('a');
                    a.style.textDecoration = "none";
                    a.style.color = "inherit";
                    a.setAttribute('href', generateProductUrl(item));
                    
                    const card = document.createElement('div');
                    card.classList.add('card', 'product-card');
                    
                    const productImage = document.createElement('div');
                    productImage.classList.add('product-image');
                    const basePath = <?= json_encode(assets('/uploads/')) ?>;
                    productImage.style.backgroundImage = `url(${basePath}${item.product_thumbnail})`;
                    
                    const cardBody = document.createElement('div');
                    cardBody.classList.add('card-body', 'p-2');
                    
                    const title = document.createElement('p');
                    title.classList.add("product-title");
                    title.innerText = item.product_title;
                    
                    // Add model number if it exists
                    if(item.model_number) {
                        const model = document.createElement('p');
                        model.classList.add("product-model");
                        model.innerText = `Model: ${item.model_number}`;
                        cardBody.appendChild(model);
                    }
                    
                    cardBody.appendChild(title);
                    card.appendChild(productImage);
                    card.appendChild(cardBody);
                    a.appendChild(card);
                    div.appendChild(a);
                    
                    itemList.appendChild(div);
                });
            }
            
            function generateProductUrl(item) {
                const slug = item.product_title
                    .replace(/[\/\s]+/g, '-')
                    .replace(/-+$/, '')
                    .toLowerCase();
                return `/product/${slug}-${item.id}`;
            }
            
            function renderPagination() {
                paginationControls.innerHTML = '';
                
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.classList.add("page-item");
                    if (i === currentPage) li.classList.add("active");
                    
                    const a = document.createElement('a');
                    a.classList.add("page-link");
                    a.textContent = i;
                    
                    a.addEventListener('click', (e) => {
                        e.preventDefault();
                        currentPage = i;
                        renderItems(currentPage);
                        renderPagination();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                    
                    li.appendChild(a);
                    paginationControls.appendChild(li);
                }
            }
            
            // Initialize
            if (arr.length > 0) {
                renderItems(currentPage);
                renderPagination();
            }
        </script>
    </div>
</div>

<?php 
    template_include("/frontend/partials/footer");
?>
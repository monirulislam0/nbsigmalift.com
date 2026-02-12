<?php 
    $route = '/products';
    template_include("/frontend/partials/header",compact('page','route'));
?>

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
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="col-md-9">
            <h4 class="p-3">You are searching for "<b><?= $search_key ?></b>"</h4>
            
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
                    margin-bottom: 0.5rem;
                    text-align: center;
                    font-weight: bold;
                }
            </style>
            
            <div class="row" id="product-list">
                <?php if(empty($products)): ?>
                    <h2 class="p-3">No Products Found for "<b><?= $search_key ?></b>"!</h2>
                <?php else: ?>
                    
                       
                    
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
                        <!--<li class="page-item">-->
                        <!--    <a class="page-link" href="/products?page" tabindex="-1">Previous</a>-->
                        <!--</li>-->
                            
                        <!--<li class="page-item?>">-->
                        <!--    <a class="page-link" href="/">Next</a>-->
                        <!--</li>-->
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
                        div.classList.add('col-md-3', 'mb-4', 'product-item')
                  const a = document.createElement('a')
                        a.style.textDecoration="none"
                         a.setAttribute('href',generateProductUrl(item) ) 
                  const div2 = document.createElement('div');
                         div2.classList.add('card', 'product-card');
                  const proudctImage = document.createElement('div');
                        proudctImage.classList.add('product-image');
                        const basePath = <?= json_encode(assets('/uploads/')) ?>;
                        proudctImage.style.backgroundImage = `url(${basePath}${item.product_thumbnail})`;
                 const cardBody = document.createElement('div');
                        cardBody.classList.add('card-body', 'p-2')
                 const paragraph = document.createElement('p');
                       paragraph.classList.add("product-title");
                       paragraph.innerText = item.product_title
                    cardBody.appendChild(paragraph);
                    div2.appendChild(proudctImage);
                    div2.appendChild(cardBody);
                    a.appendChild(div2);
                    div.appendChild(a);
                      
                  itemList.appendChild(div);
                });
              }
              
              function generateProductUrl(item) {
              const slug = item.product_title
                .replace(/[\/\s]+/g, '-')      // Replace spaces and slashes with hyphen
                .replace(/-+$/, '')            // Remove trailing hyphens
                .toLowerCase();                // Convert to lowercase
            
              return `/product/${slug}-${item.id}`;
            }
            

            
              function renderPagination() {
                paginationControls.innerHTML = '';
            
                for (let i = 1; i <= totalPages; i++) {
                  const li = document.createElement('li');
                //   li.textContent = i;
                  li.classList.add("page-item");
                  li.className = (i === currentPage) ? 'active' : '';
                //   li.style.display = 'inline-block';
                //   li.style.margin = '0 5px';
                  li.style.cursor = 'pointer';
                  const a = document.createElement('a');
                  a.classList.add("page-link");
                  a.textContent = i;
                  li.appendChild(a);
                  li.addEventListener('click', () => {
                    currentPage = i;
                    renderItems(currentPage);
                    renderPagination();
                  });
                  paginationControls.appendChild(li);
                }
              }
            
              // Initialize
              renderItems(currentPage);
              renderPagination();
        </script>
    </div>
</div>

<?php template_include("/frontend/partials/footer"); ?>
<?php 
    $route = "/news";
    template_include("/frontend/partials/header" ,compact('page','route'));
    template_include("/frontend/partials/banner",compact('page'));
?>

<style>
    /* Updated News Card Styles to match the reference implementation */
    .news-card {
        height: 100%;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border: 1px solid #eee;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .news-img {
        height: 300px;
        width: 100%;
        background-color: rgba(0,0,0,0.15);
        background-size: cover;
        background-position: center;
        position: relative;
        transition: all 0.4s ease;
    }
    .news-date {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: rgba(0,0,0,0.7);
        color: white;
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 3px;
    }
    .news-title {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 15px;
        background-color: rgba(0,0,0,0.6);
        color: white;
        font-size: 16px;
        font-weight: bold;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.8em;
    }
    
    /* Hover effects matching the reference code */
    .news-item:hover .news-img {
        transform: scale(1.05);
        filter: brightness(0.9);
    }
    
    /* Page title style */
    .page-title {
        font-size: 22px;
        font-weight: 600;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #0d6efd;
        padding-bottom: 10px;
        display: inline-block;
        margin-bottom: 20px;
        color: #0d6efd;
    }
    
    /* Pagination styles (unchanged) */
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
    
    /* Sidebar nav styles (unchanged) */
    .sidebar-nav {
        position: sticky;
        top: 100px;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .sidebar-nav .nav-link {
        color: #333;
        padding: 10px 15px;
        margin: 5px 0;
        border-radius: 5px;
        transition: all 0.3s;
    }
    .sidebar-nav .nav-link:hover,
    .sidebar-nav .nav-link.active {
        background: #0d6efd;
        color: white;
    }
</style>

<div class="container pt-5">
    <div class="row">
        <!-- Left Navigation (unchanged) -->
        <div class="col-md-3">
            <div class="nav flex-column nav-pills" aria-orientation="vertical">
                <a class="nav-link" href="/about">About</a>
                <a class="nav-link" href="/why-choose-us">Why Choose Us</a>
                <a class="nav-link" href="/factory-tours">Factory Tours</a>
                <a class="nav-link" href="/products">Products</a>
                <a class="nav-link" href="/distributor">Distributor</a>
                <a class="nav-link" href="/projects">Projects</a>
                <a class="nav-link active" href="/blog">Blog</a>
                <a class="nav-link" href="/faq">FAQs</a>
                <a class="nav-link" href="/contact-us">Contacts</a>
            </div>
        </div>
        
        <!-- News Grid -->
        <div class="col-lg-9">
            <h1 class="page-title">Elevator Industry Blog</h1>
            
            <div class="row" id="item-list">
            </div>
        </div>
        
        <!-- Pagination -->
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
            let arr = <?php echo json_encode($news); ?> 
            console.log(arr.length)
            const itemsPerPage = 15;
            const itemList = document.getElementById('item-list');
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
                    div.classList.add('col-md-6', 'col-xl-4', 'mb-4', 'news-item');
            
                    const div2 = document.createElement('div');
                    div2.classList.add('news-card');
                    div.appendChild(div2);
            
                    const a = document.createElement('a');
                    a.setAttribute('href', generateNewsUrl(item.news_title, item.id));
                    a.style.display = 'block';
                    a.style.position = 'relative';
                    a.style.height = '300px';
                    a.style.overflow = 'hidden';
                    
                    // Image container
                    const divBackground = document.createElement('div');
                    divBackground.classList.add('news-img');
                    divBackground.style.backgroundImage = `url(${<?= json_encode(assets('/uploads/')) ?>}${item.news_image})`;
                    a.appendChild(divBackground);
            
                    // Date element
                    const newsDate = document.createElement('div');
                    newsDate.classList.add('news-date');
                    
                    const icon = document.createElement('i');
                    icon.classList.add('far', 'fa-calendar', 'me-2');
                    newsDate.appendChild(icon);
            
                    // Format date to: 19 Jun, 2025
                    const dateString = item.date_time;
                    const date = new Date(dateString);
                    const formattedDate = date.toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    }).replace(/ /g, ' ').replace(' ', ', ');
                    
                    const spanDate = document.createElement('span');
                    spanDate.textContent = formattedDate;
                    newsDate.appendChild(spanDate);
                    a.appendChild(newsDate);
            
                    // Title element
                    const titleDiv = document.createElement('div');
                    titleDiv.style.position = 'absolute';
                    titleDiv.style.bottom = '0';
                    titleDiv.style.left = '0';
                    titleDiv.style.right = '0';
                    titleDiv.style.padding = '15px';
                    titleDiv.style.backgroundColor = 'rgba(0,0,0,0.6)';
                    
                    const h3 = document.createElement("p");
                    h3.style.margin = '0';
                    h3.style.fontSize = '16px';
                    h3.style.fontWeight = 'bold';
                    h3.style.color = 'white';
                    h3.style.display = '-webkit-box';
                    h3.style.webkitLineClamp = '2';
                    h3.style.webkitBoxOrient = 'vertical';
                    h3.style.overflow = 'hidden';
                    h3.style.minHeight = '2.8em';
                    h3.textContent = item.news_title;
                    
                    titleDiv.appendChild(h3);
                    a.appendChild(titleDiv);
                    
                    div2.appendChild(a);
                    itemList.appendChild(div);
                });
            }
            
            function generateNewsUrl(str, id) {
                str = str.toLowerCase();
                str = str.replace(/<\/?[^>]+(>|$)/g, "");
                str = str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                str = str.replace(/[^a-z0-9\s-]/g, "");
                str = str.replace(/[\s-]+/g, "-");
                str = str.replace(/^-+|-+$/g, "");
                return `/blog/${str}-${id}`;
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

<?php template_include("/frontend/partials/footer"); ?>
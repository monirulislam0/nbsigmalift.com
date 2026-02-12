<?php 
$route = "/projects";
template_include("/frontend/partials/header" ,compact('page','route'));
template_include("/frontend/partials/banner",compact('page'));
?>

<div class="p-3"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="nav flex-column nav-pills" aria-orientation="vertical">
                <a class="nav-link " href="/about">About</a>
                <a class="nav-link" href="/why-choose-us">Why Choose Us</a>
                <a class="nav-link" href="/factory-tours">Factory Tours</a>
                <a class="nav-link" href="/products">Products</a>
                <a class="nav-link" href="/distributor">Distributor</a>
                <a class="nav-link active" href="/projects">Projects</a>
                <a class="nav-link" href="/blog">Blog</a>
                <a class="nav-link" href="/faq">FAQs</a>
                <a class="nav-link" href="/contact-us">Contacts</a>
            </div>
        </div>
        
        <div class="col-md-9">
            <!-- Page Title Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="page-title fw-bold text-primary mb-4" style="font-size: 22px;">Completed Projects</h1>
                </div>
            </div>
            
            <div class="row" id="item-list">
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
                            <p>Test</p>
                            <!-- Pagination will be rendered by JavaScript -->
                        </ul>
                    </nav>
                </div>
            </div>
            <script>
                let arr = <?php echo json_encode($projects); ?> 
                console.log(arr.length)
                const itemsPerPage = 12;
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
                              div.classList.add('col-md-4', 'mb-4');
                        const div2 = document.createElement('div');
                              div2.classList.add('project-card', 'border-0' ,'rounded', 'overflow-hidden' ,'h-100');
                        const divBackground = document.createElement('div');
                              divBackground.classList.add('position-relative');
                              divBackground.style.height = '220px';
                              divBackground.style.backgroundColor = '#f8f9fa';
                        const basePath = <?= json_encode(assets('/uploads/')) ?>;
                              divBackground.style.backgroundImage = `url(${basePath}${item.project_image})`;
                              divBackground.style.backgroundSize = 'contain'; // Changed from 'cover' to 'contain'
                              divBackground.style.backgroundPosition = 'center';
                              divBackground.style.backgroundRepeat = 'no-repeat'; // Added to prevent repeating
                              divBackground.style.overflow = 'hidden';
                        
                        // Create title container below the image
                        const titleContainer = document.createElement('div');
                              titleContainer.classList.add('project-title-container', 'p-3');
                        const h5 = document.createElement("h5");
                              h5.classList.add('project-title', 'mb-0', 'text-center');
                              h5.textContent  = item.location;
                              
                        div2.appendChild(divBackground);
                        div2.appendChild(titleContainer);
                        titleContainer.appendChild(h5);
                        div.appendChild(div2);
                        itemList.appendChild(div);
                        
                    });
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

<style>
.page-title {
    letter-spacing: 0.5px;
    font-weight: 600;
    border-bottom: 2px solid #0d6efd;
    padding-bottom: 10px;
    display: inline-block;
}

/* Clean project card style */
.project-card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    border: 1px solid #eaeaea;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.1);
}

/* Project title style */
.project-title-container {
    background: white;
    border-top: none;
}

.project-title {
    font-size: 16px;
    font-weight: 700;
    color: #000;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Ensure proper image display */
.position-relative {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<?php 
    template_include("/frontend/partials/footer");
?>
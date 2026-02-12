<div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Site Options</div>
                            <a class="nav-link" href="/admin/site/settings">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Site Settings
                            </a>
                            <a class="nav-link" href="/admin/sliders">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                               Sliders
                            </a>

                            <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#FileManager" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                               File Manager
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                            <div class="collapse" id="FileManager" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="/admin/file-manager">Media</a>
                                </nav>
                            </div>



                            <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Products Manager
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="/admin/categories">Manage Categories</a>
                                    <a class="nav-link" href="/admin/subcategories">Manage Sub Categories</a>
                                    <a class="nav-link" href="/admin/products/add">Add Product</a>
                                    <a class="nav-link" href="/admin/manager/products">All Products</a>
                                </nav>
                            </div>
                              <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#faq_page" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                 Faq Page
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                            <div class="collapse" id="faq_page" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="/admin/pages/faq">Page Setup</a>
                                    <a class="nav-link" href="/admin/faq/manage">Manage Faq</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#newsManager" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                News Manager
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="newsManager" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="/admin/news/add">Add news</a>
                                    <a class="nav-link" href="/admin/manager/news">All News</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#Pages" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                               Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="Pages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="/admin/pages/about">About</a>
                                    <a class="nav-link" href="/admin/pages/product">Product</a>
                                    <a class="nav-link" href="/admin/pages/global-partners">Global Partners</a>
                                    <a class="nav-link" href="/admin/pages/our-projects">Our Projects</a>
                                    <a class="nav-link" href="/admin/pages/certificate">Certificate</a>
                                    <a class="nav-link" href="/admin/pages/company-profile">Company Profile</a>
                                    <a class="nav-link" href="/admin/pages/news">News</a>
                                    <a class="nav-link" href="/admin/pages/contact-us">Contact US</a>
                                </nav>
                            </div>
                            
                            <a class="nav-link" href="/admin/messages">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                <?php 
                                    $count = \app\http\models\Messages::all()->get();
                                    if(! count($count)) {$allMessages = 0;}
                                    else{ $allMessages = count($count);}
                                    
                                ?>
                               Messages <span class="badge badge-danger"><?= $allMessages?></span>
                            </a>

                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as: Admin</div>
                        
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
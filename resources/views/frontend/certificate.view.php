<?php 
    $route = "/Why Choose Us";
    template_include("/frontend/partials/header" ,compact('page','route'));
    template_include("/frontend/partials/banner",compact('page'));

?>
<div class="p-3"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            
        <div class="nav flex-column nav-pills" aria-orientation="vertical">
                    <a class="nav-link" href="/about">About</a> 
                    <a class="nav-link active" href="/why-choose-us">Why Choose Us</a>
                    <a class="nav-link" href="/factory-tours">Factory Tours</a> 
                    <a class="nav-link" href="/products">Products</a>
                    <a class="nav-link" href="/distributor">Distributor</a>
                    <a class="nav-link" href="/projects">Projects</a>
                    <a class="nav-link" href="/blog">Blog</a>
                    <a class="nav-link" href="/faq">FAQs</a>
                    <a class="nav-link" href="/contact-us">Contacts</a>
                </div>
        </div>
        <div class="col-md-9">
            <?= $page['page_content'] ?>
        </div>
    </div>
</div>
<?php 
    template_include("/frontend/partials/footer");
?>
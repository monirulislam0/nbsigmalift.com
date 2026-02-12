<?php 
    $route = '/contact-us';
    template_include("/frontend/partials/header",compact('page','route'));
    template_include("/frontend/partials/banner",compact('page'));

?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "NINGBO SIGMA ELEVATOR COMPANY LIMITED",
  "image": "https://nbsigmalift.com/uploads/1837145317519620.webp",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "1507 Chunchi Road, Gaoqiao Town, Haishu District, Ningbo City, Zhejiang Province, China.",
    "addressLocality": "Ningbo City",
    "postalCode": "315000",
    "addressCountry": "CN"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 29.885581600734394,
    "longitude": 121.46082145409181 
  },
  "openingHoursSpecification": [{
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
    "opens": "09:00",
    "closes": "18:00"
  }],
  "telephone": "+86-18657970560",
  "url": "https://nbsigmalift.com/"
}
</script>

<div class="p-3"></div>
<div class="container">
<div class="row">
    <div class="col-md-3">
        
        <div class="nav flex-column nav-pills" aria-orientation="vertical">
            <a class="nav-link " href="about">About</a>

            <a class="nav-link" href="/why-choose-us">Why Choose Us</a>
            <a class="nav-link" href="/factory-tours">Factory Tours</a>
            <a class="nav-link" href="/products">Products</a>
            <a class="nav-link" href="/distributor">Distributor</a>
            <a class="nav-link" href="/projects">Projects</a>
            <a class="nav-link" href="/blog">Blog</a>
            <a class="nav-link" href="/faq">FAQs</a>
            <a class="nav-link active" href="/contact-us">Contacts</a>
        </div>
    </div>
    <div class="col-md-9">
                
               <div>
                <?= $page['page_content'] ?>
               </div>
               
               <style>
                iframe{
                    width:100% !important;
                    height: 380px !important;
                }
               </style>
               <?= $page['google_iframe']?>
            

            <div class="p-3 bg-transparent"></div>
                <h4 class="text-primary">Request a Quote</h4>
                <hr class="hr">
                <div>
                    <?php if(session_get('message')):?>
                        <p style="padding:7px; background-color: green; color: white; "><?= session_get('message')?></p>
                    <?php endif; ?>
                </div>
                <form action="/admin/contact-us/store" method="POST">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
</div>
</div>
<?php 

template_include("/frontend/partials/footer");

?>

<?php 

    template_include("/frontend/partials/footer");

?>
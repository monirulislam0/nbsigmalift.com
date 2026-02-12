<?php 
    $route = "/faq";
    template_include("/frontend/partials/header" ,compact('page','route'));
    template_include("/frontend/partials/banner",compact('page'));

?>
<!-- FAQ Schema Markup -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    <?php
    $faqItems = [];
    foreach ($items as $item) {
        $faqItems[] = json_encode([
            '@type' => 'Question',
            'name' => htmlspecialchars_decode($item['faq_question']),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => htmlspecialchars_decode($item['answer'])
            ]
        ], JSON_UNESCAPED_SLASHES);
    }
    echo implode(",\n    ", $faqItems);
    ?>
  ]
}
</script>
<div class="p-3"></div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            
              <div class="nav flex-column nav-pills" aria-orientation="vertical">
                    <a class="nav-link " href="/about">About</a>

                    <a class="nav-link" href="/why-choose-us">Why Choose Us</a>
                    <a class="nav-link" href="/factory-tours">Factory Tours</a>
                    <a class="nav-link" href="/projects">Our Projects</a>
                    <a class="nav-link" href="/products">Products</a>
                    <a class="nav-link" href="/distributor">Distributor</a>
                    <a class="nav-link" href="/blog">Blog</a>
                    <a class="nav-link active" href="/faq">FAQs</a>
                    <a class="nav-link" href="/contact-us">Contacts</a>

                </div>
        </div>
        <div class="col-md-9">
            
            <?= $page['page_content'] ?>
            
            <style>
            .faq-container {
              /*width: 80%;*/
              margin: 40px auto;
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
            <?php foreach($items as $item):?>
          <div class="faq-item" data-id="1">
            <div class="faq-question">
              <span class="faq-title"><?= $item['faq_question']?></span>
              <span class="faq-toggle">+</span>
            </div>
            <div class="faq-answer">
             <?= $item['answer'] ?>
            </div>
          </div>
            <?php endforeach;?>
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
        </div>
        </div>
    </div>
</div>
<?php 

    template_include("/frontend/partials/footer");

?>
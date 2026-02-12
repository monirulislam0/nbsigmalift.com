<?php 

template_include("/backend/partials/header");

?>

<?php 

template_include("/backend/partials/sidebar");

?>

<!-- ============================================================================= -->
<!-- ============================================================================= -->
<!-- ============================================================================= -->
<main>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Welcome ! Admin.</h1>
    <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
      <li class="breadcrumb-item active">Add New Product</li>
      <li><a href="/admin/manager/products" class="btn btn-primary">Manage Products</a></li>
    </ol>
    <hr>
        <div class="row justify-content-center">
          <div class="col-md-8">
          <?php if(session_get("message")) : ?>
            <div class="card text-bg-primary mb-3" >
              <div class="card-body">
                <p class="card-text"><?= session_get("message") ?></p>
              </div>
            </div> 
            <?php endif ; ?>

            <h1 class="mb-4">Add New Product</h1>
            <form action="/admin/product/store" method="post" enctype="multipart/form-data" style="padding-bottom: 100px;">
              <!-- Product Name -->
              <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
               
                <input type="text" id="productName" class="form-control" placeholder="Enter product name" name="productName" value="<?= trim(old('productName')) ?>">
                <?php 
                    if(error("productName")):
                ?>
                <p class="text-danger" style="margin-bottom:-20px"><sub><?= error('productName') ?></sub></p>
                <div class="p-1"></div>
                <?php 
                    endif;
                ?>
              </div>
               <!-- Product Name -->
               <div class="mb-3">
                <label for="productModel" class="form-label">Product Model</label>
               
                <input type="text" id="productModel" class="form-control" placeholder="Enter product model" name="productModel" value="<?= trim(old('productModel')) ?>">
               
              </div>

              <!-- Product Category -->
              <div class="mb-3">
                <label for="productCategory" class="form-label">Category</label>
                <select id="productCategory" name="productCategory" class="form-select"  onchange="updateSubCategories(event)">
                    <option value="">Select a category</option>
                    <?php 
                    
                    foreach($categories as $category) : ?>
                    <option value="<?= $category['id'] ?>" <?php if( $category['id'] == old("productCategory")) { echo "selected" ; } ?> > <?= $category['category_name'] ?> </option>
                        <?php endforeach; ?>
                </select>
                    <?php 
                        if(error("productCategory")):
                    ?>
                     <p class="text-danger" style="margin-bottom:-20px"><sub><?= error('productCategory') ?></sub></p>
                     <div class="p-1"></div>
                    <?php 
                        endif;
                    ?>
              </div>

              <!-- Product Sub-Category -->
              <div class="mb-3">
                <label for="productSubCategory" class="form-label">Sub-Category</label>
                <select id="productSubCategory" class="form-select" name="productSubCategory">
                  <option value="">Select a sub-category</option>
                </select>
              </div>

              <!-- Product Price -->
              <div class="mb-3">
                <label for="" class="form-label">Price ($)</label>
                <input type="number" id="productPrice" class="form-control" placeholder="Enter price" min="0" name="productPrice" value="<?= old("productPrice") ?>">
               
               <?php 
                        if(error("productPrice")):
                    ?>
                    <p class="text-danger" style="margin-bottom:-20px"><sub><?= error('productPrice') ?></sub></p>
                    <div class="p-1"></div>
                    <?php 
                        endif;
                    ?>
              </div>

              <!-- Product Description -->
              <div class="mb-3">
  <label for="productShortDescription" class="form-label">Short Description</label>
  <textarea id="productShortDescription" class="form-control" rows="4" placeholder="Short product description" name="productShortDescription">
    <?= trim(old('productShortDescription')) ?>
  </textarea>
  <?php if(error("productShortDescription")): ?>
    <p class="text-danger" style="margin-bottom:-20px"><sub><?= error('productShortDescription') ?></sub></p>
    <div class="p-1"></div>
  <?php endif; ?>
  
  <!-- TinyMCE Initialization Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      tinymce.init({
        selector: '#productShortDescription',
        plugins: 'lists',
        toolbar: 'bold underline | bullist numlist',
        height: 200,
        setup: function(editor) {
          // Ensure <br> on Enter (next line behavior)
          editor.on('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
              e.preventDefault();
              editor.execCommand('InsertLineBreak');
            }
          });
        }
      });
    });
  </script>
</div>


              <div class="mb-3">
                <label for="productLongDescription" class="form-label">Long Description</label>
                <textarea id="productLongDescription" class="form-control" rows="4" placeholder="Long Product Description" name="productLongDescription">
                        <?= old("productLongDescription") ?>
                </textarea>
                <?php 
                        if(error("productLongDescription")):
                    ?>
                    <p class="text-danger" style="margin-bottom:-20px"><sub><?= error('productLongDescription') ?></sub></p>
                    <div class="p-1"></div>
                    <?php 
                        endif;
                    ?>
              </div>

                <script>
                tinymce.init({
                    selector: 'textarea#productLongDescription',
                   plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code',
                   toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                });
                </script>
              <!-- Product Image -->
              <div class="mb-3">
                <label for="productThumbnail" class="form-label">Upload Thumbnail</label>
                <input type="file" id="productThumbnail" class="form-control" accept="image/*" name="productThumbnail">

                    <?php 
                        if(error("productThumbnail")):
                    ?>
                    <p class="text-danger" style="margin-bottom:-20px"><sub><?= error('productThumbnail') ?></sub></p>
                    <div class="p-1"></div>
                    <?php 
                        endif;
                    ?>
              </div>
              <!-- Product Alt Text -->
              <div class="mb-3">
                <label for="productThumbnailAltText" class="form-label">Alt Text</label>
                <input type="text" id="productThumbnailAltText" class="form-control" name="productThumbnailAltText">
              </div>

              <!-- Product Sliders -->
              <div class="mb-3">
                <label for="productGallaries" class="form-label">Product Gallary</label>
                <input type="file" id="productGallaries" class="form-control" accept="image/*" name="productGallaries[]" multiple>
                <?php 
                        if(error("productGallaries")):
                    ?>
                    <p class="text-danger" style="margin-bottom:-20px"><sub><?= error('productGallaries') ?></sub></p>
                    <div class="p-1"></div>
                    <?php 
                        endif;
                    ?>
              </div>

              <!-- Product Image -->
              <div class="mb-3">
                <label for="productPDF" class="form-label">Upload PDF</label>
                <input type="file" id="productPDF" class="form-control" name="productPDF" accept="application/pdf" >

              </div>
              <h1 class="mb-4 mt-2">Open Graph Information to share social media</h1>
              <hr class="border border-primary border-3 opacity-75">

             

              <div class="mb-3">
                <label for="OgTitle" class="form-label">OG Title</label>
               <input type="text" name="OgTitle" class="form-control" id="OgTitle" value="<?= old("OgTitle") ?>">
              </div>

              <div class="mb-3">
                <label for="OgDesription" class="form-label">OG Description</label>
                <textarea id="OgDesription" class="form-control" rows="4" placeholder="Enter product description" name="OgDesription">
                    <?= trim(old('OgDesription')) ?>
                </textarea>
              </div>
              <div class="mb-3">
                <label for="OgImage" class="form-label">OG Image</label>
               <input type="file" name="OgImage" class="form-control" id="OgImage">
              </div>
              
               <h1 class="mb-4 mt-2">SEO Here</h1>
              <hr class="border border-primary border-3 opacity-75">
              
               <div class="mb-3">
                <label for="productTags" class="form-label">Meta Keywords</label>
                <input type="text" id="productTags" value="<?= old("productTags") ?? 'Tags....'?>" data-role="tagsinput"  class="form-control" name="productTags"/>
              </div>
              
              <div class="mb-3">
                <label for="meta_title" class="form-label">Meta Title</label>
               <input type="text" name="meta_title" class="form-control" id="meta_title" value="<?= old("meta_title") ?>">
              </div>

             <div class="mb-3">
  <label for="meta_description" class="form-label">Meta Description (Recommended: 150-160 characters)</label>
  <textarea 
    id="meta_description" 
    class="form-control" 
    rows="4" 
    placeholder="Enter product description" 
    name="meta_description"
    oninput="countMetaDescriptionChars(this)"
  ><?= htmlspecialchars(trim(old('meta_description') ?? $product['meta_description'] ?? '')) ?></textarea>
  <div class="text-muted">
    <span id="meta_desc_counter">0</span>/160 characters
  </div>
  <?php if(error("meta_description")): ?>
    <p class="text-danger"><sub><?= error('meta_description') ?></sub></p>
  <?php endif; ?>
</div>

<script>
  function countMetaDescriptionChars(textarea) {
    const counter = document.getElementById('meta_desc_counter');
    const text = textarea.value;
    
    // Count characters (including spaces)
    const charCount = text.length;
    
    // Update counter
    counter.textContent = charCount;
    
    // Visual feedback
    if (charCount > 160) {
      counter.classList.add('text-danger');
      counter.classList.remove('text-success');
    } else {
      counter.classList.add('text-success');
      counter.classList.remove('text-danger');
    }
  }

  // Initialize counter on page load
  document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('meta_description');
    if (textarea) {
      countMetaDescriptionChars(textarea);
    }
  });
</script>
              
              <!-- Submit Button -->
              <button type="submit" class="btn btn-success w-100">Add Product</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<script>
  function updateSubCategories(event) {

    categoryId = parseInt(event.target.value);

    var url = "<?php echo getEnv('SITE_URL'); ?>";
    url = url.replace(/\/$/, ""); 

    // Construct the full URL with categoryId
     fetch(url + "/subcategories/target?id=" + categoryId)
    .then(response => {
        if (!response.ok) {
        throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
        subCategories = data;
        const subCategory = document.getElementById('productSubCategory');
         subCategory.innerHTML = '<option value="">Select a sub-category</option>'; // Reset sub-categories
            if (subCategories) {
            subCategories.forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.id;
                option.textContent = sub.subcategory_name;
                subCategory.appendChild(option);
            });
            }
    })
    .catch(error => {

        console.error('There was a problem with the fetch operation:', error);
        
    });




  }


    document.addEventListener('DOMContentLoaded', function() {
        ContentTrim();
    });

    function ContentTrim() {

        document.getElementById("productShortDescription").innerHTML = (document.getElementById("productShortDescription").innerHTML).trim() ;
        document.getElementById("OgDesription").innerHTML = (document.getElementById("OgDesription").innerHTML).trim() ;

    }

</script>
<!-- ============================================================================ -->
<!-- ============================================================================ -->
<!-- ============================================================================ -->

<?php

template_include("/backend/partials/footer");

?>
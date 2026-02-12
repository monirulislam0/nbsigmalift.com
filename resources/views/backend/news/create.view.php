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
      <li class="breadcrumb-item active">News</li>
      <li><a href="/admin/manager/news" class="btn btn-primary">Manage News</a></li>
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

            <h1 class="mb-4">Add New News</h1>
            <form action="/admin/news/store" method="post" enctype="multipart/form-data" style="padding-bottom: 100px;">
              <!-- Product Name -->
              <div class="mb-3">
                <label for="news_name" class="form-label">News Name</label>
               
                <input type="text" id="news_name" class="form-control" placeholder="Enter product name" name="news_name" value="<?= trim(old('news_name')) ?>">
                <?php 
                    if(error("news_name")):
                ?>
                <p class="text-danger" style="margin-bottom:-20px"><sub><?= error('news_name') ?></sub></p>
                <div class="p-1"></div>
                <?php 
                    endif;
                ?>
              </div>


              <div class="mb-3">
                <label for="content" class="form-label">News Content</label>
                <textarea id="content" class="form-control" rows="4" placeholder="News Content" name="content">
                        <?= old("content") ?>
                </textarea>
                <?php 
                        if(error("content")):
                    ?>
                    <p class="text-danger" style="margin-bottom:-20px"><sub><?= error('content') ?></sub></p>
                    <div class="p-1"></div>
                    <?php 
                        endif;
                    ?>
              </div>

                <script>
                tinymce.init({
                    selector: 'textarea#content',
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code',
                   toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                });
                </script>
              <!-- Product Image -->
              <div class="mb-3">
                <label for="news_image" class="form-label">News Image</label>
                <input type="file" id="news_image" class="form-control" accept="image/*" name="news_image">
              </div>
              <!-- Product Alt Text -->
              <div class="mb-3">
                <label for="alt_text" class="form-label">Alt Text</label>
                <input type="text" id="alt_text" class="form-control" name="alt_text">
              </div>

              <h1 class="mb-4 mt-2">Open Graph Information to share social media</h1>
              <hr class="border border-primary border-3 opacity-75">

             

              <div class="mb-3">
                <label for="OgTitle" class="form-label">OG Title</label>
               <input type="text" name="OgTitle" class="form-control" id="OgTitle" value="<?= old("OgTitle") ?>">
              </div>

              <div class="mb-3">
                <label for="OgDescription" class="form-label">OG Description</label>
                <textarea id="OgDescription" class="form-control" rows="4" placeholder="Enter product description" name="OgDescription">
                    <?= trim(old('OgDescription')) ?>
                </textarea>
              </div>
              
              <div class="mb-3">
                <label for="OgImage" class="form-label">OG Image</label>
               <input type="file" name="OgImage" class="form-control" id="OgImage">
              </div>
              
              <h1 class="mb-4 mt-2">SEO Here</h1>
              <hr class="border border-primary border-3 opacity-75">

             
               <div class="mb-3">
                <label for="meta_tags" class="form-label">Meta Tags</label>
                <input type="text" id="meta_tags" value="<?= old("meta_tags") ?? 'Tags....'?>" data-role="tagsinput"  class="form-control" name="meta_tags"/>
              </div>
              

              <div class="mb-3">
                <label for="meta_title" class="form-label">Meta Title</label>
               <input type="text" name="meta_title" class="form-control" id="meta_title" value="<?= old("meta_title") ?>">
              </div>

              <div class="mb-3">
                <label for="meta_description" class="form-label">Meta Description</label>
                <textarea id="meta_description" class="form-control" rows="4" placeholder="Enter product description" name="meta_description">
                    <?= trim(old('meta_description')) ?>
                </textarea>
              </div>
              
              <!-- Submit Button -->
              <button type="submit" class="btn btn-success w-100">Add News</button>
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

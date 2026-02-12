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
      <li class="breadcrumb-item active">Projects </li>
      <li><a href="/projects" target="blank" class="btn btn-primary">View</a></li>
    </ol>
    <hr>
    <div class="row justify-content-center">
      <!-- Moved Add Project section to the top -->
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12">
            <form id="ProjectForms" action="/admin/pages/our-projects/prjoect/store" method="post" enctype="multipart/form-data">
              <h1 class="mb-4">Add Project</h1>
              <hr class="hr">
              <!-- Region Name -->
              <div class="mb-3">
                <label for="location" class="form-label">Location: </label>
                <input type="text" class="form-control" id="location" placeholder="Enter Location" name="location" >

                <?php 
                  if(error("location")):
                 ?>
                <p class="text-danger" style="margin-bottom:-20px"><sub> <?= error('location') ?></sub></p>
                <div class="p-1"></div>
                <?php 
                    endif;
                ?>
              </div>
              <!-- Product Image -->
              <div class="mb-3">
                <label for="project_image" class="form-label">Project Image</label>
                <input type="file" id="project_image" class="form-control" name="project_image" onchange="ProjectImagePreview(event)">
              </div>

              <div class="mb-3">
                <!-- Initially show the current image -->
                <img id="show_project" src="<?= assets('/uploads/no_image.jpg')?>" class="form-control">
              </div>

              <script>
              function ProjectImagePreview(event) {
                  var reader = new FileReader();
                  reader.onload = function(){
                      var output = document.getElementById('show_project');
                      output.src = reader.result;  
                  }
                  reader.readAsDataURL(event.target.files[0]);  
              }
              </script>
              <!-- Submit Button -->
              <input type="submit" class="btn btn-primary w-100" value="Add Project" onclick="submitProjectsForm(event)">
            </form>
            <script>
            function submitProjectsForm(event) {
                event.preventDefault(); 
                document.getElementById('ProjectForms').submit(); 
            }
            </script>
          </div>
          <div class="col-md-12">
            <div class=" mt-4">
              <div class="table-responsive">
                <table class="table table-bordered align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>#</th>
                      <th>Location</th>
                      <th>Image</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      foreach($projects as $keys => $project):
                    ?>
                    <tr>
                      <td><?= $keys+1 ?></td>
                      <td>
                        <?= $project['location']?>
                      </td>
                      <td>
                        <img src="<?= assets('/uploads/'.$project['project_image']) ?>" alt="" style="width:150px; height: auto;">
                      </td>
                      <td style="width:200px">
                        <a href="/admin/pages/our-projects/project/delete?target=<?= $project['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End of moved Add Project section -->

      <!-- Page form section (moved below Add Project) -->
      <div class="col-md-8">
        <?php if(session_get("message")) : ?>
          <div class="card text-bg-primary mb-3" >
            <div class="card-body">
              <p class="card-text"><?= session_get("message") ?></p>
            </div>
          </div> 
        <?php endif ; ?>

        <h1 class="mb-4">About Page</h1>
        <form action="/admin/pages/our-projects/store" method="post" enctype="multipart/form-data" style="padding-bottom: 100px;">
          <!-- Product Name -->
          <input type="hidden" name="_method" value="update">
          <input type="hidden" name="id" value=" <?= $page['id'] ?>">

          <div class="mb-3">
            <label for="page_title" class="form-label">Page title</label>
            <input type="text" id="page_title" class="form-control" placeholder="Page Title" name="page_title" value=" <?= old('page_title')?? $page['page_title']  ?>">
            <?php 
                if(error("page_title")):
            ?>
            <p class="text-danger" style="margin-bottom:-20px"><sub> <?= error('page_title') ?></sub></p>
            <div class="p-1"></div>
            <?php 
                endif;
            ?>
          </div>
          <div class="mb-3">
            <label for="page_content" class="form-label">Page Content</label>
            <textarea id="page_content" class="form-control" rows="4" placeholder="Page Content" name="page_content">
              <?= old("page_content")?? $page['page_content']  ?>
            </textarea>
            <?php 
                    if(error("page_content")):
                ?>
                <p class="text-danger" style="margin-bottom:-20px"><sub> <?= error('page_content') ?></sub></p>
                <div class="p-1"></div>
                <?php 
                    endif;
                ?>
          </div>

            <script>
            tinymce.init({
                selector: 'textarea#page_content',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            });
            </script>
          <!-- Product Image -->
          <div class="mb-3">
            <label for="banner_image" class="form-label">Banner Image</label>
            <input type="file" id="banner_image" class="form-control" name="banner_image" onchange="BannerPreview(event)">
        </div>

        <div class="mb-3">
            <!-- Initially show the current image -->
            <img id="banner_preview" src="<?= assets('/uploads/'.$page['banner_image'])?>" alt="<?= $page['banner_image'] ?>" class="form-control">
        </div>

        <script>
        function BannerPreview(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('banner_preview');
                output.src = reader.result;  // Update the img source with the selected file
            }
            reader.readAsDataURL(event.target.files[0]);  // Read the selected file as a DataURL
        }
        </script>

          <!-- Product Alt Text -->
          <div class="mb-3">
            <label for="alt_text" class="form-label">Alt Text</label>
            <input type="text" id="alt_text" class="form-control" name="alt_text" value="<?= $page['alt_text'] ?>">
          </div>

          <h1 class="mb-4 mt-2">You're almost ready !! Have a look for SEO</h1>
          <hr class="border border-primary border-3 opacity-75">

          <div class="mb-3">
            <label for="meta_tags" class="form-label">Meta Tags</label>
            <input type="text" id="meta_tags" value=" <?= old("meta_tags") ?? $page['meta_tags'] ?>" data-role="tagsinput"  class="form-control" name="meta_tags"/>
          </div>

          <div class="mb-3">
            <label for="OgTitle" class="form-label">Meta Title</label>
           <input type="text" name="OgTitle" class="form-control" id="OgTitle" value="<?= old("OgTitle")?? $page['page_title'] ?>">
          </div>

            <div class="mb-3">
        <label for="OgDescription" class="form-label">Meta Description 
         <span id="charCount" class="text-muted">(0/160 characters)</span>
        </label>
        <textarea id="OgDescription" class="form-control" rows="4" placeholder="Enter meta description" name="OgDescription" oninput="updateCharCount()"><?= trim(old('OgDescription') ?? $page['og_description']) ?></textarea>
         </div>
          <div class="mb-3">
            <label for="OgImage" class="form-label">OG Image</label>
           <input type="file" name="OgImage" class="form-control" id="OgImage" onChange="OgPreviews(event, this)" accept="image/*">
          </div>
          <div class="mb-3">
           
           <img src="<?= assets('/uploads/'.$page['og_image'])?>" alt="<?= $page['og_image'] ?>" class="form-control" id="OgPreview">
         </div>
         <script>
        function OgPreviews(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('OgPreview');
                output.src = reader.result;  // Update the img source with the selected file
            }
            reader.readAsDataURL(event.target.files[0]);  // Read the selected file as a DataURL
        }
        </script>
          <!-- Submit Button -->
          <button type="submit" class="btn btn-success w-100">Update</button>
        </form>
      </div>
    </div>
  </div>
</main>
<script>
  document.addEventListener('DOMContentLoaded', function() {
      ContentTrim();
  });

  function ContentTrim() {
      document.getElementById("OgDescription").innerHTML = (document.getElementById("OgDescription").innerHTML).trim() ;
  }
</script>
<!-- ============================================================================ -->
<!-- ============================================================================ -->
<!-- ============================================================================ -->

<?php
template_include("/backend/partials/footer");
?>
<?php 
template_include("/backend/partials/header");
template_include("/backend/partials/sidebar");
?>

<!-- ============================================================================= -->
<!-- ============================================================================= -->
<!-- ============================================================================= -->
<main>
   <div class="container-fluid px-4">
      <h1 class="mt-4">Welcome ! Admin.</h1>
      <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
         <li class="breadcrumb-item active">Global Partners</li>
         <li><a href="/global-partners" target="blank" class="btn btn-primary">View</a></li>
      </ol>
      <hr>
      
      <!-- Moved Global Partners Management to the top -->
      <div class="row justify-content-center">
         <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                <form id="regionCountryForm" action="/admin/pages/global-partners/region/store" method="post">
                <h1 class="mb-4">Add Region</h1>
                <hr class="hr">
                    <!-- Region Name -->
                    <div class="mb-3">
                        <label for="regionName" class="form-label">Region</label>
                        <input type="text" class="form-control" id="regionName" placeholder="Enter region name" name="region" >

                        <?php 
                          if(error("page_title")):
                         ?>
                        <p class="text-danger" style="margin-bottom:-20px"><sub> <?= error('page_title') ?></sub></p>
                        <div class="p-1"></div>
                     <?php 
                         endif;
                     ?>

                    </div>
                    <!-- Submit Button -->
                    <input type="submit" class="btn btn-primary w-100" value="Add Region" onclick="submitRegionForm(event)">

                </form>
                </div>
                <script>
                function submitRegionForm(event) {
                    event.preventDefault();
                    document.getElementById('regionCountryForm').submit();
                }
                </script>

                <div class="col-md-6">
                <div class=" mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Region</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach($regions as $keys => $region):
                                            ?>
                                            <tr>
                                                <td><?= $keys+1 ?></td>
                                                <td>
                                                   <?= $region['region']?>
                                                </td>
                                                <td style="width:200px">
                                                    <a href="/admin/pages/region/delete?target=<?= $region['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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
      </div>
      
      <div class="row justify-content-center mt-4">
         <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                <?php if(!isset($partner)) :?>
                <form id="addGlobalPartnersForm" action="/admin/pages/global-partners/partners/store" method="post">
                <h1 class="mb-4">Add Global Partners</h1>
                <hr class="hr">
                    <!-- Region Name -->
                    <div class="mb-3">
                        <label for="region_id" class="form-label">Region</label>
                        <select name="region_id" class="form-control">
                           <?php foreach($regions as $region): ?>
                             <option value="<?= $region['id']?>"><?= $region['region']?></option>
                           <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="country_name" class="form-label">Country</label>
                        <input type="text" name="country_name" class="form-control" placeholder="Country Name...">
                        <?php 
                          if(error("country_name")):
                         ?>
                        <p class="text-danger" style="margin-bottom:-20px"><sub> <?= error('country_name') ?></sub></p>
                        <div class="p-1"></div>
                     <?php 
                         endif;
                     ?>
                    </div>
                    <div class="mb-3">
                        <label for="company_details" class="form-label">Company Details</label>
                        <textarea name="company_details" id="company_details" class="form-control company-details-editor" placeholder="Enter the page content here..."></textarea>
                        <?php 
                          if(error("company_details")):
                         ?>
                        <p class="text-danger" style="margin-bottom:-20px"><sub> <?= error('company_details') ?></sub></p>
                        <div class="p-1"></div>
                     <?php 
                         endif;
                     ?>
                    </div>
                    <!-- Submit Button -->
                    <input type="submit" class="btn btn-primary w-100" value="Add Partners" onclick="addGlobal(event)">

                </form>
                
                <?php else: ?>
                 <form id="UpdateGlobalPartnersEdit" action="/admin/pages/global-partners/partners/update" method="post">
                     <input type="hidden" name="_method" value="update" />
                     <input type="hidden" name="id" value="<?= $partner['id'] ?>" />
                <h1 class="mb-4">Edit Global Partners</h1>
                <hr class="hr">
                    <!-- Region Name -->
                    <div class="mb-3">
                        <label for="region_id" class="form-label">Region</label>
                        <select name="region_id" class="form-control">
                           <?php foreach($regions as $region): ?>
                             <option value="<?= $region['id']?>"><?= $region['region']?></option>
                           <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="country_name" class="form-label">Country</label>
                        <input type="text" name="country_name" class="form-control" placeholder="Country Name..." value="<?= $partner['country_name']  ?>" >
                        <?php 
                          if(error("country_name")):
                         ?>
                        <p class="text-danger" style="margin-bottom:-20px"><sub> <?= error('country_name') ?></sub></p>
                        <div class="p-1"></div>
                     <?php 
                         endif;
                     ?>
                    </div>
                    <div class="mb-3">
                        <label for="company_details" class="form-label">Company Details</label>
                        <textarea name="company_details" id="edit_company_details" class="form-control company-details-editor" placeholder="Enter the page content here..."><?= $partner['company_details']  ?></textarea>
                        <?php 
                          if(error("company_details")):
                         ?>
                        <p class="text-danger" style="margin-bottom:-20px"><sub> <?= error('company_details') ?></sub></p>
                        <div class="p-1"></div>
                     <?php 
                         endif;
                     ?>
                    </div>
                    <!-- Submit Button -->
                    <input type="submit" class="btn btn-primary w-100" value="Update Partners" onclick="UpdateGlobal(event)">

                </form>
                <?php endif; ?>
                </div>
                <script>
                function addGlobal(event) {
                    event.preventDefault();
                    document.getElementById('addGlobalPartnersForm').submit();
                }
                function UpdateGlobal(event){
                    event.preventDefault();
                    document.getElementById('UpdateGlobalPartnersEdit').submit();
                }
                </script>

                <div class="col-md-12">
                <div class=" mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Region</th>
                                                <th>Country Name</th>
                                                <th>Company Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach($partners as $keys => $partner):
                                            ?>
                                            <tr>
                                                <td><?= $keys+1 ?></td>
                                                <td>
                                                   <?php 
                                                   $region_id = $partner['region_id'];
                                                   $reg = \app\http\models\Region::find($region_id)->get();
                                                   echo $reg['region'];
                                                   ?>
                                                </td>
                                                <td>
                                                   <?= $partner['country_name']?>
                                                </td>
                                                <td>
                                                   <?= $partner['company_details']?>
                                                </td>
                                                <td style="width:200px">
                                                <a href="/admin/pages/partners/delete?target=<?= $partner['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                                 <a href="/admin/pages/partners/edit?target=<?= $partner['id'] ?>" class="btn btn-info btn-sm">Edit</a> 
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                </div>
                <div class="col-md-12">
                    <div class="p-5"></div>
                </div>
            </div>
         </div>
      </div>
      
      <!-- Moved Page Content Section to Bottom -->
      <div class="row justify-content-center mt-4">
         <div class="col-md-8">
            <?php if(session_get("message")) : ?>
            <div class="card text-bg-primary mb-3" >
               <div class="card-body">
                  <p class="card-text"><?= session_get("message") ?></p>
               </div>
            </div>
            <?php endif ; ?>
            <h1 class="mb-4">Global Partners Page Settings</h1>
            <form action="/admin/pages/global-partners/store" method="post" enctype="multipart/form-data" style="padding-bottom: 100px;">
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
                          output.src = reader.result;
                      }
                      reader.readAsDataURL(event.target.files[0]);
                  }
               </script>
               <!-- Product Alt Text -->
               <div class="mb-3">
                  <label for="alt_text" class="form-label">Alt Text</label>
                  <input type="text" id="alt_text" class="form-control" name="alt_text" value="<?= $page['alt_text'] ?>">
               </div>
               <h1 class="mb-4 mt-2">SEO Settings</h1>
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
                  <input type="file" name="OgImage" class="form-control" id="OgImage" onchange="OgPreview(event)">
               </div>
               <div class="mb-3">
                  <img src="<?= assets('/uploads/'.$page['og_image'])?>" alt="<?= $page['og_image'] ?>" class="form-control" id="OgPreviews">
               </div>
               <script>
                  function OgPreview(event) {
                      var reader = new FileReader();
                      reader.onload = function(){
                          var output = document.getElementById('OgPreviews');
                          output.src = reader.result;
                      }
                      reader.readAsDataURL(event.target.files[0]);
                  }
               </script>
               <!-- Submit Button -->
               <button type="submit" class="btn btn-success w-100">Update Settings</button>
            </form>
         </div>
      </div>
   </div>
</main>

<!-- Initialize TinyMCE for Company Details -->
<script>
  tinymce.init({
    selector: 'textarea.company-details-editor',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>

<!-- ============================================================================ -->
<!-- ============================================================================ -->
<!-- ============================================================================ -->

<?php
template_include("/backend/partials/footer");
?>
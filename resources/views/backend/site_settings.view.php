
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
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Site Settings</li>
                        </ol>
                        <hr class="">
                        <div class="row">
                            <div class="col-xl-6">
                                <form action="/admin/site/settings/changes" method="post" >
                                    <input type="hidden" name="_method" value="update">
                                    <div class="mb-3">
                                        <label for="author" class="form-label">Meta Author</label>
                                        <input type="text" name="meta_author" class="form-control" value="<?= $data['meta_author']?? '' ?>" id="author" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                       <textarea name="meta_description" id="meta_description" class="form-control" rows='10'><?= $data['meta_description'] ?? '' ?>

                                       </textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text" name="meta_title" class="form-control" id="meta_title"  value="<?= $data['meta_title']?? '' ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>   
                            </div>
                            <div class="col-xl-6">
                                  <form action="/admin/site/settings/changes" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="update">
                                    <div class="mb-3">
                                        <label for="Logo" class="form-label">Site Logo</label>
                                        <input type="file" name="logo" class="form-control" id="Logo" accept="image/jpeg, image/png, image/webp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label"></label>
                                        <img src="<?= $data['logo'] ?  assets("/uploads/".$data['logo']) : assets("/frontend/media/logo.png") ?>" class="img-thumbnail" alt="Logo Image"  id="logo_show"/>
                                    </div>
                                    <script>
                                        document.getElementById("Logo").addEventListener('change', function(event){
                                            let a = event.target.files[0];

                                            const reader = new FileReader();
                                                reader.onload = function(e){

                                                    document.getElementById('logo_show').setAttribute('src', e.target.result);

                                                }
                                                reader.readAsDataURL(a);
                                        });
                                    </script>
                                    <div class="mb-3">
                                        <label for="Icon" class="form-label">Site Icon</label>
                                        <input type="file" name="icon" class="form-control" id="Icon" accept="image/png, image/webp, image/jpeg, image/x-icon" >
                                    </div>

                                    <div class="mb-3">
                                        <label for="" class="form-label"></label>
                                        <img src="<?= $data['icon'] ?  assets("/uploads/".$data['icon']) : assets("/frontend/media/logo.png") ?>"  class="img-icon" alt="Fav Icon" id="icon_show" style="width:80px; height:80px">
                                    </div>
                                    <script>
                                        document.getElementById("Icon").addEventListener('change', function(event){
                                            let a = event.target.files[0];

                                            const reader = new FileReader();
                                                reader.onload = function(e){

                                                    document.getElementById('icon_show').setAttribute('src', e.target.result);

                                                }
                                                reader.readAsDataURL(a);
                                        });
                                    </script>
                                    <div class="mb-3">
                                        <label for="copywrite_text" class="form-label">Copywrite Text</label>
                                       <textarea name="copywrite_text" id="copywrite_text" class="form-control"> <?= $data["copywrite_text"] ?></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary ">Save Changes</button>
                                </form>   
                            </div>
                        </div>
                    </div>
                </main>

<!-- ============================================================================ -->
<!-- ============================================================================ -->
<!-- ============================================================================ -->


<?php

    template_include("/backend/partials/footer");

?>

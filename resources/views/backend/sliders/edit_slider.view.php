
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
                            <li class="breadcrumb-item active">Manage Sliders</li>
                            <li><a href="/admin/sliders" class="btn btn-primary">Manage Slider</a></li>
                        </ol>
                        <hr class="">
                        <div class="row">
                            <div class="col-xl-12">

                                    <form action="/admin/slide/update" method="post" enctype="multipart/form-data">
                                            <div class="mb-3">
                                              <?php if(session_get('message'))  :?>
                                              
                                                <div class="alert alert-success" role="alert"> <?= session_get('message') ?>  </div>

                                              <?php endif?>
                                            </div>
                                            <input type="hidden" name="_method" value="update">
                                            <input type="hidden" name="id" value="<?= $slide['id'] ?>">
                                            <div class="mb-3">
                                                    <input type="file" name="slider" class="form-control" id="slider">
                                            </div>
                                            <div class="mb-3 d-flex justify-content-center align-items-center">
                                                <img src="<?= assets("/uploads/".$slide['slider_image']) ?>" alt="slider" style="width: 800px" id="show_slider">
                                            </div>
                                            <script>
                                                document.getElementById("slider").addEventListener("change", function(event){
                                                    let file = event.target.files[0] ;
                                                   const reader = new FileReader();
                                                
                                                   reader.onload = function(e){

                                                      document.getElementById('show_slider').setAttribute('src', e.target.result);

                                                    }
                                                    reader.readAsDataURL(file);

                                                });
                                            </script>
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <label for="alt_text" class="form-label mb-0">Alt Text :</label>
                                                        
                                                    </div>
                                                    <input type="text" name="alternative_text" class="form-control" id="alt_text"  value="<?= $slide['alternative_text'] ?>" >
                                                </div>
                                            <div class="mb-3">
                                                <div class="action-group d-flex justify-content-end">
                                                            <input type="submit" class="btn btn-primary" value="Save" style="width: 250px">                                           
                                                </div>
                                            </div>
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

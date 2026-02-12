
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
                            <li><a href="/admin/add/slider" class="btn btn-primary">Add Slider</a></li>
                        </ol>
                        <hr class="">
                        <div class="row">

                            <?php
                               if(!empty($sliders)) : 
                                foreach($sliders as $slide):
                            ?>
                          
                                
                            <div class="col-xl-12">
                                 <div class="card mb-3">
                                 <div class="mb-3">
                                    <img src="<?= assets("/uploads/".$slide['slider_image']) ?>" alt="<?= $slide['alternative_text']?>" class="w-100">
                                   </div>

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <label for="meta_title" class="btn btn-secondary mb-0">SEO Alternative Text: </label>
                                            <div class="action-group">
                                                  <a href="/admin/slide/edit?target=<?= $slide['id'] ?>" class="btn btn-info text-decoration-none">Edit</a>
                                                <a href="/admin/slide/delete?target=<?= $slide['id'] ?>" class="btn btn-danger text-decoration-none">Delete</a>                                              
                                            </div>
                                        </div>
                                        <input type="text" name="meta_title" class="form-control" id="meta_title"  value="<?= $slide['alternative_text']?>" disabled>
                                    </div>
                                 </div>                                   
                            </div>



                            <?php 
                                endforeach;
                                else: 
                            
                            ?>

                                <div class="col-xl-12">
                                   <div class="m-5 ">
                                   <p for="" class="mt-5 mb-5 text-center">You don't have sliders to shows !!<a href="/admin/add/slider" class="btn btn-link text-decoration-none"> Create a new </a></p>
                                   </div>
                              </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </main>

<!-- ============================================================================ -->
<!-- ============================================================================ -->
<!-- ============================================================================ -->


<?php

    template_include("/backend/partials/footer");

?>

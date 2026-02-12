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
                            <li class="breadcrumb-item active">Manage Categories</li>
                            <?php if(empty($category)):?>
                            <li><a href="/admin/manager/products" class="btn btn-primary">Manage Products</a></li>
                            <?php else: ?>
                                <li><a href="/admin/categories" class="btn btn-primary">Add New</a></li>
                            <?php endif ?>

                        </ol>
                        <hr class="">
                       <div class="row">
                            
                        <div class="col-xl-12">
                                <?php if(session_get("delete_message") ): ?>

                                    <h3 class="bg-danger   mb-2 p-2"> <?= session_get("delete_message") ?> </h3>

                                <?php endif ; ?>
                            </div>

                       </div>

                        <div class="row">

                            <?php if(empty($category)) :?>
                                
                            <div class="col-xl-6">
                                 <div class="card mb-3">
                                    <div class="mb-3 p-2">
                                          <?php if(session_get('message')) : ?>
                                                <div class="card-header bg-primary"><?= session_get('message') ?></div>
                                            <?php endif; ?>
                                        <h4>New Category</h4>
                                        <form action="/admin/category/store" method="post" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="category_name" class="form-label">Category Name</label>
                                                <input type="text" class="form-control" id="category_name" aria-describedby="emailHelp" name="category_name">
                                                <?php if(error('category_name')) : ?>
                                                <div id="emailHelp" class="form-text text-danger"><?=  error('category_name') ?> </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <label for="category_image" class="form-label">Category Image</label>
                                                <input type="file" class="form-control" id="category_image" name="category_image">
                                            </div>
                                            <!-- NEW: Alt text input field -->
                                            <div class="mb-3">
                                                <label for="alt_text" class="form-label">Image Alt Text</label>
                                                <input type="text" class="form-control" id="alt_text" name="alt_text" aria-describedby="altHelp">
                                                <div id="altHelp" class="form-text">Descriptive text for accessibility and SEO</div>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-primary">Add Category</button>
                                        </form>
                                    </div>  
                                </div>                                   
                            </div>
                                <?php else : ?>
                            
                            
                                
                            <div class="col-xl-6">
                                 <div class="card mb-3">
                                    <div class="mb-3 p-2">
                                          <?php if(session_get('message')) : ?>
                                                <div class="card-header bg-warning"><?= session_get('message') ?></div>
                                            <?php endif; ?>
                                        <h4 class="mt-2">Edit Category</h4>
                                        <form action="/admin/category/update" method="post" enctype="multipart/form-data">

                                            <input type="hidden" name="_method" value="update">
                                            <input type="hidden" name="id" value="<?= $category['id']?>">

                                            <div class="mb-3">
                                                <label for="category_name" class="form-label">Category Name</label>
                                                <input type="text" class="form-control" id="category_name" aria-describedby="emailHelp" value="<?= $category['category_name'] ?>" name="category_name">
                                                <?php if(error('category_name')) : ?>
                                                <div id="emailHelp" class="form-text text-danger"><?=  error('category_name') ?> </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <label for="category_image" class="form-label">Category Image</label>
                                                <input type="file" class="form-control" id="category_image" name="category_image">
                                            </div>
                                            <!-- NEW: Alt text input field for editing -->
                                            <div class="mb-3">
                                                <label for="alt_text" class="form-label">Image Alt Text</label>
                                                <input type="text" class="form-control" id="alt_text" name="alt_text" 
                                                       value="<?= $category['alt_text'] ?? '' ?>" 
                                                       aria-describedby="altHelp">
                                                <div id="altHelp" class="form-text">Descriptive text for accessibility and SEO</div>
                                            </div>
                                            <div class="mb-3">
                                                <img src="<?= assets("/uploads/".$category['category_image'])?>" 
                                                     alt="<?= $category['alt_text'] ?? $category['category_name'] ?>"  
                                                     id="show_image" 
                                                     style="width: 100px ; height : 80px ;">
                                            </div>

                                            <script>
                                                document.getElementById("category_image").addEventListener('change', function(e){
                                                    file = e.target.files[0];

                                                    const reader = new FileReader();

                                                    reader.onload = function(e){
                                                        document.getElementById("show_image").setAttribute("src", e.target.result);
                                                    }

                                                    reader.readAsDataURL(file);
                                                });
                                            </script>
                                            <br>
                                            <button type="submit" class="btn btn-primary">Update Category</button>
                                        </form>
                                    </div>  
                                </div>                                   
                            </div>
                            <?php endif ;?>
                              
                            <div class="col-xl-6">
                                 <div class="card mb-3">
                                 <div class="mb-3 p-2">
                                 <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Alt Text</th>
                                        <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($categories as $key => $value):
                                               if(isset($category))  if($value['id'] == $category['id']) continue ;
                                        ?>
                                        <tr>
                                        <th scope="row"><?= $key+1 ?></th>
                                        <td><?= $value['category_name']?> </td>
                                        <td>
                                            <img src="<?= assets("/uploads/".$value['category_image'])?>" 
                                                 alt="<?= $value['alt_text'] ?? $value['category_name'] ?>" 
                                                 style="width: 80px; height : 30px;">
                                        </td>
                                        <td><?= $value['alt_text'] ?? 'N/A' ?></td>
                                        <td>
                                            <a href="/admin/categories/edit?target=<?= $value['id']?>" class="btn btn-primary">Edit</a>
                                            <a href="/admin/category/delete?target=<?= $value['id']?>" class="btn btn-danger">Delete</a>
                                        </td>
                                        </tr>
                                        <?php 
                                        endforeach;
                                        ?>
                                    </tbody>
                                    </table>    
                                 </div>                                   
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
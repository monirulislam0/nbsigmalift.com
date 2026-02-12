
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
                            <li class="breadcrumb-item active">Manage Sub Categories</li>
                            <?php if(empty($category)):?>
                            <li><a href="/admin/manager/products" class="btn btn-primary">Manage Products</a></li>
                            <?php else: ?>
                                <li><a href="/admin/subcategories/create" class="btn btn-primary">Add New</a></li>
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

                            <?php if(empty($subcategory)) :?>
                                
                            <div class="col-xl-6">
                                 <div class="card mb-3">
                                    <div class="mb-3 p-2">
                                          <?php if(session_get('message')) : ?>
                                                <div class="card-header bg-primary"><?= session_get('message') ?></div>
                                            <?php endif; ?>
                                        <h4>New Category</h4>
                                        <form action="/admin/subcategory/store" method="post" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="subcategory_name" class="form-label">Subcategory Name</label>
                                                <input type="text" class="form-control" id="subcategory_name" aria-describedby="emailHelp" name="subcategory_name">
                                                <?php if(error('subcategory_name')) : ?>
                                                <div id="emailHelp" class="form-text text-danger"><?=  error('subcategory_name') ?> </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <label for="subcategory_image" class="form-label">Sub Category Image</label>
                                                <input type="file" class="form-control" id="subcategory_image" name="subcategory_image">
                                            </div>

                                            <div class="mb-3">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select name="category_id" id="" class="form-control">

                                                    <?php foreach($categories as $category) : ?>
                                                    <option value="<?= $category['id'] ?>" class="form-control"><?= $category['category_name']?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-primary">Add Subcategory</button>
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
                                        <form action="/admin/subcategory/update" method="post" enctype="multipart/form-data">

                                            <input type="hidden" name="_method" value="update">
                                            <input type="hidden" name="id" value="<?= $subcategory['id']?>">

                                            <div class="mb-3">
                                                <label for="subcategory_name" class="form-label">Sub category Name</label>
                                                <input type="text" class="form-control" id="subcategory_name" aria-describedby="emailHelp" value="<?= $subcategory['subcategory_name'] ?>" name="subcategory_name">
                                                <?php if(error('subcategory_name')) : ?>
                                                <div id="emailHelp" class="form-text text-danger"><?=  error('subcategory_name') ?> </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3">
                                                <label for="subcategory_image" class="form-label">Category Image</label>
                                                <input type="file" class="form-control" id="subcategory_image" name="subcategory_image">
                                            </div>
                                            <div class="mb-3">

                                                <img src="<?= assets("/uploads/".$subcategory['subcategory_image'])?>" alt=""  id="show_image" style="width: 100px ; height : 80px ;">

                                            </div>

                                            <script>
                                                document.getElementById("subcategory_image").addEventListener('change', function(e){
                                                    file = e.target.files[0];

                                                    const reader = new FileReader();

                                                    reader.onload = function(e){

                                                        document.getElementById("show_image").setAttribute("src", e.target.result);

                                                    }

                                                    reader.readAsDataURL(file);

                                                });
                                            </script>
                                            
                                            <div class="mb-3">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select name="category_id" id="" class="form-control">

                                                    <?php foreach($categories as $category) : ?>
                                                    <option value="<?= $category['id'] ?>" class="form-control" <?= $category['id'] == $subcategory['category_id'] ? 'selected' : ''  ?>><?= $category['category_name']?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
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
                                        <th scope="col">Subcategory</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            foreach($subcategories as $key => $value):

                                               if(isset($subcategory))  if($value['id'] == $subcategory['id']) continue ;
                                        ?>
                                        <tr>
                                        <th scope="row"><?= $key+1 ?></th>
                                        <td><?= $value['subcategory_name']?> </td>
                                        <?php 

                                                    $category = \app\http\models\Categories::find($value['category_id'])->get()['category_name'];
                                        ?>
                                        <td><?=  $category ?> </td>
                                        <td><img src="<?= assets("/uploads/".$value['subcategory_image'])?>" alt="" style="width: 80px; height : 30px;"></td>
                                        <td>
                                            <a href="/admin/subcategory/edit?target=<?= $value['id']?>" class="btn btn-primary">Edit</a>
                                            <a href="/admin/subcategory/delete?target=<?= $value['id']?>" class="btn btn-danger">Delete</a>
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

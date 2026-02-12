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
                            <li class="breadcrumb-item active">Manage Products</li>
                            
                            <li><a href="/admin/products/add" class="btn btn-primary">Add Product</a></li>

                        </ol>
                        <hr class="">
                       <div class="row">

                        <div class="col-xl-12">
                        <?php if(session_get("message")) : ?>
                            <div class="card text-bg-primary mb-3" >
                            <div class="card-body">
                                <p class="card-text"><?= session_get("message") ?></p>
                            </div>
                            </div> 
                            <?php endif ; ?>
                        <div class=" mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Checked</th>
                                                <th>Inquiry</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php  foreach($products as $key => $product):?>
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="product-img-container me-3" style="width:100px; height:80px; overflow:hidden; display:flex; align-items:center; justify-content:center; background:#f8f9fa; border:1px solid #dee2e6;">
                                                            <img 
                                                                src="<?= $product['product_thumbnail'] ? assets('/uploads/'.$product['product_thumbnail']) : assets('\/uploads/no_image.jpg') ?>" 
                                                                alt="Product Image" 
                                                                style="max-height:100%; max-width:100%; object-fit:contain;"
                                                            >
                                                        </div>
                                                        <div style="max-width:200px;"><?= $product['product_title']?></div>
                                                    </div>
                                                </td>
                                                <td style="width:105px">
                                                    <span >Trending: <input type="checkbox" id="trending_product" <?= $product['trending'] ? 'checked' : '' ?> data-id="<?= $product['id']?>"></span>
                                                </td>
                                                <td><span class="badge bg-primary">10</span></td>
                                                <td style="width:200px">
                                                    <a target="blank" href="/product/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $product['product_title']), '-'))."-".$product['id'] ?>" class="btn btn-secondary btn-sm">View</a>
                                                    <a href="/admin/product/edit?target=<?= $product['id']?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="/admin/product/delete?target=<?= $product['id']?>" class="btn btn-danger btn-sm">Delete</a>
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
                </main>

<!-- ============================================================================ -->
<!-- ============================================================================ -->
<!-- ============================================================================ -->

    <script>
            document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll("#trending_product").forEach((checkbox) => {
                checkbox.addEventListener("change", function () {
                    let productId = this.getAttribute("data-id");
                    let isChecked = this.checked ? 1 : 0; // Convert to 1 or 0

                    fetch("/admin/product/update-trending?target=" + productId + "&status=" + isChecked, {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            alert(data.message);
                        } else {
                            alert("Failed to update trending status.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
                });
            });
        });

    </script>
<?php

    template_include("/backend/partials/footer");

?>
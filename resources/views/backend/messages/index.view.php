
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
                            <li class="breadcrumb-item active">Messages</li>
                            
                            <!--<li><a href="/admin/products/add" class="btn btn-primary">Add Product</a></li>-->

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
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                              <?php 
                                            $pgNumber = $_GET['page'] ?? 1 ;
                                             $sl = (10*$pgNumber) - 10;
                                             foreach($messages as $key => $message):?>
                                            <tr>
                                                <td><?= $sl+1 ?></td>
                                                <td>
                                                    <?= strip_tags($message['name']) ?>
                                                </td>
                                                <td >
                                                     <?= strip_tags($message['email']) ?>
                                                </td>
                                                <td>
                                                      <?= strip_tags($message['message'])?>
                                                </td>
                                                <td>
                                                    <a href="/admin/message/delete?target=<?= $message['id'] ?>" class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                            <?php 
                                             $sl++;
                                            endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                            <style>
            .pagination {
            justify-content: center;
            margin-top: 20px;
            }
            .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            }
            .page-link {
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 16px;
            }
            .page-item:hover .page-link {
            background-color: #e9ecef;
            }
            .page-item:first-child .page-link,
            .page-item:last-child .page-link {
            padding: 10px 16px;
            }
        </style>
        <?php 
            if(count($messages)):
        ?>
            <div class="col-md-9 ">
                <div class="py-5">
                <div class="row">
                    <nav>
                    <ul class="pagination">
                        <?php 
                            $pageNumbers = $_GET['page'] ?? 1 ;
                            
                           

                        ?>
                        <li class="page-item <?= $pageNumbers > 1 ? ' ' : 'disabled' ?>">
                        <a class="page-link" href="/admin/messages?page=<?= $pageNumbers -  1 ?>" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item <?= $pageNumbers == 1 ? 'active' : '' ?> ">
                        <a class="page-link" href="/admin/messages">1</a>
                        </li>
                        <?php for($i = 2; $i <= $rows ; $i++): ?>
                            <li class="page-item <?= $pageNumbers == $i ? 'active' : '' ?>">
                            <a class="page-link" href="/admin/messages?page=<?= $i?>"><?= $i ?></a>
                            </li>
                        <?php endfor;?>
                        <li class="page-item <?= $pageNumbers == $rows ? 'disabled' : '' ?>">
                        <a class="page-link" href="/admin/messages?page=<?= $pageNumbers +  1 ?>">Next</a>
                        </li>
                    </ul>
                    </nav>
                </div>
                </div>
            </div>
        <?php 
            endif;
        ?>
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

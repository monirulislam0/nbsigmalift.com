<?php 
    template_include("/backend/partials/header");
?>

<?php 
    template_include("/backend/partials/sidebar");
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Welcome ! Admin.</h1>
        <ol class="breadcrumb mb-4 d-flex justify-content-between align-items-center">
            <li class="breadcrumb-item active">Manage News</li>
            <li><a href="/admin/news/add" class="btn btn-primary">Add News</a></li>
        </ol>
        <hr class="">
        <div class="row">
            <div class="col-xl-12">
                <?php if(session_get("message")) : ?>
                    <div class="card text-bg-primary mb-3">
                        <div class="card-body">
                            <p class="card-text"><?= session_get("message") ?></p>
                        </div>
                    </div> 
                <?php endif ; ?>
                
                <div class="mt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>News</th>
                                    <th>Checked</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($news as $key => $item): ?>
                                    <tr>
                                        <td><?= $key+1 ?></td>
                                        <td class="d-flex align-items-center">
                                            <div class="image-container me-2" style="width:250px; height:80px; overflow:hidden; display:flex; justify-content:center; align-items:center; background:#f8f9fa;">
                                                <img src="<?= $item['news_image'] ? assets('/uploads/'.$item['news_image']) : assets('/uploads/no_image.jpg') ?>" 
                                                     alt="News Image" 
                                                     style="max-width:100%; max-height:100%; object-fit:contain;">
                                            </div>
                                            <span><?= $item['news_title']?></span>
                                        </td>
                                        <td style="width:105px">
                                            <span>Feature: <input type="checkbox" id="feature_news" <?= $item['featured'] ? 'checked' : '' ?> data-id="<?= $item['id']?>"></span>
                                        </td>
                                        <td style="width:200px">
                                            <a href="/news/<?= strtolower(rtrim(preg_replace('/[\/\s]+/', '-', $item['news_title']), '-'))."-".$item['id'] ?>" class="btn btn-secondary btn-sm">View</a>
                                            <a href="/admin/news/edit?target=<?= $item['id']?>" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="/admin/news/delete?target=<?= $item['id']?>" class="btn btn-danger btn-sm">Delete</a>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("#feature_news").forEach((checkbox) => {
            checkbox.addEventListener("change", function () {
                let newsId = this.getAttribute("data-id");
                let isChecked = this.checked ? 1 : 0; // Convert to 1 or 0

                fetch("/admin/news/update-featured?target=" + newsId + "&status=" + isChecked, {
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
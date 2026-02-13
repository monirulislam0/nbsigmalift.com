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

            <li class="breadcrumb-item active">Manage Password</li>

            <li><a href="/admin/sliders" class="btn btn-primary">Change Password</a></li>

        </ol>

        <hr class="">

        <div class="row">

            <div class="col-xl-12">



                <form action="/admin/reset/password/store" method="post">

                    <div>
                       <div class="mb-3">
                            <?php if (session_get('success')): ?>
                            <div class="bg-success" style="padding:10px 10px;">
                                <p> <?= session_get('success') ?> </p>
                            </div>
                        <?php endif; ?>
                       </div>
                        <div class="mb-3">
                            <label for="password" class="py-1">New Password</label>
                            <input type="text" name="password" class="form-control" id="password" value="<?= old('password') ?> ">
                            <?php if (error('password')) : ?>
                                <p class="text-danger"> <?= error('password')  ?> </p>
                            <?php endif;  ?>

                        </div>

                        <div class="mb-3">
                            <label for="password" class="py-1">Old Password</label>

                            <input type="text" name="old_password" class="form-control" id="old_password">

                            <?php if (error('old_password')) : ?>
                                <p class="text-danger"> <?= error('old_password')  ?> </p>
                            <?php endif;  ?>

                            <?php if (session_get('message')) : ?>
                                <p class="text-danger"> <?= session_get('message')  ?> </p>
                            <?php endif;  ?>

                        </div>

                        <div class="mb-3">

                            <div class="action-group d-flex justify-content-end">

                                <input type="submit" class="btn btn-primary" value="Update" style="width: 250px">

                            </div>

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
<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />

        <link href="<?= assets('/backend/css/styles.css') ?>" rel="stylesheet" />

        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
        <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    
                    <div class="container">
                        <div class="row justify-content-center mt-5">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form action="/session/store" method="post">
                                        <?php if(error('email')): ?>
                                            <div>
                                            <p class="text-danger"><?= error('email') ?> *</p>
                                            </div>
                                        <?php endif; ?>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" value="<?= old('email') ?? '' ?>" placeholder="name@example.com" name="email" />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <?php if(error('password')): ?>
                                            <div>
                                            <p class="text-danger"><?= error('password') ?> *</p>
                                            </div>
                                          <?php endif; ?>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password" value="<?= old('password') ?? '' ?>"/>
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <?php if(session_get('message')): ?>
                                                 <div>
                                                      <p class="text-danger"><?= session_get('message') ?> *</p>
                                                 </div>
                                              <?php endif; ?>

                                            <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                                                <!-- <a class="small" href="password.html">Forgot Password?</a> -->
                                                 <input type="submit" value="Login" class="btn btn-primary p-5 pb-2 pt-2">
                                                <!-- <a class="btn btn-primary" href="index.html">Login</a> -->
                                            </div>

                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="<?= base_url() ?>">Go to Website</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>

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

                <div class="card shadow-lg border-0 rounded-3 p-5" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h2 class="fw-bold">Change Password</h2>
                            <p class="text-muted">Update your password to keep your account secure.</p>
                        </div>
                        <form action="/admin/reset/password/store" method="post" onsubmit="return validatePasswordForm()">

                            <div>
                               <div class="mb-3">
                                    <?php if (session_get('success')): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <strong>Success!</strong> <?= session_get('success') ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                               </div>
                                <div class="mb-3">
                                    <label for="old_password" class="py-1">Old Password</label>
                                    <div class="input-group">
                                        <input type="password" name="old_password" class="form-control" id="old_password">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('old_password')">
                                            <i class="fas fa-eye" id="old_password_icon"></i>
                                        </button>
                                    </div>
                                    <?php if (error('old_password')) : ?>
                                        <p class="text-danger"> <?= error('old_password')  ?> </p>
                                    <?php endif;  ?>
                                    <?php if (session_get('message')) : ?>
                                        <p class="text-danger"> <?= session_get('message')  ?> </p>
                                    <?php endif;  ?>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="py-1">New Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" id="password" value="<?= old('password') ?>">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                            <i class="fas fa-eye" id="password_icon"></i>
                                        </button>
                                    </div>
                                    <?php if (error('password')) : ?>
                                        <p class="text-danger"> <?= error('password')  ?> </p>
                                    <?php endif;  ?>
                                </div>

                                <div class="mb-3">
                                    <label for="confirm_password" class="py-1">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" value="<?= old('confirm_password') ?>">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                            <i class="fas fa-eye" id="confirm_password_icon"></i>
                                        </button>
                                    </div>
                                    <?php if (error('confirm_password')) : ?>
                                        <p class="text-danger"> <?= error('confirm_password')  ?> </p>
                                    <?php endif;  ?>
                                    <div id="password_match_error" class="text-danger small mt-1" style="display: none;">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        New password and confirm password do not match.
                                    </div>
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



        </div>

    </div>

</main>



<!-- ============================================================================ -->

<!-- ============================================================================ -->

<!-- ============================================================================ -->

<script>
function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const iconField = document.getElementById(fieldId + '_icon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        iconField.classList.remove('fa-eye');
        iconField.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        iconField.classList.remove('fa-eye-slash');
        iconField.classList.add('fa-eye');
    }
}

function validatePasswordForm() {
    const oldPassword = document.getElementById('old_password').value;
    const newPassword = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const matchError = document.getElementById('password_match_error');
    
    // Reset previous error
    matchError.style.display = 'none';
    
    // Check if all fields are filled
    if (!oldPassword || !newPassword || !confirmPassword) {
        alert('Please fill in all password fields.');
        return false;
    }
    
    // Check if new password and confirm password match
    if (newPassword !== confirmPassword) {
        matchError.style.display = 'block';
        document.getElementById('confirm_password').focus();
        return false;
    }
    
    // Check if new password is at least 8 characters
    if (newPassword.length < 8) {
        alert('New password must be at least 8 characters long.');
        document.getElementById('password').focus();
        return false;
    }
    
    // Check if old password is different from new password
    if (oldPassword === newPassword) {
        alert('New password must be different from the current password.');
        document.getElementById('password').focus();
        return false;
    }
    
    return true;
}

// Real-time password match validation
document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm_password');
    const matchError = document.getElementById('password_match_error');
    
    if (passwordField && confirmPasswordField && matchError) {
        function checkPasswordMatch() {
            if (confirmPasswordField.value && passwordField.value !== confirmPasswordField.value) {
                matchError.style.display = 'block';
            } else {
                matchError.style.display = 'none';
            }
        }
        
        passwordField.addEventListener('input', checkPasswordMatch);
        confirmPasswordField.addEventListener('input', checkPasswordMatch);
    }
});
</script>

<?php



template_include("/backend/partials/footer");



?>
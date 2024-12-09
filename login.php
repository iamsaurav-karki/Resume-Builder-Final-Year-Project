<?php
$title = "Login | Resume Builder";
require './assets/includes/header.php';
$fn->nonAuthPage();
?>
<div class="d-flex align-items-center" style="height:100vh">
    <div class="w-100">
        <main class="form-signin w-100 m-auto bg-white shadow rounded" style="max-width: 400px;">
            <!-- Adjust max-width to make the form wider -->
            <form method="post" action="actions/login.action.php">
                <div class="d-flex gap-2 justify-content-center">
                    <img class="mb-4" src="./assets/images/logo.png" alt="" height="70">
                    <div>
                        <h1 class="h3 fw-normal my-1"><b>Resume</b> Builder</h1>
                        <p class="m-0">Login to your account</p>
                    </div>
                </div>

                <div class="form-floating">
                    <input type="email" class="form-control" name="email_id" id="floatingEmail" placeholder="name@example.com" required>
                    <label for="floatingInput"><i class="bi bi-envelope"></i> Email address</label>
                </div>

                <div class="form-floating position-relative">
                    <input type="password" class="form-control pr-5" name="password" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword"><i class="bi bi-key"></i> Password</label>
                    <!-- Password toggle icon -->
                    <button type="button" id="togglePassword" class="btn btn-link position-absolute end-0 top-50 translate-middle-y p-0">
                        <i id="eyeIcon" class="bi bi-eye-slash"></i>
                    </button>
                </div>

                <div class="form-floating">
                    <input type="text" class="form-control" name="captcha" id="captchaInput" placeholder="Enter CAPTCHA" required>
                    <label for="captchaInput"><i class="bi bi-shield-lock"></i> Enter CAPTCHA</label>
                </div>
                <div class="mb-3">
                    <img src="./captcha.php" alt="CAPTCHA" class="captcha-image">
                    <button type="button" class="btn btn-link p-0" onclick="refreshCaptcha()">Refresh CAPTCHA</button>
                </div>

                <button class="btn btn-primary w-100 py-2" type="submit">Login
                    <i class="bi bi-box-arrow-in-right"></i>
                </button>
                <div class="d-flex justify-content-between my-3">
                    <a href="forgot-password.php" class="text-decoration-none">Forgot Password?</a>
                    <a href="register.php" class="text-decoration-none">Register</a>
                </div>
            </form>
        </main>
    </div>
</div>

<script>
    // JavaScript to refresh CAPTCHA
    function refreshCaptcha() {
        document.querySelector('.captcha-image').src = 'captcha.php?' + Date.now();
    }

    // JavaScript to toggle password visibility with smooth transition
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('floatingPassword');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function() {
        // Toggle the type attribute of the password field
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;

        // Toggle the eye icon with a smooth transition
        eyeIcon.classList.toggle('bi-eye');
        eyeIcon.classList.toggle('bi-eye-slash');

        // Smooth transition for the icon rotation
        eyeIcon.style.transition = "transform 0.3s ease-in-out";
        if (passwordField.type === 'password') {
            eyeIcon.style.transform = 'rotate(0deg)';
        } else {
            eyeIcon.style.transform = 'rotate(180deg)';
        }
    });
</script>

<?php
require './assets/includes/footer.php';
?>

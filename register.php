<?php
$title = "Register | Resume Builder";
require './assets/includes/header.php';
$fn->nonAuthPage();
?>

<style>
    .form-signin {
        max-width: 500px;
        padding: 1rem;
    }
    #password-strength-msg {
        font-size: 0.9em;
        margin-top: 5px;
        font-weight: bold;
    }
</style>

<div class="d-flex align-items-center" style="height:100vh">
    <div class="w-100">
        <main class="form-signin w-100 m-auto bg-white shadow rounded">
            <form method="post" action="actions/register.action.php">
                <div class="d-flex gap-2 justify-content-center">
                    <img class="mb-4" src="./assets/images/logo.png" alt="" height="70">
                    <div>
                        <h1 class="h3 fw-normal my-1"><b>Resume</b> Builder</h1>
                        <p class="m-0">Create account</p>
                    </div>
                </div>

                <div class="form-floating">
                    <input type="text" class="form-control" name="full_name" id="floatingName" placeholder="" required>
                    <label for="floatingName"><i class="bi bi-person"></i> Full Name</label>
                </div>
                <div class="form-floating">
                    <input type="email" class="form-control" name="email_id" id="floatingEmail" placeholder="name@example.com" required>
                    <label for="floatingEmail"><i class="bi bi-envelope"></i> Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    <label for="floatingPassword"><i class="bi bi-key"></i> Password</label>
                    <div id="password-strength-msg"></div>
                </div>

                
                <div class="form-floating">
                <input type="text" class="form-control" name="captcha" id="captchaInput" placeholder="Enter CAPTCHA" required>
                <label for="captchaInput"><i class="bi bi-shield-lock"></i> Enter CAPTCHA</label>
               </div>
               <div class="mb-3">
               <img src="./captcha.php" alt="CAPTCHA" class="captcha-image">
               <button type="button" class="btn btn-link p-0" onclick="refreshCaptcha()">Refresh CAPTCHA</button>
               </div>

                <button class="btn btn-primary w-100 py-2" type="submit"><i class="bi bi-person-plus-fill"></i> Register</button>
                <div class="d-flex justify-content-between my-3">
                    <a href="forgot-password.php" class="text-decoration-none">Forgot Password ?</a>
                    <a href="login.php" class="text-decoration-none">Login</a>
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
// JavaScript to check password strength in real-time
document.getElementById('password').addEventListener('input', function() {
    let password = this.value;
    let strengthMessage = document.getElementById('password-strength-msg');
    
    // Check the password strength
    let strength = checkPasswordStrength(password);

    // Update strength feedback based on the score
    strengthMessage.textContent = 'Password Strength: ' + strength;
    switch(strength) {
        case 'Very Weak':
            strengthMessage.style.color = 'red';
            break;
        case 'Weak':
            strengthMessage.style.color = 'orange';
            break;
        case 'Medium':
            strengthMessage.style.color = 'blue';
            break;
        case 'Strong':
            strengthMessage.style.color = 'green';
            break;
        case 'Very Strong':
            strengthMessage.style.color = 'darkgreen';
            break;
    }
});

// Function to check password strength
function checkPasswordStrength(password) {
    let strength = 0;
    let length = password.length;

    // Length of password
    if (length >= 8) strength++;
    if (length >= 14) strength++;

    // Uppercase letters
    if (/[A-Z]/.test(password)) strength++;

    // Lowercase letters
    if (/[a-z]/.test(password)) strength++;

    // Digits
    if (/[0-9]/.test(password)) strength++;

    // Special characters
    if (/[^a-zA-Z0-9]/.test(password)) strength++;

    // Categorize password
    if (strength < 3) return 'Very Weak';
    if (strength < 4) return 'Weak';
    if (strength < 5) return 'Medium';
    if (strength < 6) return 'Strong';
    return 'Very Strong';
}
</script>

<?php
require './assets/includes/footer.php';
?>

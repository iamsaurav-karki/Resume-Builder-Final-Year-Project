// Email validation function
function validateEmail(input) {
    const value = input.value.trim();
    const errorDiv = document.getElementById('email-error');

    // If the email field is empty, hide the error message
    if (value === '') {
        errorDiv.style.display = 'none';
        return true; // Allow further processing (empty field is not invalid)
    }

    // Validate email format using regex
    const emailRegex = /^[a-zA-Z0-9]+([._-][a-zA-Z0-9]+)*@[a-zA-Z0-9]+([.-][a-zA-Z0-9]+)*\.[a-zA-Z]{2,4}$/;
    const isValidEmail = emailRegex.test(value);

    if (!isValidEmail) {
        // If email is invalid, show the error message
        errorDiv.style.display = 'block';
        return false; // Prevent further processing
    } else {
        // If email is valid, hide the error message
        errorDiv.style.display = 'none';
        return true; // Allow further processing
    }
}

// Attach input event listener for real-time email validation
const emailInput = document.querySelector('input[name="email_id"]');
if (emailInput) {
    emailInput.addEventListener('input', function () {
        validateEmail(this);
    });
}

// Handle email validation on form submission
document.addEventListener('submit', function (event) {
    const emailInput = document.querySelector('input[name="email_id"]');
    if (emailInput) {
        const isValidEmail = validateEmail(emailInput);
        if (!isValidEmail) {
            event.preventDefault(); // Stop form submission if email is invalid
        }
    }
});
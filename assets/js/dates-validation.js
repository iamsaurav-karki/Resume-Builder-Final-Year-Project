// Reusable date validation functions
function showError(inputId, message) {
    const errorDiv = document.getElementById(`${inputId}-error`);
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
}

function hideError(inputId) {
    document.getElementById(`${inputId}-error`).style.display = 'none';
}

function validateAge(dateString, minAge) {
    const today = new Date();
    const birthDate = new Date(dateString);
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    return age >= minAge;
}

function validateDate(inputId, isDob = false) {
    const input = document.getElementById(inputId);
    if (!input || !input.value) {
        hideError(inputId);
        return true;
    }

    const date = new Date(input.value);
    const today = new Date();
    hideError(inputId);

    if (date > today) {
        showError(inputId, isDob ? "Date of birth cannot be in the future" : "Date cannot be in the future");
        return false;
    }

    if (isDob && !validateAge(input.value, 15)) {
        showError(inputId, "You must be at least 15 years old");
        return false;
    }

    return true;
}

function validateDateRange(startId, endId) {
    const startDate = new Date(document.getElementById(startId)?.value);
    const endDate = new Date(document.getElementById(endId)?.value);

    if (!startDate || !endDate) return true;
    if (endDate < startDate) {
        showError(endId, "End date cannot be before start date");
        return false;
    }
    return true;
}

function handleDateInput(e) {
    const input = e.target;
    const isDob = input.id === 'dob';
    validateDate(input.id, isDob);
}

function handleEmploymentToggle(checkboxId, endDateId) {
    const checkbox = document.getElementById(checkboxId);
    const endDate = document.getElementById(endDateId);

    if (checkbox && endDate) {
        endDate.disabled = checkbox.checked;
        if (checkbox.checked) {
            endDate.value = '';
            hideError(endDateId);
        }
    }
}

// Initialize date validation and event listeners
function initDateValidations() {
    const today = new Date().toISOString().split('T')[0];
    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.max = today;
        input.addEventListener('input', handleDateInput);
    });

    // Special max date for DOB (15 years ago)
    const dobInput = document.getElementById('dob');
    if (dobInput) {
        const minAgeDate = new Date(new Date().setFullYear(new Date().getFullYear() - 15));
        dobInput.max = minAgeDate.toISOString().split('T')[0];
    }

    // Range validation listeners
    const ranges = [
        { start: 'started', end: 'endDate' },
        { start: 'edu_started', end: 'edu_ended' }
    ];
    ranges.forEach(({ start, end }) => {
        document.getElementById(end)?.addEventListener('input', () => {
            if (validateDate(end) && validateDate(start)) {
                validateDateRange(start, end);
            }
        });
    });

    // Checkbox handlers for employment/education
    handleEmploymentToggle('currentlyWorking', 'endDate');
    handleEmploymentToggle('currentlyStudying', 'edu_ended');

    document.getElementById('currentlyWorking')?.addEventListener('change', () => handleEmploymentToggle('currentlyWorking', 'endDate'));
    document.getElementById('currentlyStudying')?.addEventListener('change', () => handleEmploymentToggle('currentlyStudying', 'edu_ended'));
}

// Form submission handler
function validateFormSubmission(e) {
    let isValid = true;

    const dateFields = ['dob', 'started', 'endDate', 'edu_started', 'edu_ended'];
    dateFields.forEach(id => {
        const isDob = id === 'dob';
        isValid &= validateDate(id, isDob);
    });

    // Date range validations
    isValid &= validateDateRange('started', 'endDate');
    isValid &= validateDateRange('edu_started', 'edu_ended');

    if (!isValid) {
        e.preventDefault();
        alert('Please fix all date validation errors before submitting.');
    }
}

// Initialize everything
document.addEventListener('DOMContentLoaded', () => {
    initDateValidations();
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', validateFormSubmission);
    });
});
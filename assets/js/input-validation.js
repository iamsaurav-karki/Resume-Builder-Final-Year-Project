// Generic cleaning function
function cleanInput(input, options) {
    let value = input.value.trim();

    // Remove disallowed characters based on the options
    value = value.replace(options.regex, '');

    // Process based on the input type
    if (options.isParagraph) {
        // For paragraph fields (e.g., objective, job description)
        // Remove everything before the first letter
        const firstLetterIndex = value.search(/[a-zA-Z]/);
        value = firstLetterIndex === -1 ? '' : value.slice(firstLetterIndex);

        // Collapse multiple full stops into a single full stop
        value = value.replace(/\.+/g, '.'); // Fix consecutive full stops

        // Remove everything after last period and ensure ending
        const lastPeriodIndex = value.lastIndexOf('.');
        if (lastPeriodIndex !== -1) {
            value = value.substring(0, lastPeriodIndex + 1);
        } else if (value.length > 0) {
            value += '.'; // Add period if missing
        }

        // Collapse multiple spaces and clean punctuation spacing
        value = value.replace(/\s+/g, ' ')
            .replace(/,(\S)/g, ', $1') // Ensure space after comma
            .replace(/\.(\S)/g, '. $1'); // Ensure space after period

        // Collapse multiple hyphens to single hyphen (if allowed)
        if (options.allowHyphen) {
            value = value.replace(/-+/g, '-');
        }
    } else if (options.allowComma) {
        // For inputs that allow commas (e.g., hobbies, languages, addresses, skills)
        value = value.split(/,+/)
            .map(part => {
                // Trim spaces and hyphens (if allowed)
                let cleaned = part.trim();
                // Collapse multiple spaces to single space
                cleaned = cleaned.replace(/\s+/g, ' ');
                // Collapse multiple hyphens to single hyphen (if allowed)
                if (options.allowHyphen) {
                    cleaned = cleaned.replace(/-+/g, '-');
                }
                return cleaned;
            })
            .filter(part => part !== '') // Remove empty parts
            .join(', '); // Join with comma + space

        // Remove any remaining leading/trailing commas or spaces
        value = value.replace(/^[, ]+|[, ]+$/g, '');
    } else {
        // For inputs that do not allow commas (e.g., resume title, full name, course, institute, position)
        // Collapse multiple spaces to single space
        value = value.replace(/\s+/g, ' ');
    }

    input.value = value;
    return true; // Allow further processing
}

// Configuration objects
const hobbiesLanguagesConfig = {
    regex: /[^a-zA-Z,\s]/g,
    allowComma: true,
    allowHyphen: false,
};

const addressConfig = {
    regex: /[^a-zA-Z0-9,\s-]/g,
    allowComma: true,
    allowHyphen: true,
};

const nameTitleConfig = {
    regex: /[^a-zA-Z\s]/g, // Allow only letters and spaces
    allowComma: false,
    allowHyphen: false,
};

const companyConfig = {
    regex: /[^a-zA-Z0-9\s]/g, // Allow letters, numbers, and spaces
    allowComma: false,
    allowHyphen: false,
};

const skillConfig = {
    regex: /[^a-zA-Z0-9,\s]/g,
    allowComma: true,
    allowHyphen: false,
};

const objectiveConfig = {
    regex: /[^a-zA-Z,.\s-]/g, // Allow letters, commas, periods, spaces, and hyphens
    isParagraph: true, // Special flag for paragraph handling
    allowHyphen: true // Allow hyphens
};

// List of validated inputs and their configurations
const validatedInputs = [
    { name: 'hobbies', config: hobbiesLanguagesConfig },
    { name: 'languages', config: hobbiesLanguagesConfig },
    { name: 'address', config: addressConfig },
    { name: 'resume_title', config: nameTitleConfig },
    { name: 'full_name', config: nameTitleConfig },
    { name: 'skill', config: skillConfig },
    { name: 'objective', config: objectiveConfig },
    { name: 'course', config: nameTitleConfig },
    { name: 'institute', config: nameTitleConfig },
    { name: 'position', config: nameTitleConfig },
    { name: 'company', config: companyConfig },
    { name: 'job_desc', config: objectiveConfig },
];

// Attach blur event listeners dynamically (works for modal inputs)
document.addEventListener('blur', function (event) {
    const input = event.target;
    const validatedInput = validatedInputs.find(item => input.name === item.name);
    if (validatedInput) {
        cleanInput(input, validatedInput.config);
    }
}, true); // Use capturing phase to catch modal inputs

// Handle form submissions from ALL forms
document.addEventListener('submit', function (event) {
    let isFormValid = true;

    // Clean all inputs before submission
    validatedInputs.forEach(({ name, config }) => {
        const input = document.querySelector(`[name="${name}"]`); // Works for both input and textarea
        if (input) {
            const isValid = cleanInput(input, config);
            if (!isValid) {
                isFormValid = false; // Prevent submission if any input is invalid
            }
        }
    });

    // Prevent form submission if any input is invalid
    if (!isFormValid) {
        event.preventDefault(); // Stop form submission
    }
});
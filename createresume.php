
<?php
$title = "Create Resume | Resume Builder";
require './assets/includes/header.php';
require './assets/includes/navbar.php';
$fn->authPage();
?>

    <div class="container">

        <div class="bg-white rounded shadow p-2 mt-4" style="min-height:80vh">
            <div class="d-flex justify-content-between border-bottom">
                <h5>Create Resume</h5>
                <div>
                    <a  class="text-decoration-none" onclick='history.back()'><i class="bi bi-arrow-left-circle"></i> Back</a>
                </div>
            </div>

            <div>

                <form action="actions/createresume.action.php" method="post" class="row g-3 p-3" style="position: relative;">
                    <div class="col-md-6">
                        <label class="form-label">Resume Title</label>
                        <input type="text" name="resume_title" id="resume_title" placeholder="Web Developer"  class="form-control" required> 
                       
                    </div>
                    <h5 class="mt-3 text-secondary"><i class="bi bi-person-badge"></i> Personal Information</h5>
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" placeholder="Ram Rai" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email_id" placeholder="ramrai@gmail.com" class="form-control" required>
                    </div>
                    <div class="col-12">
                    <label for="inputAddress" class="form-label"> Objective</label>
                    <textarea name="objective" class="form-control" rows="3" id="objective-field" required></textarea>
                    <ul id="suggestions-list" class="list-group mt-2" style="display: none;"></ul> <!-- Suggestions container -->
                </div>
                    <div class="col-md-6">
                        <label class="form-label">Mobile No</label>
                        <input type="number" min="1111111111" name="mobile_no" placeholder="9869569569" max="9999999999"
                            class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date Of Birth</label>
                        <input type="date" class="form-control" name="dob" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select class="form-select" name="gender">
                            <option>Male</option>
                            <option>Female</option>
                            <option>Others</option>




                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Religion</label>
                        <select class="form-select" name="religion">
                            <option>Hindu</option>
                            <option>Muslim</option>
                            <option>Sikh</option>
                            <option>Christian</option>

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nationality</label>
                        <select class="form-select" name ="nationality">
                            <option>Nepali</option>
                            <option>Indian</option>
                            <option>American</option>
                            <option>European</option>
                            <option>Others</option>


                        </select>
                    </div> 

                    <div class="col-md-6">
                        <label class="form-label">Marital Status</label>
                        <select class="form-select" name="marital_status">
                            <option>Married</option>
                            <option>Single</option>
                            <option>Divorced</option>
                            

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Hobbies</label>
                        <input type="text" name="hobbies" placeholder="Reading Books, Watching Movies" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Languages Known</label>
                        <input type="text" name="languages" placeholder="Nepali,English" class="form-control" required>
                    </div>

                    <script>
                        function cleanInput(input) {
                            let value = input.value.trim();
                        
                            // Remove special characters except commas, spaces, and letters
                            value = value.replace(/[^a-zA-Z,\s]/g, '');
                        
                            // Split by commas, process each part, and join with commas and a space
                            value = value.split(/,+/)
                                .map(part => part.trim().replace(/\s+/g, ' ')) // Trim and collapse spaces in each part
                                .filter(part => part !== '') // Remove empty parts
                                .join(', '); // Join valid parts with a comma and a space
                        
                            // Remove any remaining leading/trailing commas or spaces (for cases like empty input after processing)
                            value = value.replace(/^[, ]+|[, ]+$/g, '');
                        
                            input.value = value;
                        }
                    
                        // Attach the cleaning function to input events
                        document.querySelector('input[name="hobbies"]').addEventListener('blur', function () {
                            cleanInput(this);
                        });
                    
                        document.querySelector('input[name="languages"]').addEventListener('blur', function () {
                            cleanInput(this);
                        });
                    </script>

                    <div class="col-12">
                        <label for="inputAddress" class="form-label"> Address</label>
                        <input type="text" name="address" class="form-control" id="inputAddress" placeholder="Lainchaur,Kathmandu" required>
                    </div>

                    <script>
                        function cleanAddressInput(input) {
                            let value = input.value.trim();
                        
                            // Allow letters, numbers, commas, spaces, and hyphens
                            value = value.replace(/[^a-zA-Z0-9,\s-]/g, '');
                        
                            // Split by commas and process each part
                            value = value.split(/,+/)
                                .map(part => {
                                    // Trim spaces and hyphens from both ends
                                    let cleaned = part.trim();
                                    // Collapse multiple spaces to single space
                                    cleaned = cleaned.replace(/\s+/g, ' ');
                                    // Collapse multiple hyphens to single hyphen
                                    cleaned = cleaned.replace(/-+/g, '-');
                                    return cleaned;
                                })
                                .filter(part => part !== '') // Remove empty parts
                                .join(', '); // Join with comma + space
                            
                            // Remove any remaining leading/trailing commas or spaces
                            value = value.replace(/^[, ]+|[, ]+$/g, '');
                            
                            input.value = value;
                        }
                    
                        // Attach the cleaning function to address input
                        document.querySelector('input[name="address"]').addEventListener('blur', function() {
                            cleanAddressInput(this);
                        });
                    </script>


                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Add
                            Resume</button>
                    </div>
                </form>
            </div>

        </div>

    </div>
    <script>
    // Set the max attribute dynamically for Date of Birth
    const today = new Date();
    const minAge = 15;
    const maxDate = new Date(today.getFullYear() - minAge, today.getMonth(), today.getDate());
    const formattedMaxDate = maxDate.toISOString().split('T')[0];

    // Apply the max attribute to the DOB input field
    document.querySelector('input[name="dob"]').setAttribute('max', formattedMaxDate);
    
    document.querySelector('form').addEventListener('submit', function (event) {
        const dobInput = document.querySelector('input[name="dob"]');
        const emailInput = document.querySelector('input[name="email_id"]');

        // Validate Date of Birth (DOB)
        const dob = new Date(dobInput.value);
        const currentDate = new Date();

        if (dob > currentDate) {
            alert('Date of Birth cannot be in the future.');
            event.preventDefault();
            return;
        }

        // Check if the user is at least 15 years old
        if (dob > maxDate) {
            alert('You must be at least 15 years old.');
            event.preventDefault();
            return;
        }

        // Validate Email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailInput.value)) {
            alert('Please enter a valid email address.');
            event.preventDefault();
            return;
        }
    });
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
        <script>
// JavaScript for objective suggestions
document.getElementById('objective-field').addEventListener('input', function() {
    const objective = this.value.trim();
    const resumeTitle = document.querySelector('input[name="resume_title"]').value.trim(); // Get resume title
    const suggestionsList = document.getElementById('suggestions-list');
    
    if (objective.length > 2) {
        // Make an AJAX request to fetch suggestions
        fetch(`actions/objective_suggestions.php?objective=${objective}&title=${resumeTitle}`)
            .then(response => response.json())
            .then(data => {
                suggestionsList.innerHTML = ''; // Clear previous suggestions
                if (data.suggestions.length > 0) {
                    data.suggestions.forEach(suggestion => {
                        const listItem = document.createElement('li');
                        listItem.classList.add('list-group-item');
                        listItem.textContent = suggestion;
                        listItem.onclick = () => {
                            document.getElementById('objective-field').value = suggestion;
                            suggestionsList.style.display = 'none';
                        };
                        suggestionsList.appendChild(listItem);
                    });
                    suggestionsList.style.display = 'block'; // Show the suggestion list
                } else {
                    suggestionsList.style.display = 'none';
                }
            })
            .catch(err => console.error('Error fetching suggestions:', err));
    } else {
        suggestionsList.style.display = 'none'; // Hide suggestions if input is short
    }
});

// Hide suggestions when clicking outside
document.addEventListener('click', function(event) {
    const suggestionsList = document.getElementById('suggestions-list');
    if (!suggestionsList.contains(event.target) && event.target !== document.getElementById('objective-field')) {
        suggestionsList.style.display = 'none';
    }
});
</script>
</body>
</html>
</body>

</html>
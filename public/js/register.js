// Simulated Department Data (MOCK DATA)
        const mockDepartments = [
            { id: '1', name: 'Administration' }, { id: '2', name: 'Finance' },
            { id: '3', name: 'Human Resources' }, { id: '4', name: 'Communication' },
            { id: '5', name: 'Projects & Development' }, { id: '6', name: 'Logistics' },
            { id: '7', name: 'IT' }, { id: '8', name: 'Legal' },
            { id: '9', name: 'Partnerships' }, { id: '10', name: 'Education' },
            { id: '11', name: 'Health' }, { id: '12', name: 'Environment' },
            { id: '13', name: 'Research' }, { id: '14', name: 'Training' },
            { id: '15', name: 'Public Relations' }, { id: '16', name: 'Digital Marketing' },
            { id: '17', name: 'Accounting' }, { id: '18', name: 'Internal Audit' },
            { id: '19', name: 'Procurement' }, { id: '20', name: 'Maintenance' },
            { id: '21', name: 'Security' }, { id: '22', name: 'Quality' },
            { id: '23', name: 'Innovation' }, { id: '24', name: 'Sustainable Development' },
            { id: '25', name: 'Volunteering' }, { id: '26', name: 'Evaluation & Monitoring' },
            { id: '27', name: 'Fundraising' }, { id: '28', name: 'International Affairs' },
            { id: '29', name: 'Technical Support' }, { id: '30', name: 'General Services' }
        ];

        // Variables for form step management
        let currentStep = 0; // The index of the currently displayed step (starts at 0)
        const formSteps = document.querySelectorAll('.form-step'); // All form step sections
        const prevBtn = document.getElementById('prevBtn'); // "Previous" button
        const nextBtn = document.getElementById('nextBtn'); // "Next" button
        const submitBtn = document.getElementById('submitBtn'); // Final "Submit" button
        const registrationForm = document.getElementById('registrationForm'); // The entire form
        const responseMessage = document.getElementById('responseMessage'); // Message display area
        const departmentSelect = document.getElementById('departementQG'); // Department dropdown list (renamed for this form)
        const stepIndicators = document.querySelectorAll('.progress-step'); // Progress indicator circles
        const progressLines = document.querySelectorAll('.progress-line'); // Progress lines

        // Function to display a specific form step
        function showStep(stepIndex) {
            // Hide all steps
            formSteps.forEach((step, index) => {
                step.classList.remove('active');
            });
            // Display the desired step
            formSteps[stepIndex].classList.add('active');

            // Update visibility of navigation buttons
            prevBtn.style.display = (stepIndex === 0) ? 'none' : 'inline-block'; // Hide "Previous" on the first step
            nextBtn.style.display = (stepIndex === formSteps.length - 1) ? 'none' : 'inline-block'; // Hide "Next" on the last step
            submitBtn.style.display = (stepIndex === formSteps.length - 1) ? 'inline-block' : 'none'; // Display "Submit" on the last step

            // Update visual progress indicator
            updateProgressIndicators(stepIndex);
        }

        // Function to validate fields of the current step before proceeding to the next
        function validateCurrentStep() {
            const currentActiveStep = document.querySelector('.form-step.active');
            // Select all required fields EXCEPT 'hidden' type inputs
            const inputs = currentActiveStep.querySelectorAll('input[required]:not([type="hidden"]), select[required], textarea[required]');
            let allValid = true;

            inputs.forEach(input => {
                // For radio groups, ensure at least one is selected if required
                if (input.type === 'radio' && input.name && input.required) {
                    const radioGroup = document.querySelectorAll(`input[name="${input.name}"]`);
                    const isChecked = Array.from(radioGroup).some(radio => radio.checked);
                    if (!isChecked) {
                        allValid = false;
                        // Optional: Add visual styling to indicate error
                        // radioGroup[0].closest('.radio-group').style.border = '1px solid red';
                    } else {
                        // radioGroup[0].closest('.radio-group').style.border = 'none';
                    }
                } else if (!input.checkValidity()) { // checkValidity() is a built-in HTML5 validation method
                    allValid = false;
                    input.classList.add('border-red-500'); // Add Tailwind class for error
                } else {
                    input.classList.remove('border-red-500'); // Remove error class if valid
                }
            });
            return allValid;
        }

        // Function to update the visual progress indicators
        function updateProgressIndicators(stepIndex) {
            stepIndicators.forEach((indicator, index) => {
                indicator.classList.remove('active-step', 'completed-step');
                if (index < stepIndex) {
                    indicator.classList.add('completed-step');
                } else if (index === stepIndex) {
                    indicator.classList.add('active-step');
                }
            });

            progressLines.forEach((line, index) => {
                line.classList.remove('completed-line');
                if (index < stepIndex) {
                    line.classList.add('completed-line');
                }
            });
        }

        // Event listener for "Next" button click
        nextBtn.addEventListener('click', () => {
            if (validateCurrentStep()) {
                currentStep++;
                showStep(currentStep);
            } else {
                displayMessage('Please fill in all required fields.', 'error');
            }
        });

        // Event listener for "Previous" button click
        prevBtn.addEventListener('click', () => {
            currentStep--;
            showStep(currentStep);
            hideMessage(); // Hide message when navigating back
        });

        // Event listener for form submission
        registrationForm.addEventListener('submit', async (e) => {
            e.preventDefault(); // Prevent default form submission

            if (!validateCurrentStep()) {
                displayMessage('Please fill in all required fields before submitting.', 'error');
                return;
            }

            // Collect form data
            const formData = new FormData(registrationForm);
            const data = {};
            for (let [key, value] of formData.entries()) {
                // Handle file inputs separately if needed for actual upload
                if (value instanceof File) {
                    // For this simulation, we'll just store the file name
                    data[key] = value.name;
                } else {
                    data[key] = value;
                }
            }

            console.log('Form data:', data); // Log the collected data

            // Simulate API call
            try {
                // In a real application, you would send this data to a server
                // const response = await fetch('/api/register', {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json'
                //     },
                //     body: JSON.stringify(data)
                // });
                // const result = await response.json();

                // Mock API success response
                setTimeout(() => {
                    displayMessage('Registration successful! Thank you.', 'success');
                    registrationForm.reset(); // Clear the form
                    showStep(0); // Go back to the first step
                }, 1000);

            } catch (error) {
                console.error('Submission error:', error);
                displayMessage('An error occurred during registration. Please try again.', 'error');
            }
        });

        // Function to display messages (success/error)
        function displayMessage(message, type) {
            responseMessage.textContent = message;
            responseMessage.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');
            if (type === 'success') {
                responseMessage.classList.add('bg-green-100', 'text-green-700');
            } else if (type === 'error') {
                responseMessage.classList.add('bg-red-100', 'text-red-700');
            }
            responseMessage.style.display = 'block'; // Ensure it's visible
        }

        // Function to hide messages
        function hideMessage() {
            responseMessage.classList.add('hidden');
        }

        // Populate department dropdown on page load
        function populateDepartments() {
            // Clear existing options, keeping the placeholder
            departmentSelect.innerHTML = '<option value="">Which Department at HQ?</option>';
            mockDepartments.forEach(dept => {
                const option = document.createElement('option');
                option.value = dept.id;
                option.textContent = dept.name;
                departmentSelect.appendChild(option);
            });
        }

        // Initialize form on page load
        document.addEventListener('DOMContentLoaded', () => {
            showStep(currentStep); // Display the first step
            populateDepartments(); // Populate the department dropdown
        });

// Function to fetch departments from PHP (if you decide to make it dynamic)
async function fetchDepartments() {
    try {
        const response = await fetch('api/get_departments.php'); // Your PHP endpoint for departments
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const departments = await response.json();
        // Clear existing options, keeping the placeholder
        departmentSelect.innerHTML = '<option value="">Which Department at HQ?</option>';
        departments.forEach(dept => {
            const option = document.createElement('option');
            option.value = dept.id; // Assuming PHP returns id
            option.textContent = dept.name; // Assuming PHP returns name
            departmentSelect.appendChild(option);
        });
    } catch (error) {
        console.error('Error fetching departments:', error);
        // Fallback to mockDepartments if fetching fails
        populateDepartmentsFromMock();
    }
}

// Function to populate departments from mock data (your existing function, possibly renamed)
function populateDepartmentsFromMock() {
    departmentSelect.innerHTML = '<option value="">Which Department at HQ?</option>';
    mockDepartments.forEach(dept => {
        const option = document.createElement('option');
        option.value = dept.id;
        option.textContent = dept.name;
        departmentSelect.appendChild(option);
    });
}


// Modified Event listener for form submission
registrationForm.addEventListener('submit', async (e) => {
    e.preventDefault(); // Prevent default form submission

    if (!validateCurrentStep()) {
        displayMessage('Please fill in all required fields before submitting.', 'error');
        return;
    }

    // Collect form data
    const formData = new FormData(registrationForm);
    const data = {};

    // Process all fields, including file inputs
    for (let [key, value] of formData.entries()) {
        // Handle boolean values for radio buttons more explicitly if needed
        if (value === 'Yes') {
            data[key] = true;
        } else if (value === 'No') {
            data[key] = false;
        } else {
            data[key] = value;
        }
    }

    console.log('Form data to send:', data);

    try {
        // Ajout du token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Send data to Laravel endpoint
        const response = await fetch('/register', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        if (response.ok) {
            // Redirection vers la page de login
            window.location.href = '/login';
        } else {
            const result = await response.json();
            displayMessage(result.message || 'An error occurred during registration. Please try again.', 'error');
        }

    } catch (error) {
        console.error('Submission error:', error);
        displayMessage('A network error occurred. Please check your connection and try again.', 'error');
    }
});

// Initialize form on page load
document.addEventListener('DOMContentLoaded', () => {
    showStep(currentStep); // Display the first step
    // Decide whether to fetch dynamically or use mock data
    // fetchDepartments(); // Uncomment this line if you implement get_departments.php
    populateDepartmentsFromMock(); // Keep this if you're using static mock data
});

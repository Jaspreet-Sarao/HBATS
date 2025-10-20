document.addEventListener("DOMContentLoaded", () => {
    const searchForm = document.getElementById("searchForm");
    const patientDetails = document.getElementById("patient-details");
    const errorBox = document.getElementById("errorBox");
    const searchInput = document.querySelector('input[name="q"]');
    
    // Simple search input handling
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            if (e.target.value.length === 0) {
                hidePatientDetails();
            }
        });
    }

    if (searchForm) {
        searchForm.addEventListener("submit", (e) => {
            const searchTerm = searchInput.value.trim();
            if (!searchTerm) {
                e.preventDefault();
                alert('Please enter a search term.');
                searchInput.focus();
                return false;
            }
            
            // Show loading state but allow form to submit
            showSearchLoading();
            // Don't prevent default - let the form submit normally
        });
    }
    
    // Generate passcode form handling
    const generateForm = document.querySelector('form[action*="passcode.generate"]');
    if (generateForm) {
        generateForm.addEventListener('submit', (e) => {
            const expirySelect = generateForm.querySelector('select[name="expiry"]');
            if (!expirySelect.value) {
                e.preventDefault();
                alert('Please select expiry duration.');
                return false;
            }
            
            // Show loading state
            const submitBtn = generateForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.textContent = 'Generating...';
                submitBtn.disabled = true;
            }
        });
    }
    
    // Invalidate passcode form handling
    const invalidateForm = document.querySelector('form[action*="passcode.invalidate"]');
    if (invalidateForm) {
        invalidateForm.addEventListener('submit', (e) => {
            const reasonSelect = invalidateForm.querySelector('select[name="reason"]');
            if (!reasonSelect.value) {
                e.preventDefault();
                alert('Please select a reason for invalidation.');
                return false;
            }
            
            // Confirm invalidation
            if (!confirm('Are you sure you want to invalidate the current passcode?')) {
                e.preventDefault();
                return false;
            }
            
            // Show loading state
            const submitBtn = invalidateForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.textContent = 'Invalidating...';
                submitBtn.disabled = true;
            }
        });
    }
    
    // Auto-generate passcode preview
    const autoGenerateCheckbox = document.querySelector('input[name="auto_generate"]');
    if (autoGenerateCheckbox) {
        autoGenerateCheckbox.addEventListener('change', (e) => {
            if (e.target.checked) {
                showPasscodePreview();
            } else {
                hidePasscodePreview();
            }
        });
    }
    
    function showSearchLoading() {
        const submitBtn = searchForm.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.textContent = 'Searching...';
            submitBtn.disabled = true;
        }
    }
    
    function hidePatientDetails() {
        if (patientDetails) {
            patientDetails.style.display = "none";
        }
        if (errorBox) {
            errorBox.style.display = "block";
        }
    }
    
    function showPatientDetails() {
        if (patientDetails) {
            patientDetails.style.display = "block";
        }
        if (errorBox) {
            errorBox.style.display = "none";
        }
    }
    
    function showPasscodePreview() {
        const previewContainer = document.getElementById('passcodePreview');
        if (!previewContainer) {
            const container = document.createElement('div');
            container.id = 'passcodePreview';
            container.className = 'info-box';
            container.innerHTML = `
                <h4>Passcode Preview</h4>
                <p><strong>Generated Code:</strong> <span id="previewCode">${generateRandomCode()}</span></p>
                <p><strong>Expires:</strong> <span id="previewExpiry">24 hours from now</span></p>
            `;
            
            const generateForm = document.querySelector('form[action*="passcode.generate"]');
            if (generateForm) {
                generateForm.parentNode.insertBefore(container, generateForm);
            }
        }
    }
    
    function hidePasscodePreview() {
        const previewContainer = document.getElementById('passcodePreview');
        if (previewContainer) {
            previewContainer.remove();
        }
    }
    
    function generateRandomCode() {
        return Math.random().toString(36).substring(2, 8).toUpperCase();
    }
    
    // Initialize - check if patient details are already visible
    setTimeout(() => {
        if (patientDetails) {
            const hasPatientData = patientDetails.querySelector('h4') && patientDetails.querySelector('h4').textContent.includes('Patient Information');
            if (hasPatientData) {
                // Patient details are already loaded, show them
                showPatientDetails();
            } else {
                // No patient details, hide them
                hidePatientDetails();
            }
        }
    }, 100);
});



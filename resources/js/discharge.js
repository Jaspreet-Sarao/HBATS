document.addEventListener("DOMContentLoaded", () => {
    const searchForm = document.getElementById("searchForm");
    const dischargeDetails = document.getElementById("dischargeDetails");
    const confirmCheck = document.getElementById("confirmDischarge");
    const completeBtn = document.getElementById("completeBtn");
    const searchInput = document.querySelector('input[name="q"]');
    
    // Simple search input handling
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            if (e.target.value.length === 0) {
                hideDischargeDetails();
            }
        });
    }
    
    // Show hidden section after discharge
    if (searchForm) {
        searchForm.addEventListener("submit", (e) => {
            const searchTerm = searchInput.value.trim();
            if (!searchTerm) {
                e.preventDefault();
                alert('Please enter a search term.');
                searchInput.focus();
                return false;
            }
            // Allow form to submit normally - don't prevent default
        });
    }
    
    // Enable complete button only if confirmed
    if (confirmCheck && completeBtn) {
        confirmCheck.addEventListener("change", () => {
            completeBtn.disabled = !confirmCheck.checked;
            updateStepIndicator(confirmCheck.checked ? 3 : 2);
        });
    }
    
    // Form validation for discharge
    const dischargeForm = document.querySelector('form[action*="discharge.complete"]');
    if (dischargeForm) {
        dischargeForm.addEventListener('submit', (e) => {
            const dischargeTime = document.querySelector('input[name="discharge_time"]');
            const dischargeType = document.querySelector('select[name="discharge_type"]');
            
            if (!dischargeTime.value) {
                e.preventDefault();
                alert('Please select discharge date and time.');
                dischargeTime.focus();
                return false;
            }
            
            if (!dischargeType.value) {
                e.preventDefault();
                alert('Please select discharge type.');
                dischargeType.focus();
                return false;
            }
            
            if (!confirmCheck.checked) {
                e.preventDefault();
                alert('Please confirm the discharge.');
                return false;
            }
            
            // Show loading state
            completeBtn.textContent = 'Processing Discharge...';
            completeBtn.disabled = true;
        });
    }
    
    
    function hideDischargeDetails() {
        if (dischargeDetails) {
            dischargeDetails.classList.add("hidden");
        }
        updateStepIndicator(1);
    }
    
    function updateStepIndicator(activeStep) {
        const steps = document.querySelectorAll('.step');
        steps.forEach((step, index) => {
            step.classList.remove('active', 'completed');
            if (index + 1 < activeStep) {
                step.classList.add('completed');
                // Update circle content for completed steps
                const circle = step.querySelector('.circle');
                if (circle && index + 1 < activeStep) {
                    circle.textContent = '✓';
                }
            } else if (index + 1 === activeStep) {
                step.classList.add('active');
                // Update circle content for active step
                const circle = step.querySelector('.circle');
                if (circle) {
                    circle.textContent = index + 1;
                }
            } else {
                // Reset circle content for inactive steps
                const circle = step.querySelector('.circle');
                if (circle) {
                    circle.textContent = index + 1;
                }
            }
        });
    }
    
    function showPatientDetails() {
        if (dischargeDetails) {
            dischargeDetails.style.display = "block";
        }
    }
    
    // Initialize - check if patient details are already visible
    if (dischargeDetails) {
        const hasPatientData = dischargeDetails.querySelector('h4') && dischargeDetails.querySelector('h4').textContent.includes('Patient Information');
        if (hasPatientData) {
            // Patient details are already loaded, show them
            showPatientDetails();
            updateStepIndicator(2);
        } else {
            // No patient details, hide them
            hideDischargeDetails();
        }
    } else {
        // No discharge details section, start with step 1
        updateStepIndicator(1);
    }
    
    // Initialize
    updateStepIndicator(1);
});
document.addEventListener("DOMContentLoaded", () => {
    const bedInputs = document.querySelectorAll('input[name="bed_id"]');
    const selectDisplay = document.getElementById('selectedBed');
    const wardFilter = document.getElementById('ward');
    const bedGrid = document.querySelector('.bed-grid');
    const admissionForm = document.getElementById('admissionForm');
    
    // Bed selection functionality
    bedInputs.forEach(input => {
        input.addEventListener('change', () => {
            const selected = document.querySelector('input[name="bed_id"]:checked');
            if (selectDisplay) {
                selectDisplay.innerText = selected ? selected.parentElement.textContent.trim() : 'None';
            }
            
            // Update step indicator
            updateStepIndicator(2);
        });
    });
    
    // Ward filtering functionality
    if (wardFilter) {
        wardFilter.addEventListener('change', () => {
            filterBedsByWard();
        });
    }
    
    // Form validation
    if (admissionForm) {
        admissionForm.addEventListener('submit', (e) => {
            const selectedBed = document.querySelector('input[name="bed_id"]:checked');
            const patientName = document.querySelector('input[name="name"]');
            
            if (!selectedBed) {
                e.preventDefault();
                alert('Please select a bed before proceeding.');
                return false;
            }
            
            if (!patientName.value.trim()) {
                e.preventDefault();
                alert('Please enter patient name.');
                patientName.focus();
                return false;
            }
            
            // Show loading state
            const submitBtn = admissionForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.textContent = 'Processing...';
                submitBtn.disabled = true;
            }
        });
    }
    
    function filterBedsByWard() {
        const selectedWardId = wardFilter.value;
        const allBeds = document.querySelectorAll('input[name="bed_id"]');
        
        allBeds.forEach(bedInput => {
            const bedContainer = bedInput.closest('label');
            if (selectedWardId === '' || bedContainer.dataset.wardId === selectedWardId) {
                bedContainer.style.display = 'block';
            } else {
                bedContainer.style.display = 'none';
                bedInput.checked = false; // Uncheck hidden beds
            }
        });
        
        // Update selected bed display
        const selected = document.querySelector('input[name="bed_id"]:checked');
        if (selectDisplay) {
            selectDisplay.innerText = selected ? selected.parentElement.textContent.trim() : 'None';
        }
    }
    
    function updateStepIndicator(activeStep) {
        const steps = document.querySelectorAll('.step');
        steps.forEach((step, index) => {
            step.classList.remove('active', 'completed');
            if (index + 1 < activeStep) {
                step.classList.add('completed');
            } else if (index + 1 === activeStep) {
                step.classList.add('active');
            }
        });
    }
    
    // Initialize
    updateStepIndicator(1);
});

document.addEventListener("DOMContentLoaded", () => {
    const viewBtns = document.querySelectorAll(".toggle-view");
    const editBtns = document.querySelectorAll(".toggle-edit");
    const deleteBtns = document.querySelectorAll(".toggle-delete");
    const cancelEditBtns = document.querySelectorAll(".cancel-edit");
    const cancelDeleteBtns = document.querySelectorAll(".cancel-delete");
    const addWardForm = document.getElementById("addWardForm");
    const settingsCheckboxes = document.querySelectorAll('.settings-list input[type="checkbox"]');
    
    viewBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            const section = document.getElementById(btn.dataset.target);
            if (section) {
                section.classList.toggle("hidden");
                // Update button text
                btn.textContent = section.classList.contains("hidden") ? "View" : "Hide";
            }
        });
    });

    editBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            const section = document.getElementById(btn.dataset.target);
            if (section) {
                section.classList.toggle("hidden");
                // Update button text
                btn.textContent = section.classList.contains("hidden") ? "Edit" : "Cancel Edit";
            }
        });
    });

    deleteBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            const section = document.getElementById(btn.dataset.target);
            if (section) {
                section.classList.toggle("hidden");
                // Update button text
                btn.textContent = section.classList.contains("hidden") ? "Delete" : "Cancel Delete";
            }
        });
    });

    cancelEditBtns.forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const wardSection = btn.closest(".ward-section");
            if (wardSection) {
                wardSection.classList.add("hidden");
            }
        });
    });

    cancelDeleteBtns.forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const wardSection = btn.closest(".ward-section");
            if (wardSection) {
                wardSection.classList.add("hidden");
            }
        });
    });

    // Add ward form validation
    if (addWardForm) {
        addWardForm.addEventListener('submit', (e) => {
            const wardName = addWardForm.querySelector('input[name="name"]');
            const wardCode = addWardForm.querySelector('input[name="code"]');
            const totalBeds = addWardForm.querySelector('input[name="total_beds"]');
            
            if (!wardName.value.trim()) {
                e.preventDefault();
                alert('Please enter ward name.');
                wardName.focus();
                return false;
            }
            
            if (!wardCode.value.trim()) {
                e.preventDefault();
                alert('Please enter ward code.');
                wardCode.focus();
                return false;
            }
            
            if (!totalBeds.value || totalBeds.value < 1) {
                e.preventDefault();
                alert('Please enter a valid number of beds (minimum 1).');
                totalBeds.focus();
                return false;
            }
            
            // Show loading state
            const submitBtn = addWardForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.textContent = 'Creating Ward...';
                submitBtn.disabled = true;
            }
        });
    }

    // Settings checkboxes with real-time updates
    settingsCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', (e) => {
            const setting = e.target.closest('label').textContent.trim();
            const isEnabled = e.target.checked;
            
            // Show feedback
            showSettingsFeedback(setting, isEnabled);
            
            // In a real app, this would make an AJAX call to save settings
            console.log(`Setting "${setting}" ${isEnabled ? 'enabled' : 'disabled'}`);
        });
    });

    // Ward management forms
    const editForms = document.querySelectorAll('form[action*="ward"]');
    editForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const wardName = form.querySelector('input[type="text"]');
            const wardCode = form.querySelectorAll('input[type="text"]')[1];
            const totalBeds = form.querySelector('input[type="number"]');
            
            if (!wardName.value.trim()) {
                e.preventDefault();
                alert('Please enter ward name.');
                wardName.focus();
                return false;
            }
            
            if (!wardCode.value.trim()) {
                e.preventDefault();
                alert('Please enter ward code.');
                wardCode.focus();
                return false;
            }
            
            if (!totalBeds.value || totalBeds.value < 1) {
                e.preventDefault();
                alert('Please enter a valid number of beds (minimum 1).');
                totalBeds.focus();
                return false;
            }
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.textContent = 'Saving...';
                submitBtn.disabled = true;
            }
        });
    });

    // Delete confirmation
    const deleteButtons = document.querySelectorAll('button[class*="danger"]');
    deleteButtons.forEach(btn => {
        if (btn.textContent.includes('Delete')) {
            btn.addEventListener('click', (e) => {
                if (!confirm('Are you sure you want to delete this ward? This action cannot be undone.')) {
                    e.preventDefault();
                    return false;
                }
                
                // Show loading state
                btn.textContent = 'Deleting...';
                btn.disabled = true;
            });
        }
    });

    function showSettingsFeedback(setting, isEnabled) {
        // Create temporary feedback element
        const feedback = document.createElement('div');
        feedback.className = 'settings-feedback';
        feedback.textContent = `${setting} ${isEnabled ? 'enabled' : 'disabled'}`;
        feedback.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${isEnabled ? '#4CAF50' : '#f44336'};
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            z-index: 1000;
            font-size: 14px;
        `;
        
        document.body.appendChild(feedback);
        
        // Remove after 3 seconds
        setTimeout(() => {
            feedback.remove();
        }, 3000);
    }

    // Auto-save settings (simulate)
    let settingsTimeout;
    settingsCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            clearTimeout(settingsTimeout);
            settingsTimeout = setTimeout(() => {
                console.log('Settings auto-saved');
                showSettingsFeedback('Settings', true);
            }, 2000);
        });
    });
});
    

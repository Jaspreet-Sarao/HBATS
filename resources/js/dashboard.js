document.addEventListener("DOMContentLoaded", () => {
    // Get all elements
    const wardFilter = document.getElementById('wardFilter');
    const statusFilter = document.getElementById('statusFilter');
    const searchBox = document.getElementById('searchbox');
    const wardSections = document.querySelectorAll('.ward-section');
    const bedElements = document.querySelectorAll('.bed');
    
    // Statistics elements
    const totalBedsElement = document.querySelector('.stat-box h3');
    const availableElement = document.querySelector('.stat-box.available h3');
    const occupiedElement = document.querySelector('.stat-box.occupied h3');
    const rateElement = document.querySelector('.stat-box.rate h3');
    
    // Store original data
    const originalWards = Array.from(wardSections).map(section => ({
        element: section,
        name: section.querySelector('h3').textContent,
        beds: Array.from(section.querySelectorAll('.bed')).map(bed => ({
            element: bed,
            number: bed.querySelector('.bed-id').textContent,
            patient: bed.querySelector('.bed-data').textContent,
            status: bed.querySelector('.status-red, .status-green') ? 
                   (bed.querySelector('.status-red') ? 'occupied' : 'available') : 'unknown'
        }))
    }));
    
    // Filter functions
    function filterWards() {
        const selectedWard = wardFilter.value;
        const selectedStatus = statusFilter.value;
        const searchTerm = searchBox.value.toLowerCase();
        
        let filteredBeds = [];
        let totalFilteredBeds = 0;
        let availableFilteredBeds = 0;
        let occupiedFilteredBeds = 0;
        
        wardSections.forEach(section => {
            const wardName = section.querySelector('h3').textContent.toLowerCase();
            const beds = section.querySelectorAll('.bed');
            let showWard = true;
            let wardBedCount = 0;
            let wardAvailableCount = 0;
            let wardOccupiedCount = 0;
            
            // Filter by ward
            if (selectedWard !== 'all' && !wardName.includes(selectedWard.toLowerCase())) {
                showWard = false;
            }
            
            // Filter beds within ward
            beds.forEach(bed => {
                const bedNumber = bed.querySelector('.bed-id').textContent.toLowerCase();
                const patientName = bed.querySelector('.bed-data').textContent.toLowerCase();
                const isOccupied = bed.querySelector('.status-red') !== null;
                const isAvailable = bed.querySelector('.status-green') !== null;
                
                let showBed = true;
                
                // Filter by status
                if (selectedStatus === 'available' && !isAvailable) {
                    showBed = false;
                } else if (selectedStatus === 'occupied' && !isOccupied) {
                    showBed = false;
                }
                
                // Filter by search term
                if (searchTerm && !bedNumber.includes(searchTerm) && !patientName.includes(searchTerm)) {
                    showBed = false;
                }
                
                if (showBed) {
                    bed.style.display = 'block';
                    wardBedCount++;
                    if (isOccupied) {
                        wardOccupiedCount++;
                    } else if (isAvailable) {
                        wardAvailableCount++;
                    }
                } else {
                    bed.style.display = 'none';
                }
            });
            
            // Show/hide ward section
            if (showWard && wardBedCount > 0) {
                section.style.display = 'block';
                filteredBeds.push(...Array.from(beds).filter(bed => bed.style.display !== 'none'));
                totalFilteredBeds += wardBedCount;
                availableFilteredBeds += wardAvailableCount;
                occupiedFilteredBeds += wardOccupiedCount;
            } else {
                section.style.display = 'none';
            }
        });
        
        // Update statistics
        updateStatistics(totalFilteredBeds, availableFilteredBeds, occupiedFilteredBeds);
    }
    
    function updateStatistics(total, available, occupied) {
        if (totalBedsElement) totalBedsElement.textContent = total;
        if (availableElement) availableElement.textContent = available;
        if (occupiedElement) occupiedElement.textContent = occupied;
        
        const rate = total > 0 ? Math.round((occupied / total) * 100 * 10) / 10 : 0;
        if (rateElement) rateElement.textContent = rate + '%';
    }
    
    // Event listeners
    if (wardFilter) {
        wardFilter.addEventListener('change', filterWards);
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterWards);
    }
    
    if (searchBox) {
        searchBox.addEventListener('input', filterWards);
    }
    
    // Initialize with all data visible
    filterWards();
});


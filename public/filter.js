document.addEventListener('DOMContentLoaded', () => {
    // Close all dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.filter-select-container')) {
            document.querySelectorAll('.filter-select-header').forEach(header => {
                header.classList.remove('active');
            });
        }
    });

    // Toggle dropdown on header click
    document.querySelectorAll('.filter-select-header').forEach(header => {
        header.addEventListener('click', (e) => {
            e.stopPropagation();
            const wasActive = header.classList.contains('active');
            
            // Close all other dropdowns
            document.querySelectorAll('.filter-select-header').forEach(h => {
                h.classList.remove('active');
            });

            // Toggle current dropdown
            if (!wasActive) {
                header.classList.add('active');
            }
        });
    });

    // Handle price range inputs
    const minInput = document.getElementById('min-price');
    const maxInput = document.getElementById('max-price');
    const rangeSlider = document.getElementById('price-range');

    if (minInput && maxInput && rangeSlider) {
        minInput.addEventListener('input', updateRange);
        maxInput.addEventListener('input', updateRange);
    }

    function updateRange() {
        const min = parseInt(minInput.value) || 0;
        const max = parseInt(maxInput.value) || 2000;
        rangeSlider.value = ((max - min) / 2000) * 100;
    }
});

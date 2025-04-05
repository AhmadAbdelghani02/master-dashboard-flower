document.addEventListener('DOMContentLoaded', function() {
    // Handle the discount type change
    const discountTypeSelect = document.getElementById('discount_type');
    const discountSymbol = document.getElementById('discount-symbol');
    
    if (discountTypeSelect && discountSymbol) {
        // Function to update the symbol
        function updateDiscountSymbol() {
            const isPercentage = discountTypeSelect.value === 'percentage';
            discountSymbol.textContent = isPercentage ? '%' : '$';
        }
        
        // Set initial value and add event listener
        updateDiscountSymbol();
        discountTypeSelect.addEventListener('change', updateDiscountSymbol);
    }
    
    // Handle datetime formatting for the form
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    // Format the datetime-local inputs if they exist and have values
    [startDateInput, endDateInput].forEach(input => {
        if (input && input.value && !input.value.includes('T')) {
            // Convert date string to datetime-local format if needed
            const date = new Date(input.value);
            if (!isNaN(date)) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                
                input.value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }
        }
    });
});
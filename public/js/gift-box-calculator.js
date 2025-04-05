document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const flowerSelect = document.getElementById('flower_id');
    const chocolateSelect = document.getElementById('chocolate_id');
    const packagingSelect = document.getElementById('packaging_id');
    const quantityInput = document.getElementById('quantity');
    const priceInput = document.getElementById('price');
    
    // Store product prices
    const productPrices = {
        flowers: {},
        chocolates: {},
        packagings: {}
    };
    
    // Initialize product prices
    function initProductPrices() {
        // Parse flower prices
        if (flowerSelect) {
            Array.from(flowerSelect.options).forEach(option => {
                if (option.value) {
                    const priceText = option.text.match(/\$([0-9]+(\.[0-9]+)?)/);
                    if (priceText && priceText[1]) {
                        productPrices.flowers[option.value] = parseFloat(priceText[1]);
                    }
                }
            });
        }
        
        // Parse chocolate prices
        if (chocolateSelect) {
            Array.from(chocolateSelect.options).forEach(option => {
                if (option.value) {
                    const priceText = option.text.match(/\$([0-9]+(\.[0-9]+)?)/);
                    if (priceText && priceText[1]) {
                        productPrices.chocolates[option.value] = parseFloat(priceText[1]);
                    }
                }
            });
        }
        
        // Parse packaging prices
        if (packagingSelect) {
            Array.from(packagingSelect.options).forEach(option => {
                if (option.value) {
                    const priceText = option.text.match(/\$([0-9]+(\.[0-9]+)?)/);
                    if (priceText && priceText[1]) {
                        productPrices.packagings[option.value] = parseFloat(priceText[1]);
                    }
                }
            });
        }
    }
    
    // Calculate total price
    function calculateTotalPrice() {
        const flowerId = flowerSelect.value;
        const chocolateId = chocolateSelect.value;
        const packagingId = packagingSelect.value;
        const quantity = parseInt(quantityInput.value) || 1;
        
        let totalPrice = 0;
        
        if (flowerId && productPrices.flowers[flowerId]) {
            totalPrice += productPrices.flowers[flowerId];
        }
        
        if (chocolateId && productPrices.chocolates[chocolateId]) {
            totalPrice += productPrices.chocolates[chocolateId];
        }
        
        if (packagingId && productPrices.packagings[packagingId]) {
            totalPrice += productPrices.packagings[packagingId];
        }
        
        // Multiply by quantity
        totalPrice *= quantity;
        
        // Update price input
        if (priceInput && totalPrice > 0) {
            priceInput.value = totalPrice.toFixed(2);
        }
    }
    
    // Initialize prices and add event listeners
    if (flowerSelect && chocolateSelect && packagingSelect && quantityInput && priceInput) {
        initProductPrices();
        
        flowerSelect.addEventListener('change', calculateTotalPrice);
        chocolateSelect.addEventListener('change', calculateTotalPrice);
        packagingSelect.addEventListener('change', calculateTotalPrice);
        quantityInput.addEventListener('change', calculateTotalPrice);
        quantityInput.addEventListener('input', calculateTotalPrice);
        
        // Add a calculate button next to the price field
        const calculateButton = document.createElement('button');
        calculateButton.type = 'button';
        calculateButton.className = 'ml-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded';
        calculateButton.textContent = 'Calculate';
        calculateButton.addEventListener('click', calculateTotalPrice);
        
        priceInput.parentNode.parentNode.appendChild(calculateButton);
    }
});
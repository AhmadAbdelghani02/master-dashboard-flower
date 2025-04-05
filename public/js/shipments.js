document.addEventListener('DOMContentLoaded', function() {
    // Auto-update status when actual delivery date is set
    const actualDeliveryInput = document.getElementById('actual_delivery');
    const statusSelect = document.getElementById('status');
    
    if (actualDeliveryInput && statusSelect) {
        actualDeliveryInput.addEventListener('change', function() {
            if (this.value && statusSelect.value !== 'Delivered' && statusSelect.value !== 'Cancelled') {
                statusSelect.value = 'Delivered';
            }
        });
    }
    
    // Validation for dates
    const shippingDateInput = document.getElementById('shipping_date');
    const estimatedDeliveryInput = document.getElementById('estimated_delivery');
    
    if (shippingDateInput && estimatedDeliveryInput) {
        estimatedDeliveryInput.addEventListener('change', function() {
            if (shippingDateInput.value && this.value) {
                const shippingDate = new Date(shippingDateInput.value);
                const estimatedDate = new Date(this.value);
                
                if (estimatedDate < shippingDate) {
                    alert('Estimated delivery date cannot be earlier than shipping date');
                    this.value = '';
                }
            }
        });
        
        if (actualDeliveryInput) {
            actualDeliveryInput.addEventListener('change', function() {
                if (shippingDateInput.value && this.value) {
                    const shippingDate = new Date(shippingDateInput.value);
                    const actualDate = new Date(this.value);
                    
                    if (actualDate < shippingDate) {
                        alert('Actual delivery date cannot be earlier than shipping date');
                        this.value = '';
                    }
                }
            });
        }
    }
    
    // Status color preview
    const statusPreview = document.getElementById('status-preview');
    if (statusSelect && statusPreview) {
        statusSelect.addEventListener('change', function() {
            const status = this.value;
            let bgColor = 'bg-gray-100';
            let textColor = 'text-gray-800';
            
            switch(status) {
                case 'Delivered':
                    bgColor = 'bg-green-100';
                    textColor = 'text-green-800';
                    break;
                case 'In Transit':
                    bgColor = 'bg-blue-100';
                    textColor = 'text-blue-800';
                    break;
                case 'Processing':
                case 'Packed':
                    bgColor = 'bg-yellow-100';
                    textColor = 'text-yellow-800';
                    break;
                case 'Cancelled':
                    bgColor = 'bg-red-100';
                    textColor = 'text-red-800';
                    break;
            }
            
            statusPreview.className = `px-2 py-1 text-xs rounded-full ${bgColor} ${textColor}`;
            statusPreview.textContent = status;
        });
    }
});
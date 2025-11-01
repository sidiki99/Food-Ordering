

// Quantity Control
document.querySelectorAll('.quantity-btn').forEach(button => {
    button.addEventListener('click', function() {
        const input = this.parentNode.querySelector('.quantity-input');
        let value = parseInt(input.value);
        
        if (this.classList.contains('minus')) {
            value = isNaN(value) ? 0 : value;
            value = value < 1 ? 0 : value - 1;
        } else if (this.classList.contains('plus')) {
            value = isNaN(value) ? 1 : value + 1;
        }
        
        input.value = value;
        updateBilling();
    });
});

// Billing Calculation
function updateBilling() {
    const billItems = document.getElementById('billItems');
    const billTotal = document.getElementById('billTotal');
    
    billItems.innerHTML = '';
    let total = 0;
    let hasItems = false;
    
    document.querySelectorAll('.food-item').forEach(item => {
        const quantity = parseInt(item.querySelector('.quantity-input').value);
        if (quantity > 0) {
            hasItems = true;
            const price = parseInt(item.dataset.price);
            const subtotal = quantity * price;
            total += subtotal;
            
            const itemName = item.querySelector('.food-name').textContent.trim();
            
            const billItem = document.createElement('div');
            billItem.className = 'bill-item';
            billItem.innerHTML = `
                <span>${itemName} × ${quantity}</span>
                <span>Rs. ${subtotal}</span>
            `;
            billItems.appendChild(billItem);
        }
    });
    
    billTotal.textContent = `Rs. ${total}`;
}

// Initialize quantity inputs to update billing when changed manually
document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', updateBilling);
});

// Initialize billing on page load
updateBilling();
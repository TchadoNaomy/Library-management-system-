document.addEventListener('DOMContentLoaded', function() {
    const createOrderBtn = document.getElementById('create-order-btn');
    const orderModal = document.getElementById('order-modal');
    const closeBtn = orderModal.querySelector('.close-btn');
    const orderForm = document.getElementById('order-form');
    const addItemBtn = document.getElementById('add-item-btn');
    const orderItems = document.getElementById('order-items');
    
    // Load suppliers into select dropdown
    async function loadSuppliers() {
        try {
            const response = await fetch('../../Backend/Admin/getSuppliers.php');
            const suppliers = await response.json();
            
            const select = document.getElementById('supplier-select');
            select.innerHTML = '<option value="">Select a supplier</option>';
            
            suppliers.forEach(supplier => {
                select.innerHTML += `
                    <option value="${supplier.supplier_id}">${supplier.name}</option>
                `;
            });
        } catch (error) {
            console.error('Error loading suppliers:', error);
        }
    }

    // Add new item row
    function addItemRow() {
        const itemRow = document.createElement('div');
        itemRow.className = 'item-row';
        itemRow.innerHTML = `
            <div class="form-group">
                <input type="text" name="items[][name]" placeholder="Item Name" required>
                <input type="number" name="items[][quantity]" placeholder="Quantity" min="1" required>
                <input type="number" name="items[][unit_price]" placeholder="Unit Price" min="0" step="0.01" required>
                <button type="button" class="remove-item-btn">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        orderItems.appendChild(itemRow);

        // Add remove functionality
        const removeBtn = itemRow.querySelector('.remove-item-btn');
        removeBtn.addEventListener('click', () => itemRow.remove());
    }

    // Show modal
    createOrderBtn.addEventListener('click', function() {
        orderModal.classList.add('show');
        loadSuppliers();
        // Add first item row
        if (orderItems.children.length === 0) {
            addItemRow();
        }
    });

    // Close modal
    closeBtn.addEventListener('click', function() {
        orderModal.classList.remove('show');
    });

    // Add item button
    addItemBtn.addEventListener('click', addItemRow);

    // Form submission
    orderForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const submitBtn = this.querySelector('.submit-btn');
        submitBtn.disabled = true;

        try {
            const formData = new FormData(this);
            const response = await fetch('../../Backend/Admin/createOrder.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                alert('Order created successfully');
                orderModal.classList.remove('show');
                location.reload(); // Refresh to show new order
            } else {
                throw new Error(data.message || 'Failed to create order');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(error.message);
        } finally {
            submitBtn.disabled = false;
        }
    });
});
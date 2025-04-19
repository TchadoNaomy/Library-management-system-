document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const supplierModal = document.getElementById('supplier-modal');
    const orderModal = document.getElementById('order-modal');
    
    // Get button elements
    const addSupplierBtn = document.getElementById('add-supplier-btn');
    const createOrderBtn = document.getElementById('create-order-btn');
    
    // Get all close buttons
    const closeButtons = document.querySelectorAll('.close-btn');
    
    // Show Supplier Modal
    addSupplierBtn.addEventListener('click', function() {
        supplierModal.classList.add('show');
        document.getElementById('supplier-form').reset(); // Reset form
        document.getElementById('supplier-modal-title').textContent = 'Add Supplier';
    });
    
    // Show Order Modal
    createOrderBtn.addEventListener('click', function() {
        orderModal.classList.add('show');
        document.getElementById('order-form').reset(); // Reset form
        document.getElementById('order-modal-title').textContent = 'Create Purchase Order';
    });
    
    // Close Modal Functionality
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            modal.classList.remove('show');
        });
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.classList.remove('show');
        }
    });
    
    // Prevent modal close when clicking modal content
    document.querySelectorAll('.modal-content').forEach(content => {
        content.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });
    
    // Handle Escape key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.modal').forEach(modal => {
                modal.classList.remove('show');
            });
        }
    });
    
    // Form submission handlers
    const supplierForm = document.getElementById('supplier-form');
    const orderForm = document.getElementById('order-form');
    
    supplierForm.addEventListener('submit', function(event) {
        event.preventDefault();
        // Add your supplier form submission logic here
        supplierModal.classList.remove('show');
    });
    
    orderForm.addEventListener('submit', function(event) {
        event.preventDefault();
        // Add your order form submission logic here
        orderModal.classList.remove('show');
    });
    
    // Handle supplier form submission
    async function handleSupplierSubmit(event) {
        event.preventDefault();
        const form = event.target;
        const submitButton = form.querySelector('.submit-btn');
        const supplierId = form.querySelector('#supplier-id').value;
        
        try {
            submitButton.disabled = true;
            const formData = new FormData(form);
            
            // Validate form data
            validateSupplierForm(formData);
            
            const url = supplierId ? 
                '../../Backend/Admin/Supplier.php' : 
                '../../Backend/Admin/addSupplier.php';
            
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });

            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Server returned non-JSON response');
            }

            const data = await response.json();
            
            if (data.success) {
                alert(data.message);
                form.reset();
                document.getElementById('supplier-modal').classList.remove('show');
                
                // Reload suppliers table
                const supplierTableBody = document.getElementById('suppliers-table-body');
                if (supplierTableBody) {
                    const tableResponse = await fetch('../../Backend/Admin/getSuppliers.php');
                    supplierTableBody.innerHTML = await tableResponse.text();
                }
            } else {
                throw new Error(data.message || 'Failed to save supplier');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(error.message || 'An error occurred while saving the supplier');
        } finally {
            submitButton.disabled = false;
        }
    }

    // Add event listener to supplier form
    document.getElementById('supplier-form').addEventListener('submit', handleSupplierSubmit);

    // Form validation
    function validateSupplierForm(formData) {
        const email = formData.get('email');
        const contact = formData.get('contact');
        
        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            throw new Error('Please enter a valid email address');
        }
        
        // Phone number validation (adjust regex according to your needs)
        const phoneRegex = /^\+?[\d\s-]{10,}$/;
        if (!phoneRegex.test(contact)) {
            throw new Error('Please enter a valid phone number');
        }
        
        // Name validation
        const name = formData.get('name');
        if (name.length < 2) {
            throw new Error('Name must be at least 2 characters long');
        }
        
        // Address validation
        const address = formData.get('address');
        if (address.length < 5) {
            throw new Error('Please enter a valid address');
        }
    }

    // Handle edit button clicks
    document.addEventListener('click', async function(e) {
        if (e.target.closest('.edit-btn')) {
            const button = e.target.closest('.edit-btn');
            const supplierId = button.getAttribute('data-id');
            
            if (!supplierId) {
                console.error('No supplier ID found');
                return;
            }

            // Show loading state
            const originalContent = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            try {
                // Get supplier data first
                const params = new URLSearchParams();
                params.append('supplier_id', supplierId);

                const response = await fetch('../../Backend/Admin/editSupplier.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: params
                });

                const data = await response.json();

                if (data.success) {
                    // Populate form with supplier data
                    const form = document.getElementById('supplier-form');
                    form.querySelector('#supplier-id').value = data.supplier.supplier_id;
                    form.querySelector('#supplier-name').value = data.supplier.name;
                    form.querySelector('#supplier-email').value = data.supplier.email;
                    form.querySelector('#supplier-contact').value = data.supplier.phone_number;
                    form.querySelector('#supplier-address').value = data.supplier.address;

                    // Update modal title and show
                    document.getElementById('supplier-modal-title').textContent = 'Edit Supplier';
                    document.getElementById('supplier-modal').classList.add('show');
                } else {
                    throw new Error(data.message || 'Failed to fetch supplier details');
                }
            } catch (error) {
                console.error('Error:', error);
                alert(error.message);
            } finally {
                // Reset button state
                button.innerHTML = originalContent;
                button.disabled = false;
            }
        }
    });

    // Handle form submission for both add and edit
    document.getElementById('supplier-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = this;
        const submitBtn = form.querySelector('.submit-btn');
        const supplierId = form.querySelector('#supplier-id').value;

        try {
            submitBtn.disabled = true;
            const formData = new FormData(form);
            
            // Determine if this is an add or edit operation
            const url = supplierId ? 
                '../../Backend/Admin/updateSupplier.php' : 
                '../../Backend/Admin/addSupplier.php';

            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                form.reset();
                document.getElementById('supplier-modal').classList.remove('show');
                
                // Refresh the suppliers table
                location.reload();
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert(error.message);
        } finally {
            submitBtn.disabled = false;
        }
    });

    // Add delete functionality
    document.addEventListener('click', async function(e) {
        if (e.target.closest('.delete-btn')) {
            const button = e.target.closest('.delete-btn');
            const supplierId = button.getAttribute('data-id');
            
            if (!supplierId) {
                console.error('No supplier ID found');
                return;
            }

            // Confirm deletion
            if (!confirm('Are you sure you want to delete this supplier?')) {
                return;
            }

            // Show loading state
            const originalContent = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            try {
                const response = await fetch('../../Backend/Admin/deleteSupplier.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'Accept': 'application/json'
                    },
                    body: `supplier_id=${encodeURIComponent(supplierId)}`
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    // Remove the row from the table
                    const row = button.closest('tr');
                    row.remove();
                    alert('Supplier deleted successfully');
                } else {
                    throw new Error(data.message || 'Failed to delete supplier');
                }
            } catch (error) {
                console.error('Error:', error);
                alert(`Failed to delete supplier: ${error.message}`);
            } finally {
                // Reset button state
                button.innerHTML = originalContent;
                button.disabled = false;
            }
        }
    });

    // Handle form submission
    document.getElementById('supplier-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = this;
        const submitBtn = form.querySelector('.submit-btn');

        try {
            // Validate form fields before submission
            const name = form.querySelector('#supplier-name').value.trim();
            const email = form.querySelector('#supplier-email').value.trim();
            const contact = form.querySelector('#supplier-contact').value.trim();
            const address = form.querySelector('#supplier-address').value.trim();
            const supplierId = form.querySelector('#supplier-id').value;

            // Check for empty fields
            if (!name || !email || !contact || !address) {
                throw new Error('Please fill in all required fields');
            }

            submitBtn.disabled = true;
            
            // Create FormData and explicitly append all fields
            const formData = new FormData();
            formData.append('supplier_id', supplierId);
            formData.append('name', name);
            formData.append('email', email);
            formData.append('phone_number', contact);
            formData.append('address', address);

            const response = await fetch('../../Backend/Admin/editSupplier.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                // Update the table row
                const row = document.querySelector(`tr[data-id="${supplierId}"]`);
                if (row) {
                    row.innerHTML = `
                        <td>${data.supplier.supplier_id}</td>
                        <td>${data.supplier.name}</td>
                        <td>${data.supplier.email}</td>
                        <td>${data.supplier.phone_number}</td>
                        <td>${data.supplier.address}</td>
                        <td>
                            <button class="edit-btn" data-id="${data.supplier.supplier_id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="delete-btn" data-id="${data.supplier.supplier_id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                }

                // Close modal and show success message
                document.getElementById('supplier-modal').classList.remove('show');
                alert('Supplier updated successfully');
            } else {
                throw new Error(data.message || 'Failed to update supplier');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(error.message);
        } finally {
            submitBtn.disabled = false;
        }
    });
});

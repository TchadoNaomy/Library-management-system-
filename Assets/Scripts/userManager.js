// script to handle the delete user action confirmation popup

document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('popup');
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
    const closeBtn = popup.querySelector('.close-btn');
    let selectedUserId = null;

    // Add click event to all delete buttons
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            selectedUserId = this.getAttribute('data-id');
            console.log('Selected user ID:', selectedUserId); // Debug log
            popup.style.display = 'flex';
        });
    });

    // Handle delete confirmation
    confirmDeleteBtn.addEventListener('click', function() {
        if (!selectedUserId) {
            console.error('No user ID selected');
            return;
        }

        const formData = new FormData();
        formData.append('user_id', selectedUserId);

        // Debug log
        console.log('Sending delete request for user ID:', selectedUserId);

        fetch('../../Backend/Admin/deleteUser.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Server response:', data); // Debug log
            if (data.success) {
                const row = document.querySelector(`button[data-id="${selectedUserId}"]`).closest('tr');
                row.remove();
                popup.style.display = 'none';
                alert(data.message);
            } else {
                throw new Error(data.message || 'Failed to delete user');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message);
        });
    });

    // Handle suspend/unsuspend button clicks
    document.querySelectorAll('.suspend-btn, .unsuspend-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const userId = this.getAttribute('data-id');
            const action = this.classList.contains('suspend-btn') ? 'suspend' : 'unsuspend';
            const confirmMessage = action === 'suspend' ? 
                'Are you sure you want to suspend this user?' : 
                'Are you sure you want to unsuspend this user? They will be restored as a client.';
            
            if (confirm(confirmMessage)) {
                const formData = new FormData();
                formData.append('user_id', userId);
                formData.append('action', action);

                fetch('../../Backend/Admin/suspendUser.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Reload to show updated status
                    } else {
                        alert(data.message || 'Failed to update user status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating user status');
                });
            }
        });
    });

    // Edit functionality
    const editButtons = document.querySelectorAll('.edit-btn');
    const editPopup = document.getElementById('edit-popup');
    const editForm = document.getElementById('edit-user-form');
    const editUserIdInput = document.getElementById('edit-user-id');
    const editRoleSelect = document.getElementById('edit-role');
    const editCloseBtn = editPopup.querySelector('.close-btn');

    // Show edit popup
    editButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const userId = this.getAttribute('data-id');
            const currentRole = this.closest('tr').querySelector('td:nth-child(4)').textContent.trim();
            
            editUserIdInput.value = userId;
            editRoleSelect.value = currentRole;
            editPopup.style.display = 'flex';
        });
    });

    // Handle form submission
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('user_id', editUserIdInput.value);
        formData.append('role', editRoleSelect.value);

        fetch('../../Backend/Admin/editUser.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the role in the table
                const row = document.querySelector(`button[data-id="${editUserIdInput.value}"]`).closest('tr');
                row.querySelector('td:nth-child(4)').textContent = data.newRole;
                
                // Update suspend/unsuspend button visibility
                const actionCell = row.querySelector('td:last-child');
                if (data.newRole === 'suspended') {
                    actionCell.querySelector('.suspend-btn')?.closest('abbr').replaceWith(
                        `<abbr title="Restore User">
                            <button class="unsuspend-btn" data-id="${editUserIdInput.value}">
                                <i class="fas fa-user-check"></i>
                            </button>
                        </abbr>`
                    );
                }
                
                editPopup.style.display = 'none';
                alert(data.message);
            } else {
                alert(data.message || 'Failed to update user');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating user');
        });
    });

    // Close edit popup
    editCloseBtn.addEventListener('click', () => {
        editPopup.style.display = 'none';
    });

    // Close on outside click
    window.addEventListener('click', (e) => {
        if (e.target === editPopup) {
            editPopup.style.display = 'none';
        }
    });

    // Close popup handlers
    cancelDeleteBtn.addEventListener('click', () => {
        popup.style.display = 'none';
        selectedUserId = null;
    });

    closeBtn.addEventListener('click', () => {
        popup.style.display = 'none';
        selectedUserId = null;
    });

    window.addEventListener('click', (e) => {
        if (e.target === popup) {
            popup.style.display = 'none';
            selectedUserId = null;
        }
    });
});
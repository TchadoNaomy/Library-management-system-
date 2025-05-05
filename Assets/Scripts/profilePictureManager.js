document.addEventListener('DOMContentLoaded', function() {
    const profilePicForm = document.getElementById('profile-pic-form');
    const profileImages = document.querySelectorAll('.profilePic img'); // Get all profile images in the page

    if (profilePicForm) {
        profilePicForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('../../Backend/User/profileUpdate.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update all profile images on the page
                    const fileReader = new FileReader();
                    fileReader.onload = function(e) {
                        profileImages.forEach(img => {
                            img.src = e.target.result;
                        });
                    };
                    
                    // Read the uploaded file
                    const fileInput = document.getElementById('profile_image');
                    if (fileInput.files && fileInput.files[0]) {
                        fileReader.readAsDataURL(fileInput.files[0]);
                    }

                    alert(data.message);
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message);
            });
        });
    }
});
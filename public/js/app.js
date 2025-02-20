document.addEventListener('DOMContentLoaded', function () {
    const signupDropdown = document.querySelector('.signup-dropdown');
    const signupBtn = document.querySelector('.signup-btn');

    if (signupBtn && signupDropdown) {
        signupBtn.addEventListener('click', function (event) {
            event.stopPropagation(); // Prevent click from propagating
            signupDropdown.classList.toggle('active');
        });

        // Close the dropdown if clicking outside
        document.addEventListener('click', function () {
            if (signupDropdown.classList.contains('active')) {
                signupDropdown.classList.remove('active');
            }
        });
    }
});

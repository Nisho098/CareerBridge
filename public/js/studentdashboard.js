document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM fully loaded");

    document.querySelectorAll('.dropdown-btn').forEach((dropdownBtn) => {
        console.log("Found dropdown:", dropdownBtn); // Check if buttons exist

        dropdownBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            console.log("Dropdown clicked");

            const dropdownMenu = dropdownBtn.nextElementSibling;
            if (!dropdownMenu) {
                console.error("Dropdown menu not found for this button.");
                return;
            }

            document.querySelectorAll('.dropdown-menu').forEach((menu) => {
                if (menu !== dropdownMenu) menu.style.display = 'none';
            });

            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });
    });

    document.addEventListener('click', function () {
        console.log("Clicked outside, closing dropdowns");
        document.querySelectorAll('.dropdown-menu').forEach((menu) => {
            menu.style.display = 'none';
        });
    });
});


 




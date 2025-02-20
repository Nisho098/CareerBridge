document.addEventListener("DOMContentLoaded", function () {
    // Select all dropdown buttons
    document.querySelectorAll(".dropdown-btn").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevent the click from closing the menu immediately

            // Find the corresponding dropdown menu
            let dropdownMenu = this.nextElementSibling;

            if (!dropdownMenu) {
                console.error("Dropdown menu not found.");
                return;
            }

            // Close all other open dropdowns
            document.querySelectorAll(".dropdown-menu").forEach((menu) => {
                if (menu !== dropdownMenu) menu.classList.remove("show");
            });

            // Toggle the clicked dropdown menu
            dropdownMenu.classList.toggle("show");
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function () {
        document.querySelectorAll(".dropdown-menu").forEach((menu) => {
            menu.classList.remove("show");
        });
    });

    // Prevent closing when clicking inside dropdown
    document.querySelectorAll(".dropdown-menu").forEach((menu) => {
        menu.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    });
});

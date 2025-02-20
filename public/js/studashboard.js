// function toggleDropdown(button) {
//     try {
//         // Close any open dropdowns
//         const openDropdowns = document.querySelectorAll(".dropdown-menu");
//         openDropdowns.forEach((menu) => (menu.style.display = "none"));

//         // Toggle the current dropdown
//         const dropdown = button.nextElementSibling;
//         if (dropdown) {
//             dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
//         } else {
//             console.error("Dropdown element not found for the button.");
//         }
//     } catch (error) {
//         console.error("Error in toggleDropdown function:", error);
//     }
// }

// // Close dropdown if clicked outside
// document.addEventListener("click", (event) => {
//     try {
//         const isDropdown = event.target.closest(".action-container");
//         if (!isDropdown) {
//             const dropdowns = document.querySelectorAll(".dropdown-menu");
//             dropdowns.forEach((menu) => (menu.style.display = "none"));
//         }
//     } catch (error) {
//         console.error("Error in document click event:", error);
//     }
// });

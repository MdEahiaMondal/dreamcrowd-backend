// Common Sidebar Script for Admin Dashboard
// This script handles sidebar toggle, menu arrows, and responsive behavior

(function() {
    'use strict';

    function initSidebar() {
        // Arrow toggle for submenu
        let arrow = document.querySelectorAll(".arrow");
        let submenu = document.querySelectorAll(".iocn-link");
        

        for (let i = 0; i < submenu.length; i++) {
            submenu[i].addEventListener("click", function (e) {
                console.log(e.target.parentElement);
                
                let submenuArrowParent = e.target.parentElement.parentElement.parentElement; // Selecting main parent of arrow
                submenuArrowParent.classList.toggle("showMenu");
            });
        }
        
        
        for (let i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", function (e) {
                let arrowParent = e.target.parentElement.parentElement; // Selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }

        // Sidebar toggle
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");

        if (sidebarBtn) {
            sidebarBtn.addEventListener("click", function () {
                sidebar.classList.toggle("close");
            });
        }

        // Function to toggle sidebar based on screen size
        function toggleSidebar() {
            let screenWidth = window.innerWidth;
            if (screenWidth < 992) {
                sidebar.classList.add("close");
            } else {
                sidebar.classList.remove("close");
            }
        }

        // Call the function initially
        if (sidebar) {
            toggleSidebar();

            // Listen for resize events to adjust sidebar
            window.addEventListener("resize", function () {
                toggleSidebar();
            });
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebar);
    } else {
        initSidebar();
    }
})();

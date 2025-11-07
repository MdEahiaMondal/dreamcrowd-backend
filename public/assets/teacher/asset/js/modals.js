// Common Modal Script for Teacher Dashboard
// This script handles delete account modal interactions

(function() {
    'use strict';

    function initModals() {
        // Check if jQuery is loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is required for modals.js');
            return;
        }

        // Delete account modal handlers
        $(document).ready(function () {
            $(document).on("click", "#delete-account", function (e) {
                e.preventDefault();
                $("#exampleModal7").modal("show");
                $("#delete-teacher-account").modal("hide");
            });

            $(document).on("click", "#delete-account", function (e) {
                e.preventDefault();
                $("#delete-teacher-account").modal("show");
                $("#exampleModal7").modal("hide");
            });
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initModals);
    } else {
        initModals();
    }
})();

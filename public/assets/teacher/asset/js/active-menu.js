// Active Menu Item Script
// Automatically highlights the active menu item based on current URL

(function() {
    'use strict';

    function normalizeUrl(url) {
        // Remove trailing slashes and normalize URL
        return url.replace(/\/+$/, '').toLowerCase();
    }

    function setActiveMenu() {
        const currentPath = normalizeUrl(window.location.pathname);
        const navLinks = document.querySelectorAll('.sidebar .nav-links > li');
        let foundMatch = false;

        console.log('Active Menu: Current path:', currentPath);
        console.log('Active Menu: Found', navLinks.length, 'menu items');

        // Remove all active and showMenu classes first
        navLinks.forEach(li => {
            li.classList.remove('active');
            li.classList.remove('showMenu');
        });

        // Build array of all links with their parent li elements
        const linkMap = [];
        navLinks.forEach(li => {
            const links = li.querySelectorAll('a');
            links.forEach(link => {
                const href = link.getAttribute('href');
                if (href && href !== '#' && href !== 'javascript:void(0)') {
                    linkMap.push({
                        li: li,
                        href: href,
                        normalized: normalizeUrl(href),
                        link: link
                    });
                }
            });
        });

        // Sort by specificity (longer paths first for better matching)
        linkMap.sort((a, b) => b.normalized.length - a.normalized.length);

        // Find the best match
        for (const item of linkMap) {
            const normalizedHref = item.normalized;

            // Skip empty paths
            if (normalizedHref === '') {
                continue;
            }

            // Check for exact match first (highest priority)
            if (currentPath === normalizedHref) {
                console.log('Active Menu: Exact match found:', item.href);
                item.li.classList.add('active');
                foundMatch = true;

                // If it has a sub-menu, open it
                if (item.li.querySelector('.sub-menu:not(.blank)')) {
                    item.li.classList.add('showMenu');
                }
                break;
            }

            // Check for .html pages without extension
            if (item.href.endsWith('.html')) {
                const withoutExt = normalizedHref.replace(/\.html$/, '');
                if (currentPath === withoutExt || currentPath.startsWith(withoutExt + '/')) {
                    console.log('Active Menu: HTML match found:', item.href);
                    item.li.classList.add('active');
                    foundMatch = true;
                    break;
                }
            }

            // Check if current path starts with href (for sub-routes)
            // Only if href is more than just root
            if (normalizedHref.length > 1 && currentPath.startsWith(normalizedHref)) {
                console.log('Active Menu: Partial match found:', item.href);
                item.li.classList.add('active');
                foundMatch = true;

                // If it has a sub-menu, open it
                if (item.li.querySelector('.sub-menu:not(.blank)')) {
                    item.li.classList.add('showMenu');
                }
                break;
            }
        }

        // Special handling for dashboard home pages
        if (!foundMatch) {
            if (currentPath === '' || currentPath === '/' ||
                currentPath === '/admin-dashboard' ||
                currentPath === '/teacher-dashboard' ||
                currentPath === '/user-dashboard') {
                console.log('Active Menu: Dashboard page detected');
                const dashboardLink = document.querySelector('.sidebar .nav-links > li:first-child');
                if (dashboardLink) {
                    dashboardLink.classList.add('active');
                    foundMatch = true;
                }
            }
        }

        if (!foundMatch) {
            console.log('Active Menu: No match found for path:', currentPath);
        }
    }

    // Initialize when DOM is ready
    function init() {
        console.log('Active Menu: Initializing...');
        setActiveMenu();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Also run on page show (for back/forward navigation)
    window.addEventListener('pageshow', function(event) {
        console.log('Active Menu: Page show event');
        setActiveMenu();
    });
})();

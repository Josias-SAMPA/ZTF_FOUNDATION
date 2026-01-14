// Handle hamburger menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    const navLinks = document.getElementById('navLinks');
    const mainNavbar = document.getElementById('mainNavbar');

    // Toggle mobile menu
    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            hamburgerMenu.classList.toggle('active');
        });
    }

    // Close menu when a link is clicked
    if (navLinks) {
        const links = navLinks.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.classList.remove('active');
                if (hamburgerMenu) {
                    hamburgerMenu.classList.remove('active');
                }
            });
        });
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (hamburgerMenu && navLinks) {
            if (!hamburgerMenu.contains(event.target) && !navLinks.contains(event.target)) {
                navLinks.classList.remove('active');
                hamburgerMenu.classList.remove('active');
            }
        }
    });

    // Scroll effect on navbar
    window.addEventListener('scroll', function() {
        if (mainNavbar) {
            if (window.scrollY > 50) {
                mainNavbar.classList.add('scrolled');
            } else {
                mainNavbar.classList.remove('scrolled');
            }
        }
    });

    // Handle window resize to close menu on desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            navLinks.classList.remove('active');
            if (hamburgerMenu) {
                hamburgerMenu.classList.remove('active');
            }
        }
    });
});

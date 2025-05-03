// Sticky navbar scroll effect
window.addEventListener("scroll", function () {
    const navbar = document.querySelector(".nav-bar");
    const scrollY = window.scrollY;
  
    if (scrollY > 60) {
      navbar.classList.add("sticky");
    } else {
      navbar.classList.remove("sticky");
    }
  });

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any required functionality
    console.log('DOM fully loaded');

    // Get the sidebar elements
    const sidebar = document.getElementById('mySidebar');
    const menuBtn = document.getElementById('menuBtn');
    const closeBtn = document.querySelector('.sidebar .closebtn');
    
    // Toggle sidebar when menu button is clicked
    menuBtn.addEventListener('click', function() {
        sidebar.classList.toggle('open');
    });
    
    // Close sidebar when close button is clicked
    closeBtn.addEventListener('click', function() {
        sidebar.classList.remove('open');
    });
    
    // Close sidebar when clicking outside of it
    document.addEventListener('click', function(event) {
        if (!sidebar.contains(event.target) && 
            event.target !== menuBtn && 
            sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
        }
    });
    
    // Stop propagation on sidebar clicks to prevent close-when-clicking-outside behavior
    sidebar.addEventListener('click', function(event) {
        event.stopPropagation();
    });

    // Profile dropdown functionality
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    
    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });
        
        // Close dropdown when clicking elsewhere on the page
        document.addEventListener('click', function(e) {
            if (profileDropdown.classList.contains('show') && !e.target.closest('.profile-container')) {
                profileDropdown.classList.remove('show');
            }
        });
    }
});

/* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
    document.body.style.marginLeft = "250px";
}

/* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.body.style.marginLeft = "0";
}

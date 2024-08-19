
    document.addEventListener("DOMContentLoaded", function() {
    const sidebarLinks = document.querySelectorAll('.sidebar a[data-target]');
    const sections = document.querySelectorAll('.content-section');

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            // Hide all content sections
            sections.forEach(section => {
                section.style.display = 'none';
            });

            // Show the selected content section
            const targetId = this.getAttribute('data-target');
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.style.display = 'block';
            }
        });
    });

    // Optionally, show the welcome message by default
    document.getElementById('welcome-message').style.display = 'block';
});


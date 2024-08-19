document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');
    const sections = document.querySelectorAll('.content-section');

    toggleBtn.addEventListener('click', function () {
        sidebar.classList.toggle('active');
    });

    document.querySelectorAll('.sidebar ul li a').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            // Hide all sections
            sections.forEach(section => section.classList.remove('active'));

            // Show the clicked section
            const target = document.querySelector(link.getAttribute('href'));
            if (target) {
                target.classList.add('active');
            }
        });
    });
});

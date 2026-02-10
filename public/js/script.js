document.addEventListener('DOMContentLoaded', function () {

    // Sidebar toggle
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    if (sidebar && overlay) {
        document.getElementById('sidebarOverlay').addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });
    }

    window.toggleSidebar = function () {
        if (sidebar && overlay) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    };

    // Select2 initialization
    if (window.jQuery && $('#serviceName').length) {
        $('#serviceName').select2({
            placeholder: "-- Select Service --",
            allowClear: true,
            width: '100%'
        });
    }

    // CKEditor initialization
    if (typeof CKEDITOR !== 'undefined' && document.getElementById('description')) {
        CKEDITOR.replace('description');
    }



    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const dropdown = this.closest('.dropdown');
            setTimeout(() => {
                if (dropdown?.classList.contains('show')) {
                    dropdown.querySelector('.dropdown-menu')?.style.setProperty('animation', 'fadeIn 0.3s ease-out');
                }
            }, 10);
        });
    });

});

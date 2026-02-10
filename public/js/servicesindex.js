
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Auto-focus search input when page loads
            const searchInput = document.getElementById('searchService');
            if (searchInput && !searchInput.value) {
                searchInput.focus();
            }

            // Enhanced search form with loading state
            const searchForm = document.querySelector('.search-form');
            if (searchForm) {
                searchForm.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;

                    // Show loading state
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Searching...';
                    submitBtn.disabled = true;

                    // Add loading overlay
                    const loadingOverlay = document.createElement('div');
                    loadingOverlay.className = 'loading-overlay';
                    loadingOverlay.innerHTML = '<div class="loading-spinner"></div>';
                    document.body.appendChild(loadingOverlay);

                    // Re-enable after 5 seconds as fallback
                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                        if (document.body.contains(loadingOverlay)) {
                            document.body.removeChild(loadingOverlay);
                        }
                    }, 5000);
                });
            }

            // Enhanced delete confirmation with SweetAlert-style
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const serviceName = this.querySelector('button').getAttribute(
                        'data-service-name');

                    // Create custom confirmation modal
                    const confirmModal = document.createElement('div');
                    confirmModal.className = 'modal fade';
                    confirmModal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="modal-body text-center p-5">
                            <div class="mb-4">
                                <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="mb-3 fw-bold">Delete Service</h4>
                            <p class="mb-4 text-muted">
                                Are you sure you want to delete "<strong>${serviceName}</strong>"?
                                <br><small class="text-danger">This action cannot be undone.</small>
                            </p>
                            <div class="d-flex gap-3 justify-content-center">
                                <button type="button" class="btn btn-secondary modern-btn" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-1"></i>Cancel
                                </button>
                                <button type="button" class="btn btn-danger modern-btn" id="confirmDelete">
                                    <i class="bi bi-trash3 me-1"></i>Delete Service
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                    document.body.appendChild(confirmModal);
                    const modal = new bootstrap.Modal(confirmModal);
                    modal.show();

                    // Handle confirmation
                    confirmModal.querySelector('#confirmDelete').addEventListener('click', () => {
                        modal.hide();

                        // Show loading state
                        const loadingOverlay = document.createElement('div');
                        loadingOverlay.className = 'loading-overlay';
                        loadingOverlay.innerHTML = '<div class="loading-spinner"></div>';
                        document.body.appendChild(loadingOverlay);

                        // Submit form
                        this.submit();
                    });

                    // Clean up modal after hiding
                    confirmModal.addEventListener('hidden.bs.modal', () => {
                        document.body.removeChild(confirmModal);
                    });
                });
            });

            // Add smooth scrolling to pagination links
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add loading state for pagination
                    const loadingOverlay = document.createElement('div');
                    loadingOverlay.className = 'loading-overlay';
                    loadingOverlay.innerHTML = '<div class="loading-spinner"></div>';
                    document.body.appendChild(loadingOverlay);

                    // Remove loading after 3 seconds as fallback
                    setTimeout(() => {
                        if (document.body.contains(loadingOverlay)) {
                            document.body.removeChild(loadingOverlay);
                        }
                    }, 3000);
                });
            });

            // Add entrance animation to table rows
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all service rows
            document.querySelectorAll('.service-row').forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                row.style.transition = `all 0.6s ease ${index * 0.1}s`;
                observer.observe(row);
            });
        });

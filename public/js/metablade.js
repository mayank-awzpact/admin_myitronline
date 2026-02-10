
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            const searchInput = document.getElementById('searchMeta');
            if (searchInput && !searchInput.value) {
                searchInput.focus();
            }

            const searchForm = document.querySelector('.search-form');
            if (searchForm) {
                searchForm.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;

                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Searching...';
                    submitBtn.disabled = true;

                    const loadingOverlay = document.createElement('div');
                    loadingOverlay.className = 'loading-overlay';
                    loadingOverlay.innerHTML = '<div class="loading-spinner"></div>';
                    document.body.appendChild(loadingOverlay);

                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                        if (document.body.contains(loadingOverlay)) {
                            document.body.removeChild(loadingOverlay);
                        }
                    }, 5000);
                });
            }


            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const metaTitle = this.querySelector('button').getAttribute('data-meta-title');


                    const confirmModal = document.createElement('div');
                    confirmModal.className = 'modal fade';
                    confirmModal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="modal-body text-center p-5">
                            <div class="mb-4">
                                <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="mb-3 fw-bold">Delete Meta Entry</h4>
                            <p class="mb-4 text-muted">
                                Are you sure you want to delete the meta entry for "<strong>${metaTitle}</strong>"?
                                <br><small class="text-danger">This action cannot be undone.</small>
                            </p>
                            <div class="d-flex gap-3 justify-content-center">
                                <button type="button" class="btn btn-secondary modern-btn" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-1"></i>Cancel
                                </button>
                                <button type="button" class="btn btn-danger modern-btn" id="confirmDelete">
                                    <i class="bi bi-trash3 me-1"></i>Delete Meta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                    document.body.appendChild(confirmModal);
                    const modal = new bootstrap.Modal(confirmModal);
                    modal.show();


                    confirmModal.querySelector('#confirmDelete').addEventListener('click', () => {
                        modal.hide();

                        const loadingOverlay = document.createElement('div');
                        loadingOverlay.className = 'loading-overlay';
                        loadingOverlay.innerHTML = '<div class="loading-spinner"></div>';
                        document.body.appendChild(loadingOverlay);

                        this.submit();
                    });

                    confirmModal.addEventListener('hidden.bs.modal', () => {
                        document.body.removeChild(confirmModal);
                    });
                });
            });

            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function(e) {

                    const loadingOverlay = document.createElement('div');
                    loadingOverlay.className = 'loading-overlay';
                    loadingOverlay.innerHTML = '<div class="loading-spinner"></div>';
                    document.body.appendChild(loadingOverlay);

                    setTimeout(() => {
                        if (document.body.contains(loadingOverlay)) {
                            document.body.removeChild(loadingOverlay);
                        }
                    }, 3000);
                });
            });

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


            document.querySelectorAll('.meta-row').forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                row.style.transition = `all 0.6s ease ${index * 0.1}s`;
                observer.observe(row);
            });

            document.querySelectorAll('.text-truncate').forEach(element => {
                element.addEventListener('mouseenter', function() {
                    if (this.scrollWidth > this.clientWidth) {
                        this.style.overflow = 'visible';
                        this.style.whiteSpace = 'normal';
                        this.style.position = 'relative';
                        this.style.zIndex = '10';
                        this.style.background = 'white';
                        this.style.padding = '0.5rem';
                        this.style.borderRadius = '8px';
                        this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.2)';
                    }
                });

                element.addEventListener('mouseleave', function() {
                    this.style.overflow = 'hidden';
                    this.style.whiteSpace = 'nowrap';
                    this.style.position = 'static';
                    this.style.zIndex = 'auto';
                    this.style.background = 'transparent';
                    this.style.padding = '0';
                    this.style.borderRadius = '0';
                    this.style.boxShadow = 'none';
                });
            });
        });

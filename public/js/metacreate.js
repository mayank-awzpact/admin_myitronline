
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Character counters and progress bars
            const titleInput = document.getElementById('seo_title');
            const titleCounter = document.getElementById('titleCounter');
            const titleProgress = document.getElementById('titleProgress');

            const descInput = document.getElementById('seo_description');
            const descCounter = document.getElementById('descCounter');
            const descProgress = document.getElementById('descProgress');

            // Preview elements
            const previewTitle = document.getElementById('previewTitle');
            const previewDescription = document.getElementById('previewDescription');
            const previewDomain = document.getElementById('previewDomain');

            const domainSelect = document.getElementById('domain');
            const domainMap = {
                '1': 'myitronline.com',
                '2': 'clarityefiling.com',
                '3': 'taxa23.com',
                '4': 'eitrfiling.com'
            };

            // Title character counter and preview
            if (titleInput) {
                titleInput.addEventListener('input', function() {
                    const length = this.value.length;
                    const maxLength = 60;
                    const percentage = (length / maxLength) * 100;

                    titleCounter.textContent = `${length}/${maxLength} characters`;
                    titleProgress.style.width = `${Math.min(percentage, 100)}%`;

                    // Change color based on length
                    if (percentage > 100) {
                        titleProgress.className = 'progress-bar bg-danger';
                        titleCounter.className = 'text-danger fw-bold';
                    } else if (percentage > 80) {
                        titleProgress.className = 'progress-bar bg-warning';
                        titleCounter.className = 'text-warning fw-bold';
                    } else {
                        titleProgress.className = 'progress-bar bg-success';
                        titleCounter.className = 'text-muted';
                    }

                    // Update preview
                    previewTitle.textContent = this.value || 'Enter a meta title...';
                });

                // Trigger on page load for old values
                titleInput.dispatchEvent(new Event('input'));
            }

            // Description character counter and preview
            if (descInput) {
                descInput.addEventListener('input', function() {
                    const length = this.value.length;
                    const maxLength = 160;
                    const percentage = (length / maxLength) * 100;

                    descCounter.textContent = `${length}/${maxLength} characters`;
                    descProgress.style.width = `${Math.min(percentage, 100)}%`;

                    // Change color based on length
                    if (percentage > 100) {
                        descProgress.className = 'progress-bar bg-danger';
                        descCounter.className = 'text-danger fw-bold';
                    } else if (percentage > 80) {
                        descProgress.className = 'progress-bar bg-warning';
                        descCounter.className = 'text-warning fw-bold';
                    } else {
                        descProgress.className = 'progress-bar bg-success';
                        descCounter.className = 'text-muted';
                    }

                    // Update preview
                    previewDescription.textContent = this.value || 'Enter a meta description...';
                });

                // Trigger on page load for old values
                descInput.dispatchEvent(new Event('input'));
            }

            // Domain preview update
            if (domainSelect) {
                domainSelect.addEventListener('change', function() {
                    const selectedDomain = domainMap[this.value];
                    previewDomain.textContent = selectedDomain ? `https://www.${selectedDomain}` :
                        'Select a domain';
                });

                // Trigger on page load for old values
                if (domainSelect.value) {
                    domainSelect.dispatchEvent(new Event('change'));
                }
            }

            // Form submission with loading state
            document.getElementById('metaForm').addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;

                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                }, 5000);
            });

            // Auto-resize textareas
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });
            });

            // Form validation enhancement
            const form = document.getElementById('metaForm');
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
            });

            // Auto-focus first input
            const firstInput = document.getElementById('serviceName');
            if (firstInput) {
                firstInput.focus();
            }
        });

        // Reset form function
        function resetForm() {
            const form = document.getElementById('metaForm');

            // Show confirmation
            if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
                form.reset();

                // Reset character counters
                document.getElementById('titleCounter').textContent = '0/60 characters';
                document.getElementById('descCounter').textContent = '0/160 characters';
                document.getElementById('titleProgress').style.width = '0%';
                document.getElementById('descProgress').style.width = '0%';

                // Reset preview
                document.getElementById('previewTitle').textContent = 'Enter a meta title...';
                document.getElementById('previewDescription').textContent = 'Enter a meta description...';
                document.getElementById('previewDomain').textContent = 'Select a domain';

                // Remove validation classes
                form.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                    el.classList.remove('is-valid', 'is-invalid');
                });

                // Focus first input
                document.getElementById('serviceName').focus();
            }
        }

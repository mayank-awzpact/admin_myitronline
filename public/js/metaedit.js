
        document.addEventListener('DOMContentLoaded', function() {
            const originalValues = {
                service_id: document.getElementById('service_id').value,
                domain_id: document.getElementById('domain_id').value,
                metaTitle: document.getElementById('metaTitle').value,
                metaKeyword: document.getElementById('metaKeyword').value,
                metaDescription: document.getElementById('metaDescription').value,
                tag: document.getElementById('tag').value
            };
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });


            const titleInput = document.getElementById('metaTitle');
            const titleCounter = document.getElementById('titleCounter');
            const titleProgress = document.getElementById('titleProgress');

            const descInput = document.getElementById('metaDescription');
            const descCounter = document.getElementById('descCounter');
            const descProgress = document.getElementById('descProgress');

            const previewTitle = document.getElementById('previewTitle');
            const previewDescription = document.getElementById('previewDescription');
            const previewDomain = document.getElementById('previewDomain');

            const domainSelect = document.getElementById('domain_id');
            const domainMap = {
                '1': 'myitronline.com',
                '2': 'clarityefiling.com',
                '3': 'taxa23.com',
                '4': 'eitrfiling.com'
            };

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

                    // Mark as changed
                    if (this.value !== originalValues.metaTitle) {
                        this.classList.add('changed');
                    } else {
                        this.classList.remove('changed');
                    }
                });

                // Trigger on page load
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

                    // Mark as changed
                    if (this.value !== originalValues.metaDescription) {
                        this.classList.add('changed');
                    } else {
                        this.classList.remove('changed');
                    }
                });

                // Trigger on page load
                descInput.dispatchEvent(new Event('input'));
            }

            // Domain preview update
            if (domainSelect) {
                domainSelect.addEventListener('change', function() {
                    const selectedDomain = domainMap[this.value];
                    previewDomain.textContent = selectedDomain ? `https://www.${selectedDomain}` :
                        'Select a domain';

                    // Mark as changed
                    if (this.value !== originalValues.domain_id) {
                        this.classList.add('changed');
                    } else {
                        this.classList.remove('changed');
                    }
                });

                // Trigger on page load
                domainSelect.dispatchEvent(new Event('change'));
            }

            // Track changes for all form fields
            const formFields = ['service_id', 'metaKeyword', 'tag'];
            formFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', function() {
                        if (this.value !== originalValues[fieldId]) {
                            this.classList.add('changed');
                        } else {
                            this.classList.remove('changed');
                        }
                    });
                }
            });

            // Form submission with loading state
            document.getElementById('metaEditForm').addEventListener('submit', function(e) {
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

                // Trigger on page load
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            });

            // Form validation enhancement
            const form = document.getElementById('metaEditForm');
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
        });

        // Reset to original values function
        function resetToOriginal() {
            if (confirm('Are you sure you want to reset all changes? This will restore the original values.')) {
                const originalValues = {
                    service_id: '{{ $meta->service_id }}',
                    domain_id: '{{ $meta->domain_id }}',
                    metaTitle: '{{ $meta->metaTitle }}',
                    metaKeyword: '{{ $meta->metaKeyword }}',
                    metaDescription: `{{ $meta->metaDescription }}`,
                    tag: `{{ $meta->tag }}`
                };

                // Reset all form fields
                Object.keys(originalValues).forEach(key => {
                    const field = document.getElementById(key);
                    if (field) {
                        field.value = originalValues[key];
                        field.classList.remove('changed', 'is-valid', 'is-invalid');

                        // Trigger events to update counters and previews
                        field.dispatchEvent(new Event('input'));
                        field.dispatchEvent(new Event('change'));
                    }
                });

                // Reset textareas height
                document.querySelectorAll('textarea').forEach(textarea => {
                    textarea.style.height = 'auto';
                    textarea.style.height = textarea.scrollHeight + 'px';
                });

                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4';
                alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="alert-icon me-3">
                    <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="alert-heading mb-1 fw-bold">Reset Complete!</h6>
                    <p class="mb-0">All fields have been reset to their original values.</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

                const container = document.querySelector('.container-fluid');
                container.insertBefore(alertDiv, container.firstChild);

                // Auto-dismiss after 3 seconds
                setTimeout(() => {
                    const alert = new bootstrap.Alert(alertDiv);
                    alert.close();
                }, 3000);
            }
        }

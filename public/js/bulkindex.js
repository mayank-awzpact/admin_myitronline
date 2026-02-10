
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleCheckboxes');
            const toggleText = document.getElementById('toggleText');
            const selectedCount = document.getElementById('selectedCount');
            const selectedInput = document.getElementById('selected_ids');
            const form = document.getElementById('bulkMailForm');
            const loaderOverlay = document.getElementById('loaderOverlay');
            const sendBulkBtn = document.getElementById('sendBulkBtn');
            const masterCheckbox = document.getElementById('masterCheckbox');
            let allChecked = false;
            const selectedIds = new Set();

            function updateSelectedCount() {
                selectedCount.textContent = selectedIds.size;
                selectedInput.value = Array.from(selectedIds).join(',');
                sendBulkBtn.disabled = selectedIds.size === 0;

                const checkboxes = document.querySelectorAll('.mail-checkbox');
                const checkedBoxes = document.querySelectorAll('.mail-checkbox:checked');

                if (checkedBoxes.length === 0) {
                    masterCheckbox.indeterminate = false;
                    masterCheckbox.checked = false;
                    allChecked = false;
                    toggleText.textContent = 'Select All';
                    toggleBtn.querySelector('i').className = 'bi bi-check-square me-1';
                } else if (checkedBoxes.length === checkboxes.length) {
                    masterCheckbox.indeterminate = false;
                    masterCheckbox.checked = true;
                    allChecked = true;
                    toggleText.textContent = 'Deselect All';
                    toggleBtn.querySelector('i').className = 'bi bi-x-square me-1';
                } else {
                    masterCheckbox.indeterminate = true;
                    allChecked = false;
                    toggleText.textContent = 'Select All';
                    toggleBtn.querySelector('i').className = 'bi bi-check-square me-1';
                }
            }

            document.querySelectorAll('.mail-checkbox').forEach(cb => {
                cb.addEventListener('change', function() {
                    const id = cb.dataset.id;
                    const row = cb.closest('tr');

                    if (cb.checked) {
                        selectedIds.add(id);
                        row.classList.add('selected');
                    } else {
                        selectedIds.delete(id);
                        row.classList.remove('selected');
                    }
                    updateSelectedCount();
                });
            });

            masterCheckbox.addEventListener('change', function() {
                allChecked = this.checked;
                document.querySelectorAll('.mail-checkbox').forEach(cb => {
                    const id = cb.dataset.id;
                    const row = cb.closest('tr');
                    cb.checked = allChecked;

                    if (allChecked) {
                        selectedIds.add(id);
                        row.classList.add('selected');
                    } else {
                        selectedIds.delete(id);
                        row.classList.remove('selected');
                    }
                });
                updateSelectedCount();
            });

            toggleBtn.addEventListener('click', function() {
                allChecked = !allChecked;
                masterCheckbox.checked = allChecked;

                document.querySelectorAll('.mail-checkbox').forEach(cb => {
                    const id = cb.dataset.id;
                    const row = cb.closest('tr');
                    cb.checked = allChecked;

                    if (allChecked) {
                        selectedIds.add(id);
                        row.classList.add('selected');
                    } else {
                        selectedIds.delete(id);
                        row.classList.remove('selected');
                    }
                });
                updateSelectedCount();
            });

            form.addEventListener('submit', function(e) {
                if (selectedIds.size === 0) {
                    e.preventDefault();
                    alert('Please select at least one mail to send.');
                    return;
                }

                if (!confirm(`Are you sure you want to send ${selectedIds.size} bulk mail(s)?`)) {
                    e.preventDefault();
                    return;
                }

                loaderOverlay.style.display = 'flex';
            });

            window.previewMail = function(mailId) {
                console.log('Preview mail:', mailId);
                // Add your preview logic here
            };

            window.closeAlert = function(alertId) {
                const alert = document.getElementById(alertId);
                if (alert) {
                    alert.style.animation = 'slideOutRight 0.3s ease-out';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                }
            };

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert-success-modern, .alert-danger-modern');
                alerts.forEach(alert => {
                    if (alert) {
                        alert.style.animation = 'slideOutRight 0.3s ease-out';
                        setTimeout(() => {
                            alert.style.display = 'none';
                        }, 300);
                    }
                });
            }, 5000);

            updateSelectedCount();
        });

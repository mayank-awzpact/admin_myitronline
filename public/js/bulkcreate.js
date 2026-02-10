
        document.addEventListener('DOMContentLoaded', function() {
            let currentSection = 1;
            const totalSections = 3;
            let csvEmails = [];
            let currentInputMethod = 'manual';

            // Elements
            const sections = document.querySelectorAll('.form-section');
            const stepItems = document.querySelectorAll('.step-item');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('bulkMailForm');

            // CSV Elements
            const csvInput = document.getElementById('email_csv');
            const csvUploadZone = document.getElementById('csvUploadZone');
            const csvPreview = document.getElementById('csvPreview');
            const csvEmailList = document.getElementById('csvEmailList');
            const csvEmailCount = document.getElementById('csvEmailCount');
            const csvEmailInputs = document.getElementById('csvEmailInputs');
            const clearCsvBtn = document.getElementById('clearCsv');

            // Toggle Elements - COMPLETELY FIXED
            const manualToggle = document.getElementById('manualToggle');
            const csvToggle = document.getElementById('csvToggle');
            const manualMethod = document.getElementById('manualMethod');
            const csvMethod = document.getElementById('csvMethod');

            console.log('Elements found:', {
                manualToggle: !!manualToggle,
                csvToggle: !!csvToggle,
                manualMethod: !!manualMethod,
                csvMethod: !!csvMethod
            });

            // Section Navigation
            function showSection(section) {
                sections.forEach(s => s.classList.remove('active'));
                stepItems.forEach(s => s.classList.remove('active'));

                document.querySelector(`[data-section="${section}"]`).classList.add('active');
                document.querySelector(`[data-step="${section}"]`).classList.add('active');

                prevBtn.style.display = section > 1 ? 'inline-flex' : 'none';
                nextBtn.style.display = section < totalSections ? 'inline-flex' : 'none';
                submitBtn.style.display = section === totalSections ? 'inline-flex' : 'none';

                currentSection = section;
            }

            // Method Toggle - COMPLETELY REWRITTEN
            function switchToManual() {
                console.log('Switching to manual');
                currentInputMethod = 'manual';

                // Update toggle buttons
                if (manualToggle) {
                    manualToggle.classList.add('active');
                }
                if (csvToggle) {
                    csvToggle.classList.remove('active');
                }

                // Show/hide methods with direct style manipulation
                if (manualMethod) {
                    manualMethod.style.display = 'block';
                    manualMethod.style.visibility = 'visible';
                    manualMethod.classList.add('active');
                }
                if (csvMethod) {
                    csvMethod.style.display = 'none';
                    csvMethod.style.visibility = 'hidden';
                    csvMethod.classList.remove('active');
                }

                clearCsvData();
            }

            function switchToCsv() {
                console.log('Switching to CSV');
                currentInputMethod = 'csv';

                // Update toggle buttons
                if (csvToggle) {
                    csvToggle.classList.add('active');
                }
                if (manualToggle) {
                    manualToggle.classList.remove('active');
                }

                // Show/hide methods with direct style manipulation
                if (csvMethod) {
                    csvMethod.style.display = 'block';
                    csvMethod.style.visibility = 'visible';
                    csvMethod.classList.add('active');
                }
                if (manualMethod) {
                    manualMethod.style.display = 'none';
                    manualMethod.style.visibility = 'hidden';
                    manualMethod.classList.remove('active');
                }

                clearManualEmails();
            }

            // Add event listeners with error handling
            if (manualToggle) {
                manualToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Manual toggle clicked');
                    switchToManual();
                });
            }

            if (csvToggle) {
                csvToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('CSV toggle clicked');
                    switchToCsv();
                });
            }

            // CSV Upload Functionality
            if (csvInput) {
                csvInput.addEventListener('change', handleCsvUpload);
            }
            if (clearCsvBtn) {
                clearCsvBtn.addEventListener('click', clearCsvData);
            }

            // Drag and Drop
            if (csvUploadZone) {
                csvUploadZone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('dragover');
                });

                csvUploadZone.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                });

                csvUploadZone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        csvInput.files = files;
                        handleCsvUpload();
                    }
                });
            }

            function handleCsvUpload() {
                const file = csvInput.files[0];
                if (!file) return;

                const validTypes = ['text/csv', 'text/plain', 'application/csv'];
                const fileExtension = file.name.split('.').pop().toLowerCase();

                if (!validTypes.includes(file.type) && !['csv', 'txt'].includes(fileExtension)) {
                    showNotification('Please upload a valid CSV or TXT file', 'error');
                    csvInput.value = '';
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    showNotification('File size must be less than 5MB', 'error');
                    csvInput.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const content = e.target.result;
                    parseCsvContent(content);
                };
                reader.readAsText(file);

                if (csvUploadZone) {
                    csvUploadZone.classList.add('has-file');
                }
            }

            function parseCsvContent(content) {
                const lines = content.split('\n').filter(line => line.trim());
                const emails = [];
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                lines.forEach((line, index) => {
                    let email = '';

                    if (line.includes(',')) {
                        const parts = line.split(',');
                        for (let part of parts) {
                            const cleanPart = part.trim().replace(/['"]/g, '');
                            if (emailRegex.test(cleanPart)) {
                                email = cleanPart;
                                break;
                            }
                        }
                    } else {
                        const cleanLine = line.trim().replace(/['"]/g, '');
                        if (emailRegex.test(cleanLine)) {
                            email = cleanLine;
                        }
                    }

                    if (email) {
                        if (!emails.some(e => e.email.toLowerCase() === email.toLowerCase())) {
                            emails.push({
                                email: email,
                                valid: true,
                                line: index + 1
                            });
                        }
                    } else if (line.trim()) {
                        emails.push({
                            email: line.trim(),
                            valid: false,
                            line: index + 1
                        });
                    }
                });

                csvEmails = emails;
                displayCsvPreview();
                createCsvHiddenInputs();
            }

            function displayCsvPreview() {
                const validEmails = csvEmails.filter(e => e.valid);
                const invalidEmails = csvEmails.filter(e => !e.valid);

                if (csvEmailCount) {
                    csvEmailCount.textContent = validEmails.length;
                }
                if (csvEmailList) {
                    csvEmailList.innerHTML = '';

                    validEmails.forEach(emailObj => {
                        const emailItem = document.createElement('div');
                        emailItem.className = 'email-item valid';
                        emailItem.innerHTML = `
                        <i class="bi bi-check-circle-fill" style="font-size: 0.8rem;"></i>
                        ${emailObj.email}
                    `;
                        csvEmailList.appendChild(emailItem);
                    });

                    invalidEmails.forEach(emailObj => {
                        const emailItem = document.createElement('div');
                        emailItem.className = 'email-item invalid';
                        emailItem.innerHTML = `
                        <i class="bi bi-x-circle-fill" style="font-size: 0.8rem;"></i>
                        ${emailObj.email} <small>(Line ${emailObj.line})</small>
                    `;
                        csvEmailList.appendChild(emailItem);
                    });
                }

                if (csvPreview) {
                    csvPreview.style.display = 'block';
                }

                if (validEmails.length === 0) {
                    showNotification('No valid email addresses found in the file', 'warning');
                } else {
                    showNotification(`Successfully loaded ${validEmails.length} email addresses`, 'success');
                    if (invalidEmails.length > 0) {
                        showNotification(`${invalidEmails.length} invalid email addresses were skipped`, 'warning');
                    }
                }
            }

            function createCsvHiddenInputs() {
                if (!csvEmailInputs) return;

                csvEmailInputs.innerHTML = '';
                const validEmails = csvEmails.filter(e => e.valid);

                validEmails.forEach(emailObj => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'user_mail[]';
                    input.value = emailObj.email;
                    csvEmailInputs.appendChild(input);
                });
            }

            function clearCsvData() {
                if (csvInput) csvInput.value = '';
                csvEmails = [];
                if (csvPreview) csvPreview.style.display = 'none';
                if (csvEmailInputs) csvEmailInputs.innerHTML = '';
                if (csvUploadZone) csvUploadZone.classList.remove('has-file');
            }

            function clearManualEmails() {
                const manualInputs = document.querySelectorAll('.manual-email');
                manualInputs.forEach((input, index) => {
                    if (index === 0) {
                        input.value = '';
                    } else {
                        const row = input.closest('.email-input-row');
                        if (row) row.remove();
                    }
                });
            }

            // Validation
            function validateCurrentSection() {
                let isValid = true;

                if (currentSection === 1) {
                    const senderEmail = document.getElementById('sender_mail');
                    if (senderEmail && !senderEmail.value.trim()) {
                        senderEmail.style.borderColor = 'var(--danger)';
                        isValid = false;
                    } else if (senderEmail) {
                        senderEmail.style.borderColor = 'var(--border)';
                    }

                    if (currentInputMethod === 'manual') {
                        const manualEmails = document.querySelectorAll('.manual-email');
                        let hasValidEmail = false;

                        manualEmails.forEach(input => {
                            if (input.value.trim()) {
                                hasValidEmail = true;
                                input.style.borderColor = 'var(--border)';
                            }
                        });

                        if (!hasValidEmail && manualEmails.length > 0) {
                            manualEmails[0].style.borderColor = 'var(--danger)';
                            isValid = false;
                        }
                    } else {
                        const validCsvEmails = csvEmails.filter(e => e.valid);
                        if (validCsvEmails.length === 0) {
                            showNotification('Please upload a CSV file with valid email addresses', 'error');
                            isValid = false;
                        }
                    }
                } else {
                    const currentSectionElement = document.querySelector(
                        `.form-section[data-section="${currentSection}"]`);
                    if (currentSectionElement) {
                        const requiredFields = currentSectionElement.querySelectorAll('[required]');

                        requiredFields.forEach(field => {
                            if (!field.value.trim()) {
                                field.style.borderColor = 'var(--danger)';
                                isValid = false;
                            } else {
                                field.style.borderColor = 'var(--border)';
                            }
                        });
                    }
                }

                if (!isValid) {
                    showNotification('Please fill in all required fields', 'error');
                }

                return isValid;
            }

            // Navigation
            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    if (validateCurrentSection()) {
                        if (currentSection < totalSections) {
                            showSection(currentSection + 1);
                        }
                    }
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    if (currentSection > 1) {
                        showSection(currentSection - 1);
                    }
                });
            }

            // Add More Emails (Manual method)
            const addMoreBtn = document.getElementById('addMoreEmails');
            const emailGroup = document.getElementById('user-mail-group');

            function addEmailInput() {
                if (!emailGroup) return;

                const emailRow = document.createElement('div');
                emailRow.className = 'email-input-row';
                emailRow.innerHTML = `
                <div class="input-wrapper">
                    <div class="input-icon">
                        <i class="bi bi-envelope" style="font-size: 0.8rem;"></i>
                    </div>
                    <input type="email" name="user_mail[]" class="form-input manual-email" placeholder="recipient@example.com">
                    <button type="button" class="add-email-btn remove-email-btn" title="Remove email">
                        <i class="bi bi-x-lg" style="font-size: 0.8rem;"></i>
                    </button>
                    <div class="input-focus-border"></div>
                </div>
            `;

                emailGroup.appendChild(emailRow);

                const removeBtn = emailRow.querySelector('.remove-email-btn');
                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        emailRow.remove();
                    });
                }
            }

            if (addMoreBtn) {
                addMoreBtn.addEventListener('click', addEmailInput);
            }

            document.addEventListener('click', function(e) {
                if (e.target.closest('.add-email-btn') && !e.target.closest('.remove-email-btn')) {
                    addEmailInput();
                }
            });

            // Image Preview
            const imgUrlInput = document.getElementById('img_url');
            const previewBtn = document.getElementById('previewImage');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');

            if (previewBtn) {
                previewBtn.addEventListener('click', function() {
                    const url = imgUrlInput ? imgUrlInput.value.trim() : '';
                    if (url) {
                        if (previewImg) previewImg.src = url;
                        if (imagePreview) imagePreview.style.display = 'block';
                    } else {
                        showNotification('Please enter an image URL first', 'warning');
                    }
                });
            }

            window.closePreview = function() {
                if (imagePreview) imagePreview.style.display = 'none';
            };

            // Character Counter
            const subjectInput = document.getElementById('subject');
            const charCount = document.getElementById('charCount');

            if (subjectInput && charCount) {
                subjectInput.addEventListener('input', function() {
                    const count = this.value.length;
                    charCount.textContent = count;

                    if (count > 100) {
                        charCount.style.color = 'var(--danger)';
                    } else if (count > 80) {
                        charCount.style.color = 'var(--warning)';
                    } else {
                        charCount.style.color = 'var(--text-muted)';
                    }
                });
            }

            // Toolbar Functionality
            const toolbarBtns = document.querySelectorAll('.toolbar-btn');
            const textarea = document.getElementById('description');

            toolbarBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const action = this.dataset.action;

                    if (action === 'link') {
                        const url = prompt('Enter URL:');
                        if (url && textarea) {
                            const selectedText = textarea.value.substring(
                                textarea.selectionStart,
                                textarea.selectionEnd
                            );
                            const linkText = selectedText || url;
                            const link = `<a href="${url}">${linkText}</a>`;
                            insertAtCursor(textarea, link);
                        }
                    } else if (textarea) {
                        const selectedText = textarea.value.substring(
                            textarea.selectionStart,
                            textarea.selectionEnd
                        );

                        if (selectedText) {
                            let formattedText = selectedText;
                            switch (action) {
                                case 'bold':
                                    formattedText = `<strong>${selectedText}</strong>`;
                                    break;
                                case 'italic':
                                    formattedText = `<em>${selectedText}</em>`;
                                    break;
                                case 'underline':
                                    formattedText = `<u>${selectedText}</u>`;
                                    break;
                                case 'list':
                                    formattedText = `<ul><li>${selectedText}</li></ul>`;
                                    break;
                            }
                            insertAtCursor(textarea, formattedText);
                        }
                    }

                    this.classList.toggle('active');
                });
            });

            function insertAtCursor(textarea, text) {
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const before = textarea.value.substring(0, start);
                const after = textarea.value.substring(end);

                textarea.value = before + text + after;
                textarea.selectionStart = textarea.selectionEnd = start + text.length;
                textarea.focus();
            }

            // Form Submission
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validateCurrentSection()) {
                        e.preventDefault();
                        return;
                    }

                    if (currentInputMethod === 'csv') {
                        const validCsvEmails = csvEmails.filter(e => e.valid);
                        if (validCsvEmails.length === 0) {
                            e.preventDefault();
                            showNotification('No valid email addresses to send to', 'error');
                            return;
                        }
                    }

                    if (submitBtn) {
                        submitBtn.innerHTML =
                            '<i class="bi bi-hourglass-split me-1" style="font-size: 0.8rem;"></i>Creating...';
                        submitBtn.disabled = true;
                    }
                });
            }

            // Notification Function
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `notification notification-${type}`;
                notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                padding: 1rem 1.5rem;
                border-radius: var(--radius);
                box-shadow: var(--shadow-lg);
                border-left: 4px solid var(--${type === 'error' ? 'danger' : type === 'warning' ? 'warning' : 'success'});
                z-index: 9999;
                transform: translateX(400px);
                opacity: 0;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                font-weight: 500;
                color: var(--dark);
                max-width: 400px;
            `;

                notification.innerHTML = `
                <i class="bi bi-${type === 'error' ? 'exclamation-triangle' : type === 'warning' ? 'exclamation-triangle' : 'check-circle'}-fill me-2" style="font-size: 0.9rem;"></i>
                ${message}
            `;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                    notification.style.opacity = '1';
                }, 100);

                setTimeout(() => {
                    notification.style.transform = 'translateX(400px)';
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        if (document.body.contains(notification)) {
                            document.body.removeChild(notification);
                        }
                    }, 300);
                }, 4000);
            }

            // Initialize - Set manual as default
            console.log('Initializing...');
            showSection(1);
            switchToManual(); // Ensure manual is shown by default

            // Debug: Log current state
            setTimeout(() => {
                console.log('Current method display states:', {
                    manual: manualMethod ? manualMethod.style.display : 'not found',
                    csv: csvMethod ? csvMethod.style.display : 'not found',
                    currentInputMethod: currentInputMethod
                });
            }, 1000);
        });

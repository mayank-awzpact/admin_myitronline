<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Suggest a slug from the title until the admin types one manually
        const titleInput = document.getElementById('eventTitle');
        const slugInput = document.getElementById('eventSlug');

        if (titleInput && slugInput) {
            let slugTouched = slugInput.value.trim() !== '';

            slugInput.addEventListener('input', function() {
                slugTouched = true;
            });

            titleInput.addEventListener('input', function() {
                if (slugTouched) return;
                slugInput.value = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .trim()
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            });
        }

        // Repeatable external-link rows
        const rowsWrapper = document.getElementById('mediaLinkRows');
        const addLinkBtn = document.getElementById('addLinkRow');

        if (addLinkBtn && rowsWrapper) {
            addLinkBtn.addEventListener('click', function() {
                const row = rowsWrapper.querySelector('.media-link-row').cloneNode(true);
                row.querySelectorAll('input').forEach(function(input) {
                    input.value = '';
                });
                row.querySelector('select').selectedIndex = 0;
                rowsWrapper.appendChild(row);
            });

            rowsWrapper.addEventListener('click', function(e) {
                const btn = e.target.closest('.remove-link-row');
                if (!btn) return;

                const rows = rowsWrapper.querySelectorAll('.media-link-row');
                if (rows.length > 1) {
                    btn.closest('.media-link-row').remove();
                } else {
                    rows[0].querySelectorAll('input').forEach(function(input) {
                        input.value = '';
                    });
                }
            });
        }

        // Gallery item delete posts its own form (can't nest a form inside the event form)
        document.querySelectorAll('.remove-media-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (!confirm('Remove this media item?\n\nThe file will be deleted permanently.')) {
                    return;
                }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = this.dataset.url;
                form.style.display = 'none';
                form.innerHTML =
                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                    '<input type="hidden" name="_method" value="DELETE">';
                document.body.appendChild(form);
                form.submit();
            });
        });

        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                new bootstrap.Alert(alert).close();
            });
        }, 6000);
    });
</script>

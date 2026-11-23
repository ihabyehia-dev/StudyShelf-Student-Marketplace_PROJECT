/* StudyShelf - plain JavaScript for the menu and client-side validation. */
// Wait until the page is loaded before connecting menus and form controls.
document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.querySelector('[data-menu-button]');
    const menu = document.querySelector('[data-menu]');
    if (menuButton && menu) {
        menuButton.addEventListener('click', function () {
            const isOpen = menu.classList.toggle('open');
            menuButton.setAttribute('aria-expanded', String(isOpen));
            menuButton.setAttribute('aria-label', isOpen ? 'Close navigation' : 'Open navigation');
        });
    }

    // Ask for confirmation before deleting records in the admin panel.
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm(form.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });

    // Server-side validation is also present in PHP. JavaScript gives faster feedback.
    document.querySelectorAll('form[data-validate]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const errors = [];
            form.querySelectorAll('.invalid-field').forEach(function (field) {
                field.classList.remove('invalid-field');
            });
            let firstInvalid = null;

            form.querySelectorAll('[required]').forEach(function (field) {
                if (!field.checkValidity()) {
                    const label = form.querySelector('label[for="' + field.id + '"]');
                    const labelText = label ? label.textContent.replace('*', '').trim() : 'A field';
                    errors.push(labelText + ' is missing or invalid.');
                    field.classList.add('invalid-field');
                    if (!firstInvalid) firstInvalid = field;
                }
            });
            if (form.dataset.validate === 'register') {
                const password = form.querySelector('#password');
                const confirmPassword = form.querySelector('#confirm_password');
                if (password && confirmPassword && password.value !== confirmPassword.value) {
                    errors.push('Passwords do not match.');
                    confirmPassword.classList.add('invalid-field');
                    if (!firstInvalid) firstInvalid = confirmPassword;
                }
            }
            const errorBox = form.querySelector('[data-form-errors]');
            if (errorBox) {
                errorBox.textContent = errors.length ? errors.join(' ') : '';
            }
            if (errors.length) {
                event.preventDefault();
                if (firstInvalid) firstInvalid.focus();
            }
        });
    });
});

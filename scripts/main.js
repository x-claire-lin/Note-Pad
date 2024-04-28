document.addEventListener('DOMContentLoaded', function() {
        const login = document.querySelector('input[name="username"]');
        const pass = document.querySelector('input[name="password"]');
        const pass2 = document.querySelector('input[name="password2"]');

        function validate() {
            let isValid = true;

            if (login.value.length === 0 || login.value.trim() === '' || login.value.length >= 30) {
                document.getElementById('loginWarning').innerHTML = '❌ Username should be non-empty and less than 30 characters.';
                isValid = false;
            } else {
                document.getElementById('loginWarning').innerHTML = ''; // Clear the warning
            }

            if (pass.value.length < 6 || !/[a-z]/.test(pass.value) || !/[A-Z]/.test(pass.value)) {
                document.getElementById('passWarning').innerHTML = '❌ Password should be at least 6 characters long and contain at least one uppercase and one lowercase letter.';
                isValid = false;
            } else {
                document.getElementById('passWarning').innerHTML = ''; // Clear the warning
            }

            if (pass.value !== pass2.value || pass2.value.trim() === '') {
                document.getElementById('pass2Warning').innerHTML = '❌ Please retype the password correctly.';
                isValid = false;
            } else {
                document.getElementById('pass2Warning').innerHTML = ''; // Clear the warning
            }

            return isValid;
        }

        login.addEventListener('input', function() {
            validate(); // Validate on input change
        });

        pass.addEventListener('input', function() {
            validate(); // Validate on input change
        });

        pass2.addEventListener('input', function() {
            validate(); // Validate on input change
        });

        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            if (!validate()) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    });
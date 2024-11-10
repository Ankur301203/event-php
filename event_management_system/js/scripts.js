document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            const inputs = form.querySelectorAll('input, textarea');
            let valid = true;

            inputs.forEach(input => {
                if (!input.value) {
                    valid = false;
                    input.style.borderColor = 'red'; // Highlight empty fields
                } else {
                    input.style.borderColor = ''; // Reset border color
                }
            });

            if (!valid) {
                event.preventDefault(); // Prevent form submission if invalid
                alert('Please fill out all fields.');
            }
        });
    });
});

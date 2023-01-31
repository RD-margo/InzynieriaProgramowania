const form = document.querySelector("form");
const emailInput = form.querySelector('input[id="email"]');
function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

function validateEmail() {
    markValidation(emailInput, isEmail(emailInput.value));
}

emailInput.addEventListener('keyup', function() {
    setTimeout(validateEmail, 1000);
});
document.addEventListener("DOMContentLoaded", function () {
    const emailField = document.getElementById("email");
    const passwordField = document.getElementById("password");

    function validateField(field, message) {
        const errorMessage = document.createElement("p");
        errorMessage.style.color = "red";

        const previousError = field.parentElement.querySelector(".error-message");
        if (previousError) {
            previousError.remove();
        }

        if (field.value.trim() === "") {
            field.style.borderColor = "red";
            errorMessage.textContent = message;
            errorMessage.classList.add("error-message");
            field.parentElement.appendChild(errorMessage);
        } else {
            field.style.borderColor = "";
        }
    }

    function validateEmail() {
        const errorMessage = document.createElement("p");
        errorMessage.style.color = "red";

        const previousError = emailField.parentElement.querySelector(".error-message");
        if (previousError) {
            previousError.remove();
        }

        if (emailField.value.trim() === "") {
            emailField.style.borderColor = "red";
            errorMessage.textContent = "El correo electrónico no puede estar vacío.";
            errorMessage.classList.add("error-message");
            emailField.parentElement.appendChild(errorMessage);
        } else if (!emailField.value.includes("@")) {
            emailField.style.borderColor = "red";
            errorMessage.textContent = "El correo electrónico debe contener '@'.";
            errorMessage.classList.add("error-message");
            emailField.parentElement.appendChild(errorMessage);
        } else {
            emailField.style.borderColor = "";
        }
    }

    function validatePassword() {
        const errorMessage = document.createElement("p");
        errorMessage.style.color = "red";

        const previousError = passwordField.parentElement.querySelector(".error-message");
        if (previousError) {
            previousError.remove();
        }

        if (passwordField.value.trim() === "") {
            passwordField.style.borderColor = "red";
            errorMessage.textContent = "La contraseña no puede estar vacía.";
            errorMessage.classList.add("error-message");
            passwordField.parentElement.appendChild(errorMessage);
        } else if (passwordField.value.length < 8) {
            passwordField.style.borderColor = "red";
            errorMessage.textContent = "La contraseña debe tener al menos 8 caracteres.";
            errorMessage.classList.add("error-message");
            passwordField.parentElement.appendChild(errorMessage);
        } else {
            passwordField.style.borderColor = "";
        }
    }

    emailField.addEventListener("blur", validateEmail);
    passwordField.addEventListener("blur", validatePassword);
});

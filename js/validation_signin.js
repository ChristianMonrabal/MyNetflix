document.addEventListener("DOMContentLoaded", function () {
    emailField = document.getElementById("email");
    passwordField = document.getElementById("password");

    function validateField(field, message) {
        errorMessage = document.createElement("p");
        errorMessage.style.color = "red";

        previousError = field.parentElement.querySelector(".error-message");
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
        validateField(emailField, "El correo electrónico no puede estar vacío.");
        if (emailField.value.trim() !== "" && !emailField.value.includes("@")) {
            validateField(emailField, "El correo electrónico debe contener '@'.");
        }
    }

    function validatePassword() {
        validateField(passwordField, "La contraseña no puede estar vacía.");
        if (passwordField.value.trim() !== "" && passwordField.value.length < 8) {
            validateField(passwordField, "La contraseña debe tener al menos 8 caracteres.");
        }
    }

    emailField.addEventListener("blur", validateEmail);
    passwordField.addEventListener("blur", validatePassword);
});

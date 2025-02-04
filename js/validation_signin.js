document.addEventListener("DOMContentLoaded", function () {
    const emailField = document.getElementById("email");
    const passwordField = document.getElementById("password");

    function validateField(field, fieldName) {
        const errorMessage = document.createElement("p");
        errorMessage.style.color = "red";

        const previousError = field.parentElement.querySelector(".error-message");
        if (previousError) {
            previousError.remove();
        }

        if (field.value.trim() === "") {
            field.style.borderColor = "red";
            errorMessage.textContent = `${fieldName} no puede estar vacío.`;
            errorMessage.classList.add("error-message");
            field.parentElement.appendChild(errorMessage);
        } else {
            field.style.borderColor = "";
        }
    }

    emailField.addEventListener("blur", function () {
        validateField(emailField, "El correo electrónico");
    });

    passwordField.addEventListener("blur", function () {
        validateField(passwordField, "La contraseña");
    });
});

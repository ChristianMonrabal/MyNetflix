document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const fields = form.querySelectorAll("input, select, textarea");

    function validateField(field) {
        const errorMessage = document.createElement("p");
        errorMessage.style.color = "red";

        const previousError = field.parentElement.querySelector(".error-message");
        if (previousError) {
            previousError.remove();
        }

        // No validar el campo imagen_cartelera
        if (field.id !== "imagen_cartelera" && field.value.trim() === "") {
            field.style.borderColor = "red";
            errorMessage.textContent = "Este campo es obligatorio.";
            errorMessage.classList.add("error-message");
            field.parentElement.appendChild(errorMessage);
        } else {
            field.style.borderColor = "";
        }
    }

    fields.forEach(field => {
        if (field.id === "id_genero" || field.id === "id_director") {
            field.removeAttribute("disabled");
        }

        field.addEventListener("blur", function () {
            validateField(field);
        });
    });

    form.addEventListener("submit", function (e) {
        let isValid = true;

        fields.forEach(field => {
            if (field.id !== "imagen_cartelera" && field.value.trim() === "") {
                validateField(field);
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
        }
    });
});

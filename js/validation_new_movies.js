document.addEventListener("DOMContentLoaded", function () {
    form = document.querySelector("form");
    fields = form.querySelectorAll("input, select, textarea");

    function validateField(field) {
        errorMessage = document.createElement("p");
        errorMessage.style.color = "red";

        previousError = field.parentElement.querySelector(".error-message");
        if (previousError) {
            previousError.remove();
        }

        if (field.value.trim() === "") {
            field.style.borderColor = "red";
            errorMessage.textContent = "Este campo es obligatorio.";
            errorMessage.classList.add("error-message");
            field.parentElement.appendChild(errorMessage);
        } else {
            field.style.borderColor = "";
        }
    }

    function validateFechaEstreno(field) {
        errorMessage = document.createElement("p");
        errorMessage.style.color = "red";

        previousError = field.parentElement.querySelector(".error-message");
        if (previousError) {
            previousError.remove();
        }

        fechaActual = new Date().toISOString().split("T")[0];
        fechaIngresada = field.value;

        if (fechaIngresada > fechaActual) {
            field.style.borderColor = "red";
            errorMessage.textContent = "La fecha de estreno no puede ser posterior a la fecha actual.";
            errorMessage.classList.add("error-message");
            field.parentElement.appendChild(errorMessage);
            return false;
        } else {
            field.style.borderColor = "";
            return true;
        }
    }

    fields.forEach(field => {
        if (field.id === "id_genero" || field.id === "id_director") {
            field.removeAttribute("disabled");
        }

        field.addEventListener("blur", function () {
            validateField(field);

            if (field.id === "fecha_estreno") {
                validateFechaEstreno(field);
            }
        });
    });

    form.addEventListener("submit", function (e) {
        isValid = true;

        fields.forEach(field => {
            if (field.value.trim() === "") {
                validateField(field);
                isValid = false;
            }

            if (field.id === "fecha_estreno" && !validateFechaEstreno(field)) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
        }
    });
});

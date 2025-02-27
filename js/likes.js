document.addEventListener("DOMContentLoaded", function () {
    likeButton = document.getElementById("likeButton");
    likeCounter = document.getElementById("likeCounter");

    if (likeButton) {
        likeButton.addEventListener("click", function () {
            idPelicula = this.getAttribute("data-id");
            action = this.getAttribute("data-action");

            xhr = new XMLHttpRequest();
            xhr.open("POST", "../php/likes.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        data = JSON.parse(xhr.responseText);
                        if (data.success) {
                            likeCounter.textContent = data.total_likes;

                            if (action === "add") {
                                likeButton.innerHTML = '<i class="fas fa-thumbs-down"></i> No me gusta';
                                likeButton.setAttribute("data-action", "remove");
                            } else {
                                likeButton.innerHTML = '<i class="fas fa-thumbs-up"></i> Me gusta';
                                likeButton.setAttribute("data-action", "add");
                            }
                        }
                    } catch (error) {
                        console.error("Error al procesar JSON:", error);
                    }
                }
            };

            xhr.send(`id_pelicula=${idPelicula}&action=${action}`);
        });

        setInterval(() => {
            idPelicula = likeButton.getAttribute("data-id");

            xhr = new XMLHttpRequest();
            xhr.open("GET", `../php/get_likes.php?id_pelicula=${idPelicula}`, true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        data = JSON.parse(xhr.responseText);
                        if (data.success) {
                            likeCounter.textContent = data.total_likes;
                        }
                    } catch (error) {
                        console.error("Error al procesar JSON:", error);
                    }
                }
            };

            xhr.send();
        }, 1000);
    }
});

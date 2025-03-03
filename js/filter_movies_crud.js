document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const clearButton = document.getElementById('clearSearch');
    const moviesTable = document.getElementById('movies-table');

    function ajaxRequest(url) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const peliculas = JSON.parse(xhr.responseText);
                let tableContent = '';

                if (peliculas.length > 0) {
                    peliculas.forEach(function(pelicula) {
                        tableContent += `<tr>
                            <td>${pelicula.titulo}</td>
                            <td>${pelicula.description_pelicula.substring(0, 100)}...</td>
                            <td>${pelicula.genero}</td>
                            <td>${pelicula.director}</td>
                            <td>${pelicula.fecha_estreno}</td>
                            <td>${pelicula.duracion} min</td>
                            <td>
                                <a href="../admin/edit_movies.php?id=${pelicula.id_pelicula}" class="btn btn-warning btn-sm">Editar</a>
                                <a href="#" class="btn btn-danger btn-sm" onclick="confirmDeleteMovie(${pelicula.id_pelicula})">Eliminar</a>
                            </td>
                        </tr>`;
                    });
                } else {
                    tableContent = `<tr>
                        <td colspan="7" class="text-center">No se encontraron películas.</td>
                    </tr>`;
                }

                moviesTable.innerHTML = tableContent;
            }
        };
        xhr.open('GET', url, true);
        xhr.send();
    }

    function loadAllMovies() {
        ajaxRequest('../includes/select_movies.php');
    }

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.trim();
        clearButton.style.display = searchTerm ? 'block' : 'none';

        if (searchTerm) {
            ajaxRequest(`../includes/select_movies.php?search=${searchTerm}`);
        } else {
            loadAllMovies();
        }
    });

    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        clearButton.style.display = 'none';
        loadAllMovies();
    });

    loadAllMovies();
});

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const clearButton = document.getElementById('clearSearch');
    const moviesTable = document.getElementById('movies-table');

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

    function ajaxRequest(url) {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const peliculas = JSON.parse(xhr.responseText);
                let tableContent = '';
                peliculas.forEach(function(pelicula) {
                    tableContent += '<tr>';
                    tableContent += '<td>' + pelicula.titulo + '</td>';
                    tableContent += '<td>' + pelicula.description_pelicula + '</td>';
                    tableContent += '<td>' + pelicula.genero + '</td>';
                    tableContent += '<td>' + pelicula.director + '</td>';
                    tableContent += '<td>' + pelicula.fecha_estreno + '</td>';
                    tableContent += '<td>' + pelicula.duracion + ' min</td>';
                    tableContent += '<td>';
                    tableContent += '<a href="../admin/edit_movies.php?id=' + pelicula.id_pelicula + '" class="btn btn-warning btn-sm">Editar</a>';
                    tableContent += '<a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete(' + pelicula.id_pelicula + ')">Eliminar</a>';
                    tableContent += '</td>';
                    tableContent += '</tr>';
                });
                moviesTable.innerHTML = tableContent;
            }
        };
        xhr.open('GET', url, true);
        xhr.send();
    }

    function loadAllMovies() {
        ajaxRequest('../includes/select_movies.php');
    }
});
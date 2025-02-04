document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('emailSearch');
    const clearButton = document.getElementById('clearSearch');
    const userTable = document.getElementById('userTable');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.trim();
        clearButton.style.display = searchTerm ? 'block' : 'none';

        if (searchTerm) {
            ajaxRequest(`../php/search_users_active.php?email=${searchTerm}`);
        } else {
            loadAllUsers();
        }
    });

    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        clearButton.style.display = 'none';
        loadAllUsers();
    });

    function loadAllUsers() {
        ajaxRequest('../php/search_users_active.php');
    }

    function ajaxRequest(url) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                updateUserTable(data);
            }
        };
        xhr.send();
    }

    function updateUserTable(users) {
        userTable.innerHTML = '';

        if (users.length === 0) {
            userTable.innerHTML = '<tr><td colspan="3" class="text-center">No se encontraron resultados.</td></tr>';
            return;
        }

        users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.email}</td>
                <td>${user.fecha_registro}</td>
                <td>
                    <a href="../php/disable_users.php?id=${user.id_usuario}" class="btn btn-warning btn-sm">Desactivar</a>
                    <a href="../php/delete_users.php?id=${user.id_usuario}" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                </td>
            `;
            userTable.appendChild(row);
        });
    }

    loadAllUsers();
});

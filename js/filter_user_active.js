document.addEventListener('DOMContentLoaded', function() {
    searchInput = document.getElementById('emailSearch');
    clearButton = document.getElementById('clearSearch');
    userTable = document.getElementById('userTable');
    let filterActive = false;

    searchInput.addEventListener('input', function() {
        searchTerm = searchInput.value.trim();
        clearButton.style.display = searchTerm ? 'block' : 'none';
        filterActive = searchTerm.length > 0;

        if (searchTerm) {
            ajaxRequest(`../php/search_users_active.php?email=${searchTerm}`);
        } else {
            loadAllUsers();
        }
    });

    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        clearButton.style.display = 'none';
        filterActive = false;
        loadAllUsers();
    });

    function loadAllUsers() {
        if (!filterActive) {
            ajaxRequest('../php/search_users_active.php');
        }
    }

    function ajaxRequest(url) {
        xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                data = JSON.parse(xhr.responseText);
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
            row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.email}</td>
                <td>${user.fecha_registro}</td>
                <td>
                    <a href="../admin/edit_users.php?id=${user.id_usuario}" class="btn btn-success btn-sm">Editar</a>
                    <a href="../php/disable_users.php?id=${user.id_usuario}" class="btn btn-warning btn-sm">Desactivar</a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="confirmDeleteUser(${user.id_usuario})">Eliminar</a>
                </td>
            `;
            userTable.appendChild(row);
        });
    }

    setInterval(() => {
        if (!filterActive) {
            loadAllUsers();
        }
    }, 2000);

    loadAllUsers();
});

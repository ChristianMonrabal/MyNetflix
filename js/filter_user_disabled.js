document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('emailSearch');
    const clearButton = document.getElementById('clearSearch');
    const userTable = document.getElementById('userTable');
    let filterActive = false;

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.trim();
        clearButton.style.display = searchTerm ? 'block' : 'none';
        filterActive = searchTerm.length > 0;

        if (searchTerm) {
            ajaxRequest(`../php/search_users_disabled.php?email=${searchTerm}`);
        } else {
            filterActive = false;
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
            ajaxRequest('../php/search_users_disabled.php');
        }
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
                    <a href="../admin/edit_users.php?id=${user.id_usuario}" class="btn btn-success btn-sm">Editar</a>
                    <a href="../php/active_users.php?id=${user.id_usuario}" class="btn btn-warning btn-sm">Activar</a>
                    <a href="../php/delete_users.php?id=${user.id_usuario}" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                </td>
            `;
            userTable.appendChild(row);
        });
    }

    function addNewUserAndRefreshTable() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../includes/select_disabled_users.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                loadAllUsers();
            }
        };
        xhr.send();
    }

    setInterval(() => {
        if (!filterActive) {
            loadAllUsers();
        }
    }, 2000);

    loadAllUsers();
});

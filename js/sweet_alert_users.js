window.confirmDeleteUser = function(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Esta acción es irreversible!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `../php/delete_users.php?id=${id}`;
        }
    });
}

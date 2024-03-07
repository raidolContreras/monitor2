
<script src="view/assets/vendor/Datatables/datatables.js"></script>
<!-- Elimina esta línea ya que Popper.js viene incluido con Bootstrap Bundle -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> -->

<script>
$(document).ready(function() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.getElementById('navbarNav');
    navbarToggler.addEventListener('click', function() {
        navbarToggler.classList.toggle('active');
        navbarCollapse.classList.toggle('show');
    });

    // Cerrar el menú al hacer clic en un enlace del menú
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            navbarToggler.classList.remove('active');
            navbarCollapse.classList.remove('show');
        });
    });
    
    document.querySelector('.navbar-collapse').addEventListener('click', function() {
      this.classList.toggle('active');
    });

});

function logout() {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/logout.php',
        success: function(response) {
            if (response === 'ok') {
                window.location.href = 'login';
            } else {
                alert('Error al intentar cerrar sesión. Inténtalo de nuevo más tarde.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cerrar sesión:', error);
            alert('Hubo un error al intentar cerrar sesión. Inténtalo de nuevo más tarde.');
        }
    });
}

$(document).on('click', '#modalAcceptButton', function() {
    var formData = $('#modalForm').serialize();
    $.ajax({
        type: "POST",
        url: "controller/ajax/ajax.form.php",
        data: formData, 
        success: function(response) {
			verificarEventosActivos();
			if (response !== 'Error') {
				var content = `Evento ${response} con éxito.`
				$('.resultModal').html(content);
				$('#resultModal').modal('show');
			}
        },
        error: function(error) {
            // Maneja el error si es necesario
            console.log("Error en la solicitud AJAX:", error);
        }
    });
    
    $('#tableEvents').DataTable().ajax.reload();
});
</script>

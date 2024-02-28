<script src="view/assets/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script>
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

    function closeMenu() {
        document.querySelector('.navbar-collapse').classList.remove('show');
    }
</script>
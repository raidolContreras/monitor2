<header>
	<nav class="navbar">
		<div class="container">
			<a class="navbar-brand" href="#">
				<img src="view/assets/images/logo.png" alt="Logo" class="logo">
			</a>
			<button class="navbar-toggler boton-sombra" type="button" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon one"></span>
				<span class="navbar-toggler-icon two"></span>
				<span class="navbar-toggler-icon three"></span>
			</button>
			<div class="navbar-collapse" id="navbarNav">
          		<span class="close-btn" onclick="closeMenu()">&times;</span>
				<ul class="navbar-nav">
					<li class="nav-item mt-5">
						<h4>Administrador</h4>
					</li>
					<li class="nav-item mt-1">
						<button class="nav-link px-3" data-bs-toggle="modal" data-bs-target="#newUserModal">
							<i class="fas fa-user-plus"></i> Nuevo usuario
						</button>
					</li>
					<li class="nav-item">
						<a class="nav-link px-3" href="#">
							<i class="fas fa-sign-out-alt"></i> Cerrar sesión
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>
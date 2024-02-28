<main class="container">
    <div class="card-custom">
        <div class="card-header-custom">
            <strong>Eventos Montrer</strong>
        </div>
    </div>

    <button class="btn btn-primary mb-3 float-end" data-bs-toggle="modal" data-bs-target="#eventModal">Registrar evento</button>

    <!-- Modal para el registro de eventos -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Registrar evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para registro de eventos -->
                <form>
                    <input type="text" class="form-control" placeholder="Nombre del evento">
                    <input type="text" class="form-control" placeholder="Fecha del evento">
                </form>
				<div class="center-buttons mt-4">
					<button type="button" class="btn btn-primary mx-1">Registrar</button>
					<button type="button" class="btn btn-danger mx-1" data-bs-dismiss="modal">Cancelar</button>
				</div>
            </div>
        </div>
    </div>
</div>

</main>

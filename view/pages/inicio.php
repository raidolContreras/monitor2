<main class="container">
    <div class="card-custom">
        <div class="card-header-custom">
            <strong>Eventos Montrer</strong>
        </div>
    </div>

    <button class="btn btn-primary mb-3 float-end" data-bs-toggle="modal" data-bs-target="#eventModal">Registrar evento</button>
	
	<div>
		<table id="tableEvents" class="table table-resposive">
			<thead>
				<th>Nombre del Evento</th>
				<th>Fecha del evento</th>
				<th>Status</th>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</main>

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
				<form id="events">
					<input type="text" class="form-control" placeholder="Nombre del evento" name="eventName">
					<input type="text" class="form-control" placeholder="Fecha del evento" name="dateEvent">
				</form>
				<div class="center-buttons mt-4">
					<button type="button" class="btn btn-primary mx-1">Registrar</button>
					<button type="button" class="btn btn-danger mx-1" data-bs-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="view\assets\js\events\getEvents.js"></script>

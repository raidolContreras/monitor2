<main class="container">
    <div class="card-custom">
        <div class="card-header-custom">
            <strong id="evento"></strong>
        </div>
    </div>

    <button class="btn btn-primary mb-3 float-end" data-bs-toggle="modal" data-bs-target="#invitadosModal">Registrar invitados</button>
	
	<div>
		<table id="tableEvents" class="table table-resposive stripe">
			<thead>
				<th>Invitado</th>
				<th>Institución</th>
				<th>Puesto</th>
				<th>Sección</th>
				<th>Estacionamiento</th>
				<th>Anfitrión</th>
				<th>Asistencia</th>
			</thead>
		</table>
	</div>
</main>
<input type="hidden" name="idEvent">
<!-- Modal para el registro de eventos -->
<div class="modal fade" id="invitadosModal" tabindex="-1" aria-labelledby="invitadosModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<center>
					<a class="btn-custom btn-editar mb-4" href="view/assets/docs/Plantilla de invitaciones a eventos.csv" download='Plantilla de invitaciones a eventos.csv' >Descargar plantilla</a>
				</center>
				<form class="registerInv">
					<!-- Agrega un elemento div con el id myDropzone para Dropzone -->
					<div id="myDropzone" class="dropzone"></div>
				</form>
				<div class="center-buttons mt-4">
					<button type="submit" class="btn btn-primary mx-1" id="register" data-bs-dismiss="modal">Registrar</button>
					<button type="button" class="btn btn-danger mx-1" data-bs-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="view\assets\js\events\getEventActive.js"></script>
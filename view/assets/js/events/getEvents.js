var active = '';
$(document).ready(function() {
	
	verificarEventosActivos();
	$('#tableEvents').DataTable({
		ajax: {
			url: 'controller/ajax/getEvents.php',
			dataSrc: ''
		},
		columns:[
			{
				data: null,
				render: function(data) {
					return `
					<center class="table-columns">
						`+data.nameEvent+`
					</center>
					`;
				}
			},
			{
				data: null,
				render: function(data) {
					return `
					<center class="table-columns">
						`+data.dateEvent+`
					</center>
					`;
				}
			},
			{
				data: null,
				render: function(data) {
					if(data.statusEvent == 0){
						if (active === 'ok'){
							return `
							<center class="table-columns"> 
								<button class="btn-custom btn-modal btn-editar" data-id="${data.idEvent}" data-title="Editar" data-type="2" data-name="${data.nameEvent}" data-date="${data.dateEvent}">Editar</button> | 
								<button class="btn-custom btn-modal btn-eliminar" data-id="${data.idEvent}" data-title="Eliminar" data-type="3">Eliminar</button>
							</center>
							`;
						} else {
							return `
							<center class="table-columns">
								<button class="btn-custom btn-modal btn-activar" data-id="${data.idEvent}" data-title="Activar" data-type="1">Activar</button> | 
								<button class="btn-custom btn-modal btn-editar" data-id="${data.idEvent}" data-title="Editar" data-type="2" data-name="${data.nameEvent}" data-date="${data.dateEvent}">Editar</button> | 
								<button class="btn-custom btn-modal btn-eliminar" data-id="${data.idEvent}" data-title="Eliminar" data-type="3">Eliminar</button>
							</center>
							`;
						}
					} else if (data.statusEvent == 1) {
						return `
						<center class="table-columns">
							Activo | 
							<button class="btn-custom btn-modal btn-eliminar" data-id="${data.idEvent}" data-title="Finalizar" data-type="4">Finalizar</button>
						</center>
						`;
					} else {
						if (active === 'ok'){
							return `
							<center class="table-columns">
								Terminado | 
								<button class="btn-custom btn-modal btn-editar" data-id="${data.idEvent}" data-title="Ver asistencia del" data-type="5">Ver asistencia</button>
							</center>
							`;
						} else {
							return `
							<center class="table-columns">
								<button class="btn-custom btn-modal btn-activar" data-id="${data.idEvent}" data-title="Activar" data-type="1">Activar</button> | 
								Terminado | 
								<button class="btn-custom btn-modal btn-editar" data-id="${data.idEvent}" data-title="Ver asistencia del" data-type="5">Ver asistencia</button>
							</center>
							`;
						}
					}
				}
        
			},
			{
				data: null,
				render: function(data) {
					return `
						<center class="table-columns">
							<button class="btn-custom btn-invitados" data-idEvent="` + data.idEvent + `">Ver invitados <i class="fas fa-chevron-right"></i></button>
						</center>
					`;
				}
			}
		],
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
		}
	});

	setInterval(function() {
		$('#tableEvents').DataTable().ajax.reload();
	}, 10000);

	$("form.events").submit(function (event) {
		event.preventDefault();
		// Collect form values
		var eventName = $("input[name='eventName']").val();
		var dateEvent = $("input[name='dateEvent']").val();
		
		$.ajax({
			type: "POST",
			url: "controller/ajax/ajax.form.php",
			data: {
				function: 1,
				eventName: eventName,
				dateEvent: dateEvent,
			},
			success: function (response) {				
				
				if (response === 'ok') {

					clearForm();
					$('#tableEvents').DataTable().ajax.reload();

				} else {
					
				}
			},
			error: function (error) {
				console.log("Error en la solicitud Ajax:", error);
			}
		});
	});
	
});

function clearForm(){
	$("input[name='eventName']").val('');
	$("input[name='dateEvent']").val('');
}

$(document).on('click', '.btn-invitados', function() {
    var eventId = $(this).data('idevent');
    window.location.href = '?pagina=invitados&event='+eventId; // Redirigir a la página de invitados
});

$(document).on('click', '.btn-modal', function() {
    var eventId = $(this).data('id');
    var title = $(this).data('title');
    var type = $(this).data('type');
    var content = generateModalContent(type, $(this), eventId);

        $('.titleEvent').text(`${title} evento`);
        $('.contentModal').html(content);
        $('#actionModal').modal('show');
    
});


function generateModalContent(type, button, eventId) {
    switch (type) {
        case 1:
            return `¿Está seguro de que desea activar el evento? Esta acción permitirá la inscripción y visualización del evento por parte de los usuarios.
				<Form id="modalForm">
					<input type="hidden" value="${eventId}" name="activateEvent">
				</form>
		`;
        case 2:
            let name = button.data('name');
            let date = button.data('date');
            return `
			<Form id="modalForm">
                <label>Nombre del evento:</label>
                <input type="text" class="form-control mb-2" value="${name}" name="editNameEvent">
                <label>Fecha del evento:</label>
                <input type="datetime-local" class="form-control" value="${date}" name="editDateEvent">
                <input type="hidden" value="${eventId}" name="editEvent">
			</form>
            `;
        case 3:
            return `¿Está seguro de que desea eliminar el evento? Esta acción es irreversible y eliminará toda la información relacionada con el evento.
				<Form id="modalForm">
					<input type="hidden" value="${eventId}" name="deleteEvent">
				</form>
			`;
        case 4:
            return `¿Está seguro de que desea finalizar el evento? Esta acción marcará el evento como completado y no se podrán realizar más inscripciones.
				<Form id="modalForm">
					<input type="hidden" value="${eventId}" name="closeEvent">
				</form>
				`;
        case 5:
            return `¿Está seguro de que desea descargar la lista de asistencias del evento? Esto generará un archivo con los datos de los asistentes al evento.
				<Form id="modalForm">
                    <input type="hidden" value="${eventId}" name="downloadAttendanceList">
				</form>
            `;
        default:
            return 'Acción no reconocida. Por favor, intente de nuevo.';
    }
}
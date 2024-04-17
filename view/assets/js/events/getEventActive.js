$(document).ready(function() {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getEventActive.php',
        dataType: 'json',
        success: function(response) {
            // Verifica si la respuesta tiene la propiedad 'nameEvent'
            if (response.hasOwnProperty('nameEvent')) {
                $('#evento').text(response.nameEvent); // Actualiza el contenido del elemento con el ID 'evento'
                $('input[name="idEvent"]').val(response.idEvent);

                // Configurar DataTables y obtener invitados después de obtener el evento activo
                setupDataTables(response.idEvent);
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });

    $("form.events").submit(function (event) {
        event.preventDefault();
        var eventName = $("input[name='eventName']").val();
        var dateEvent = $("input[name='dateEvent']").val();
        
        $.ajax({
            type: "POST",
            url: "controller/ajax/ajax.form.php",
            data: {
                function: 2,
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

function setupDataTables(idEvent) {
	$('#tableEvents').DataTable({
		ajax: {
            type: 'POST',
            url: 'controller/ajax/getInvitados.php',
            data: {'event': idEvent},
            dataType: 'json',
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
}

function aceptar(id){
    var content = `
        <Form id="modalForm">
            <label for="nInvitados">Número de invitados:</label>
            <input type="number" class="form-control mb-2" value="1" min="1" name="nInvitados">
            <input type="hidden" name="enviarAsistencia" value="${id}">
            <input type="hidden" name="function" value="3">
        </form>
    `;
    
    $('.titleEvent').text(`Confirmación de Asistencia`);
    $('.contentModal').html(content);
    $('#actionModal').modal('show');
}

function rechazar(id){
    var content = `
    <p>¿Está seguro de que desea marcar como ausente a este invitado?</p>
        <Form id="modalForm">
            <input type="hidden" name="marcarAusente" value="${id}">
            <input type="hidden" name="function" value="4">
        </form>
    `;
    
    $('.titleEvent').text(`Marcar como Ausente`);
    $('.contentModal').html(content);
    $('#actionModal').modal('show');
}

setInterval(function() {
    $('#tableEvents').DataTable().ajax.reload();
}, 30000);
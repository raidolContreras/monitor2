$(document).ready(function() {
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
						return `
						<center class="table-columns">
							<button class="btn-custom btn-activar">Activar</button> | 
							<button class="btn-custom btn-editar">Editar</button> | 
							<button class="btn-custom btn-eliminar">Eliminar</button>
						</center>
						`;
					} else if (data.statusEvent == 1) {
						return `
						<center class="table-columns">
							Activo | 
							<button class="btn-custom btn-eliminar">Finalizar</button>
						</center>
						`;
					} else {
						return `
						<center class="table-columns">
							Terminado | 
							<button class="btn-custom btn-editar">Ver asistencia</button>
						</center>
						`;
					}
				}
        
			}
		],
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
		},
	});

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
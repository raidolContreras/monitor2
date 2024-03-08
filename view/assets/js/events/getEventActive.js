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
                            ${data.lastname} ${data.firstname}
                        </center>
                    `;
                }
            },
            {
                data: null,
                render: function(data) {
                    return `
                        <center class="table-columns">
                            ${data.institucion}
                        </center>
                    `;
                }
            },
            {
                data: null,
                render: function(data) {
                    return `
                        <center class="table-columns">
                            ${data.puesto}
                        </center>
                    `;
                }
            },
            {
                data: null,
                render: function(data) {
                    let colorIcon;
                    switch (data.color) {
                        case '1':
                            textColor = 'Rojo';
                            colorIcon = 'red';
                            break;
                        case '2':
                            textColor = 'Amarillo';
                            colorIcon = '#FFA500';
                            break;
                        default:
                            textColor = 'Verde';
                            colorIcon = 'green';
                    }
                    return `
                        <center class="table-columns row" style="justify-content: center;">
                            <i class="fas fa-circle" style="color: ${colorIcon};"></i> ${textColor}
                        </center>
                    `;
                }
            },
            {
                data: null,
                render: function(data) {
                    return `
                        <center class="table-columns">
                            ${data.estacionamiento}
                        </center>
                    `;
                }
            },
            {
                data: null,
                render: function(data) {
                    return `
                        <center class="table-columns">
                            ${data.anfitrion}
                        </center>
                    `;
                }
            },
            {
                data: null,
                render: function(data) {
                    if (data.statusInvitado == 0) {
                        return `
                            <center class="table-columns row" style="justify-content: center;">
                                <button class="btn-circle-success" onClick="aceptar(`+data.idInvitado+`)"><i class="fas fa-check"></i></button>
                                <button class="btn-circle-danger" onClick="rechazar(`+data.idInvitado+`)"><i class="fas fa-times"></i></button>
                            </center>
                        `;
                    } else if (data.statusInvitado == 1) {
                        return `
                            <center class="table-columns">
                                Presente
                            </center>
                        `;
                    } else {
                        return `
                            <center class="table-columns">
                                Ausente
                            </center>
                        `;
                    }
                }
            }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
    });
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
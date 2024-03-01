$(document).ready(function() {
    var idEvent = $('input[name="idEvent"]').val();
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getEvents.php',
        data: {'event': idEvent},
        dataType: 'json',
        success: function(response) {
            // Verifica si la respuesta tiene la propiedad 'nameEvent'
            if (response.hasOwnProperty('nameEvent')) {
                $('#evento').text(response.nameEvent); // Actualiza el contenido del elemento con el ID 'evento'
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });

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
                        case 1:
                            colorIcon = 'red';
                            break;
                        case 2:
                            colorIcon = '#FFA500'; // Amarillo oscuro
                            break;
                        default:
                            colorIcon = 'green';
                    }
                    return `
                        <center class="table-columns">
                            <i class="fas fa-circle" style="color: ${colorIcon};"></i>
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
                                <button class="btn-circle-success"><i class="fas fa-check"></i></button>
                                <button class="btn-circle-danger"><i class="fas fa-times"></i></button>
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
        },
        "ordering": false
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


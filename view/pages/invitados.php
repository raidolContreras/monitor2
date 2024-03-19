<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>

<?php if ($_SESSION['level'] == '2'): ?>
	<script>
		window.location.href = "./";
	</script>
<?php else: ?>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

<main class="container">
    <div class="card-custom">
        <div class="card-header-custom">
            <strong id="evento"></strong>
        </div>
    </div>
	<button id="sheetjsexport" class="btn btn-primary mb-3">Exportar excel</button>
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
      <tfoot>
        <td colspan="4">Total de asistentes</td>
        <td colspan="3" class="invitados">0 invitados</td>
      </tfoot>
		</table>
	</div>
</main>
<input type="hidden" name="idEvent" value="<?php echo $_GET['event'] ?>">
<!-- Modal para el registro de eventos -->
<div class="modal fade" id="invitadosModal" tabindex="-1" aria-labelledby="invitadosModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="invitadosModalLabel">Registrar invitados</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
			</div>
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
<script src="view\assets\js\events\getInvitados.js"></script>

<script>
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("#myDropzone", {
		autoProcessQueue: false,
        url: "controller/ajax/uploadInv.php",
        paramName: "file",
        maxFilesize: 10,
        acceptedFiles: ".csv",
        dictDefaultMessage: "Arrastra y suelta el archivo<br><span>Carga archivos: csv, tamaño máximo 10 MB.</span>",
        dictFallbackMessage: "Tu navegador no admite la carga de archivos mediante arrastrar y soltar.",
        dictFileTooBig: "El archivo es demasiado grande ({{filesize}} MB). Tamaño máximo permitido: {{maxFilesize}} MB.",
        dictInvalidFileType: "No puedes subir archivos de este tipo.",
        dictResponseError: "El servidor respondió con el código {{statusCode}}.",
        dictCancelUpload: "Cancelar subida",
        dictCancelUploadConfirmation: "¿Estás seguro de que deseas cancelar esta subida?",
        dictRemoveFile: "Eliminar archivo",
        dictRemoveFileConfirmation: null,
        dictMaxFilesExceeded: "No puedes subir más archivos.",
        addRemoveLinks: true,
	init: function() {
		var submitButton = document.getElementById("register");
		var idEvent = $('input[name="idEvent"]').val();
		var myDropzone = this;

		submitButton.addEventListener("click", function() {
			myDropzone.processQueue();
		});

		this.on("sending", function(file, xhr, formData) {
			// Añade el parámetro del evento al objeto formData aquí
			formData.append("event", idEvent);
		});

		this.on("success", function(file, response) {
			$('#tableEvents').DataTable().ajax.reload();
		});
	}
});


document.getElementById("sheetjsexport").addEventListener('click', function() {
    /* Crear hoja de cálculo a partir de la tabla HTML */
    var wb = XLSX.utils.table_to_book(document.getElementById("tableEvents"), {
      sheet: "Invitados", // Nombre de la hoja en el archivo Excel
      display: true, // Mostrar celdas en negrita y en cursiva
      /* Estilo personalizado para la hoja de cálculo */
      styles: {
        /* Estilo de la tabla */
        table: {
          background: '#ffffff', // Color de fondo de la tabla
          font: { color: "#333333" } // Color del texto
        },
        /* Estilo de las celdas del encabezado */
        th: {
          background: '#4CAF50', // Color de fondo del encabezado
          color: "#ffffff", // Color del texto del encabezado
          font: { bold: true }, // Negrita para el encabezado
          border: "1px solid #dddddd", // Borde de las celdas del encabezado
          textAlign: "center" // Alineación del texto en el encabezado
        },
        /* Estilo de las celdas de datos */
        td: {
          background: '#ffffff', // Color de fondo de las celdas de datos
          color: "#333333", // Color del texto de las celdas de datos
          font: { italic: false }, // Cursiva para las celdas de datos
          border: "1px solid #dddddd", // Borde de las celdas de datos
          textAlign: "center" // Alineación del texto en las celdas de datos
        }
      }
    });
    /* Exportar a un archivo (iniciar la descarga) */
    XLSX.writeFile(wb, "Invitados.xlsx");
  });
</script>
<?php endif ?>
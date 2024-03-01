<?php
// uploadInv.php
require_once "../forms.controller.php";
require_once "../../model/forms.models.php";

$expectedHeaders = ['firstname', 'lastname', 'anfitrion', 'institucion', 'puesto', 'invitaciones', 'color'];

if (!empty($_FILES) && isset($_POST['event'])) {
    $file = $_FILES['file']['tmp_name'];
    $event = $_POST['event'];
    $fileContent = file_get_contents($file);
    $bom = pack('H*','EFBBBF');
    $fileContent = preg_replace("/^$bom/", '', $fileContent); // Eliminar BOM si está presente
    $csvData = array_map(function($line) {
        return str_getcsv($line, ","); // Ajusta el delimitador según sea necesario
    }, explode("\n", $fileContent));
    
    $headers = array_map('trim', array_shift($csvData));

    if ($headers !== $expectedHeaders) {
        echo json_encode(array(
            'error' => 'Los encabezados del CSV no coinciden con la estructura esperada.',
            'expected' => $expectedHeaders,
            'found' => $headers
        ));
        return;
    }

    $response = FormsController::ctrUploadInv($csvData, $event, $headers);
    echo json_encode($response);
} else {
    echo json_encode(array('error' => 'No se recibió ningún archivo o falta el parámetro del evento.'));
}

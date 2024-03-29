<?php 

require_once "../forms.controller.php";
require_once "../../model/forms.models.php";

session_start();

if (isset($_POST['function'])) {

    switch ($_POST['function']) {
        case 1:
            echo FormsController::ctrRegisterEvent($_POST['eventName'], $_POST['dateEvent']);
            break;
        case 2:
            echo FormsController::ctrRegisterUser($_POST['userName'], $_POST['email'], $_POST['password'], $_POST['level']);
            break;
        case 3:
            echo FormsController::ctrRegisterAssist($_POST['enviarAsistencia'], $_POST['nInvitados']);
            break;
        case 4:
            echo FormsController::ctrMarkAssist($_POST['marcarAusente']);
            break;
    }

} else if (isset($_POST['deleteEvent'])) {
    echo FormsController::ctrDeleteEvent($_POST['deleteEvent']);
} else if (isset($_POST['editEvent'])) {
    echo FormsController::ctrEditEvent($_POST['editEvent'], $_POST['editNameEvent'], $_POST['editDateEvent']);
} else if (isset($_POST['closeEvent'])) {
    echo FormsController::ctrCloseEvent($_POST['closeEvent']);
} else if (isset($_POST['downloadAttendanceList'])) {
    $resultado = FormsController::ctrDownloadEvent($_POST['downloadAttendanceList']);
    if ($resultado == 'ok') {
        $eventId = $_POST['downloadAttendanceList'];
        $filePath = '../../view/assets/docs/' . $eventId . '/lista_invitados.xlsx';
        if (file_exists($filePath)) {
            echo 'ok';
        } else {
            echo 'El archivo no existe.';
        }
    }

} else if (isset($_POST['activateEvent'])) {
    echo FormsController::ctrActivateEvent($_POST['activateEvent']);
}
<?php 

require_once "../forms.controller.php";
require_once "../../model/forms.models.php";

session_start();

if (isset($_POST['function'])) {

    switch ($_POST['function']) {
        case 1:
            // Llama a la función que maneja el registro de eventos
            echo FormsController::ctrRegisterEvent($_POST['eventName'], $_POST['dateEvent']);
            break;
        case 2:
            // Llama a la función que maneja el registro de eventos
            // echo FormsController::ctrRegisterEvent($_POST['eventName'], $_POST['dateEvent']);
            // break;
        case 3:
            // Llama a la función que maneja el registro de eventos
            echo FormsController::ctrRegisterAssist($_POST['enviarAsistencia'], $_POST['nInvitados']);
            break;
        case 4:
            // Llama a la función que maneja el registro de eventos
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
    echo FormsController::ctrDownloadEvent($_POST['downloadAttendanceList']);
} else if (isset($_POST['activateEvent'])) {
    echo FormsController::ctrActivateEvent($_POST['activateEvent']);
}
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
        // Puedes agregar más casos para diferentes funciones
    }
}
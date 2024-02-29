<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";
    $idEvent = (isset($_POST['event'])) ? $_POST['event'] : null;
    $getEvents = FormsController::ctrGetEvents($idEvent);
    echo json_encode($getEvents);
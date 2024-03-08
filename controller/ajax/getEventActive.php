<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";
    $getEvents = FormsController::ctrGetEventActive();
    echo json_encode($getEvents);
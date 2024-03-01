<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";
    
    $getInvitados = FormsController::ctrGetInvitados($_POST['event']);
    echo json_encode($getInvitados);
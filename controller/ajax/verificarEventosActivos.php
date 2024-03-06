<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";
    $getEventsActives = FormsController::ctrGetEventsActives();
    echo $getEventsActives;
<?php 

class FormsController {
    static public function ctrGetEvents($idEvent) {
        return FormsModel::mdlGetEvents($idEvent);
    }

    static public function ctrRegisterEvent($eventName, $dateEvent) {
        return FormsModel::mdlRegisterEvent($eventName, $dateEvent);
    }
}
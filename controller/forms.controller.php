<?php 

class FormsController {
    static public function ctrGetEvents($idEvent) {
        return FormsModel::mdlGetEvents($idEvent);
    }
    static public function ctrGetEventActive() {
        return FormsModel::mdlGetEventActive();
    }
    
    static public function ctrGetInvitados($idEvent) {
        return FormsModel::mdlGetInvitados($idEvent);
    }

    static public function ctrRegisterEvent($eventName, $dateEvent) {
        return FormsModel::mdlRegisterEvent($eventName, $dateEvent);
    }

    static public function ctrDeleteEvent($idEvent) {
        return FormsModel::mdlDeleteEvent($idEvent);
    }

    static public function ctrEditEvent($idEvent, $NameEvent, $DateEvent) {
        return FormsModel::mdlEditEvent($idEvent, $NameEvent, $DateEvent);
    }

    static public function ctrCloseEvent($idEvent) {
        return FormsModel::mdlCloseEvent($idEvent);
    }

    static public function ctrDownloadEvent($idEvent) {
        return FormsModel::mdlDownloadEvent($idEvent);
    }

    static public function ctrActivateEvent($idEvent) {
        return FormsModel::mdlActivateEvent($idEvent);
    }

    static public function ctrGetEventsActives() {
        return FormsModel::mdlGetEventsActives();
    }

    static public function ctrUploadInv($datos, $idEvent, $headers) {
        $results = [];
        foreach ($datos as $dato){
            if (count($dato) !== count($headers)) {
                // Si la cantidad de campos no coincide con los encabezados esperados, retornar error
                return array('error' => 'La cantidad de campos no coincide con los encabezados esperados.');
            }
            $rowData = array_combine($headers, $dato);
            $result = FormsModel::mdlUploadInv($rowData, $idEvent);
            array_push($results, $result);
        }
        return $results;
    }

    static public function ctrSearchUsers($email){
        return FormsModel::mdlSearchUsers($email);
    }

    static public function ctrRegisterAssist($enviarAsistencia, $nInvitados){
        return FormsModel::mdlRegisterAssist($enviarAsistencia, $nInvitados);
    }

    static public function ctrMarkAssist($idInvitado){
        return FormsModel::mdlMarkAssist($idInvitado);
    }

    static public function ctrRegisterUser($name, $email, $password, $level){
        
        $cryptPassword = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
        return FormsModel::mdlRegisterUser($name, $email, $cryptPassword, $level);
    }

}
<?php 

class FormsController {
    static public function ctrGetEvents($idEvent) {
        return FormsModel::mdlGetEvents($idEvent);
    }
    
    static public function ctrGetInvitados($idEvent) {
        return FormsModel::mdlGetInvitados($idEvent);
    }

    static public function ctrRegisterEvent($eventName, $dateEvent) {
        return FormsModel::mdlRegisterEvent($eventName, $dateEvent);
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
}
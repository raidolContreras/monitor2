<?php 
include "conection.php";

class FormsModel {
    static public function mdlGetEvents($idEvent){
        try {
            $pdo = Conexion::conectar();
            if ($idEvent !== null) {
                $stmt = $pdo->prepare('SELECT * FROM unimo_events WHERE idEvent = :idEvent');
                $stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
    
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $stmt = $pdo->prepare('SELECT * FROM unimo_events');
                
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            error_log("Error en la consulta SQL: " . $e->getMessage());
            throw $e;
        }
    }
    
    static public function mdlGetInvitados($idEvent){
        try {
            $pdo = Conexion::conectar();
            $stmt = $pdo->prepare('SELECT * FROM unimo_invitados WHERE idEvent = :idEvent');
            $stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en la consulta SQL: " . $e->getMessage());
            throw $e;
        }
    }

    static public function mdlRegisterEvent($eventName, $dateEvent) {
        try {
            $pdo = Conexion::conectar();
            $stmt = $pdo->prepare('INSERT INTO unimo_events (nameEvent, dateEvent) VALUES (:nameEvent, :dateEvent)');
            
            $stmt->bindParam(':nameEvent', $eventName, PDO::PARAM_STR);
            $stmt->bindParam(':dateEvent', $dateEvent, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                return 'ok';
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error al registrar el evento: " . $e->getMessage());
            throw $e;
        }
    }
    
    static public function mdlUploadInv($dato, $idEvent) {
        $color = (strtolower($dato['color']) == 'rojo') ? 1 : ((strtolower($dato['color']) == 'amarillo') ? 2 : 0);
        print_r($dato);
        // Verifica que todos los datos necesarios estén presentes y no sean NULL
        foreach ($dato as $value) {
            if (trim($value) === '') {
                // Puedes devolver un error o manejar este caso según sea necesario
                return 'Error: Uno de los campos requeridos está vacío.';
            }
        }
    
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("INSERT INTO unimo_invitados (idEvent, firstname, lastname, anfitrion, institucion, puesto, invitaciones, color) VALUES (:idEvent, :firstname, :lastname, :anfitrion, :institucion, :puesto, :invitaciones, :color)");
        
        // Asegúrate de que $dato contenga los valores en el orden correcto
        $stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
        $stmt->bindParam(':firstname', $dato['firstname'], PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $dato['lastname'], PDO::PARAM_STR);
        $stmt->bindParam(':anfitrion', $dato['anfitrion'], PDO::PARAM_STR);
        $stmt->bindParam(':institucion', $dato['institucion'], PDO::PARAM_STR);
        $stmt->bindParam(':puesto', $dato['puesto'], PDO::PARAM_STR);
        $stmt->bindParam(':invitaciones', $dato['invitaciones'], PDO::PARAM_INT);
        $stmt->bindParam(':color', $color, PDO::PARAM_INT);
    
        if (!$stmt->execute()) {
            // Devuelve información sobre el error si la inserción falla
            $errorInfo = $stmt->errorInfo();
            return 'Error al insertar en la base de datos: ' . $errorInfo[2];
        }
    
        return $pdo->lastInsertId();
    }
    
    
}
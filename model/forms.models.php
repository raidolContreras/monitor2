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
    
    
}
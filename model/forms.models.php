<?php 

require_once __DIR__ . '/../view/assets/vendor/PHP/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

include "conection.php";

class FormsModel {
    static public function mdlGetEvents($idEvent){
        try {
            $pdo = Conexion::conectar();
            if ($idEvent !== null) {
                $stmt = $pdo->prepare('SELECT e.*, SUM(i.invitados) AS nInvitados FROM unimo_events e
                                            LEFT JOIN unimo_invitados i ON i.idEvent = e.idEvent
                                        WHERE e.idEvent = :idEvent');
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
    static public function mdlGetEventActive(){
        try {
            $pdo = Conexion::conectar();
            $stmt = $pdo->prepare('SELECT * FROM unimo_events WHERE statusEvent = 1');

            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en la consulta SQL: " . $e->getMessage());
            throw $e;
        }
    }
    
    static public function mdlGetInvitados($idEvent){
        try {
            $pdo = Conexion::conectar();
            $stmt = $pdo->prepare('
            SELECT i.*, e.statusEvent
                FROM unimo_invitados i
                left JOIN unimo_events e ON e.idEvent = i.idEvent
            WHERE i.idEvent = :idEvent
            ');
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
        $stmt = $pdo->prepare("INSERT INTO unimo_invitados (idEvent, firstname, lastname, anfitrion, institucion, puesto, estacionamiento, color) VALUES (:idEvent, :firstname, :lastname, :anfitrion, :institucion, :puesto, :estacionamiento, :color)");
        
        // Asegúrate de que $dato contenga los valores en el orden correcto
        $stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
        $stmt->bindParam(':firstname', $dato['firstname'], PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $dato['lastname'], PDO::PARAM_STR);
        $stmt->bindParam(':anfitrion', $dato['anfitrion'], PDO::PARAM_STR);
        $stmt->bindParam(':institucion', $dato['institucion'], PDO::PARAM_STR);
        $stmt->bindParam(':puesto', $dato['puesto'], PDO::PARAM_STR);
        $stmt->bindParam(':estacionamiento', $dato['estacionamiento'], PDO::PARAM_STR);
        $stmt->bindParam(':color', $color, PDO::PARAM_INT);
    
        if (!$stmt->execute()) {
            // Devuelve información sobre el error si la inserción falla
            $errorInfo = $stmt->errorInfo();
            return 'Error al insertar en la base de datos: ' . $errorInfo[2];
        }
    
        return $pdo->lastInsertId();
    }

    static public function mdlDeleteEvent($idEvent) {
        try {
            $pdo = Conexion::conectar();
            $stmt = $pdo->prepare('DELETE FROM unimo_events WHERE idEvent = :idEvent');
            
            $stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return 'eliminado';
            } else {
                return 'Error';
            }
        } catch (PDOException $e) {
            error_log("Error al registrar el evento: " . $e->getMessage());
            throw $e;
        }
    }

    static public function mdlEditEvent($idEvent, $nameEvent, $dateEvent) {
        try {
            $pdo = Conexion::conectar();
            $stmt = $pdo->prepare('UPDATE unimo_events SET nameEvent=:nameEvent, dateEvent=:dateEvent where idEvent = :idEvent');
            
            $stmt->bindParam(':nameEvent', $nameEvent, PDO::PARAM_STR);
            $stmt->bindParam(':dateEvent', $dateEvent, PDO::PARAM_STR);
            $stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return 'actualizado';
            } else {
                return 'Error';
            }
        } catch (PDOException $e) {
            error_log("Error al registrar el evento: " . $e->getMessage());
            throw $e;
        }
    }

    static public function mdlCloseEvent($idEvent) {
        try {
            $pdo = Conexion::conectar();
            $stmt = $pdo->prepare('UPDATE unimo_events SET statusEvent = 2 where idEvent = :idEvent');
            
            $stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return 'finalizado';
            } else {
                return 'Error';
            }
        } catch (PDOException $e) {
            error_log("Error al registrar el evento: " . $e->getMessage());
            throw $e;
        }
    }

    static public function mdlActivateEvent($idEvent) {
        try {
            $pdo = Conexion::conectar();
            $stmt = $pdo->prepare('UPDATE unimo_events SET statusEvent = 1 where idEvent = :idEvent');
            
            $stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return 'activado';
            } else {
                return 'Error';
            }
        } catch (PDOException $e) {
            error_log("Error al registrar el evento: " . $e->getMessage());
            throw $e;
        }
    }
    
    static public function mdlGetEventsActives() {
        try {
            $pdo = Conexion::conectar();
            $stmt = $pdo->prepare('SELECT * FROM unimo_events WHERE statusEvent = 1;');
            
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                return 'ok';
            } else {
                return 'false';
            }
        } catch (PDOException $e) {
            error_log("Error al registrar el evento: " . $e->getMessage());
            throw $e;
        }
    }    

    static public function mdlDownloadEvent($idEvent) {
        $registros = FormsModel::mdlGetInvitados($idEvent);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Definir los títulos de las columnas
        $titles = ['ID Invitado', 'ID Evento', 'Nombre', 'Apellidos', 'Email', 'Anfitrión', 'Institución', 'Puesto', 'Color', 'Invitados', 'Estacionamiento', 'Estado del Invitado'];
        $column = 'A';
        foreach ($titles as $title) {
            $sheet->setCellValue($column.'1', $title);
            $column++;
        }

        // Llenar el Excel con los datos
        $row = 2;
        foreach ($registros as $registro) {
            $sheet->setCellValue('A'.$row, $registro['idInvitado']);
            $sheet->setCellValue('B'.$row, $registro['idEvent']);
            $sheet->setCellValue('C'.$row, $registro['firstname']);
            $sheet->setCellValue('D'.$row, $registro['lastname']);
            $sheet->setCellValue('E'.$row, $registro['email']);
            $sheet->setCellValue('F'.$row, $registro['anfitrion']);
            $sheet->setCellValue('G'.$row, $registro['institucion']);
            $sheet->setCellValue('H'.$row, $registro['puesto']);
            $sheet->setCellValue('I'.$row, $registro['color']);
            $sheet->setCellValue('J'.$row, $registro['invitados']);
            $sheet->setCellValue('K'.$row, $registro['estacionamiento']);
            $sheet->setCellValue('L'.$row, $registro['statusInvitado']);
            $row++;
        }

        // Generar el archivo de Excel
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        // Forzar la descarga del archivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="lista_invitados.xlsx"');
        $writer->save('php://output');
    }

    static public function mdlSearchUsers($email) {
        try {
            $pdo = Conexion::conectar();
            $stmt = $pdo->prepare('SELECT * FROM unimo_users WHERE email = :email');
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                return $stmt->fetch();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error al registrar el evento: " . $e->getMessage());
            throw $e;
        }
    }

    static public function mdlRegisterAssist($enviarAsistencia, $nInvitados) {
        try {
            $pdo = Conexion::conectar();
            $stmt = $pdo->prepare('UPDATE unimo_invitados SET invitados = :nInvitados, statusInvitado = 1 where idInvitado = :idInvitado');
            
            $stmt->bindParam(':idInvitado', $enviarAsistencia, PDO::PARAM_INT);
            $stmt->bindParam(':nInvitados', $nInvitados, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return 'ok';
            } else {
                return 'Error';
            }
        } catch (PDOException $e) {
            error_log("Error al registrar el evento: " . $e->getMessage());
            throw $e;
        }
    }

    static public function mdlMarkAssist($idInvitado) {
        try {
            $pdo = Conexion::conectar();
            $stmt = $pdo->prepare('UPDATE unimo_invitados SET statusInvitado = 2 where idInvitado = :idInvitado');
            
            $stmt->bindParam(':idInvitado', $idInvitado, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return 'ok';
            } else {
                return 'Error';
            }
        } catch (PDOException $e) {
            error_log("Error al registrar el evento: " . $e->getMessage());
            throw $e;
        }
    }
    
    static public function mdlRegisterUser($name, $email, $cryptPassword, $level) {
        $pdo = Conexion::conectar();
        $stmt = $pdo->prepare("INSERT INTO unimo_users (name, email, password, level) VALUES (:name, :email, :password, :level)");
        
        // Asegúrate de que $dato contenga los valores en el orden correcto
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $cryptPassword, PDO::PARAM_STR);
        $stmt->bindParam(':level', $level, PDO::PARAM_INT);
    
        if (!$stmt->execute()) {
            // Devuelve información sobre el error si la inserción falla
            $errorInfo = $stmt->errorInfo();
            return 'Error al insertar en la base de datos: ' . $errorInfo[2];
        } else {
            return 'ok';
        }
    
        return $pdo->lastInsertId();
    }

}
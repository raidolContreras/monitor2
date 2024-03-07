<?php 
    
	$pagina = $_GET['pagina'] ?? 'inicio';

	$navs = [
		'inicio',
		'invitados',
	];
    
    if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
        
        if (in_array($pagina, $navs)) {
            include "view/pages/navs/header.php";
            include "view/pages/modals.php";
            include "view/js.php";
        }

        if ($pagina == 'inicio'){
    
            include "view/pages/$pagina.php";
    
        } elseif($pagina == 'invitados'){
    
            include "view/pages/$pagina.php";
    
        } elseif ($pagina == 'login'){
    
            header("Location: inicio");
            exit();
    
        } else {
    
            include "error404.php";
    
        }
    } elseif($pagina == 'login') {
        include "view/pages/login/login.php";
    } else {
        header("Location: login");
        exit();
    }
<?php 
    
	$pagina = $_GET['pagina'] ?? 'inicio';

	$navs = [
		'inicio',
		'invitados',
	];


	if (in_array($pagina, $navs)) {
		include "view/pages/navs/header.php";
	}

    if ($pagina == 'inicio'){

        include "view/pages/$pagina.php";

    } elseif($pagina == 'invitados'){

        include "view/pages/$pagina.php";

    } else {

        include "error404.php";

    }
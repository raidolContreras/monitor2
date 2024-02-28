<?php
header('Content-Type: text/html; charset=utf-8');
?>

<?php

// Comenzar la sesión
session_start();

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
	<title>Monitor - UNIMO</title>
	<?php include "css.php"; ?>
</head>

<body>
	
	<?php include "config/whiteList.php"; ?>
	<?php include "pages/navs/header.php"; ?>
	<?php include "pages/inicio.php"; ?>
	
</body>
<?php include "js.php"; ?>

</html>

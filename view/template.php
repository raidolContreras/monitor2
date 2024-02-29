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
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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

<?php 
if  ($_SESSION['level'] == '1'){
    include ("eventos.php");
} else {
    include ("eventoActivo.php");
}

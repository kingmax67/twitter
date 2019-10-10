<?php
include '../core/int.php';
$getFromU->logout();
if (!isset($_SESSION['user_id'])){
	header('Location:../index.php');
}
?>
?>
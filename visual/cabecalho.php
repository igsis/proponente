<?php
session_start();

if(!isset ($_SESSION['login']) == true) //verifica se há uma sessão, se não, volta para área de login
{
	unset($_SESSION['login']);
	header('location:../index.php');
}
else
{
	$logado = $_SESSION['login'];
}
//ini_set('session.gc_maxlifetime', 30*60); // 30 minutos
ini_set('session.gc_maxlifetime', 60*60); // 60 minutos
?>

<html>
	<head>
		<title>IGSIS-CAPAC - 2017 - v1.0 - Secretaria Municipal de Cultural - São Paulo</title>
		<meta charset="utf-8" />
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- css -->
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/style.css" rel="stylesheet" media="screen">
		<link href="color/default.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<?php include "../include/script.php"; ?>
    </head>
	<body>
		<div id="bar">
			<p id="p-bar">&nbsp;IGSIS - CADASTRO DE ARTISTAS E PROFISSIONAIS DE ARTE E CULTURA<!--<img src="images/logo_pequeno.png" />-->
			</p>
		</div>
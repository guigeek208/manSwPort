<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../favicon.ico">
		<title></title>
		<!--Import Google Icon Font-->
      	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css"  media="screen,projection"/>
		<!-- Custom styles for this template -->
		<link href="css/my.css" rel="stylesheet">
		<!-- graph -->
	</head>
	<body>
	<!-- Dropdown Structure -->
	<ul id="dropdown1" class="dropdown-content">
	  <li><a href="settings.php">Préférences</a></li>
	  <li class="divider"></li>
	  <li><a href="logout.php"><i class="material-icons">input</i>Se délogguer</a></li>
	</ul>
	<!-- Dropdown Structure -->
	<ul id="dropdown2" class="dropdown-content">
	  <li><a href="settings.php">Préférences</a></li>
	  <li class="divider"></li>
	  <li><a href="logout.php"><i class="material-icons">input</i>Se délogguer</a></li>
	</ul>
	<nav>
	    <div class="nav-wrapper #8bc34a light-green">
	    	<a href="#!" class="brand-logo"><i class="material-icons">settings_input_composite</i>manSwPort</a>
	    	<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
	      	<ul id="nav-mobile" class="right hide-on-med-and-down">
	        	<li><a class="dropdown-button" href="#!" data-constrainWidth="false" data-gutter=55 data-alignment="right" data-beloworigin="true" data-activates="dropdown2">admin<i class="material-icons right">arrow_drop_down</i></a></li>
	      	</ul>
	      	<ul class="side-nav" id="mobile-demo">
	      		<li><a class="dropdown-button" href="#!" data-constrainWidth="false" data-gutter=55 data-alignment="right" data-beloworigin="true" data-activates="dropdown1">admin<i class="material-icons right">arrow_drop_down</i></a></li>
	      	</ul>
	    </div>
	</nav>

	<div class="container row">
	<?php
	session_start();
	//var_dump($_SESSION);
	if (!isset($_SESSION)) {
		header('Location: login.php');
	} else {
		if (!isset($_SESSION["login"])) {
			header('Location: login.php');
		}
	}
	?>
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
		<!-- Bootstrap core CSS -->
	<!--		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">-->
		<!--Import Google Icon Font-->
      	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="../materialize/css/materialize.min.css"  media="screen,projection"/>
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
		<!-- Custom styles for this template -->
		<link href="css/my.css" rel="stylesheet">
		<!-- graph -->
	</head>
	<body>
<?php
require_once("manSwPort.php");
$manSwPort = manSwPort::getInstance();
if (isset($_POST)) {
	if (isset($_POST["password"])) {
		if ($manSwPort->login($_POST["password"])) {
			session_start();
			$_SESSION['login'] = 'admin';
			header('Location: index.php');
		} else {
			//echo "NOK";
			echo '<div class="card-panel red white-text">Erreur de mot de passe !</div>';
		}
	}
}
?>
	<div class="container row">
		<div class="col s4 offset-s4">
			<h3>Identifiez vous</h3>
		</div>
		<div class="col s4 offset-s4">
			<form class="col s12" action="login.php" method="post">
			    <div class="row">
			        <div class="input-field">
			          <input id="password" type="password" name="password" class="validate">
			          <label for="password">Mot de passe</label>
			        </div>
			    </div>
			    <div class="row">
			    	<button class="center-align btn waves-effect waves-light #8bc34a light-green" type="submit" name="action">Connexion
					    <i class="material-icons right">send</i>
					</button>
			    </div>
			</form>
		</div>
	</div>

<!-- support lib for bezier stuff -->
<script src="js/jquery.min.js"></script>
<!--<script src="../bootstrap/js/bootstrap.min.js"></script>-->
<script src="../materialize/js/materialize.min.js"></script>
<script src="js/my.js"></script>
  </body>
</html>
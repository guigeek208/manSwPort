<?php
include("header.php");
require_once("manSwPort.php");
$manSwPort = manSwPort::getInstance();
$infos = $manSwPort->get_Configjson();

if (isset($_POST)) {
	//var_dump($_POST);
	if (isset($_POST["webpassword"]) and isset($_POST["webconfirmpassword"])) {
		if ($_POST["webpassword"] == $_POST["webconfirmpassword"]) {
			if ($_POST["webpassword"] != "") {
				$manSwPort->set_webpassword("admin");
			} else {
				echo '<div class="card-panel red white-text">Le mot de passe ne peut pas être vide !</div>';
			}
		} else {
			echo '<div class="card-panel red white-text">Les mots de passe ne correspondent pas !</div>';
		}
	}

	if (isset($_POST["swpassword"]) and isset($_POST["swpassword"]) and isset($_POST["swconfirmpassword"]) and isset($_POST["swenablepassword"]) and isset($_POST["swconfirmenablepassword"])) {
		if ($_POST["swpassword"] == $_POST["swconfirmpassword"]) {
			if ($_POST["swenablepassword"] == $_POST["swconfirmenablepassword"]) {
				if (($_POST["swpassword"] != "") and ($_POST["swenablepassword"] != "") and ($_POST["username"] != "")) {
					$manSwPort->set_swuser($_POST["username"], $_POST["swpassword"], $_POST["swenablepassword"]);
				} else {
					echo '<div class="card-panel red white-text">Un des mots de passe est vide !</div>';
				}
			} else {
				echo '<div class="card-panel red white-text">Les mots de passe enable ne correspondent pas !</div>';
			}
		} else {
			echo '<div class="card-panel red white-text">Les mots de passe ne correspondent pas !</div>';
		}
	}
}
?>
<p></p>
<div class="row col s2 offset-s1">
<a href="index.php" class="btn btn-floating btn-large waves-effect waves-light #8bc34a light-green"><i class="material-icons">keyboard_backspace</i></a>
</div>

<div class="row col offset-s2 s8">
	<div class="card-panel">
		<p><h5>Changement du mot de passe</h5></p>
		<form name="weblogin" action="settings.php" method="post">
		    <div class="row">
		        <div class="input-field">
		          <input id="password" type="password" name="webpassword" class="validate">
		          <label for="password">Mot de passe</label>
		        </div>
		    </div>
		    <div class="row">
		        <div class="input-field">
		          <input id="password" type="password" name="webconfirmpassword" class="validate">
		          <label for="password">Mot de passe</label>
		        </div>
		    </div>
		    <div class="row">
		    	<button class="btn waves-effect waves-light #8bc34a light-green" type="submit" name="action">Valider
				</button>
		    </div>
		</form>
	</div>

	<div class="card-panel">
		<p><h5>Identifiants des équipements réseau</h5></p>
		<form  name="swlogin" action="settings.php" method="post">
			<div class="row">
		        <div class="input-field">
		          <input id="username" type="text" name="username" class="validate">
		          <label for="username">Identifiant</label>
		        </div>
		    </div>
		    <div class="row">
		        <div class="input-field">
		          <input id="password" type="password" name="swpassword" class="validate">
		          <label for="password">Mot de passe</label>
		        </div>
		    </div>
		    <div class="row">
		        <div class="input-field">
		          <input id="password" type="password" name="swconfirmpassword" class="validate">
		          <label for="password">Mot de passe</label>
		        </div>
		    </div>
		    <div class="row">
		        <div class="input-field">
		          <input id="password" type="password" name="swenablepassword" class="validate">
		          <label for="password">Mot de passe enable</label>
		        </div>
		    </div>
		    <div class="row">
		        <div class="input-field">
		          <input id="password" type="password" name="swconfirmenablepassword" class="validate">
		          <label for="password">Mot de passe enable</label>
		        </div>
		    </div>
		    <div class="row">
		    	<button class="btn waves-effect waves-light #8bc34a light-green" type="submit" name="action">Valider
				</button>
		    </div>
		</form>
	</div>

</div>


</div>
<?php
include("footer.php");
?>
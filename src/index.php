<?php
include("header.php");
require_once("manSwPort.php");
$manSwPort = manSwPort::getInstance();
$infos = $manSwPort->get_Configjson();
//$results = $manSwPort->status();


foreach($infos["site"] as $site) {
	echo '<div class="card-panel">';
	echo '  <div class="panel-heading">';
	echo '    <h3 class="panel-title">'.$site["nom"].'</h3>';
	echo '  </div>';
	echo '  <div class="panel-body">';
	foreach ($site["salles"] as $salle) {
		echo '<div class="card-panel">';
		echo '  <div class="">'.$salle["nom"].'</div>';
		echo '  <div class="panel-body">';
		echo '<table class="highlight responsive-table">';
		$i = 0;
		echo '<thead>';
		echo '<th></th><th>Nom</th><th>Couverture</th><th>SW</th><th>Port</th><th>Status</th>';
		echo '</thead>';
		foreach ($salle["hosts"] as $host) {
			foreach($host["devices"] as $device) {
				echo '<tr>';
				echo '<td><input name="checkbox" id="'.$host["ip"].'_'.$device["port"].'" type="checkbox"><label for="'.$host["ip"].'_'.$device["port"].'"</td>';
				echo '<td>'.$device["nom"].'</td>';
				echo '<td>'.$device["couverture"].'</td>';
				echo '<td>'.$host["ip"].'</td>';
				echo '<td>'.$device["port"].'</td>';
				if (isset($results)) {
					if ($results[$host["ip"]][$device["port"]] == 1) {
						echo '<td><i class="material-icons green-text" aria-hidden="true">arrow_upward</i></td>';
					}
					if ($results[$host["ip"]][$device["port"]] == 0) {
						echo '<td><i class="material-icons red-text" aria-hidden="true">arrow_downward</i></td>';
					}
				} else {
					echo '<td><i id="status_'.$i.'" ipport="'.$host["ip"].'-'.$device["port"].'" class="material-icons red-text" aria-hidden="true">help</i></td>';
				}
				$i++;
				echo '</tr>';
			}
		}
		echo '</table>';
		echo '  </div>';
		echo '</div>';
	}
	echo '  </div>';
	echo '</div>';
}

?>
	<a class="waves-effect waves-light btn-floating btn-large modal-trigger #8bc34a light-green"  onclick="getStatus();" href="#modal-refresh"><i class="material-icons" aria-hidden="true">refresh</i></a>
	<a class="waves-effect waves-light btn-floating btn-large modal-trigger #8bc34a light-green" onclick="changePortState('UP');" href="#modal-refresh"><i class="material-icons" aria-hidden="true">arrow_upward</i></a>
	<a class="waves-effect waves-light btn-floating btn-large modal-trigger #8bc34a light-green" onclick="changePortState('DOWN');" href="#modal-refresh"><i class="material-icons aria-hidden="true">arrow_downward</i></a>

	<div id="modal-refresh" class="modal">
		<div class="modal-content">
			<h5>Connexion aux équipements ... veuillez patienter ...</h5>
			<br>
			<div class="progress">
		    	<div class="indeterminate"></div>
		  	</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Annuler</a>
		</div>
	</div>

</div>
<?php
include("footer.php");
?>
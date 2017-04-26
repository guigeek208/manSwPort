<?php
require_once("manSwPort.php");
$manSwPort = manSwPort::getInstance();
if (isset($_GET) and $_GET["action"] == "UP") {
	if (isset($_POST) and isset($_POST["json"])) {
		//var_dump($_POST["json"]);
		$data = json_decode($_POST["json"]);
		//var_dump($data);
		$manSwPort->changePortState("UP", $data);
	}
}
if (isset($_GET) and $_GET["action"] == "DOWN") {
	if (isset($_POST) and isset($_POST["json"])) {
		//var_dump($_POST["json"]);
		$data = json_decode($_POST["json"]);
		//var_dump($data);
		$manSwPort->changePortState("DOWN", $data);
	}
}
if (isset($_GET) and $_GET["action"] == "STATUS") {
	$manSwPort->status();
}
?>
<?php
session_start();
if (session_destroy()) {
    header('Location: login.php');
} else {
    echo 'Erreur : erreur impossible de se déconnecter !';
}


?>
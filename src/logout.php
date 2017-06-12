<?php
session_start();
session_unset ();

if (session_destroy()) {
    header('Location: login.php');
} else {
    echo 'Erreur : erreur impossible de se déconnecter !';
}


?>
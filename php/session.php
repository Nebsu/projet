<?php   
    // Gestion de la session (les utlisateurs non inscrits ne peuvent pas accéder au site)
    session_start();
    if(!isset($_SESSION['user'])){
        header('Location: ../index.php');
        die();
    }
?>
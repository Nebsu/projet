<?php 
    //Deconnection de la base de donnée et redirection vers la page de connexion
    session_start();
    session_destroy();
    header('Location: ../index.php');
    die();
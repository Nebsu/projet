<?php 
    //Connexion à la base de donnée
    try 
    {
        $bdd = new PDO("mysql:host=localhost;dbname=netdrip;charset=utf8", "root", "");
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
?>
<?php
    session_start();
    require_once 'config.php';

    if(isset($_POST['email']) && isset($_POST['password']))
    {
        //Suppression des balises
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        //Récupération des données de la base
        $check = $bdd->prepare('SELECT * FROM users WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();

        //Vérification si l'utilisateur existe déjà
        if($row == 1)
        {
                //Vérification correspondance mot de passe/email
                if(password_verify($password, $data['password']))
                {
                    $_SESSION['user'] = $data['username'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['id'] = $data['id'];
                    header('Location: ../accueil.php');
                    //Alertes erreur identifiant
                }else{ header('Location: ../index.php?login_err=password');}
        }else{ header('Location: ../index.php?login_err=already');}
    }

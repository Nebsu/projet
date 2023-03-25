<!DOCTYPE html>
<html lang="fr">
 <head>
   <meta charset="utf-8">
   <link rel="stylesheet" href="css/indexs.css">
   <title> Connexion </title>
 </head>
 
    <body>
        <?php 
        //Messages d'erreur
                if(isset($_GET['login_err']))
                {
                    $err = htmlspecialchars($_GET['login_err']);

                    switch($err)
                    {
                        case 'password':
                        ?>
                            <div class="error">
                                <strong>Erreur : </strong> Mot de passe incorrect
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="error">
                                <strong>Erreur : </strong> Email invalide
                            </div>
                        <?php
                        break;

                        case 'already':
                        ?>
                            <div class="error">
                                <strong>Erreur : </strong> Compte inconnu
                            </div>
                        <?php
                        break;
                    }
                }
            ?> 
 
        <form action="php/loginsystem.php" method="post">
        <h1 style="color:white;"> Netdrip </h1>
            <div class="entry">
                <input type="email" name="email" placeholder="Email" autocomplete="off" required="required">
            </div>
            <div class="entry">
                <input type="password" name="password" placeholder="Mot de passe" autocomplete="off" required="required">
            </div>
            <div class="entry">
                <input class="myButton" type="submit" value="Se connecter">
            </div>
        </form>
        <div class="button_back"><a href="signup.php"> S'inscrire </a></div>
    </body>
</html>
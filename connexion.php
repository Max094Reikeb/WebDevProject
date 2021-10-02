<?php 
require("function.php");	 		
            if(isset($_SESSION['login'])) {
                header("Location: index.php");
                die();
            }

            //verification des données
            if(!empty($_POST)) {
                $mail = $_POST['mail'];
                $mdp = $_POST['mdp'];
               
                $bdd = connexionBDD();
                // on recherche si ce login est déjà utilisé par un autre membre
                $sql = 'SELECT count(*) FROM utilisateurs WHERE mail="'.$_POST['mail'].'" AND mdp="'.sha1($_POST['mdp']).'"'; //compte le nombre de utilisateur ayant l'adresse email et le mdp qui concorde
                $query = $bdd->prepare($sql);
                $query->execute();
                $Reponse = $query->fetchAll();
                $query->closeCursor();
                if($Reponse[0]['count(*)']==0) { //s'il y en a pas erreur
                    $erreur = 'Cette email et ce mot de passe ne correspondent pas';
                }
                else { //sibob on le connecte
                    $sql = 'SELECT * FROM utilisateurs WHERE mail="'.$_POST['mail'].'" AND mdp="'.sha1($_POST['mdp']).'"';
                    $query = $bdd->prepare($sql);
                    $query->execute();
                    $Reponse = $query->fetchAll();
                    $query->closeCursor();

                    $sql1 = 'SELECT * FROM typeutilisateurs WHERE id='.$Reponse[0]['idtypeUtilisateurs'];
                    $query1 = $bdd->prepare($sql1);
                    $query1->execute();
                    $Reponse1 = $query1->fetchAll();
                    $query1->closeCursor();


                    session_start(); //création des variables de session 
                    $_SESSION['login'] = $Reponse[0]['mail'];
                    $_SESSION['nom'] = $Reponse[0]['nom'];
                    $_SESSION['prenom'] = $Reponse[0]['prenom'];
                    $_SESSION['date_naissance'] = $Reponse[0]['age'];
                    $_SESSION['pseudo'] = $Reponse[0]['pseudo'];
                    $_SESSION['typeUtilisateurs'] = $Reponse1[0]['id'];
                    header('Location: index.php');
                    exit();
                }
                } 

           


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
  </head>
  <body>
<?php
include 'menu.php';
?>
<div class="container" style="margin-bottom: 120px;">
<form action="connexion.php" method="POST"> <!--formulaire pour rentrer les informations de connexion et les prendre grace au POST-->
    <div class="row justify-content-center">
    <h1 class="text-center title-top">Connexion </h1>
        <div class="col-6">
             
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Votre Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Votre Email" name="mail" required>
                </div>
                <div class="mb-5">
                    <label for="exampleInputPassword1" class="form-label">Mot De Passe</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="mdp" required>
                    <div id="" class="form-text text-danger"><?php if(isset($erreur)) {echo($erreur);} ?></div> <!--afficher l'erreur si elle existe-->
                </div>
                <button type="submit" class="btn btn-primary">Connexion</button>

        </div>
    </div>
    </form>
</div>

<?php include 'footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
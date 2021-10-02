<?php 
require("function.php");	 		
            if(isset($_SESSION['login'])) {
                header("Location: index.php");
                die();
            }
            else {
                //verification des données
                if(!empty($_POST)) {
                    $nom = $_POST['nom'];
                    $prenom = $_POST['prenom'];
                    $age = $_POST['age'];
                    $mail = $_POST['mail'];
                    $mdp = $_POST['mdp'];
                    $pseudo = $_POST['pseudo'];
                    if ($_POST['mdp'] != $_POST['mdpConfirm']) {
                        $erreur = 'Les 2 mots de passe sont différents.';
                    }
                    else {
                        $bdd = connexionBDD();
                        // on recherche si ce login est déjà utilisé par un autre membre
                        $sql = 'SELECT count(*) FROM utilisateurs WHERE mail="'.$_POST['mail'].'"';
                        $query = $bdd->prepare($sql);
                        $query->execute();
                        $Reponse = $query->fetchAll();
                        $query->closeCursor();
                        if($Reponse[0]['count(*)']!=0) {
                            $erreur = 'Cette email existe déjà';
                        }
                        else {

                            $sql = 'INSERT INTO utilisateurs (nom,prenom,age,mail,mdp,pseudo,idtypeUtilisateurs) VALUES ("'.$nom.'","'.$prenom.'",'.$age.',"'.$mail.'","'.sha1($mdp).'","'.$pseudo.'",2) ';
                            $query = $bdd->prepare($sql); //on l'ajoute à la base de donnée 
                            $query->execute();
                            $query->closeCursor();



                            session_start(); //création des variables de session (connexion)
                            $_SESSION['login'] = $_POST['mail'];
                            $_SESSION['nom'] = $_POST['nom'];
                            $_SESSION['prenom'] = $_POST['prenom'];
                            $_SESSION['date_naissance'] = $_POST['age'];
                            $_SESSION['pseudo'] = $_POST['pseudo'];
                            header('Location: index.php');
                            exit();
                        }
                    }
                } 
            }

           


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Inscription</title>
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
<form action="inscription.php" method="POST"> <!--formulaire bootstrap form pour récupérer les infos-->
    <div class="row justify-content-center">
    <h1 class="text-center title-top">Inscription </h1>
        <div class="col-6">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input placeholder="Votre nom" type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input placeholder="Votre prénom" type="text" class="form-control" id="prenom" name="prenom" required>
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input placeholder="Votre âge" type="number" class="form-control" id="age" min="13" max="110" name="age" required>
                </div>
                <div class="mb-3">
                    <label for="pseudo" class="form-label">Pseudo</label>
                    <input placeholder="Votre Pseudo" type="text" class="form-control" id="pseudo" name="pseudo" required>
                    <div id="emailHelp" class="form-text">Votre pseudo sera visible par tous</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Votre Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Votre Email" name="mail" required>
                    <div id="emailHelp" class="form-text">Nous ne partagerons jamais votre email</div>
                </div>
                <div class="mb-5">
                    <label for="exampleInputPassword1" class="form-label">Mot De Passe</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="mdp" required>
                </div>
                <div class="mb-5">
                    <label for="exampleInputPassword1" class="form-label">Confirmation De Mot De Passe</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="mdpConfirm" required>
                    <div id="" class="form-text text-danger"><?php if(isset($erreur)) {echo($erreur);} //si les deux mots de passes sont différents on affiche l'erreur ici ?></div>
                </div>
                <button type="submit" class="btn btn-primary">Inscription</button>

        </div>
    </div>
    </form>
</div>

<?php include 'footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
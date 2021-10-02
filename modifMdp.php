<?php 
            session_start();
            require("function.php");	 		
            if(!isset($_SESSION['login'])) {
                header("Location: index.php");
                die();
            }
            else {
                $bdd = connexionBDD();
                $sql = 'SELECT mdp,id FROM utilisateurs WHERE mail="'.$_SESSION['login'].'"'; //on récupère le mdp et l'id de l'utilisateur faisant la requete
                $query = $bdd->prepare($sql);
                $query->execute();
                $Reponse = $query->fetchAll();
                $query->closeCursor();
                if(!empty($_POST)) {
                    $mdp = sha1($_POST['mdp']); //on cripte le mdp rentré pour pouvoir le comparer à celui dans la bdd
                    $newMdp = $_POST['newMdp'];
                    $newMdpConfirm = $_POST['newMdpConfirm'];
                    if($mdp != $Reponse[0]['mdp']) { // on le compare 
                        $erreur1 = 'le mot de passe rentré est incorrect';
                    }
                    else {
                        if ($newMdp != $newMdpConfirm) { //on test que les deux nouveaux mdp sont identiques
                            $erreur = 'Les 2 mots de passe sont différents.';
                        }
                        else {
                            $sql2 = 'UPDATE utilisateurs SET mdp="'.sha1($newMdp).'" WHERE id='.$Reponse[0]['id'].''; //modification du mdp avec criptage évidemment par la fonction sha1()
                            $query2 = $bdd->prepare($sql2);
                            $query2->execute();
                            $query2->closeCursor();
                            $message = "Votre mot de passe a bien été modifié";
                        }
                    }
                }    
            }       
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Modification du mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
  </head>
  <body>
  <!-- symbole pour alert bootstrap -->
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>
<!-- ///////////////////////////////////////////////// -->
<?php if(isset($message)) { ?>
    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
  <div>
  <?php echo($message); ?>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
<?php
include 'menu.php';
?>
<div class="container" style="margin-bottom: 120px;">
<form action="modifMdp.php" method="POST">
    <div class="row justify-content-center">
    <h1 class="text-center title-top">Changer de mot de passe </h1>
        <div class="col-6">
                <div class="mb-3">
                    <label for="mdp" class="form-label">Ancien mot de passe</label>
                    <input placeholder="ancien mot de passe" type="password" class="form-control" id="mdp" name="mdp" required>
                    <div id="" class="form-text text-danger"><?php if(isset($erreur1)) {echo($erreur1);} //si l'ancien mot de passe n'est pas correct on affiche l'erreur ici ?></div>
                </div>
                <div class="mb-3">
                    <label for="newMdp" class="form-label">Nouveau mot de passe</label>
                    <input placeholder="nouveau mot de passe" type="password" class="form-control" id="mdp" name="newMdp" required>
                </div>
                <div class="mb-3">
                    <label for="newMdpConfirm" class="form-label">Confirmation nouveau mot de passe</label>
                    <input placeholder="confirmation du nouveau mot de passe" type="password" class="form-control" id="mdp" name="newMdpConfirm" required>
                    <div id="" class="form-text text-danger"><?php if(isset($erreur)) {echo($erreur);} //si le mdp de confirmation n'est pas le même que le mdp rentré : erreur ?></div>
                </div>
                <button type="submit" class="btn btn-primary" >Modifier mon mot de passe</button>
        </div>
    </div>
    </form>
</div>

<?php include 'footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
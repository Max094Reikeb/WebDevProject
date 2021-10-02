<?php 
            session_start(); 
            require("function.php");	 		
            if(!isset($_SESSION['login'])) {
                header("Location: index.php");
                die();
            }
            else {

                $bdd = connexionBDD();


                $sql = 'SELECT * FROM produit';
                $query = $bdd->prepare($sql);
                $query->execute();
                $Reponse = $query->fetchAll();
                $query->closeCursor();

                $end_tab = end($Reponse); //on récupère l'id présent dans le bouton (correspond au produit qu'on veut modif) si le post correspond à l'id on modifie le produit avec l'id correspondante
                for ($i=0; $i <= $end_tab['id']; $i++) { 
                    if(isset($_POST[$i])) {
                        $sql1 = 'SELECT * FROM produit WHERE id='.$i.'';
                        $query1 = $bdd->prepare($sql1);
                        $query1->execute();
                        $Reponse1 = $query1->fetchAll();
                        $query1->closeCursor();
                        
                    }
                }
            }


            
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Gestion boutique modification</title>
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
<form action="traitementModifBoutique.php" method="POST"> <!-- formulaire pour récupérer les info enregistrées-->
    <div class="row justify-content-center">
    <h1 class="text-center title-top">Modification de l'evenement</h1>
        <div class="col-6">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom du produit</label>
                    <input placeholder="Le nom" type="text" class="form-control" id="nom" name="nom" value="<?php echo($Reponse1[0]['nom']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="prix" class="form-label">Prix</label>
                    <input placeholder="Prix" type="text" class="form-control" id="prix" name="prix" value="<?php echo($Reponse1[0]['prix']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="lien_image" class="form-label">Lien de l'image</label>
                    <input placeholder="le lien de l'image" type="text" class="form-control" id="lien_image" name="lien_image" value="<?php echo($Reponse1[0]['lien_image']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Le stock</label>
                    <input placeholder="Stock" type="number" class="form-control" id="stock" name="stock" value="<?php echo($Reponse[0]['stock']) ?>" required>
                </div>
                <input style="display: none;" name="id" value="<?php echo($Reponse[0]['id']); ?>">
                <button type="submit" class="btn btn-primary">Modifier le produit</button>

        </div>
    </div>
    </form>
</div>
<?php include 'footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
<?php 
            session_start();
            require("function.php");	
	 		$servname = 'localhost';
            $dbname = 'projetinfo1';
            $user = 'root';
            $pass = '';
            $tamp = 0;
            if(!isset($_SESSION['login']) || $_SESSION['typeUtilisateurs']!=1) { // securité pour qu'un membre ne puisse pas se connecter
                header("Location: index.php");
                die();
            }
            try{
                $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
                $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                
            }
            
            catch(PDOException $e){
              echo "Erreur : " . $e->getMessage();
            }

            $sql = 'SELECT * FROM produit';
            $query = $dbco->prepare($sql);
            $query->execute();
            $Reponse = $query->fetchAll();
            $query->closeCursor();

            $end_tab = end($Reponse);
            
            if(!empty($_POST)) { // si on appuie sur un bouton suppr 
                var_dump($_POST);
                for ($i=0; $i <= $end_tab['id']; $i++) { // on cherche l'id correspondant au produit à suppr et on le fait
                    if(isset($_POST[$i])) {
                        $sql1 = 'DELETE FROM produit WHERE id='.$i.'';
                        $query1 = $dbco->prepare($sql1);
                        $query1->execute();
                        $query1->closeCursor();
                        header('Location: gestionBoutique.php');
                        die();
                    }
                }
            }
            ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Gestion de la boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
  </head>
  <body>
  <?php include 'menu.php'; ?>
<div class="container" style="margin-bottom: 150px;">
    <div class="row center">
        <h1 class="text-center title-top"> Gestion de la boutique</h1>
    </div>
    <div>
        
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Nom du produit</th>
                <th scope="col">Prix</th>
                <th scope="col">Stock</th>
                <th scope="col">Lien de l'image</th>
                <th colspan="2">Gérer</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                    for($i=0 ; $i <= $nbElement = count($Reponse) ; $i++) { //affichage en tableau (bootstrap) pour avoir le nb exact de produit 
                        if(isset($Reponse[$i])) { ?>
                            <tr>
                            <th scope="row"><?php echo($Reponse[$i]['nom']); ?></th>
                            <td><?php echo($Reponse[$i]['prix']); ?>€</td>
                            <td><?php echo($Reponse[$i]['stock']); ?></td>
                            <td><?php echo($Reponse[$i]['lien_image']); ?></td>
                           
                            <form action="gestionBoutiqueModif.php" method="post"><td><button type="submit"  name="<?php echo ($Reponse[$i]['id'])?>" class="btn btn-outline-primary">Modifier</button>
                            </td></form>
                            <form action="gestionBoutique.php" method="post"><td><button type="submit" name="<?php echo ($Reponse[$i]['id'])?>" class="btn btn-outline-danger">Supprimer</button></td></form>
                            </tr>
                        <?php }
                    }
                    ?>
            </tbody>
        </table>
        
    </div>
</div>
<?php include 'footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
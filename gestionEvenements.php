<?php 
            session_start(); //même fonctionnement que gestionBoutique.php
	 		      $servname = 'localhost';
            $dbname = 'projetinfo1';
            $user = 'root';
            $pass = '';
            $tamp = 0;

            try{
                $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
                $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                
            }
            
            catch(PDOException $e){
              echo "Erreur : " . $e->getMessage();
            }

            if(!isset($_SESSION['login']) || $_SESSION['typeUtilisateurs']!=1) {
                header("Location: index.php");
                die();
            }

            $sql = 'SELECT * FROM evenements';
            $query = $dbco->prepare($sql);
            $query->execute();
            $Reponse = $query->fetchAll();
            $query->closeCursor();

            $sql1 = 'SELECT id FROM produit';
            $query1 = $dbco->prepare($sql1);
            $query1->execute();
            $Reponse1 = $query1->fetchAll();
            $query1->closeCursor();

            $end_tab = end($Reponse);
            
            if(!empty($_POST)) {
                var_dump($_POST);
                for ($i=0; $i <= $end_tab['id']; $i++) { 
                    if(isset($_POST[$i])) {
                        $sql1 = 'DELETE FROM evenements WHERE id='.$i.'';
                        $query1 = $dbco->prepare($sql1);
                        $query1->execute();
                        $query1->closeCursor();
                        header('Location: gestionEvenements.php');
                        die();
                    }
                }
            }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Gestion des événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
  </head>
  <body>
<?php include 'menu.php'; ?>
<div class="container" style="margin-bottom: 150px;">
    <div class="row center">
        <h1 class="text-center title-top"> Gestion des événements </h1>
    </div>
    <div>
        
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Nom de l'événement</th>
                <th scope="col">lieu</th>
                <th scope="col">Prix</th>
                <th scope="col">Date de début</th>
                <th scope="col">Date de fin</th>
                <th scope="col">Date de fin des inscriptions</th>
                <th scope="col">Nombre de participants</th>
                <th scope="col">Places restantes</th>
                <th scope="col">Description</th>
                <th scope="col">Image de présantation (lien)</th>
                <th colspan="2">Gérer</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                    for($i=0 ; $i <= $nbElement = count($Reponse) ; $i++) {
                        if(isset($Reponse[$i])) { ?>
                            <tr>
                            <th scope="row"><?php echo($Reponse[$i]['nom']); ?></th>
                            <td><?php echo($Reponse[$i]['lieu']); ?></td>
                            <td><?php echo($Reponse[$i]['prix']); ?>€</td>
                            <td><?php echo($Reponse[$i]['dateDebut']); ?></td>
                            <td><?php echo($Reponse[$i]['dateFin']); ?></td>
                            <td><?php echo($Reponse[$i]['dateLimiteInscription']); ?></td>
                            <td><?php echo($Reponse[$i]['nombreParticipants']); ?></td>
                            <td><?php echo($Reponse[$i]['placesRestantes']); ?></td>
                            <td><?php echo($Reponse[$i]['description']); ?></td>
                            <td><?php echo($Reponse[$i]['lien_image']); ?></td>
                           
                            <form action="gestionEvenementsModif.php" method="post"><td><button type="submit"  name="<?php echo ($Reponse[$i]['id'])?>" class="btn btn-outline-primary">Modifier</button>
                            </td></form>
                            <form action="gestionEvenements.php" method="post"><td><button type="submit" name="<?php echo ($Reponse[$i]['id'])?>" class="btn btn-outline-danger">Supprimer</button></td></form>
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
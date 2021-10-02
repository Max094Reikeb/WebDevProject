<?php 
            session_start(); //inclut les variables de session
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

            if(!empty($_POST)) { //barre de recherche si on a une requete, on vérifie le type de requete (decroissant ou croissant) et on tri
              if($_POST['select_input']=='desc') {
                $sql =  'select * from produit order by prix desc';
              }
              else {
                if($_POST['select_input']=='croi') {
                  $sql =  'select * from produit order by prix asc';
                }
                else {
                  $sql =  'select * from produit';
                }
              }
            }
            else {
              $sql =  'select * from produit';
            }

            



?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/accueil.css"> <! -- design de la page (bootstrap)  -->
    <link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
  </head>
  <body>
<?php
include 'menu.php';
?>
<div class="container" style="margin-bottom: 150px;">
<form action="boutique.php" method="post">
<div class="row justify-content-center">
<h1 class="text-center title-top"> La boutique </h1>

  <select class="form-select" aria-label="Default select example" name="select_input" style="width: 300px">
          <option selected>Prix</option> <!--bootstrap barre de recherche-->
          <option value="desc">Décroissant</option>
          <option value="croi">Croissant</option>
      </select>
    <button type="submit" class="btn btn-success bg-success" style="margin-left:20px; width: 150px">Trier</button>
    
  </div>
  </form>
  <br>
    <div class="row justify-content-center">
        
        <?php  
				foreach  ($dbco->query($sql) as $row) { //boucle pour afficher exactement le nombre de produit présents dans la bdd?>
        
        <div class="col" style="margin-left: 60px" id="<?php echo($row['nom']) ?>">
            <form action="produit.php" method="post" name="<?php echo($row['id']) //aller dans produit.php avec le bon produit via l'id?>">
                <div class="card" style="width: 18rem;">
                    <img src="<?php echo($row['lien_image']) //affichage de l'image ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo($row['nom']) //affichage du nom du produit ?></h5>
                        <p class="card-text"><?php echo($row['prix']) //affichage du prix (en euro) ?>€</p>
                        <p class="card-text">Stock : <?php echo($row['stock']) //affichage du stock?></p>
                        <button type="submit" class="btn btn-primary" name="<?php echo($row['id']) ?>" id="<?php echo($row['id']) //on met des valeur dans le bouton pour pouvoir acheter le produit (en fonction du bouton ou l'on a cliqué)?>">Acheter</button>
                    </div>
                </div>
            </form>
        </div>
        
        <?php } ?>
    </div>
</div>

<?php include 'footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
<?php 
            session_start();
            require("function.php");
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
            $sql1  = 'SELECT DISTINCT lieu FROM evenements'; //on selectionne distinctement les lieus pour le moteur de recherche
            $query1 = $dbco->prepare($sql1);
            $query1->execute();
            $Reponse1 = $query1->fetchAll();
            $query1->closeCursor();


            if(!empty($_POST)) { // moteur de recherche 
                $sql = 'SELECT * FROM evenements ';
                $cpt = 0; //sert à faire les requetes sql correctement (where)
                $compteurDesc = 0;
                $compteurAsc = 0;
                $compteurOrder = 0;
                if($_POST['lieu']!='base') { // si le lieu est différent que ca valeur de base (i.e que l'user a selectionner qq chose) on incremente le compteur si celui-ci est nul et on fais la requete de tri
                    if($cpt==0) {
                        $sql = $sql.'WHERE ';
                        $cpt = $cpt+1;
                    }
                    $sql = $sql.'lieu="'.$_POST['lieu'].'" ';
                }
                

                if(!empty($_POST['description'])) {
                    if($cpt==0) {
                        $sql = $sql.'WHERE ';
                        $cpt = $cpt+1;
                        $sql = $sql.'description LIKE "%'.$_POST['description'].'%"'; //pour la bonne requete encore
                    }
                    else {
                        $sql = $sql.'AND description LIKE "%'.$_POST['description'].'%" '; //si le lieu est selectionner on fait une requete correcte
                    }
                    
                }
                

                if($_POST['nbparti']!='base') { //si sélection
                   
                    if($_POST['nbparti']=='desc') { // tri décroissant
                        $sql = $sql.' order by nombreParticipants';
                        $compteurDesc = $compteurDesc+1; //on compte car on ne peut pas faire un tri decroissant et un croissant si les chiffres de concorde pas et surtout pour faire des requetes sql plus tard
                        $compteurOrder = $compteurOrder+1;
                    }
                    else {
                        $sql = $sql.' order by nombreParticipants';
                        $compteurAsc = $compteurAsc+1;
                        $compteurOrder = $compteurOrder+1;
                    }
                }

                if($_POST['date_tri']!='base') {
                
                    if($_POST['date_tri']=='recent') {
                        if($compteurOrder!=0) {
                            $sql = $sql.',dateDebut'; //comme ici avec la virgule
                            $compteurDesc = $compteurDesc+1;
                        }
                        else {
                            $sql = $sql.' order by dateDebut'; //comme il n'y a pas eu de requete precedemment on met l'ordre 
                            $compteurDesc = $compteurDesc+1;
                            $compteurOrder = $compteurOrder+1;
                        }
                        
                    }
                    else {
                        if($compteurOrder!=0) {
                            $sql = $sql.',dateDebut';
                            $compteurAsc = $compteurAsc+1;
                        }
                        else {
                            $sql = $sql.' order by dateDebut';
                            $compteurAsc = $compteurAsc+1;
                            $compteurOrder = $compteurOrder+1;
                        }
                    }
                }

                if($_POST['prix']!='base') { //même fonctionnement
                   
                    if($_POST['prix']=='desc') {
                        if($compteurOrder!=0) {
                            $sql = $sql.',prix';
                            $compteurDesc = $compteurDesc+1;
                        }
                        else {
                            $sql = $sql.' order by prix';
                            $compteurDesc = $compteurDesc+1;
                            $compteurOrder = $compteurOrder+1;
                        }
                        
                    }
                    else {
                        if($compteurOrder!=0) {
                            $sql = $sql.',prix';
                            $compteurAsc = $compteurAsc+1;
                        }
                        else {
                            $sql = $sql.' order by prix';
                            $compteurAsc = $compteurAsc+1;
                            $compteurOrder = $compteurOrder+1;
                        }
                    }
                }

                if($_POST['placedispo']!='base') {
                   
                    if($_POST['placedispo']=='desc') {
                        if($compteurOrder!=0) {
                            $sql = $sql.',placesRestantes';
                            $compteurDesc = $compteurDesc+1;
                        }
                        else {
                            $sql = $sql.' order by placesRestantes';
                            $compteurDesc = $compteurDesc+1;
                            $compteurOrder = $compteurOrder+1;
                        }
                        
                    }
                    else {
                        if($compteurOrder!=0) {
                            $sql = $sql.',placesRestantes';
                            $compteurAsc = $compteurAsc+1;
                        }
                        else {
                            $sql = $sql.' order by placesRestantes';
                            $compteurAsc = $compteurAsc+1;
                            $compteurOrder = $compteurOrder+1;
                        }
                    }
                }

                if($compteurAsc>0) { //l'ordre croissant sera prioritaire
                    $sql=$sql.' ASC';
                }
                else {
                    if($compteurDesc>0) {
                        $sql=$sql.' DESC';
                    }
                }



                    
                
            }
            else {
                $sql =  'select * from evenements';
            }
  

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Evénements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
  </head>
  <body>
<?php
include 'menu.php';
?>
<div class="container" style="margin-bottom: 150px;">
<form action="evenements.php" method="post"> <!-- affichage bootstrap d'une barre de recherche avec des options-->
<div class="row justify-content-center">
<h1 class="text-center title-top"> Nos événements </h1>

    <select class="form-select" aria-label="Default select example" name="lieu" style="width: 150px; margin-left:20px;">
        <option selected value="base">Lieu</option>
        <?php for ($i=0; $i < count($Reponse1); $i++) { 
            ?> <option value="<?php echo($Reponse1[$i]['lieu']) ?>"> <?php echo($Reponse1[$i]['lieu']) ?> </option> <?php 
        } ?>
    </select>
    <select class="form-select" aria-label="Default select example" name="nbparti" style="width: 250px; margin-left:20px;">
        <option selected value="base">Nombre de participant</option>
        <option value="desc">Décroissant</option>
        <option value="croi">Croissant</option>
    </select>
    <select class="form-select" aria-label="Default select example" name="date_tri" style="width: 150px; margin-left:20px;">
        <option selected value="base">Date</option>
        <option value="recent">Plus récent</option>
        <option value="vieux">Plus vieux</option>
    </select>
</div>
<div class="row justify-content-center mt-3">
    <select class="form-select" aria-label="Default select example" name="prix" style="width: 150px; margin-left:20px;">
        <option selected value="base">Prix</option>
        <option value="desc">Décroissant</option>
        <option value="croi">Croissant</option>
    </select>
    <select class="form-select" aria-label="Default select example" name="placedispo" style="width: 200px; margin-left:20px;">
        <option selected value="base">Place disponible</option>
        <option value="desc">Décroissant</option>
        <option value="croi">Croissant</option>
    </select>
        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Chercher un mot clé dans la description" style="width: 350px; margin-left:20px;" name="description">
    <button type="submit" class="btn btn-success bg-success" style="margin-left:20px; width: 150px">Trier</button>
    
  </div>
  </form>
  <br><br>
    <div class="row justify-content-center">
        
        <?php // on affiche les événements et on met en place un bouton pour s'inscrire encore avec une boucle for pour afficher le nombre d'événements exact
		foreach  ($dbco->query($sql) as $row) { ?>
        
        <div class="col" style="margin-left: 60px" id="<?php echo($row['nom']) ?>">
            <form action="pageEvenements.php" method="post" name="<?php echo($row['id']) ?>">
                <div class="card" style="width: 18rem;">
                    <img src="<?php echo($row['lien_image']) ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo($row['nom']) ?></h5>
                        <p class="card-text">Description : <?php echo($row['description']) ?></p>
                        <p class="card-text">Lieu : <?php echo($row['lieu']) ?></p>
                        <p class="card-text">Nombre de participants : <?php echo($row['nombreParticipants']) ?></p>
                        <p class="card-text">Début de l'événement : <?php echo($row['dateDebut']) ?></p>
                        <p class="card-text">Fin de l'événement : <?php echo($row['dateFin']) ?></p>
                        <p class="card-text"><?php echo($row['prix']) ?>€ la place</p>
                        <p class="card-text">Vous pouvez vous inscrire jusqu'au : <?php echo($row['dateLimiteInscription']) ?></p>
                        <p class="card-text">Places restantes : <?php echo($row['placesRestantes']) ?></p>
                        <button type="submit" class="btn btn-primary" name="<?php echo($row['id']) ?>" id="<?php echo($row['id']) ?>">S'inscrire</button>
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
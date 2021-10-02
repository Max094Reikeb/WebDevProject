<?php 
function connexionBDD() { //connexion à la bdd 
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
    return $dbco;
}
?>
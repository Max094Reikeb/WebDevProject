<?php
session_start();
session_unset(); // on supprime les variables de session
session_destroy();
header('Location: index.php');
exit();
?>
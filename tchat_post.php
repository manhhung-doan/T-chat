<?php
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=manhhungdb;charset=utf8', 'manhhung', '123456789');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

// Insertion du message à l'aide d'une requête préparée
$req = $bdd->prepare('INSERT INTO tchat (nom, mess) VALUES(?, ?)');
$req->execute(array($_POST['name'], $_POST['usermsg']));

// Redirection du visiteur vers la page du tchat
header('Location: index.php');
?>
<?php
try{
	//$pdo = new PDO ('mysql:host=185.98.131.176;dbname=probi2118503;charset=UTF8', 'probi2118503', 'wnupbt3f7s');
	$db_host = new PDO ('mysql:host=localhost;dbname=midevsoft;charset=utf8', 'root', '');
}
catch(Exception $e)
{
	//die('Erreur : ' .$e->getMessage());
}
?>
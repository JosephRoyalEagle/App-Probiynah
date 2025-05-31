<?php
try{
	//$pdo = new PDO ('mysql:host=localhost;dbname=cp2118503p21_appro;charset=UTF8', 'cp2118503p21_irmael', 'Wz8Eprj$V(o%');
	$db_host = new PDO ('mysql:host=localhost;dbname=approdb;charset=utf8', 'root', '');
}
catch(Exception $e)
{
	//die('Erreur : ' .$e->getMessage());
}
?>
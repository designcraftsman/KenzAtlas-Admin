<?php
try
{
	$db = new PDO('mysql:host=localhost;dbname=kenzatlas;charset=utf8', 'mariam.fayz', 'kenzatlas2024');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
?>
<?php
session_start(); 
if(!isset($_SESSION['emailAdmin'])){
    header("Location: error.php");
    exit();
}
    if(isset($_GET['idArticle'])){
        $idArticle = $_GET['idArticle'];
        include('connection.php');
        $delete = $db->prepare('DELETE FROM articles WHERE idArticle = :idArticle');
        $delete->bindParam(':idArticle', $idArticle, PDO::PARAM_STR);
        $delete->execute();
        header("Location: article.php");
    }else{
        echo('erreur');
    }
?>
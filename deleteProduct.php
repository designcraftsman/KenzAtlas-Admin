<?php
    if(isset($_GET['idProduit'])){
        $idProduit = $_GET['idProduit'];
        include('connection.php');
        $delete = $db->prepare('DELETE FROM produitsCommandés WHERE idProduit = :idProduit');
        $delete->bindParam(':idProduit', $idProduit, PDO::PARAM_STR);
        $delete->execute();
        include('connection.php');
        $delete = $db->prepare('DELETE FROM produit WHERE idProduit = :idProduit');
        $delete->bindParam(':idProduit', $idProduit, PDO::PARAM_STR);
        $delete->execute();
        header("Location: product.php");
    }else{
        echo('erreur');
    }
?>
<?php
    if(isset($_GET['numeroCommande'])){
        $numeroCommande = $_GET['numeroCommande'];
        include('connection.php');
        $sqlQuery = "SELECT * FROM commandes WHERE numeroCommande = :numeroCommande ;";
        $commandeStatement = $db->prepare($sqlQuery);
        $commandeStatement->bindParam(':numeroCommande', $numeroCommande, PDO::PARAM_STR);
        $commandeStatement->execute();
        $commande = $commandeStatement->fetch(PDO::FETCH_ASSOC);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande - <?php echo($commande['prenomClient'].' '.$commande['nomClient']); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<?php include('sideBar.php'); ?>
    <div class="main--content">
    <?php include('head.php'); ?>
    <div class="container p-4">
        <h2>Détail de Commande:</h2>
        <hr class="border-primary border-5">
        <p class="fs-5 fw-lighter"><span class="fw-bold m-3">Numero Commande:</span> <?php echo($commande['numeroCommande']); ?></p>
        <hr>
        <p class="fs-5 fw-lighter"><span class="fw-bold m-3">Date :</span> <?php echo($commande['dateCommande']); ?></p>
        <hr>
        <p class="fs-5 fw-lighter"><span class="fw-bold m-3">Nom Client :</span> <?php echo($commande['nomClient']); ?></p>
        <hr>
        <p class="fs-5 fw-lighter"><span class="fw-bold m-3">Prenom Client :</span> <?php echo($commande['prenomClient']); ?></p>
        <hr>
        <p class="fs-5 fw-lighter"><span class="fw-bold m-3">Adresse :</span> <?php echo($commande['adresseClient']); ?></p>
        <hr>
        <p class="fs-5 fw-lighter"><span class="fw-bold m-3">Ville :</span> <?php echo($commande['villeClient']); ?></p>
        <hr>
        <p class="fs-5 fw-lighter"><span class="fw-bold m-3">Code Postal :</span> <?php echo($commande['codePostalClient']); ?></p>
        <hr>
        <p class="fs-5 fw-lighter"><span class="fw-bold m-3">Telephone :</span> <?php echo($commande['telephoneClient']); ?></p>
        <hr>
        <p class="fs-5 fw-lighter"><span class="fw-bold m-3">Note :</span> <?php echo($commande['noteCommandeClient']); ?></p>
        <hr>
        <p class="fs-5 fw-lighter"><span class="fw-bold m-3">Produit(s) commandé(s):</span> 
        <?php 
                                    include('connection.php');
                                    $id = $commande['idUtulisateur'];
                                    $sqlQuery = "SELECT idProduit FROM produitsCommandés WHERE numeroCommande = :numeroCommande;";
                                    $produitsIdStatement = $db->prepare($sqlQuery);
                                    $produitsIdStatement->bindParam(':numeroCommande', $commande['numeroCommande'], PDO::PARAM_STR);
                                    $produitsIdStatement->execute();
                                    $produitsId = $produitsIdStatement->fetchAll(PDO::FETCH_ASSOC);
                                    $prixTotal = 0;
                                    foreach($produitsId as $id){
                                        $sqlQuery = "SELECT nomProduit, prixProduit FROM produit WHERE idProduit = :id;";
                                        $produitStatement = $db->prepare($sqlQuery);
                                        $produitStatement->bindParam(':id', $id['idProduit'], PDO::PARAM_STR);
                                        $produitStatement->execute();
                                        $produit = $produitStatement->fetch(PDO::FETCH_ASSOC);
                                        $prixTotal += $produit['prixProduit'];
                                        echo($produit['nomProduit'].' ');
                                    }
                                ?>
        </p>
    </div>
</div>
</body>
</html>
<?php 
    include('connection.php');
    $sqlQuery = "SELECT * FROM commandes  ORDER BY `commandes`.`numeroCommande` DESC ;";
    $commandesStatement = $db->prepare($sqlQuery);
    $commandesStatement->execute();
    $commandes = $commandesStatement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/custom.css">
    <title>KenzAtlas - Commandes</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <?php include('sideBar.php'); ?>
    
    <div class="main--content d-block ">
      <div class="header--wrapper">
        <div class="header--title">
        </div>
       <div class="user--info">
        
         <img src="image/WhatsApp Image 2024-01-04 at 18.29.28.jpeg" alt="">
       </div> 
      </div>
      <div class="container-fluid    mt-2">
         <h1 class="fs-4 text-dark fw-bold">Tous les commandes</h1>
        <div class="container-fluid  p-2 rounded    ">
        <div class="row mt-1 border-top border-dark p-2">
                <div class="col-2 ">
                    <p class="fs-6 fw-bold">Numero Commande</p>
                </div>
                <div class="col-2 ">
                    <p class="fs-6 fw-bold">Client</p>
                </div>
               <div class="col-2">
                    <p class="fs-6 fw-bold">Produit(s)</p>
               </div>
                <div class="col-2  fs-6">
                    <p class="fs-6 fw-bold">Telephone</p>
                </div>
                <div class="col-2 ">
                    <p class="fs-6 fw-bold">Date</p>
                </div>
                <div class="col-2"></div>
                
            </div>
            <?php foreach($commandes as $commande){?>
            <div class="row border-top border-dark p-2 d-flex align-items-center ">
                <div class="col-2  ">
                    <p class="fs-6 "><?php echo($commande['numeroCommande']); ?></p>
                </div>
                <div class="col-2 ">
                    <p class="fs-6 "><?php echo($commande['prenomClient'].' '.$commande['nomClient']); ?></p>
                </div>
                <div class="col-2">
                    <p class="fs-6">
                    <div class="col-2">
                <p class="fs-6">
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
                                        echo($produit['nomProduit'].'<br>');
                                    }
                ?>
                </p>
                </div>
                    </p>
                </div>
                <div class="col-2 fs-6">
                    <p class="fs-6 "><?php echo($commande['telephoneClient']); ?></p>
                </div>
                <div class="col-2">
                    <p class="fs-6 "><?php echo($commande['dateCommande']); ?></p>
                </div>
                <div class="col-2">
                <a href="" class="btn btn-primary  text-secondary "><i class="fa-solid fa-circle-info m-1"></i> Détails</a>
                </div>
            </div>
            <?php } ?>
        </div>
      </div>
    </div>
    

    
</body>
</html>
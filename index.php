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
    <title>KenzAtlas - Admin</title>
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php include('sideBar.php'); ?>


    <div class="main--content">
      <div class="header--wrapper">
        <div class="header--title">
        </div>
       <div class="user--info">
        <div class="searh--box">
        <i class="fa-solid fa-search"></i>
        <input type="text" placeholder="Search">
         </div>
         <img src="image/WhatsApp Image 2024-01-04 at 18.29.28.jpeg" alt="">
       </div> 
      </div>
      <div class="card--container">
        <div class="card--wrapper">
            <div class="payment--card">
                <div class="card--header">
                    <div class="amount">
                        <i class="fa-solid fa-list icon"></i>
                        <span class="title">
                            Cette semaine
                        </span>
                        <span class="amount-value">
                        <?php
                            include('connection.php');
                            $sqlQuery = "SELECT *
                            FROM commandes
                            WHERE dateCommande >= CURRENT_DATE
                            AND dateCommande <= DATE_ADD(CURRENT_DATE, INTERVAL 7 DAY);";
                            $commandesStatement = $db->prepare($sqlQuery);
                            $commandesStatement->execute();
                            $commandesSemaine = $commandesStatement->fetchAll(PDO::FETCH_ASSOC);    
                            echo(count($commandesSemaine));
                        ?>  
                            commandes
                        </span>
                    </div>
                </div>
            </div>

            <div class="payment--card">
                <div class="card--header">
                    <div class="amount">
                        <i class="fa-solid fa-calendar-days icon"></i>
                        <span class="title">
                            Ce mois  
                        </span>
                        <span class="amount-value">
                        <?php
                            include('connection.php');
                            $sqlQuery = "SELECT *
                            FROM commandes
                            WHERE dateCommande >= CURRENT_DATE
                            AND dateCommande <= DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY);";
                            $commandesStatement = $db->prepare($sqlQuery);
                            $commandesStatement->execute();
                            $commandesMois = $commandesStatement->fetchAll(PDO::FETCH_ASSOC);    
                            echo(count($commandesMois));
                        ?>  
                            commandes
                        </span>
                    </div>
                </div>
            </div>


            <div class="payment--card">
                <div class="card--header">
                    <div class="amount">
                        <i class="fa-solid fa-cart-shopping icon"></i>
                        <span class="title">
                            Commandes confirmée
                        </span>
                        <span class="amount-value">
                        <?php
                            include('connection.php');
                            $sqlQuery = "SELECT *
                            FROM commandes
                            WHERE statutCommande='confirmé'";
                            $commandesStatement = $db->prepare($sqlQuery);
                            $commandesStatement->execute();
                            $commandesConfirme = $commandesStatement->fetchAll(PDO::FETCH_ASSOC);    
                            echo(count($commandesConfirme));
                        ?>  
                        commandes
                        </span>
                    </div>
                </div>
            </div>


            <div class="payment--card">
                <div class="card--header">
                    <div class="amount">
                        <i class="fa-solid fa-xmark icon" ></i>
                        <span class="title">
                            Commandes non confirmée
                        </span>
                        <span class="amount-value">
                        <?php
                            include('connection.php');
                            $sqlQuery = "SELECT *
                            FROM commandes
                            WHERE statutCommande='non confirmé'";
                            $commandesStatement = $db->prepare($sqlQuery);
                            $commandesStatement->execute();
                            $commandesNonConfirme = $commandesStatement->fetchAll(PDO::FETCH_ASSOC);    
                            echo(count($commandesNonConfirme));
                        ?> 
                        commandes
                        </span>
                    </div>
                </div>
            </div>

        </div>
      </div>

      <div class="tabular--wrapper">
        <h3 class="main-title">Dernières Commandes</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr class="table-border">
                        <th>Numéro Commande</th>
                        <th>Date </th>
                        <th>Nom du Client</th>
                        <th>Produit commandés</th>
                        <th>Prix Total</th>
                        <th>état de la commande</th>
                    </tr>
                    <tbody>
                    <?php foreach($commandes as $commande){ ?>
                        <tr class="  align-items-center" >
                            <th scope="row "><?php echo($commande['numeroCommande']); ?></th>
                            <td><?php echo($commande['dateCommande']); ?></td>
                            <td><?php echo($commande['prenomClient'].' '.$commande['nomClient']); ?></td>
                            <td>
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
                            </td>
                            <td><?php echo($prixTotal); ?> dh</td>
                            <td><?php echo($commande['statutCommande']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </thead>
            </table>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
<?php 
    include('connection.php');
    $sqlQuery = "SELECT * FROM produit  ORDER BY `produit`.`idProduit` DESC ;";
    $produitsStatement = $db->prepare($sqlQuery);
    $produitsStatement->execute();
    $produits = $produitsStatement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/custom.css">
    <title>KenzAtlas - Produits</title>
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
        <div class="d-flex justify-content-between rounded align-items-center  ">
            <h1 class="fs-4 text-dark fw-bold">Tous les produits</h1>
            <a href="newProduct.php" class="btn btn-lg btn-dark text-secondary  fw-light "><i class="fa-solid fa-plus m-1"></i> Ajouter un produit</a>
        </div>
        <div class="container-fluid  p-2 rounded    ">
            <?php foreach($produits as $produit){?>
            <div class="row mt-2 border-top border-dark p-3">
                <div class="col-2 m-auto ">
                    <img src="<?php echo($produit['imageProduit1']); ?>" class="w-50 rounded">
                </div>
                <div class="col-2 m-auto">
                    <h2 class="fs-6"><?php echo($produit['nomProduit']); ?></h2>
                </div>
                <div class="col-2 m-auto fs-6">
                    <?php echo($produit['prixProduit']); ?>
                    dh
                </div>
                <div class="col-2 m-auto">
                    <a href="" class="btn btn-primary text-secondary "><i class="fa-solid fa-pen m-1"></i> Modifier</a>
                </div>
                <div class="col-2 m-auto">
                <a href="" class="btn btn-danger "><i class="fa-solid fa-trash m-1"></i> Supprimer</a>
                </div>
            </div>
            <?php } ?>
        </div>
      </div>
    </div>
    

    
</body>
</html>
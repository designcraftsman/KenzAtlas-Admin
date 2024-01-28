<?php 
session_start(); 
if(!isset($_SESSION['emailAdmin'])){
    header("Location: error.php");
    exit();
}
    include('connection.php');
    $sqlQuery = "SELECT * FROM utulisateur  ORDER BY `utulisateur`.`idUtulisateur` DESC ;";
    $utulisateursStatement = $db->prepare($sqlQuery);
    $utulisateursStatement->execute();
    $utulisateurs = $utulisateursStatement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/custom.css">
    <title>KenzAtlas - Utulisateurs</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <?php include('sideBar.php'); ?>
    
    <div class="main--content d-block ">
      <?php include('head.php'); ?>
      <div class="container-fluid    mt-2">
         <h1 class="fs-4 text-dark fw-bold">Tous les utulisateurs</h1>
        <div class="container-fluid  p-2 rounded    ">
        <div class="row mt-1 border-top border-dark p-2">
                <div class="col-2 ">
                    <p class="fs-6 fw-bold">Nom complet</p>
                </div>
                <div class="col-2 ">
                    <p class="fs-6 fw-bold">Email</p>
                </div>
               <div class="col-2">
                    <p class="fs-6 fw-bold">Date de naissance</p>
               </div>
                <div class="col-2">
                    <p class="fw-bold fs-6">Telephone</p>
                </div>
                <div class="col-2 ">
                    <p class="fw-bold fs-6">Nombre de commandes</p>
                </div>
                <div class="col-2"></div>
                
            </div>
            <?php foreach($utulisateurs as $utulisateur){?>
            <div class="row border-top border-dark p-2 d-flex align-items-center ">
                <div class="col-2  ">
                    <p class="fs-6 "><?php echo($utulisateur['prenomUtulisateur'].' '.$utulisateur['nomUtulisateur']); ?></p>
                </div>
                <div class="col-2 ">
                    <p class="fs-6 "><?php echo($utulisateur['emailUtulisateur']); ?></p>
                </div>
                <div class="col-2">
                    <p class="fs-6">
                        <?php echo($utulisateur['dateNaissanceUtulisateur']); ?>
                    </p>
                </div>
                <div class="col-2 fs-6">
                    <p class="fs-6">
                        <?php echo($utulisateur['telephoneUtulisateur']); ?>
                    </p>
                </div>
                <div class="col-2">
                <?php 
                        $id = $utulisateur['idUtulisateur'];
                        include('connection.php');
                        $sqlQuery = "SELECT * FROM commandes WHERE idUtulisateur = :id ;";
                        $commandesStatement = $db->prepare($sqlQuery);
                        $commandesStatement->bindParam(':id', $id, PDO::PARAM_STR);
                        $commandesStatement->execute();
                        $commandes = $commandesStatement->fetchAll(PDO::FETCH_ASSOC);
                        echo(count($commandes));
                    ?>
                </div>
                <div class="col-2">
              
                </div>
            </div>
            <?php } ?>
        </div>
      </div>
    </div>
    

    
</body>
</html>
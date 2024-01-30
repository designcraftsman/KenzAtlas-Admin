<?php 
session_start(); 
if(!isset($_SESSION['emailAdmin'])){
    header("Location: error.php");
    exit();
}
    include('connection.php');
    $sqlQuery = "SELECT * FROM messages  ORDER BY `messages`.`idMessage` DESC ;";
    $messagesStatement = $db->prepare($sqlQuery);
    $messagesStatement->execute();
    $messages = $messagesStatement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/custom.css">
    <title>KenzAtlas - Messages</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <?php include('sideBar.php'); ?>
    
    <div class="main--content d-block ">
    <?php include('head.php'); ?>
      <div class="container-fluid    mt-2">
         <h1 class="fs-4 text-dark fw-bold">Tous les messages</h1>
        <div class="container-fluid  p-2 rounded    ">
        <div class="row mt-1 border-top border-dark p-2">
                <div class="col-2 ">
                    <p class="fs-6 fw-bold"> Émetteur</p>
                </div>
                <div class="col-2 ">
                    <p class="fs-6 fw-bold">Email</p>
                </div>
               <div class="col-5">
                    <p class="fs-6 fw-bold">Message</p>
               </div>
                <div class="col-3  fs-6">
                    <p class="fs-6 fw-bold">Date</p>
                </div>
                
            </div>
            <?php foreach($messages as $message){?>
            <div class="row border-top border-dark p-2 d-flex align-items-center ">
                <div class="col-2 ">
                    <p class="fs-6 "><?php echo($message['nomCompletUtulisateur']) ?></p>
                </div>
                <div class="col-2 ">
                    <p class="fs-6 "><?php echo($message['emailUtulisateur'])?></p>
                </div>
               <div class="col-5">
                    <p class="fs-6 "><?php echo($message['messageUtulisateur']) ?></p>
               </div>
                <div class="col-3 ">
                    <p class="fs-6"><?php echo($message['dateMessage']) ?></p>
                </div>
                <?php } ?>
            </div>
        </div>
      </div>
    </div>
    

    
</body>
</html>
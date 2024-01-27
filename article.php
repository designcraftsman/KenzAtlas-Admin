<?php 
    include('connection.php');
    $sqlQuery = "SELECT * FROM articles  ORDER BY `articles`.`idArticle` DESC ;";
    $articlesStatement = $db->prepare($sqlQuery);
    $articlesStatement->execute();
    $articles = $articlesStatement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/custom.css">
    <title>KenzAtlas - Articles</title>
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
            <h1 class="fs-4 text-dark fw-bold">Tous les articles</h1>
            <a href="addArticle.php" class="btn btn-lg btn-dark text-secondary  fw-light "><i class="fa-solid fa-plus m-1"></i> Ajouter un article</a>
        </div>
        <div class="container-fluid  p-2 rounded    ">
        <div class="row mt-2 border-top border-dark p-3">
                <div class="col-2 m-auto ">
                <h2 class="fs-6 fw-bold">Image</h2>
                </div>
                <div class="col-2 m-auto">
                    <h2 class="fs-6 fw-bold">Titre</h2>
                </div>
                <div class="col-2 m-auto fs-6">
                    <h2 class="fs-6 fw-bold">Titre</h2>
                </div>
                <div class="col-2 m-auto">
                    
                </div>
                <div class="col-2 m-auto">
                
                </div>
            </div>
            <?php foreach($articles as $article){?>
            <div class="row mt-2 border-top border-dark p-3">
                <div class="col-2 m-auto ">
                    <img src="<?php echo($article['imgArticle']); ?>" class="w-25 rounded">
                </div>
                <div class="col-2 m-auto">
                    <h2 class="fs-6"><?php echo($article['titreArticle']); ?></h2>
                </div>
                <div class="col-2 m-auto fs-6">
                    <?php echo($article['vueArticle']); ?>
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
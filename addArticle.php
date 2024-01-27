
<?php require_once('connection.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KenzAtlas-Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="bg-dark text-white">
    <div class="container">
        <div class="row p-5">
        <form method="Post" enctype="multipart/form-data">
                <h1 class="text-center fw-bolder">Ajouter un article</h1>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Ajouter un titre </label>
                    <input type="text" class="form-control" name="titreArticle" placeholder="Ajouter un titre">
                </div> 
                <div class="mb-3">
                    <label for="formFile" class="form-label">Ajouter une image</label>
                    <input class="form-control" type="file" name="imgArticle">
                </div>
                <select class="form-select" name="categorieArticle" aria-label="Default select example">
                    <option value="beauté">Beauté</option>
                    <option value="corps">corps</option>
                    <option value="cheveux">cheveux</option>
                    <option value="conseils">conseils</option>
                </select>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Ajouter un texte :</label>
                    <textarea class="form-control" name="contenuArticle" rows="10"></textarea>
                </div> 
                <button type="submit" class="btn btn-danger w-100 fs-5 fw-bolder p-3">Ajouter Article</button>
        </form>
        <?php
           if (!isset($_POST['titreArticle']) || !isset($_POST['contenuArticle']) || !isset($_POST['categorieArticle']) || !isset($_FILES['imgArticle']) && $_FILES['imgArticle']['error'] == 0) 
           {
               echo('Erreur D\'envoie !');
               return;
           }
           $titreArticle = $_POST['titreArticle'];	
           $contenuArticle = $_POST['contenuArticle'];
           $categorieArticle = $_POST['categorieArticle'];
           $fileInfo = pathinfo($_FILES['imgArticle']['name']);
           $extension = $fileInfo['extension'];
           $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
           if (in_array($extension, $allowedExtensions))
                       {
                           move_uploaded_file($_FILES['imgArticle']['tmp_name'], '../kenzatlas/assets/img/articles/' . basename($_FILES['imgArticle']['name']));
                           $imgArticle = '../kenzatlas/assets/img/articles/' . basename($_FILES['imgArticle']['name']);
                           $sqlQuery = 'INSERT INTO articles(imgArticle,titreArticle,categorieArticle,contenuArticle) VALUES (:imgArticle,:titreArticle,:categorieArticle,:contenuArticle)';
                           $insertPost = $db->prepare($sqlQuery);
                           $insertPost->execute([
                               'imgArticle'=> $imgArticle,
                               'titreArticle'=> $titreArticle,
                               'categorieArticle'=>$categorieArticle,
                               'contenuArticle'=>$contenuArticle,
                           ]);
                       }else{
                        echo('Erreur : L\'extension de l\'image n\'est pas autorisée');
                       }
        ?>
        </div>
    </div>
    
</body>
</html>
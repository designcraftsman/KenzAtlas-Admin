<?php
session_start(); 
if(!isset($_SESSION['emailAdmin'])){
    header("Location: error.php");
    exit();
}
    if($_GET['idArticle']){
        $idArticle = $_GET['idArticle'];
        include('connection.php');
        $sqlQuery = "SELECT * FROM articles WHERE idArticle = :idArticle ;";
        $articleStatement = $db->prepare($sqlQuery);
        $articleStatement->bindParam(':idArticle', $idArticle, PDO::PARAM_STR);
        $articleStatement->execute();
        $article = $articleStatement->fetch(PDO::FETCH_ASSOC);
    }else{
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit - <?php echo($article['titreArticle']); ?></title>
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php include('sideBar.php'); ?>
    <div class="main--content">
    <?php include('head.php'); ?>
    <div class="container-fluid">
        <div class="row p-5">
        <form method="Post" enctype="multipart/form-data">
                <h1 class="text-center fw-bolder"><?php echo($article['titreArticle']); ?></h1>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nom du produit</label>
                    <input type="text" class="form-control" name="titreArticle" value="<?php echo($article['titreArticle']); ?>" >
                </div> 
                <div class="mb-3">
                    <label for="formFile" class="form-label">Ajouter la premiére image</label>
                    <input class="form-control" type="file" name="imgArticle">
                </div>
                <label for="categorieProduit mb-3">Catégorie Article :</label>
                <select class="form-select mb-3 mt-3" name="categorieArticle" aria-label="Default select example">
                    <option value="<?php echo $article['categorieArticle']; ?>" selected><?php echo $article['categorieArticle']; ?></option>
                    <option value="cheveux">corps</option>
                    <option value="gommage">beauté</option>
                    <option value="savon">cheveux</option>
                    <option value="huile">conseils</option>
                </select>
                <div class="mb-3">
                    <label for="desriptionProduit" class="form-label">Contenu:</label>
                    <textarea class="form-control" name="contenuArticle"  rows="10">
                        <?php echo($article['contenuArticle']); ?>
                    </textarea>
                </div> 
                <button type="submit" class="btn btn-primary text-secondary  w-100 fs-5 fw-bolder p-3">Enregistrer les modifications</button>
        </form>
            <?php
                if (
                    isset($_POST['titreArticle']) &&
                    isset($_POST['categorieArticle']) &&
                    isset($_POST['contenuArticle'])
                ) {
                    // Assigning values to variables
                    $titreArticle = $_POST['titreArticle'];
                    $categorieArticle = $_POST['categorieArticle'];
                    $contenuArticle = $_POST['contenuArticle'];
                    include('connection.php');

                    if(isset($_FILES['imgArticle']) && $_FILES['imgArticle']['error'] == 0 ){
                    // Validate and upload images
                    $imageUploadErrors = [];

                    function uploadImage($file, $targetPath)
                    {
                        global $imageUploadErrors;

                        $fileInfo = pathinfo($file['name']);
                        $extension = $fileInfo['extension'];
                        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];

                        if (in_array($extension, $allowedExtensions)) {
                            move_uploaded_file($file['tmp_name'], $targetPath . basename($file['name']));
                            return $targetPath . basename($file['name']);
                        } else {
                            $imageUploadErrors[] = 'Erreur : L\'extension de l\'image n\'est pas autorisée';
                            return null;
                        }
                    }

                    $imgArticle = uploadImage($_FILES['imgArticle'], '../kenzatlas/assets/img/articles/');

                    // Check if there were any image upload errors
                    if (!empty($imageUploadErrors)) {
                        foreach ($imageUploadErrors as $error) {
                            echo $error . '<br>';
                        }
                    } else {
                        // Insert data into the database
                        $sqlQuery = "UPDATE articles
                            SET imgArticle = :imgArticle,  
                                titreArticle = :titreArticle, 
                                categorieArticle = :categorieArticle, 
                                contenuArticle = :contenuArticle 
                            WHERE idArticle = :idArticle";
                        $insertArticle = $db->prepare($sqlQuery);
                        $insertArticle->execute([
                            'imgArticle'=>  $imgArticle,
                            'titreArticle' => $titreArticle,
                            'categorieArticle' => $categorieArticle,
                            'contenuArticle'=> $contenuArticle,
                            'idArticle'=>$idArticle,
                        ]);
                    }}else{
                        $sqlQuery = "UPDATE articles 
                            SET 
                                titreArticle = :titreArticle, 
                                categorieArticle = :categorieArticle, 
                                contenuArticle = :contenuArticle
                            WHERE idArticle = :idArticle ";
                        $insertArticle = $db->prepare($sqlQuery);
                        $insertArticle->execute([
                            'titreArticle' => $titreArticle,
                            'categorieArticle' => $categorieArticle,
                            'contenuArticle'=> $contenuArticle,
                            'idArticle'=>$idArticle,
                        ]);
                    }
                }
    ?>

        </div>
    </div>
    </div>
</body>
</html>
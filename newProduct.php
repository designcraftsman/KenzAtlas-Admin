<?php
session_start(); 
if(!isset($_SESSION['emailAdmin'])){
    header("Location: error.php");
    exit();
}
include('connection.php');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kenzatlas - Nouveau Produit</title>
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
                <h1 class="text-center fw-bolder">Ajouter un produit</h1>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nom du produit</label>
                    <input type="text" class="form-control" name="nomProduit" placeholder="Nom du produit">
                </div> 
                <div class="mb-3">
                    <label for="formFile" class="form-label">Ajouter la premiére image</label>
                    <input class="form-control" type="file" name="imageProduit1">
                </div>
                <div class="mb-3">
                    <label for="sousTitreProduit" class="form-label">Sous titre du produit:</label>
                    <input type="text" class="form-control" name="sousTitreProduit" placeholder="Sous titre produit">
                </div> 
                <label for="prixProduit " class="mb-2">Prix produit:</label> 
                <div class="input-group mb-3">
                    <input type="text" name="prixProduit" placeholder="Prix du produit" class="form-control" >
                    <span class="input-group-text">dh</span>
                </div> 
                <label for="categorieProduit mb-3">Catégorie Produit :</label>
                <select class="form-select mb-3 mt-3" name="categorieProduit" aria-label="Default select example">
                    <option value="cheveux">cheveux</option>
                    <option value="gommage">gommage</option>
                    <option value="savon">savon</option>
                    <option value="huile">huile</option>
                </select>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="pack promo" name="etatProduit">
                    <label class="form-check-label" for="flexCheckDefault">
                        Pack promo
                    </label>
                </div>
                <div class="mb-3">
                    <label for="desriptionProduit" class="form-label">Ajouter une description:</label>
                    <textarea class="form-control" name="descriptionProduit" rows="10"></textarea>
                </div> 
                <div class="mb-3">
                    <label for="ingredientsProduit" class="form-label">Ajouter les ingrédients:</label>
                    <textarea class="form-control" name="ingredientsProduit" rows="10"></textarea>
                </div> 
                <button type="submit" class="btn btn-primary text-secondary  w-100 fs-5 fw-bolder p-3">Ajouter Produit</button>
        </form>
            <?php
                if (
                    isset($_POST['nomProduit']) &&
                    isset($_POST['sousTitreProduit']) &&
                    isset($_POST['descriptionProduit']) &&
                    isset($_POST['ingredientsProduit']) &&
                    isset($_POST['prixProduit']) &&
                    isset($_POST['categorieProduit']) &&
                    isset($_POST['etatProduit']) &&
                    isset($_FILES['imageProduit1']) && $_FILES['imageProduit1']['error'] == 0 
                ) {
                    // Assigning values to variables
                    $nomProduit = $_POST['nomProduit'];
                    $prixProduit = $_POST['prixProduit'];
                    $sousTitreProduit = $_POST['sousTitreProduit'];
                    $descriptionProduit = $_POST['descriptionProduit']; // Added missing field
                    $ingredientsProduit = $_POST['ingredientsProduit']; // Added missing field
                    $categorieProduit = $_POST['categorieProduit'];
                    $etatProduit = $_POST['etatProduit'];
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

                    $imageProduit1 = uploadImage($_FILES['imageProduit1'], '../kenzatlas/assets/img/produits/');

                    // Check if there were any image upload errors
                    if (!empty($imageUploadErrors)) {
                        foreach ($imageUploadErrors as $error) {
                            echo $error . '<br>';
                        }
                    } else {
                        // Insert data into the database
                        $sqlQuery = 'INSERT INTO produit(imageProduit1, nomProduit, sousTitreProduit, prixProduit , descriptionProduit, ingredientsProduit, categorieProduit , etatProduit) VALUES (:imageProduit1,  :nomProduit, :sousTitreProduit, :prixProduit ,:descriptionProduit, :ingredientsProduit, :categorieProduit , :etatProduit)';
                        $insertProduit = $db->prepare($sqlQuery);
                        $insertProduit->execute([
                            'imageProduit1' => $imageProduit1,
                            'nomProduit' => $nomProduit,
                            'prixProduit'=> $prixProduit,
                            'sousTitreProduit' => $sousTitreProduit,
                            'descriptionProduit' => $descriptionProduit,
                            'ingredientsProduit' => $ingredientsProduit,
                            'categorieProduit' => $categorieProduit,
                            'etatProduit' => $etatProduit,
                        ]);
                    }
                }
    ?>

        </div>
    </div>
    </div>
</body>
</html>
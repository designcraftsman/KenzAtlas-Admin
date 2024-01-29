<?php
session_start(); 
if(!isset($_SESSION['emailAdmin'])){
    header("Location: error.php");
    exit();
}
    if($_GET['idProduit']){
        $idProduit = $_GET['idProduit'];
        include('connection.php');
        $sqlQuery = "SELECT * FROM produit WHERE idProduit = :idProduit ;";
        $produitStatement = $db->prepare($sqlQuery);
        $produitStatement->bindParam(':idProduit', $idProduit, PDO::PARAM_STR);
        $produitStatement->execute();
        $produit = $produitStatement->fetch(PDO::FETCH_ASSOC);
    }else{
        exit;
    }
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
                <h1 class="text-center fw-bolder"><?php echo($produit['nomProduit']); ?></h1>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nom du produit</label>
                    <input type="text" class="form-control" name="nomProduit" value="<?php echo($produit['nomProduit']); ?>" >
                </div> 
                <div class="mb-3">
                    <label for="formFile" class="form-label">Ajouter la premiére image</label>
                    <input class="form-control" type="file" name="imageProduit1">
                </div>
                <div class="mb-3">
                    <label for="sousTitreProduit" class="form-label">Sous titre du produit:</label>
                    <input type="text" class="form-control" name="sousTitreProduit" value="<?php echo($produit['sousTitreProduit']); ?>">
                </div> 
                <label for="prixProduit " class="mb-2">Prix produit:</label> 
                <div class="input-group mb-3">
                    <input type="text" name="prixProduit" value="<?php echo($produit['prixProduit']); ?>" class="form-control" >
                    <span class="input-group-text">dh</span>
                </div> 
                <label for="categorieProduit mb-3">Catégorie Produit :</label>
                <select class="form-select mb-3 mt-3" name="categorieProduit" aria-label="Default select example">
                    <option value="<?php echo $produit['categorieProduit']; ?>" selected><?php echo $produit['categorieProduit']; ?></option>
                    <option value="cheveux">cheveux</option>
                    <option value="gommage">gommage</option>
                    <option value="savon">savon</option>
                    <option value="huile">huile</option>
                </select>

                <div class="form-check mb-3">
                    <?php if( $produit['etatProduit'] === "pack promo"){ ?>
                        <input class="form-check-input" type="checkbox" value="pack promo" name="etatProduit" checked>
                    <?php }else{ ?>
                    <input class="form-check-input" type="checkbox" value="pack promo" name="etatProduit" >
                    <?php } ?>
                    <label class="form-check-label" for="flexCheckDefault">
                        Pack promo
                    </label>
                </div>
                <div class="mb-3">
                    <label for="desriptionProduit" class="form-label">Ajouter une description:</label>
                    <textarea class="form-control" name="descriptionProduit"  rows="10">
                        <?php echo($produit['descriptionProduit']); ?>
                    </textarea>
                </div> 
                <div class="mb-3">
                    <label for="ingredientsProduit" class="form-label">Ajouter les ingrédients:</label>
                    <textarea class="form-control" name="ingredientsProduit"  rows="10">
                        <?php echo($produit['ingredientsProduit']); ?>
                    </textarea>
                </div> 
                <button type="submit" class="btn btn-primary text-secondary  w-100 fs-5 fw-bolder p-3">Enregistrer les modifications</button>
        </form>
            <?php
                if (
                    isset($_POST['nomProduit']) &&
                    isset($_POST['sousTitreProduit']) &&
                    isset($_POST['descriptionProduit']) &&
                    isset($_POST['ingredientsProduit']) &&
                    isset($_POST['prixProduit']) &&
                    isset($_POST['categorieProduit']) 
                ) {
                    // Assigning values to variables
                    $nomProduit = $_POST['nomProduit'];
                    $prixProduit = $_POST['prixProduit'];
                    $sousTitreProduit = $_POST['sousTitreProduit'];
                    $descriptionProduit = $_POST['descriptionProduit']; // Added missing field
                    $ingredientsProduit = $_POST['ingredientsProduit']; // Added missing field
                    $categorieProduit = $_POST['categorieProduit'];
                    if(!isset($_POST['etatProduit'])){
                        $etatProduit = "unique";
                    }else{
                        $etatProduit = $_POST['etatProduit'];
                    }


                    if(isset($_FILES['imageProduit1']) && $_FILES['imageProduit1']['error'] == 0 ){
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
                        $sqlQuery = "UPDATE produit 
                            SET imageProduit1 = :imageProduit1,  
                                nomProduit = :nomProduit, 
                                sousTitreProduit = :sousTitreProduit, 
                                prixProduit = :prixProduit, 
                                descriptionProduit = :descriptionProduit, 
                                ingredientsProduit = :ingredientsProduit, 
                                categorieProduit = :categorieProduit, 
                                etatProduit = :etatProduit 
                            WHERE idProduit = :idProduit";
                        $insertProduit = $db->prepare($sqlQuery);
                        $insertProduit->execute([
                            'idProduit'=>  $idProduit,
                            'imageProduit1' => $imageProduit1,
                            'nomProduit' => $nomProduit,
                            'prixProduit'=> $prixProduit,
                            'sousTitreProduit' => $sousTitreProduit,
                            'descriptionProduit' => $descriptionProduit,
                            'ingredientsProduit' => $ingredientsProduit,
                            'categorieProduit' => $categorieProduit,
                            'etatProduit' => $etatProduit,
                        ]);
                    }}else{
                        $sqlQuery = "UPDATE produit 
                            SET 
                                nomProduit = :nomProduit, 
                                sousTitreProduit = :sousTitreProduit, 
                                prixProduit = :prixProduit, 
                                descriptionProduit = :descriptionProduit, 
                                ingredientsProduit = :ingredientsProduit, 
                                categorieProduit = :categorieProduit, 
                                etatProduit = :etatProduit 
                            WHERE idProduit = :idProduit";
                        $insertProduit = $db->prepare($sqlQuery);
                        $insertProduit->execute([
                            'idProduit'=> $idProduit,
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
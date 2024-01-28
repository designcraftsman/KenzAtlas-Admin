<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrateur KenzAtlas-Identifiant</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-primary">
    <div class="container ">
        <form method="POST">
            <div class="row m-auto p-5">
                    <img src="image/svg_white.svg" class="w-25 d-block m-auto">
            </div>
            <div class="form-floating mb-3 w-25 m-auto">
                <input type="text" class="form-control" name="emailAdmin" placeholder="name@example.com" required>
                <label for="floatingInput">Nom d'utulisteur</label>
            </div>
            <div class="form-floating w-25 m-auto">
                <input type="password" class="form-control" name="motdepasseAdmin" placeholder="Password" required>
                <label for="floatingPassword">Mot de passe</label>
            </div>
            <button type="submit" class="btn btn-dark btn-lg m-auto d-block mt-3 w-25 fw-bold">Se connecter</button>
        </form>
        <?php
                 session_start();
                 if ($_SERVER["REQUEST_METHOD"] == "POST") {
                     // Check if the statutCommande is set in the POST data
                     if (!isset($_POST['emailAdmin']) || !isset($_POST['motdepasseAdmin'])) {
                         echo('Erreur D\'envoie !');
                         return;
                     }else{
                        include('connection.php');
                        $sqlQuery = "SELECT * FROM admin";
                        $loginStatement = $db->prepare($sqlQuery);
                        $loginStatement->execute();
                        $login = $loginStatement->fetch(PDO::FETCH_ASSOC);
                         $emailAdmin = $_POST['emailAdmin'];
                         $motdepasseAdmin = $_POST['motdepasseAdmin'];
                         if($emailAdmin === $login['emailAdmin'] && $motdepasseAdmin === $login['motdepasseAdmin']){
                             $_SESSION['emailAdmin'] = $emailAdmin;
                             header("Location: dashboard.php");
                         }else{
                             echo('mot de passe incorrect');
                         }
                     }
                 }   
        ?>
    </div>
</body>
</html>
<!DOCTYPE html>

<html lang="fr">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Modification Mot de Passe - OMNES BOX</title>
    <link href="../CSS/connexion.css" rel="stylesheet" type="text/css" media="all" />
    <?php include("verif_connexion_bdd.php") ?>
    <?php include("verif_session.php") ?>

    <?php

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['id'])) {
        // Rediriger vers la page de connexion
        header("Location: connexion.php");
        exit;
    }

    ?>

    <?php
    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les valeurs du formulaire
        $ancienMotDePasse = $_POST['ancienMDP'];
        $nouveauMotDePasse = $_POST['nouveauMDP'];
        $confirmationMotDePasse = $_POST['confirmationMDP'];

        // Vérifier si les champs sont vides
        if (empty($ancienMotDePasse) || empty($nouveauMotDePasse) || empty($confirmationMotDePasse)) {
            echo "Veuillez remplir tous les champs.";
        } else {
            // Vérifier si les nouveaux mots de passe correspondent
            if ($nouveauMotDePasse !== $confirmationMotDePasse) {
                echo "Les nouveaux mots de passe ne correspondent pas.";
            } else {
                // Vérifier si l'ancien mot de passe correspond à celui enregistré dans la base de données
                $id = $_SESSION['id']; // ID du compte à modifier (vous devez récupérer cette valeur à partir de votre système)

                $result = mysqli_query($bdd, "SELECT mdp FROM compte WHERE idCompte = $id");
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $motDePasseBD = $row['mdp'];

                    if ($ancienMotDePasse === $motDePasseBD) {
                        // Mettre à jour le mot de passe dans la base de données
                        $sqlUpdate = "UPDATE compte SET mdp = '$nouveauMotDePasse' WHERE idCompte = $id";

                        if (mysqli_query($bdd, $sqlUpdate)) {
                            header("Location: mon_compte.php");
                        } else {
                            echo "Erreur lors de la mise à jour du mot de passe : " . mysqli_error($bdd);
                        }
                    } else {
                        echo "L'ancien mot de passe est incorrect.";
                    }
                } else {
                    echo "Compte introuvable.";
                }
            }
        }
    }
    ?>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte - OMNES BOX</title>
</head>

<body>
<a href="accueil.php">
        <img src="../Images/logo_omnesBox.png" width="150" height="40" alt="Logo">
    </a>
    
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4" style="height:50%;">
                <div class="panel panel-default" style="height:500px;">

                    <br><br>
                    <h2 class="text">Login</h2><br>
                    <form action="connexion.php" method="post">
                        <div class="pieddepage">
                            <p class="piedgauche"> Mot de Passe :</p>
                        </div>
                        <br>
                        <br>
                        <p class="log"> <input name="mdp" id="mdp"></p>


                        <br> <br>
                        <div class="pieddepage">
                            <p class="text"> Nouveau Mot de Passe : </p>    
                        </div>
                        <br><br>
                        <p class="log"><input type="password"id="password" name="pwd" id="pwd"></p>
                        <br></br>
                        <p class="log"><input class="submit" type="submit" value="Connexion"></p>

                    </form>
                </div>
            </div>
            <div class="col-sm-4 ">
                
                <button onclick="window.location.href = 'accueil.php';" class="close-button" aria-label="Case de fermeture" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        </div>
    </div>
    
</body>

</html>
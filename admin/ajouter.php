<?php
require('../inc/head.php'); 
?>
<body>    
   <div class="container">

        <h1 class="my-3 text-center">Mon super blog en PHP</h1>
        <a href="../index.php">Retour</a>
        <h2>Ajouter un billet</h2>

        <div class="col-md-6 mx-auto">
            <form action="ajouter.php" method="post">
                <div class="form-group">
                    <label for="title">Titre*</label>
                    <input type="text" name="titre" id="title" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label for="content">Contenu*</label>
                    <textarea rows="10" cols="50" name="contenu" id="content" class="form-control"></textarea>
                </div>
                    <button type="submit" class="btn btn-primary btn-block">Enregistrer</button>
            </form>
        </div>

        <?php
            // Connexion à la base de données
            try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', 'root');
            }
            catch(Exception $e)
            {
                    die('Erreur : '.$e->getMessage());
            }

            // Définition des variables
            $titre = $_POST['titre'];
            $contenu = $_POST['contenu'];

            // On vérifie si les champs sont remplis
            if(!empty($titre) && !empty($contenu)){
                
                // Ajout d'un nouveau billet
                $req = $bdd->prepare('INSERT INTO billets(titre, contenu, date_creation) VALUES (:titre, :contenu, NOW())');
                $req->execute(array(
                    'titre'     => $titre,
                    'contenu'   => $contenu
                ));

                // Redirection vers la page d'accueil
                header('Location: ../index.php');
            }else{
                if(isset($titre) && $titre == "" && isset($contenu) && $contenu == ""){
                ?>
                <p class="text-danger mt-3">*Veuillez remplir tous les champs</p>
                <?php
                }
            }
            ?>
    </div>

    <?php require('../inc/scripts.php'); ?>  
    </body>
</html>
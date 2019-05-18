<?php
require('../inc/head.php'); 
?>
<body>    
   <div class="container">

        <h1 class="my-3 text-center">Mon super blog en PHP</h1>
        <a href="../index.php">Retour</a>
        <h2>Modifier le billet</h2>

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

            // On récupère les données du billet sélectionné
            $reponse = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets WHERE id = ?');
            $reponse->execute(array($_GET['billet']));

            $donnees = $reponse->fetch();
            ?>

            <!-- Formulaire pré-rempli -->
            <div class="col-md-6 mx-auto">
                <form action="modifier.php" method="post">
                    <input type="hidden" name="id" id="id" value="<?php echo $donnees['id']; ?>">
                    <div class="form-group">
                        <label for="title">Titre*</label>
                        <input type="text" class="form-control" name="titre" id="title" value="<?php echo $donnees['titre']?>">
                    </div>
                    <div class="form-group">
                        <label for="title">Contenu* </label>
                        <textarea rows="10" class="form-control" cols="50" name="contenu" id="content"><?php echo $donnees['contenu']?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Enregister</button>
                </form>
            </div>

            <?php


            $reponse = $bdd->prepare("UPDATE billets SET titre = :titre, contenu = :contenu, date_creation = NOW() WHERE id = :id ");

            $reponse->execute(array(
                'titre'     => $_POST['titre'],
                'contenu'   => $_POST['contenu'],
                'id'   => $_POST['id']
            ));

          

            $reponse->closeCursor();






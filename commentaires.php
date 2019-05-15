<?php require('inc/head.php'); ?>
    <body>
    <div class="container">

        <h1 class="my-3">Mon super blog en PHP</h1>
        <a href="index.php">Retour</a>

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

            // Affichage du billet
            $reponse = $bdd->prepare('SELECT titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets WHERE id = ?');
            $reponse->execute(array($_GET['billet']));

            $donnees = $reponse->fetch();
            
            // Si le tableau de donnees n'est pas vide = si le billet existe
            if(!empty($donnees)){
            ?>
                <div class="col-md-6 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title"> <?php echo htmlspecialchars($donnees['titre']) ?> </h3>
                            <h6 class="card-subtitle mb-2 text-muted">Posté le <?php echo ($donnees['date_creation_fr']) ?> </h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text"> <?php echo htmlspecialchars($donnees['contenu']) ?> </p>
                        </div>
                    </div>  
                </div>
            <?php
            //Sinon = le billet n'existe pas
            }else{
                header('Location: 404.php'); // Redirection page d'erreur 404

            }  
            $reponse->closeCursor();?>

            <h2 class="mt-5 mb-4">Commentaires</h2>

            <div class="comment">

                <?php
                // Affichage des commentaires
                $reponse = $bdd->prepare('SELECT id_billet, auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS date_commentaire_fr FROM commentaires WHERE id_billet = ? ORDER BY date_commentaire_fr');
                $reponse->execute(array($_GET['billet']));

                while ($donnees = $reponse->fetch()){
                    ?>
                        <p>
                            <strong><?php echo htmlspecialchars($donnees['auteur']); ?></strong> le <?php echo $donnees['date_commentaire_fr']; ?>
                        </p>
                        <p>
                            <?php echo htmlspecialchars($donnees['commentaire']); ?>
                        </p>
                <?php
                }
                $reponse->closeCursor();
                ?>
            
            </div>

    </div>

    <?php require('inc/scripts.php'); ?>  
    </body>
</html>

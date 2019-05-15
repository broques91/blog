<?php require('inc/head.php'); ?>
   <body>    
   <div class="container">

        <h1 class="my-3">Mon super blog en PHP</h1>

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

            // Affichage des 5 derniers billets
            $reponse = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 5');

            while($donnees = $reponse->fetch()){
                ?>
                <div class="col-md-6 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title"> <?php echo htmlspecialchars($donnees['titre']) ?> </h3>
                            <h6 class="card-subtitle mb-2 text-muted">Posté le <?php echo ($donnees['date_creation_fr']) ?> </h6>
                        </div>
                        <div class="card-body">
                            <!-- Contenu du billet -->
                            <p class="card-text"> <?php echo htmlspecialchars($donnees['contenu']) ?> </p>
                            <!-- Lien vers les commentaires du billet -->
                            <a href="commentaires.php?billet=<?php echo ($donnees['id']); ?>" class="card-link">Commentaires</a>
                        </div>
                    </div>  
                </div>
            <?php     
            }
            $reponse->closeCursor();?>

    </div>

    <?php require('inc/scripts.php'); ?>  
    </body>
</html>
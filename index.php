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

            // Nombre de billets par page
            $nbBilletsParPage = 2;
            
            // Récupération du nombre total de billets
            $reponse = $bdd->query('SELECT COUNT(*) AS nb_billets FROM billets');
            $donnees = $reponse->fetch();
            $nbTotalBillets = $donnees['nb_billets'];

            // Calcul du nombre de pages
            $nbPages = ceil($nbTotalBillets / $nbBilletsParPage);

            // Si la variable $_GET['page'] existe...
            if(isset($_GET['page'])) {
                $pageActuelle = intval($_GET['page']);
                
                // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nbPages...
                if($pageActuelle > $nbPages) {
                    $pageActuelle = $nbPages;
                }
            }else{
                $pageActuelle = 1; // La page actuelle est la n°1
            }    

            // Calcul du premier billet à afficher
            $premierBillet = ($pageActuelle-1) * $nbBilletsParPage; 

            $reponse->closeCursor();

            // Affichage des 2 derniers billets
            $reponse = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT '. $premierBillet .', '. $nbBilletsParPage .'');

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
                            <a href="admin/modifier.php?billet=<?php echo ($donnees['id']); ?>" class="card-link">Modifier</a>
                            <a href="admin/supprimer.php?billet=<?php echo ($donnees['id']); ?>" class="card-link">Supprimer</a>

                        </div>
                    </div>  
                </div>
            <?php     
            }
            $reponse->closeCursor();

        // Pagination
        require('inc/pagination.php'); ?> 
          
    </div>

    <?php require('inc/scripts.php'); ?>  
    </body>
</html>
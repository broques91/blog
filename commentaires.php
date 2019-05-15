<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog PHP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
    <body>
    <div class="container">

        <h1>Mon super blog en PHP</h1>
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

            while ($donnees = $reponse->fetch()){
                ?>
                <div class="card mx-auto shadow-sm" style="width: 30rem;">
                    <div class="card-header">
                        <h5 class="card-title"> <?php echo htmlspecialchars($donnees['titre']) ?> </h3>
                        <h6 class="card-subtitle mb-2 text-muted">Posté le <?php echo ($donnees['date_creation_fr']) ?> </h6>
                    </div>
                    <div class="card-body">
                        <p class="card-text"> <?php echo htmlspecialchars($donnees['contenu']) ?> </p>
                    </div>
                </div>  
            <?php
            }
            $reponse->closeCursor();?>

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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>
</html>

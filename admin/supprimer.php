
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

            $reponse = $bdd->prepare('DELETE FROM billets WHERE id = ?');
            $reponse->execute(array($_GET['billet']));

            $donnees = $reponse->fetch();

            // Redirection vers la page d'accueil
            header('Location: ../index.php');

            $reponse->closeCursor();


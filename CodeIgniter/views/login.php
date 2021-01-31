<!-- Pour afficher toutes les erreurs en une seule fois via la fonction validation_errors(): -->
<?php echo validation_errors(); ?>  


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">

        <!-- Responsive web design -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap CSS 4.5.3 import from CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <title> Login </title>
    </head>


    
    <body>    
        <div class="container" style="margin: 80px 0"> 
            <div style="margin-left:620px">
                <?php if (isset($notice)) {echo "<h6 style='margin-bottom:30px; color:red'>" .$notice. "</h6>" ;} ?>
                
                <!-- Formulaire Login -->
                <!-- Remarquez la ligne "echo form_open()" qui génère le code suivant: <form action="http://localhost/ci/index.php/users/login" method="post">.
                La valeur de l'attribut "action" a été renseignée automatiquement et renvoie le formulaire vers le même contrôleur/méthode qui a affiché 
                la vue, ce qui signifie que la même méthode sera utilisée pour afficher et traiter le formulaire.
                Il est très important d'utiliser la fonction form_open() car elle applique des mécanismes de sécurité contre les failles XSS et CSRF -->
                <?php echo form_open(); ?> 
                    <div class="form-group">
                        <label for="username"> Login <sup>*</sup> </label>
                        <input type="text"  id="username"  name="user_login"  style="margin-left:80px">
                    </div>
                    <div class="form-group">
                        <label for="code"> Mot de passe <sup>*</sup> </label>
                        <input type="password"  id="code"  name="user_mdp"  style="margin-left:20px">
                    </div>
                    <br>

                    <!--  Le bouton ENTRER -->
                    <div>
                        <input type="submit" value="Entrer" style="float:left; margin-left:40px; padding:10px 30px; border-radius:10px; background-color:green; color:white"> 
                    </div>
                </form>
            </div>

            <!--  Le bouton ANNULER  -->
            <a href="<?php echo site_url("produits/acceuil");?>">   <!-- On utilise la fonction site_url() pour écrire un lien -->
                <button style="margin-left:40px; padding:10px 25px; border-radius:10px; background-color:red; color:white"> Annuler </button> 
            </a> 
        </div>
    </body>
</html>
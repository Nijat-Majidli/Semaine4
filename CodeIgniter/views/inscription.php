<!-- Pour afficher toutes les erreurs en une seule fois via la fonction validation_errors(): -->
<?php echo validation_errors(); ?>  


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">

        <!-- Responsive web design -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap CSS 4.5.3 import from CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" 
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

        <!-- Link CSS file -->
        <link rel="stylesheet"  href="CodeIgniter/assets/css/CodeIgniter.css"> 

        <title> Inscription </title>
    </head>


  <!-- Formulaire Inscription -->
  <!-- Remarquez la ligne "echo form_open()" qui génère le code suivant: <form action="http://localhost/ci/index.php/users/inscription" method="post">.
  La valeur de l'attribut "action" a été renseignée automatiquement et renvoie le formulaire vers le même contrôleur/méthode qui affiche 
  la vue, ce qui signifie que la même méthode sera utilisée pour afficher et traiter le formulaire.
  Il est très important d'utiliser la fonction form_open() car elle applique des mécanismes de sécurité contre les failles XSS et CSRF -->
    <body>
        <div class="container border border-dark px-4 pb-4"  style="width:68%"> 
            <p class="pt-3"> <sup>*</sup> Ces zones sont obligatoires </p>
            <h1 style="margin-bottom:30px"> Formulaire d'inscription </h1>
            <?php if (isset($notice)) {echo "<h6 style='color:red'>" .$notice. "</h6>" ;} ?>
            <?php echo form_open(); ?> 
                <div class="form-group">
                    <label for="nom"> Nom <sup>*</sup> </label>
                    <input name="user_nom"  id="nom"  type="text"  class="form-control"  placeholder="Veuillez saisir votre nom">
                </div>
                <div class="form-group">
                    <label for="prenom"> Prénom <sup>*</sup> </label>
                    <input name="user_prenom"  id="prenom"  type="text" class="form-control"  placeholder="Veuillez saisir votre prénom">
                </div>
                <div class="form-group">
                    <label for="mail"> Adresse mail <sup>*</sup> </label>
                    <input name="user_email"  id="mail"  type="email"  class="form-control">
                </div>
                <div class="form-group">
                    <label for="login"> Login <sup>*</sup> </label>
                    <input name="user_login"  id="login"  type="text"  class="form-control">
                </div>
                <div class="form-group">
                    <label for="code"> Mot de passe <sup>*</sup> </label>
                    <input name="user_mdp"  id="code"  type="password"  class="form-control">
                </div>
                <div class="form-group">
                    <label for="confirmer"> Confirmer le mot de passe <sup>*</sup> </label>
                    <input name="user_mdp2"  id="confirmer"  type="password"  class="form-control">
                </div>
                <div class="form-group form-check"  style="margin-bottom:40px">
                    <input name="accepter"  id="exampleCheck1"  type="checkbox" class="form-check-input">
                    <label class="form-check-label" for="exampleCheck1"> J'accepte le traitement de ce formullaire. </label>
                </div>
                
                <!-- Bouton ENVOYER -->
                <button type="submit"  style="float:left; margin-left:300px; padding:10px 20px; border-radius:10px; background-color:green; color:white"> 
                    Envoyer 
                </button>
            </form>

             <!-- Bouton ANNULER -->
            <a href="<?php echo site_url("produits/acceuil");?>">   <!-- On utilise la fonction site_url() pour écrire un lien -->
                <button style="margin-left:50px; padding:10px 20px; border-radius:10px; background-color:red; color:white"> Annuler </button> 
            </a> 
        </div>
    </body>
</html>
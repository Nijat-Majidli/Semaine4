<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="UTF-8">

      <!-- Responsive web design -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- Bootstrap CSS 4.5.3 import from CDN -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

      <title> Contact </title>
  </head>

  <!-- PAGE MAIN CONTENT -->
  <!-- Formulaire Contact -->
  <!-- Remarquez la ligne "echo form_open()" qui génère le code suivant: <form action="http://localhost/ci/index.php/users/contact" method="post">.
  La valeur de l'attribut "action" a été renseignée automatiquement et renvoie le formulaire vers le même contrôleur/méthode qui a affiché 
  la vue, ce qui signifie que la même méthode sera utilisée pour afficher et traiter le formulaire.
  Il est très important d'utiliser la fonction form_open() car elle applique des mécanismes de sécurité contre les failles XSS et CSRF -->
  <body>
    <div class="container border border-dark px-4 pb-4"  style="width:68%"> 
      <p class="pt-3"> <sup>*</sup> Ces zones sont obligatoires </p>
      <h1> Vos Coordonnées </h1>
      <?php echo form_open(); ?> 
        <div class="form-group">
          <label for="nom"> Nom <sup>*</sup> </label>
          <input name=""  id="nom"  type="text"  class="form-control"  placeholder="Veuillez saisir votre nom" required>
        </div>
      
        <div class="form-group">
          <label for="prenom"> Prénom <sup>*</sup> </label>
          <input name=""  id="prenom"  type="text" class="form-control"  placeholder="Veuillez saisir votre prénom" required>
        </div>

        <p> Sexe <sup>*</sup> </p>
        <div class="form-group">
          <label for="feminin"> Féminin </label>
          <input  name="sexe"  id="feminin"  type="radio"  required>

          <label for="masculin"> Masculin </label>
          <input  name="sexe"  id="masculin"  type="radio"  required>
        </div>
      
        <div class="form-group">
          <label for="naissance"> Date de naissance <sup>*</sup> </label>
          <input name=""  id="naissance"  type="date"  class="form-control" required>
        </div>

        <div class="form-group">
          <label for="postal"> Code postal <sup>*</sup> </label>
          <input name=""  id="postal"  type="text"  class="form-control"  required>
        </div>

        <div class="form-group">
          <label for="adresse"> Adresse </label>
          <input name=""  id="adresse"  type="text" class="form-control">
        </div>

        <div class="form-group">
          <label for="ville"> Ville </label>
          <input name=""  id="ville"  type="text" class="form-control">
        </div>

        <div class="form-group"  style="margin-bottom:30px">
          <label for="email"> Email <sup>*</sup> </label>
          <input name=""  id="email"  type="email" class="form-control" placeholder="dave.loper@afpa.fr" required>
        </div>

        <h1> Votre demande </h1>
        <div class="form-group">
          <label for="sujet"> Sujet </label>
          <select class="form-control" id="sujet">
                <option> Veuillez sélectionner un sujet </option>
                <option> Mes commandes </option>
                <option> Question sur un produit </option>
                <option> Réclamation </option>
                <option> Autres </option>
          </select>
        </div>

        <div class="form-group">
          <label for="question"> Votre question <sup>*</sup> </label>
          <textarea id="question"  class="form-control"  rows="5"  required></textarea>
        </div>

        <div class="form-group form-check"  style="margin-bottom:30px">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1"> J'accepte le traitement de ce formullaire. </label>
        </div>
        
        <!-- Bouton ENVOYER et ANNULER  -->
        <!-- Pour voir le code de la fonction "verif" regardez tout en bas de la page -->
        <button type="submit"  onclick="verif()"  style="float:left; margin-left:300px; padding:10px 20px; border-radius:10px; background-color:green; color:white"> 
          Envoyer 
        </button>
      </form>

      <a href="<?php echo site_url("produits/acceuil");?>">   <!-- On utilise la fonction site_url() pour écrire un lien -->
          <button style="margin-left:50px; padding:10px 20px; border-radius:10px; background-color:red; color:white"> Annuler </button> 
      </a> 
    </div>


    <!-- JavaScript Code de la fonction verif() -->
    <script>
      function verif()
      { 
        //Rappel : confirm() -> Bouton OK et Annuler, renvoie true ou false
        var resultat = confirm("Etes-vous certain d'envoyer votre message ?");

        //alert("retour :" + resultat);

        if (resultat==false)
        {
            alert("Vous avez annulé d'envoie !");

            //annule l'évènement par défaut 
            event.preventDefault();    
        }
      }
    </script>

  </body>
</html>
<?php 
    if (isset($this->session->login) && isset($this->session->role) && $this->session->role == "administrateur") 
    {
        echo '<h6 style="margin-left:20px"> Bonjour ',$this->session->role, ' ', $this->session->login, '<br> Vous êtes connecté ! </h6>' ;
    } 
    else    // Pas connecté
    {  
        redirect("Users/login");
    }
?>



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

        <title> Detail </title>
    </head>


    <body>
        <!-- Formulaire detail -->

        <!-- Remarquez la ligne "echo form_open()" qui génère le code suivant: <form action="http://localhost/ci/index.php/produits/detail" method="post">.
        La valeur de l'attribut "action" a été renseignée automatiquement et renvoie le formulaire vers le même contrôleur/méthode qui a affiché 
        la vue, ce qui signifie que la même méthode sera utilisée pour afficher et traiter le formulaire.
        Il est très important d'utiliser la fonction form_open() car elle applique des mécanismes de sécurité contre les failles XSS et CSRF -->

        <div class="container"  style="margin:50px 0 60px 220px">
            <?php echo form_open(); ?> 

                <input type="hidden" name="pro_id" value="<?php echo $produit->pro_id; ?>">   <!-- Ici on récupere la clé 'produit' (sous forme objet $produit) du tableau $aView qui se trouvent dans méthode detail() dans controlleur Produits.php -->

                <div class="form-group">
                    <img src="<?php echo base_url("assets/photos/". $produit->pro_id .".". $produit->pro_photo); ?>"  alt="photo"  title="photo"  class="img-fluid"  style="width:600px; padding-left:300px"> 
                </div>

                <div class="form-group">
                    <label for="ref"> Référence : </label>   
                    <input type="text"  name="pro_ref"  id="ref"  class="form-control"  value="<?php echo $produit->pro_ref; ?>"  readonly> 
                    <?php echo form_error('pro_ref'); ?>     <!--Il est recommandé d'afficher le message d'erreur près du champ concerné avec la fonction form_error(); qui prend en argument le nom du champ (attribut name de l'input) -->
                </div> 

                <div class="form-group">
                    <label for="libelle"> Libellé : </label>
                    <input type="text"  name="pro_libelle"  id="libelle"  class="form-control"  value="<?php echo $produit->pro_libelle; ?>"  readonly>   
                    <?php echo form_error('pro_libelle'); ?>    
                </div>

                <div class="form-group">
                    <label for="categorie"> Categorie : </label>
                    <input type="text"  name="cat_nom"  id="categorie"  class="form-control"  value="<?php echo $categorie->cat_nom; ?>"  readonly>   
                    <?php echo form_error('cat_nom'); ?>    
                </div>

                <div class="form-group">
                    <label for="description"> Description : </label>
                    <input type="text"  name="pro_description"  id="description" class="form-control"  value="<?php echo $produit->pro_description; ?>"  readonly>   
                    <?php echo form_error('pro_description'); ?>  
                </div>

                <div class="form-group">
                    <label for="prix"> Prix : </label>
                    <input type="text"  name="pro_prix"  id="prix" class="form-control"  value="<?php echo $produit->pro_prix; ?>"  readonly>   
                    <?php echo form_error('pro_prix'); ?>  
                </div>

                <div class="form-group">
                    <label for="stock"> Stock : </label>
                    <input type="text"  name="pro_stock"  id="stock" class="form-control"  value="<?php echo $produit->pro_stock; ?>"  readonly>   
                    <?php echo form_error('pro_stock'); ?>  
                </div>

                <div class="form-group">
                    <label for="couleur"> Couleur : </label>
                    <input type="text"  name="pro_couleur"  id="couleur" class="form-control"  value="<?php echo $produit->pro_couleur; ?>"  readonly>   
                    <?php echo form_error('pro_couleur'); ?>  
                </div>
                
                <div class="form-group">
                    <label for="bloque"> Produit bloqué ? :  </label>
                    <input type="text"  name="pro_bloque"  id="bloque"  value="<?php echo $produit->pro_bloque; ?>"  readonly>  
                    <?php echo form_error('pro_bloque'); ?>  
                </div>

                <div class="form-group">
                    <label for="date_ajout"> Date d'ajout :  </label>
                    <input type="text"  name="pro_d_ajout"  id="date_ajout"  class="form-control"  value="<?php echo $produit->pro_d_ajout; ?>"  readonly>  
                    <?php echo form_error('pro_d_ajout'); ?>  
                </div>

                <div class="form-group"  style="margin-bottom: 50px">
                    <label for="date_modif"> Date modification :  </label>
                    <input type="text"  name="pro_d_modif"  id="date_modif"  class="form-control"  value="<?php echo $produit->pro_d_modif; ?>"  readonly>  
                    <?php echo form_error('pro_d_modif'); ?>  
                </div>
            </form>

            
            <!-- Bouton SUPPRIMER  -->
            <!-- Pour voir le code de la fonction "verif" regardez tout en bas de la page -->
            <div>
                <!-- On utilise la fonction site_url() pour écrire un lien -->
                <a href="<?php echo site_url("produits/supprimer/".$produit->pro_id);?>">  <!--Ici on envoie argument pro_id au méthode supprimer() qui se trouve dans controlleur Produits.php -->
                    <button  onclick="verif()"  style="float:left; margin-left:250px; padding:10px 20px; border-radius:10px; background-color:red; color:white"> Supprimer </button> 
                </a> 
            </div>
            
            <!-- Bouton RETOUR  --> 
            <!-- On utilise la fonction site_url() pour écrire un lien -->
            <a href="<?php echo site_url("produits/liste");?>">   
                <button style="margin-left:40px; padding:10px 35px; border-radius:10px; background-color:grey; color:white"> Retour </button> 
            </a> 

            <!-- Bouton MODIFIER  -->
            <!-- On utilise la fonction site_url() pour écrire un lien -->
            <a href="<?php echo site_url("produits/modifier/".$produit->pro_id);?>">   <!--Ici on envoie argument pro_id au méthode modifier() qui se trouve dans controlleur Produits.php -->
                <button style="margin-left:40px; padding:10px 30px; border-radius:10px; background-color:orange; color:white"> Modifier </button> 
            </a> 

            <!-- Bouton DECONNEXION -->
            <a href="<?php echo site_url("users/deconnexion");?>"> 
                <button style="margin:0 0 10px 20px; padding:10px 10px; border-radius:10px; background-color:blue; color:white"> Déconnexion </button> 
            </a> 
        </div>


        <!-- JavaScript Code de la fonction verif() -->
        <script>
            function verif()
            { 
                //Rappel : confirm() -> Bouton OK et Annuler, renvoie true ou false
                var resultat = confirm("Etes-vous certain de vouloir supprimer ce produit ?");

                //alert("retour :" + resultat);

                if (resultat==false)
                {
                    alert("Vous avez annulé supprésion !");

                    //annule l'évènement par défaut 
                    event.preventDefault();    
                }
            }
        </script>
    </body>
</html>

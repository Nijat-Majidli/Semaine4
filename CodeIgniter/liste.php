<?php 
    if (isset($this->session->login) && isset($this->session->role)) 
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

        <title> Liste </title>
    </head>


    <!-- PAGE MAIN CONTENT -->
    <body>
        <div class="container"> 
            <div class="table-responsive" style="margin-top:20px;"> 
                <!-- AJOUTER button -->
                <div style="margin-bottom:10px">
                    <a href="<?php echo site_url("produits/ajouter");?>">   <!-- On utilise la fonction site_url() pour écrire un lien -->
                        <button style="float:left; margin:0 0 10px 840px; padding:10px 30px; border-radius:10px; background-color:green; color:white"> Ajouter </button> 
                    </a> 
                    <!-- DECONNEXION button -->
                    <a href="<?php echo site_url("users/deconnexion");?>"> 
                        <button style="margin:0 0 10px 20px; padding:10px 10px; border-radius:10px; background-color:blue; color:white"> Déconnexion </button> 
                    </a> 
                </div>
                <!-- Table of products -->
                <table class="table table-bordered table-striped"> 
                    <thead class="thead-light" >
                        <tr class="font-weight-bolder">
                            <th scope="col"> Photo </th>
                            <th scope="col"> ID </th>
                            <th scope="col"> Référence </th>
                            <th scope="col"> Libellé </th>
                            <th scope="col"> Description </th>
                            <th scope="col"> Prix </th>
                            <th scope="col"> Stock </th>
                            <th scope="col"> Couleur </th>
                            <th scope="col"> Date_d'ajout </th>
                            <th scope="col"> Date_modification </th>
                            <th scope="col"> Bloqué </th>
                        </tr>
                    </thead>
                    <tbody>  
                        <?php                                 
                        foreach ($produits as $row)   // Ici on récupere la clé 'liste_produits' du tableau $aView qui se trouvent dans méthode liste() dans controlleur Produits.php   
                        {                             // Ici la clé est transformée en variable, on écrit $produits et non pas echo $aView["produits"]
                        ?>
                            <tr>
                                <td class="table-warning"  style="width:130px">
                                    <div>
                                        <!-- On appele les fichiers via la fonction base_url() en indiquant en paramètre le chemin vers la ressource -->
                                        <img src="<?php echo base_url("assets/photos/". $row->pro_id .".". $row->pro_photo); ?>"  alt="photo" title="photo" class="img-fluid"> 
                                    </div>
                                </td> 
                                <td> 
                                    <div> 
                                        <?php  echo $row->pro_id; ?>  
                                    </div>
                                </td>    
                                <td> 
                                    <div> 
                                        <?php  echo $row->pro_ref; ?>
                                    </div>
                                </td>
                                <td class="table-warning"> 
                                    <div>  
                                        <!-- On utilise la fonction site_url() pour écrire un lien -->
                                        <a href="<?php echo site_url("produits/detail/".$row->pro_id."/".$row->pro_cat_id);?>">   <!--Ici on envoie 2 arguments (pro_id et pro_cat_id) au méthode detail() qui se trouve dans controlleur Produits.php -->
                                            <?php echo $row->pro_libelle;?>      
                                        </a> 
                                    </div>
                                </td>
                                <td> 
                                    <div> 
                                        <?php  echo $row->pro_description; ?>
                                    </div>
                                </td>
                                <td> 
                                    <div> 
                                        <?php  echo $row->pro_prix; ?>
                                    </div>
                                </td>
                                <td> 
                                    <div> 
                                        <?php  echo $row->pro_stock; ?>
                                    </div>
                                </td>
                                <td> 
                                    <div> 
                                        <?php  echo $row->pro_couleur; ?>
                                    </div>
                                </td>
                                <td> 
                                    <div> 
                                        <?php  echo $row->pro_d_ajout; ?>
                                    </div>
                                </td>
                                <td> 
                                    <div> 
                                        <?php  echo $row->pro_d_modif; ?>
                                    </div>
                                </td>
                                <td> 
                                    <div> 
                                        <?php  echo $row->pro_bloque; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>  
                </table>
            </div>
        </div> 
    </body>
</html> 
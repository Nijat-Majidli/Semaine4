<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /* IMPORTANT!  Le contrôleur est un fichier PHP contenant le code d'une classe (ici classe Produits).
    Comme on peut le voir ci-dessous, la classe Produits hérite de la classe CI_Controller.
    La classe Produits (en UpperCase) doit se trouver dans le fichier Produits.php. Ce fichier est un controlleur et devra être placé 
    dans le répertoire application/controllers. Par exemple: application/controllers/Produits.php 
    Le nom d'un contrôleur doit commencer par une majuscule: Produits et le nom de fichier du contrôleur également : Produits.php   
    */

    /* Pour pré-charger automatiquement dans chaque méthode tous les assistants et librairies nécessaires pour tout le projet il faut :
    1. Ouvrir le fichier config/autoload.php.
    2. Rechercher la ligne $autoload['libraries'] et remplacer par: $autoload['libraries'] = array('database', 'form_validation', 'session', 'email');
    3. Rechercher la ligne $autoload['helpers'] et remplacer par:   $autoload['helpers'] = array('form', 'url');    
    */

    /* Pour indiquer à notre application quelle est l'url de base (la racine) : 
    1. Ouvrez le fichier config/config.php 
    2. Rechercher la ligne $config['base_url'] = '' 
    3. Renseigner comme valeur l'url de votre projet:  $config['base_url'] = 'http://localhost/CodeIgniter/';
    Désormais, on pourra utiliser la fonction site_url() pour écrire un lien.   
    */

    /* Il est possible d'indiquer quel sera le contrôleur et la méthode à exécuter au lancement de l'application (page d'accueil) :
    1. Ouvrez le fichier    config/routes.php 
    2. Recherchez la ligne  $route['default_controller'] = 'welcome'; 
    3. Remplacez la valeur par le contrôleur et la méthode souhaitée comme page d'accueil: $route['default_controller'] = 'produits/acceuil';   
    */

    /* On va enregistrer la date d'ajout et modification d'un produit etc... 
    Pour obtenir la bonne date et heure, il faut configurer la valeur de l'option datetime_zone sur la valeur Europe/Paris.
    Donc, il faut ajouter l'instruction date_default_timezone_set("Europe/Paris"); dans vos scripts avant toute manipulation de dates.   */
    date_default_timezone_set('Europe/Paris');



    class Produits extends CI_Controller 
    {   
        // Avec le méthode "acceuil()" on va afficher la page d'acceuil (script vue "acceuil.php")
        public function acceuil()
        {   
            /* Chargement des différents vues
            Notez qu'une vue est apellée par son nom de fichier sans l'extension ".php"
            Attention! Les vues doivent être chargées dans l'ordre de leur affichage (ici header > acceuil > footer) :    */
            $this->load->view('header');
            $this->load->view('acceuil');   
            $this->load->view('footer');
        }
        


        // Avec le méthode "liste()" on va afficher la page de liste de produits (script vue "liste.php")
        public function liste()
        {   
            // Un tableau associatif ($aViewHeader) à transmettre à la vue 'header.php' :
            $aViewHeader = ["title" => "Liste des produits"];    // celui-ci contient une valeur pour la balise <title> de la page

            // Chargement du modèle 'ProduitsModel' qui se trouve dans le fichier ProduitsModel.php
            $this->load->model('produitsModel');

            // On appelle la méthode liste() du modèle, qui retourne le tableau de résultat ici affecté dans la variable $aListe (un objet) 
            $aListe = $this->produitsModel->liste();         

            $aView["produits"] = $aListe;  /* Ajouter des résultats de la requête au tableau associatif $aView 
            
            Le tableau $aView sera transmis à la vue 'liste.php' et dans la vue on va récuperer la clé "produits"
            sous forme de variable-objet comme: $produits.   
            Dans le design pattern M.V.C., le contrôleur transmet des données via un tableau associatif (ici $aView) 
            à la vue pour affichage. Mais une vue n'envoie jamais de données au contrôleur.
            */

            /* Chargement des différents vues
            Notez qu'une vue est apellée par son nom de fichier sans l'extension ".php"
            Attention! Les vues doivent être chargées dans l'ordre de leur affichage (ici header > liste > footer) :    */
            $this->load->view('header', $aViewHeader);
            $this->load->view('liste', $aView);   
            $this->load->view('footer');
        }
        


        
        // Avec le méthode "ajouter" on va afficher et aussi traiter la page de formulaire d'ajout de produit (script vue "ajouter.php")
        public function ajouter()
        {   
             // Chargement du modèle 'ProduitsModel' qui se trouve dans le fichier ProduitsModel.php
             $this->load->model('produitsModel');

             // On appelle la méthode liste2() du modèle, qui retourne le tableau de résultat ici affecté dans la variable $aListe (un objet) 
             $aListe = $this->produitsModel->liste2();         
 
             $aView["categories"] = $aListe;    /* On ajoute des résultats de la requête au tableau associatif $aView 
             
             Le tableau $aView sera transmis à la vue 'ajouter.php' et dans la vue on va récuperer la clé "categories" 
             sous forme de variable-objet comme: $categories.   
             Dans le design pattern M.V.C., le contrôleur transmet des données via un tableau associatif (ici $aView) 
             à la vue pour affichage. Mais une vue n'envoie jamais de données au contrôleur.    */
             
            if ($this->input->post())  // 2ème appel de la page: traitement du formulaire
            { 
                $data = $this->input->post();  /* Permet de récupérer en une seule fois toutes les données envoyées par le formulaire ('ajouter.php'). 
                
                Ici $data est un tableau associatif contenant les données issues du formulaire d'ajout. Variable $data equivaut au tableau $_POST en PHP natif. 
                
                Notez que $this->input->post("nom_du_champ") permet de récupérer la valeur d'un seul champ en lui spécifiant en argument la valeur de l'attribut name.  */

                // On peut ajouter une date d'ajout que le formulaire ne contient pas :
                $data["pro_d_ajout"] = date("Y-m-d h:i:s");   
                $data["pro_d_modif"] = date("Y-m-d h:i:s");
                
                /* On peut aussi transformer une information venant du formulaire: 
                $data["pro_ref"] = strtoupper($pro_ref)    ici on mets la référence du produit en majuscules    
                
                On peut supprimer un champ inutile avec la fonction PHP unset() avant l'insertion en bdd:  unset($data["champPasEnBase"])    */

                /* Avant d'inserer les données en base de données il faut les contrôler. Pour cela on applique la librairie 'form_validation' 
                qui fonctionne comme suit: la méthode "set_rules()" cible un champ et y applique un ou plusieurs filtres de validation:    */
                $this->form_validation->set_rules("pro_ref", "Référence", "required|min_length[2]");  
                
                /* 1er argument ("pro_ref") indique le champ de formulaire à contrôler, indiquer l'attribut name du <input> 
                2ème argument ("Référence") précise un nom/libellé désignant le champ ciblé
                3ème argument : le filtre de contrôle à appliquer. Il est possible d'appliquer plusieurs filtres sur un même champ. 
                Pour se faire, il faut séparer les filtres en 3ème argument par le caractère: "|"
                Le filtre "required" inique que le champ est obligatoire (ici une valeur doit avoir été saisie pour le champ 'pro_ref').
                Le filtre "min_length[2]" requiert une valeur d'au moins 2 caractères.  */
                
                $this->form_validation->set_rules("pro_libelle", "Libelle", "required|min_length[1]");  
                $this->form_validation->set_rules("pro_cat_id", "Categorie", "required|min_length[1]");  
                $this->form_validation->set_rules("pro_description", "Description", "required|min_length[1]");  
                $this->form_validation->set_rules("pro_prix", "Prix", "required|min_length[1]");  
                $this->form_validation->set_rules("pro_stock", "Stock", "required|min_length[1]");  
                $this->form_validation->set_rules("pro_couleur", "Couleur", "required|min_length[1]");  
                $this->form_validation->set_rules("pro_bloque", "Produit bloque", "required|min_length[1]");  

                /* Si un filtre venait à manquer, on peut tenter de passer par les expressions régulières via le filtre regex_match[\regex\] 
                Exemple de filtre pour valider une date au format dd/mm/yyyy :
                $this->form_validation->set_rules('pro_d_ajout', 'Date', 'required|regex_match[\^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$\]');                                                        
                                
                L'étape suivante est l'exécution de ce filtre, grâce à la méthode run(), qui va appliquer le filtre et 
                retourner TRUE si la valeur est correcte, ou FALSE dans le cas contraire:   */
                
                if ($this->form_validation->run() == FALSE)   // Echec de la validation
                { 
                    // Pour personnaliser le style des messages d'erreurs on utilise le style des alertes de Bootstrap 
                    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');  

                    // On réaffiche la vue formulaire d'ajout en lui transmettant le tableau $aView:
                    $this->load->view('header');
                    $this->load->view('ajouter', $aView);
                    $this->load->view('footer');
                }
                else  // La validation a réussi, nos valeurs sont bonnes, on peut insérer en base de données
                {     
                    $this->db->insert('produits', $data);    // On génère et exécute une requête INSERT

                    /* Le premier argument ('produits') est le nom de la table dans laquelle les données doivent être insérées.
                    Le second argument ($data) est le tableau contenant les données issues du formulaire d'ajout ('ajouter.php').    
                    
                    ATTENTION! Le problème qui se pose avec l'utilisation de $this->db->insert('produits', $data); c'est que les noms des colonnes 
                    de la table ciblée doivent être strictement identiques aux attibuts name des champs input, ce qui n'est pas toujours le cas.  */
                    
                    /* Avant d'insérer en base de données le fichier photo, il nous faut récupérer l'extension du fichier photo.
                    Pour extraire l'extension du fichier on utilise la variable PHP superglobale $_FILES     */  
                    if ($_FILES)    
                    {
                        // Dans le tableau $_FILES["pro_photo"],  "pro_photo" est la valeur donnée à l'attribut "name" du champ de type 'file'  
                        $extension = substr(strrchr($_FILES["pro_photo"]["name"], "."), 1);
                    }

                    // Maintenant on a l'extension du fichier, donc on peut l'enregistrer en base de données 

                    // On créé un tableau de configuration pour l'upload
                    $config['upload_path'] = './assets/photos/';    // chemin où sera stocké le fichier

                    /* Pour créer le nom du fichier : il faut récupérer la clé primaire (pro_id) : 
                    - dans le cas du formulaire de modification : on récupère le pro_id passé dans un champ de type hidden;  
                    - dans le cas du formulaire d'ajout : il faut récupérer avec la méthode $this->db->insert_id() :   */ 
                    $id = $this->db->insert_id(); 

                    // nom du fichier final
                    $config['file_name'] = $id. '.' .$extension; 

                    // On indique les types autorisés (ici pour des images)
                    $config['allowed_types'] = 'gif|jpg|jpeg|png'; 

                    // On charge la librairie 'upload'
                    $this->load->library('upload');

                    // On initialise la config 
                    $this->upload->initialize($config);

                    /* La méthode do_upload() effectue les validations sur l'attribut HTML 'name' ('pro_photo' dans notre formulaire) et 
                    si OK renomme et déplace le fichier tel que configuré */
                    
                    if ( ! $this->upload->do_upload('pro_photo'))   
                    {
                        // Echec : on récupère les erreurs dans une variable (une chaîne)
                        $sUploadErrors = $this->upload->display_errors();    

                        // on réaffiche la vue du formulaire en passant les erreurs 
                        $aView["sUploadErrors"] = $sUploadErrors;

                        // On envoie le message d'erreur dans le fichier php_error.log :
                        error_log($sUploadErrors, 0);  // Le résultat sera visible dans le fichier C:/wamp/logs/php_error.log.

                        /* Pour l'utilisateur, on envoie un message flash, n'oubliez pas, cela nécessite la librairie 'session' */ 
                        $this->load->library('session'); 
                        $this->session->set_flashdata('sUploadError2','Le téléchargement de la photo a échoué.');
                        
                        // On réaffiche le formulaire d'ajout en lui transmettant le tableau $aView:
                        $this->load->view('header');
                        $this->load->view('ajouter', $aView); 
                        $this->load->view('footer');
                    }
                    else   // Succès, on redirige sur la vue liste 
                    { 
                        redirect("produits/liste");   // Redirige le navigateur vers la méthode liste() du contrôleur Produits.php 
                    }
                }         
            } 
            else  // 1er appel de la page: chargement de la vue 'ajouter.php' et l'affichage du formulaire d'ajout
            {  
                /* Chargement des différents vues
                Notez qu'une vue est apellée par son nom de fichier sans l'extension ".php"
                Attention! Les vues doivent être chargées dans l'ordre de leur affichage (ici header > ajouter > footer) :    */
                $this->load->view('header');
                $this->load->view('ajouter', $aView);
                $this->load->view('footer');
            }
        } 




        // C'est une méthode qui prend 2 arguments ($pro_id et $pro_cat_id) et il sert pour l'affichage de la vue detail.php
        public function detail($pro_id, $pro_cat_id)
        { 
            // Chargement du modèle 'ProduitsModel' qui se trouve dans le fichier ProduitsModel.php
            $this->load->model('produitsModel');      

            // On appelle la méthode liste3() du modèle, qui retourne le tableau de résultat ici affecté dans la variable $aListe (un objet) 
            $aListe = $this->produitsModel->liste3($pro_id);  
        
            // On appelle la méthode liste4() du modèle, qui retourne le tableau de résultat ici affecté dans la variable $aCateg (un objet) 
            $aCateg = $this->produitsModel->liste4($pro_cat_id);  

            // On ajoute des résultats des requêtes au tableau associatif $aView
            $aView["produit"] = $aListe;     // Récupération de la première ligne avec la méthode row() et on la mets dans tableau associatif $aView;
            $aView["categorie"] = $aCateg;    
            
            /*  Le tableau $aView sera transmis à la vue 'detail.php' et dans la vue on va récuperer la clé "produit" et  
            la clé "categories" sous forme des variable-objet comme: $produit et $categories.   
            Dans le design pattern M.V.C., le contrôleur transmet des données via un tableau associatif (ici $aView) 
            à la vue pour affichage. Mais une vue n'envoie jamais de données au contrôleur.     */

            $this->load->view('header');
            $this->load->view('detail', $aView);
            $this->load->view('footer');
        }




        // C'est une méthode qui prend 1 argument ($pro_id) et il sert pour l'afficahge et traitement du formulaire de modification
        public function modifier($pro_id)
        { 
            // Chargement du modèle 'ProduitsModel' qui se trouve dans le fichier ProduitsModel.php
            $this->load->model('produitsModel');      

            // On appelle la méthode liste3() du modèle, qui retourne le tableau de résultat ici affecté dans la variable $aListe (un objet) 
            $aListe = $this->produitsModel->liste3($pro_id);  
           
            // On appelle la méthode liste2() du modèle, qui retourne le tableau de résultat ici affecté dans la variable $aCateg (un tableau) 
            $aCateg = $this->produitsModel->liste2();  

            // On ajoute des résultats des requêtes au tableau associatif $aView
            $aView["produit"] = $aListe;     // Récupération de la première ligne avec la méthode row() et on la mets dans tableau associatif $aView;
            $aView["categories"] = $aCateg;    
             
            /*  Le tableau $aView sera transmis à la vue 'modifier.php' et dans la vue on va récuperer la clé "produit" et  
            la clé "categories" sous forme des variable-objet comme: $produit et $categories.   
            Dans le design pattern M.V.C., le contrôleur transmet des données via un tableau associatif (ici $aView) 
            à la vue pour affichage. Mais une vue n'envoie jamais de données au contrôleur.   */

            if ($this->input->post())   // 2ème appel de la page: traitement du formulaire
            { 
                $data = $this->input->post();  /* Permet de récupérer en une seule fois toutes les données envoyées par le formulaire ('modifier.php'). 
                
                Ici $data est un tableau contenant les données issues du formulaire modification. Variable $data equivaut au tableau $_POST en PHP natif.   
                
                Notez que $this->input->post("nom_du_champ") permet de récupérer la valeur d'un seul champ en lui spécifiant en argument la valeur de l'attribut name.  */

                // On peut ajouter une date de modification que le formulaire ne contient pas :
                $time = new DateTime();     // On utilise l'objet DateTime() pour enregistrer la date et l'heure de modification du produit dans la base de données.
                $data["pro_d_modif"] = $time->format("Y-m-d H:i:s"); 

                /* Avant d'inserer les données en base de données il faut les contrôler. Pour cela on applique la librairie 'form_validation' 
                qui fonctionne comme suit : la méthode "set_rules()" cible un champ et y applique un ou plusieurs filtres de validation:    */
                $this->form_validation->set_rules("pro_ref", "Référence", "required|min_length[2]");  
                
                /* 1er argument ("pro_ref") indique le champ de formulaire à contrôler, indiquer l'attribut name du <input> 
                2ème argument ("Référence") précise un nom/libellé désignant le champ ciblé
                3ème argument : le filtre de contrôle à appliquer. Il est possible d'appliquer plusieurs filtres sur un même champ. 
                Pour se faire, il faut séparer les filtres en 3ème argument par le caractère: "|"
                Le filtre "required" inique que le champ est obligatoire (ici une valeur doit avoir été saisie pour le champ 'pro_ref').
                Le filtre "min_length[2]" requiert une valeur d'au moins 2 caractères.  */
                
                $this->form_validation->set_rules("pro_libelle", "Libelle", "required|min_length[1]");  
                $this->form_validation->set_rules("pro_cat_id", "Categorie", "required|min_length[1]");  
                $this->form_validation->set_rules("pro_description", "Description", "required|min_length[1]");  
                $this->form_validation->set_rules("pro_prix", "Prix", "required|min_length[1]");  
                $this->form_validation->set_rules("pro_stock", "Stock", "required|min_length[1]");  
                $this->form_validation->set_rules("pro_couleur", "Couleur", "required|min_length[1]");  
                $this->form_validation->set_rules("pro_bloque", "Produit bloque", "required|min_length[1]");  

                /* Si un filtre venait à manquer, on peut tenter de passer par les expressions régulières via le filtre regex_match[\regex\] 
                Exemple de filtre pour valider une date au format dd/mm/yyyy :
                $this->form_validation->set_rules('pro_d_ajout', 'Date', 'required|regex_match[\^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$\]');                                                        
                                
                L'étape suivante est l'exécution de ce filtre, grâce à la méthode run(), qui va appliquer le filtre et 
                retourner TRUE si la valeur est correcte, ou FALSE dans le cas contraire:   */

                if ($this->form_validation->run() == FALSE)   // Echec de la validation
                { 
                    // Pour personnaliser le style des messages d'erreurs on utilise le style des alertes de Bootstrap 
                    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');  

                    // On réaffiche la vue 'modifier.php' 
                    $this->load->view('header');
                    $this->load->view('modifier', $aView);
                    $this->load->view('footer');
                }
                else   // La validation a réussi, nos valeurs sont bonnes, on peut modifier en base de données
                {   
                    // On génère et exécute une requête UPDATE:
                    $this->db->where('pro_id', $pro_id);    // Utilisation de la méthode where() toujours avant select(), insert() ou update() dans cette configuration sur plusieurs lignes
                    $this->db->update('produits', $data);

                    redirect("produits/liste");   // Redirige le navigateur vers la méthode liste() du contrôleur Produits.php.
                }
            } 
            else  // 1er appel de la page: chargement de la vue 'modifier.php' et l'affichage du formulaire modification
            {  
                $this->load->view('header');
                $this->load->view('modifier', $aView);
                $this->load->view('footer');
            }
        } 




        // C'est une méthode qui prend 1 argument ($pro_id) et il sert pour supprimer un produit de la vue liste.php
        public function supprimer($pro_id)
        { 
            // Chargement du modèle 'ProduitsModel' qui se trouve dans le fichier ProduitsModel.php
            $this->load->model('produitsModel');      

            // On appelle la méthode liste5() du modèle, qui supprime la produit de la base de données 
            $this->produitsModel->liste5($pro_id);  

            redirect("produits/liste");   // Redirige le navigateur vers la méthode liste() du contrôleur Produits.php.
        }

       
          
    }


?>
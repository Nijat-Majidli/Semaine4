<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    /* IMPORTANT!   Le contrôleur est un fichier PHP contenant le code d'une classe (ici classe Users).
    Comme on peut le voir ci-dessous, la classe Users hérite de la classe CI_Controller.
    La classe Users (en UpperCase) doit se trouver dans le fichier Users.php. Ce fichier est un controlleur et devra 
    être placé dans le répertoire application/controllers. Par exemple: application/controllers/Users.php 
    Le nom d'un contrôleur doit commencer par une majuscule: Users et le nom de fichier du contrôleur également : Users.php   
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
    1. Ouvrez le fichier  config/routes.php 
    2. Recherchez la ligne  $route['default_controller'] = 'welcome'; 
    3. Remplacez la valeur par le contrôleur et la méthode souhaitée comme page d'accueil: $route['default_controller'] = 'produits/acceuil';   
    */

    /* On va enregistrer la date d'inscription et dernier connexion du client etc... 
    Pour obtenir la bonne date et heure, il faut configurer la valeur de l'option datetime_zone sur la valeur Europe/Paris.
    Donc, il faut ajouter l'instruction date_default_timezone_set("Europe/Paris"); dans vos scripts avant toute manipulation de dates.   */
    date_default_timezone_set('Europe/Paris');



    class Users extends CI_Controller 
    {
        // Avec le méthode "contact()" on va afficher la page contact (script vue "contact.php")
        public function contact()
        {   
            /* Chargement des différents vues
            Notez qu'une vue est apellée par son nom de fichier sans l'extension ".php"
            Attention! Les vues doivent être chargées dans l'ordre de leur affichage (ici header > contact > footer) :    */
            $this->load->view('header');
            $this->load->view('contact');   
            $this->load->view('footer');
        }



        // Avec le méthode "deconnexion()" on va détruire la session 
        public function deconnexion()
        {   
            $this->session->sess_destroy();

            redirect("users/login");    // Rediriger le navigateur vers la méthode login() du contrôleur Users.php     
        }
        
        
        

        // Avec le méthode "login()" on va afficher et traiter la page login (script vue "login.php")
        public function login()
        {   
            if ($this->input->post())  // 2ème appel de la page: traitement du formulaire login
            { 
                $data = $this->input->post();  /* Permet de récupérer en une seule fois toutes les données envoyées par le formulaire 'login.php'. 
                
                Ici $data est un tableau associatif contenant les données issues du formulaire login. Variable $data equivaut au tableau $_POST en PHP natif.  
                
                Notez que $this->input->post("nom_du_champ") permet de récupérer la valeur d'un seul champ en lui spécifiant en argument la valeur de l'attribut name.  */

                $user_login = $data['user_login'];
                
                $user_mdp = $data['user_mdp'];

                // On peut ajouter une date de modification que le formulaire ne contient pas :
                $time = new DateTime();     // On utilise l'objet DateTime() pour enregistrer dans la base de données la date et l'heure du connexion du client.
                $data["user_connexion"] = $time->format("Y-m-d H:i:s"); 

                /* Vérification si login saisi par utilisateur déjà existe dans la base de données ou non ?
                Pour cela on va charger le modèle 'UsersModel' qui se trouve dans le fichier UsersModel.php   */   
                $this->load->model('usersModel');

                // On charge le modéle en seul fois et ensuite on va utiliser plusieurs méthodes qui se trouvent dans cette modéle.

                // Ensuite on appelle la méthode user1() du modèle, qui retourne le tableau ayant les clés en forme d'objet 
                $result = $this->usersModel->user1();
                
                // Ici $result est un tableau qui contient : objet user_login et ses valeurs 
                
                foreach($result as $login)
                {
                    $aLogins[] = $login->user_login;   // ici user_login est un attribut de l'objet $login
                }
                
                if (!in_array($user_login, $aLogins))
                {
                    $Message["notice"] = "Ce login n'existe pas ! <br> Veuillez vous inscrire !";
                    
                    // On affiche la vue "login" en lui transmettant le tableau $Message :
                    $this->load->view('header');
                    $this->load->view('login', $Message);
                    $this->load->view('footer');
                    return;

                    /* Pour rediriger le navigateur vers la méthode login() du contrôleur Users.php:  redirect("users/login");  */     
                } 

                /* Avant d'inserer les données en base de données il faut les contrôler. Pour cela on applique la librairie 'form_validation' 
                qui fonctionne comme suit : la méthode "set_rules()" cible un champ et y applique un ou plusieurs filtres de validation:    */
                $this->form_validation->set_rules("user_login", "Login", "required|min_length[2]");  
                
                /* 1er argument ("login") indique le champ de formulaire à contrôler, indiquer l'attribut name du <input> 
                2ème argument ("Login") précise un nom/libellé désignant le champ ciblé
                3ème argument : le filtre de contrôle à appliquer. Il est possible d'appliquer plusieurs filtres sur un même champ. 
                Pour se faire, il faut séparer les filtres en 3ème argument par le caractère: "|"
                Le filtre "required" inique que le champ est obligatoire (ici une valeur doit avoir été saisie pour le champ 'login').
                Le filtre "min_length[2]" requiert une valeur d'au moins 2 caractères.  */

                $this->form_validation->set_rules("user_mdp", "Mot de passe", "required|min_length[1]");

                /* L'étape suivante est l'exécution de ce filtre, grâce à la méthode run(), qui va appliquer le filtre et 
                retourner TRUE si la valeur est correcte, ou FALSE dans le cas contraire:   */
                
                if ($this->form_validation->run() == FALSE)   // Echec de la validation
                { 
                    // Pour personnaliser le style des messages d'erreurs on utilise le style des alertes de Bootstrap 
                    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');  

                    redirect("users/login");   // Redirige le navigateur vers la méthode login() du contrôleur Users.php
                }
                else  // La validation a réussi, nos valeurs sont bonnes, on peut insérer en base de données
                {
                    /* Avant d'insertion en bdd on fait vérification: 
                    Est-ce que le mot de passe saisi par utilisateur déjà existe dans la base de données ou non ?
                    Pour cela on doit récupérer le mot de passe hashé de l'utilisateur qui se trouve dans la base de données.     */

                    // Tout d'abord on va charger le modèle 'UsersModel' qui se trouve dans le fichier UsersModel.php   
                    $this->load->model('usersModel');

                    // On charge le modéle en seul fois et ensuite on va utiliser plusieurs méthodes qui se trouvent dans cette modéle  

                    // On appelle la méthode user2() du modèle qui nous renvoie un objet:
                    $aCode = $this->usersModel->user2($user_login);  

                    /*  Ici $aCode est un objet qui contient:
                    1. user_mdp et sa valeur, 
                    2. user_blocked et sa valeur.
                    */

                    // Pour vérifier si un mot de passe saisi est bien celui enregistré en base, on utilise la fonction password_verify() qui renvoie True ou False :
                    $PasswordCorrect = password_verify($user_mdp, $aCode->user_mdp); 

                    if ($PasswordCorrect && empty($aCode->user_blocked))
                    {
                        // On appelle la méthode user3() du modèle, qui mets à jour la date et l'heure du connexion du client 
                        $this->usersModel->user3($user_login);   

                        /* Pour utiliser les sessions avec CodeIgniter, il faut charger la librairie session :
                        soit dans une méthode de contrôleur, au cas par cas.
                        soit dans le fichier config/autoload.php, pour rendre la librairie disponible dans tout le projet.  */

                        // Pour mettre une variable en session, utiliser la méthode set_userdata() :   
                        $this->session->set_userdata('login', $user_login);    
                        
                        /* set_userdata('login', $user_login)  est égal à  $_SESSION["login"] = $user_login en PHP natif.
                        
                        A retenir: Même si CodeIgniter propose sa propre syntaxe pour gérer les sessions, il reste possible 
                        d'utiliser la syntaxe native PHP ($_SESSION et fonctions associées).   */

                        // On appelle la méthode user4() du modèle, qui nous retourne un objet:  
                        $resultat = $this->usersModel->user4($user_login);

                        //  Ici $resultat est un objet qui contient: user_role et sa valeur
        
                        if($resultat->user_role == 'admin')
                        {
                            $this->session->set_userdata('role', 'administrateur');    // set_userdata('role', 'administrateur') est égal à $_SESSION["role"] = "administrateur" en PHP natif.
                        }
                        else
                        {
                            $this->session->set_userdata('role', 'client');
                        }
                        
                        redirect("produits/liste");   // Redirige le navigateur vers la méthode liste() du contrôleur Produits.php
                    }
                    else 
                    {
                        // On appelle la méthode user5() du modèle, qui retourne l'objet ici affecté dans la variable $aListe 
                        $aListe = $this->usersModel->user5($user_login);  

                        /* Ici $aListe est un objet qui contient:
                        1. login_fail et sa valeur, 
                        2. user_blocked et sa valeur, 
                        3. unblock_time et sa valeur.
                        */
                         
                        // On augmente le nombre de login_fail à chaque fois que l'utilisateur rate s'identifier :
                        $login_fail = $aListe->login_fail + 1;  

                        if($login_fail < 4)   
                        {
                            // On appelle la méthode user6() du modèle, qui mets à jour le champ "login_fail"
                            $this->usersModel->user6($user_login, $login_fail);

                            $Message["notice"] = "Mauvais identifiant ou mot de passe!"; 
                            
                            /* Le tableau $Message sera transmis à la vue 'login.php' et dans la vue on va récuperer la clé "notice"
                            sous forme de variable-objet comme: $notice.   
                            Dans le design pattern M.V.C., le contrôleur transmet des données via un tableau associatif (ici $Message) 
                            à la vue pour affichage. Mais une vue n'envoie jamais de données au contrôleur.   */
                            
                            // On affiche la vue "login" en lui transmettant le tableau $Message :
                            $this->load->view('header');
                            $this->load->view('login', $Message);
                            $this->load->view('footer');
                            return;
                        }
                        else   // Si l'utilisateur 3 fois ne saisit pas son mot de passe correctement on le bloque.
                        {
                            if(empty($aListe->user_blocked))
                            {
                                // On appelle la méthode user7() du modèle, qui mets à jour les champs "user_blocked" et "unblock_time" 
                                $this->usersModel->user7($user_login);

                                $Message["notice"] = "Vous êtes bloqué pour 2 minutes!";

                                // On affiche la vue "login" en lui transmettant le tableau $Message :
                                $this->load->view('header');
                                $this->load->view('login', $Message);
                                $this->load->view('footer');
                                return;
                            }
                            else
                            {
                                $current_time = time();     // La fonction time() renvoie l'heure actuelle en nombre de secondes depuis l'époque Unix (1er janvier 1970 00:00:00 GMT).

                                if($aListe->unblock_time < $current_time)
                                {
                                    // On appelle la méthode user8() du modèle, qui mets à jour les champs "login_fail", "user_blocked" et "unblock_time"
                                    $this->usersModel->user8($user_login);

                                    $Message["notice"] = "Vous êtes débloqué ! <br> Veuillez réessayer de vous connecter!";
                                    
                                    // On affiche la vue "login" en lui transmettant le tableau $Message :
                                    $this->load->view('header');
                                    $this->load->view('login', $Message);
                                    $this->load->view('footer');
                                    return;
                                }
                                else
                                {
                                    $Message["notice"] = "Vous êtes bloqué pour 2 minutes!";

                                    // On affiche la vue "login" en lui transmettant le tableau $Message :
                                    $this->load->view('header');
                                    $this->load->view('login', $Message);
                                    $this->load->view('footer');
                                    return;
                                }
                            }
                        }
                    }  
                }
            }
            else  // 1er appel de la page: chargement de la vue 'login.php' et l'affichage du formulaire login
            {  
                $Message["notice"] = "Veuillez vous identifier"; 

                /* Chargement des différents vues
                Notez qu'une vue est apellée par son nom de fichier sans l'extension ".php"
                Attention! Les vues doivent être chargées dans l'ordre de leur affichage (ici header > login > footer).
                // On affiche la vue "login" en lui transmettant le tableau $Message    */
                $this->load->view('header');
                $this->load->view('login', $Message);   
                $this->load->view('footer');
                return;
            }            
        }





        
        // Avec le méthode "inscription()" on va afficher et traiter la page d'inscription (script vue "inscription.php")
        public function inscription()
        {   
            if ($this->input->post())  // 2ème appel de la page: traitement du formulaire d'inscription
            { 
                $data = $this->input->post();  /* Permet de récupérer en une seule fois toutes les données envoyées par le formulaire 'inscription.php'. 
                
                Ici $data est un tableau (array) associatif contenant toutes les données issues du formulaire d'inscription. Variable $data equivaut au tableau $_POST en PHP natif.  

                Notez que $this->input->post("nom_du_champ") permet de récupérer la valeur d'un seul champ en lui spécifiant en argument la valeur de l'attribut name.  */

                // On peut ajouter une date de modification que le formulaire ne contient pas :
                $time = new DateTime();     // On utilise l'objet DateTime() pour enregistrer dans la base de données la date et l'heure d'inscription du client.
                $data["user_inscription"] = $time->format("Y-m-d H:i:s"); 

                /* On peut aussi transformer une information venant du formulaire: 
                $data["pro_ref"] = strtoupper($pro_ref)    ici on mets la référence du produit en majuscules    
                
                On peut supprimer un champ inutile avec la fonction PHP unset() avant l'insertion en bdd:  unset($data["champPasEnBase"])    */
                
                /* Un mot de passe ne doit jamais être stocké en clair : il doit être crypté à l'aide d'un algorithme de cryptage afin que 
                sa valeur ne puisse être lue. La fonction password_hash() permet d’utiliser des algorithmes de cryptage en PHP. 
                D'abord on vérifie la validité du mot de passe:   */
                if ($data["user_mdp"] == $data["user_mdp2"])
                {
                    $data["user_mdp"] = password_hash($data["user_mdp"], PASSWORD_DEFAULT);  // Si le mot de passe est valide, on fait cryptage avec fonction password_hash()
                }
                else
                {
                    $Message["notice"] = "Le mot de passe n'est pas identique!";

                    // On affiche la vue "inscription" en lui transmettant le tableau $Message :
                    $this->load->view('header');
                    $this->load->view('inscription', $Message);
                    $this->load->view('footer');
                    return;
                }

                /* Vérification si login saisi par utilisateur déjà existe dans la base de données ou non ?
                Pour cela on va charger le modèle 'UsersModel' qui se trouve dans le fichier UsersModel.php   */   
                $this->load->model('usersModel');

                // On charge le modéle en seul fois et ensuite on va utiliser plusieurs méthodes qui se trouvent dans cette modéle.

                // Ensuite on appelle la méthode user1() du modèle, qui retourne le tableau ayant les clés en forme d'objet 
                $result = $this->usersModel->user1();
                
                // Ici $result est un tableau qui contient : objet user_login et ses valeurs 
                
                foreach($result as $login)
                {
                    $aLogins[] = $login->user_login;   // ici user_login est un attribut de l'objet $login
                }
                
                if (in_array($user_login, $aLogins))
                {
                    $Message["notice"] = "Ce login déjà existe! Choissiez un autre !";
                    
                    // On affiche la vue "inscription" en lui transmettant le tableau $Message :
                    $this->load->view('header');
                    $this->load->view('inscription', $Message);
                    $this->load->view('footer');
                    return;

                    /* Pour rediriger le navigateur vers la méthode inscription() du contrôleur Users.php :  redirect("users/inscription");  */     
                } 
                
                /* Avant d'inserer les données en base de données il faut les contrôler. Pour cela on applique la librairie 'form_validation' 
                qui fonctionne comme suit : la méthode "set_rules()" cible un champ et y applique un ou plusieurs filtres de validation:    */
                $this->form_validation->set_rules("user_nom", "Nom", "required|min_length[2]");  
                
                /* 1er argument ("user_nom") indique le champ de formulaire à contrôler, indiquer l'attribut name du <input> 
                2ème argument ("Nom") précise un nom/libellé désignant le champ ciblé
                3ème argument : le filtre de contrôle à appliquer. Il est possible d'appliquer plusieurs filtres sur un même champ. 
                Pour se faire, il faut séparer les filtres en 3ème argument par le caractère: "|"
                Le filtre "required" inique que le champ est obligatoire (ici une valeur doit avoir été saisie pour le champ 'user_nom').
                Le filtre "min_length[2]" requiert une valeur d'au moins 2 caractères.  */
                
                $this->form_validation->set_rules("user_prenom", "Prenom", "required|min_length[1]");  
                $this->form_validation->set_rules("user_email", "Email", "required|min_length[8]"); 
                $this->form_validation->set_rules("user_login", "Login", "required|min_length[1]"); 
                $this->form_validation->set_rules("user_mdp", "Mot de passe", "required|min_length[1]");   
                $this->form_validation->set_rules("accepter", "Accepter", "required|min_length[1]");   
                                
                /* Si un filtre venait à manquer, on peut tenter de passer par les expressions régulières via le filtre regex_match[\regex\] 
                Exemple de filtre pour valider une date au format dd/mm/yyyy :
                $this->form_validation->set_rules('pro_d_ajout', 'Date', 'required|regex_match[\^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$\]');                                                        
                
                /* L'étape suivante est l'exécution de ce filtre, grâce à la méthode run(), qui va appliquer le filtre et 
                retourner TRUE si la valeur est correcte, ou FALSE dans le cas contraire:   */
                
                if ($this->form_validation->run() == FALSE)   // Echec de la validation
                { 
                    // Pour personnaliser le style des messages d'erreurs on utilise le style des alertes de Bootstrap 
                    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');  

                    redirect("users/inscription");   // Redirige le navigateur vers la méthode inscription() du contrôleur Users.php
                }
                else  // La validation a réussi, nos valeurs sont bonnes, on peut insérer en base de données
                {
                    /* Mais avant l'insertion en bdd avec la fonction PHP unset() on va supprimer les champs "user_mdp2" et 
                    "accepter" qui ne sont pas dans bdd  :   */  
                    unset($data["user_mdp2"]); 
                    unset($data["accepter"]);

                    // On peut insérer $data en base de données avec méthode insert() :
                    $this->db->insert('users', $data);    

                    /* Le premier argument ('users') est le nom de la table dans laquelle les données doivent être insérées.
                    Le second argument ($data) est le tableau contenant les données issues du formulaire d'inscription ('inscription.php').    
                    
                    ATTENTION! Le problème qui se pose avec l'utilisation de $this->db->insert('users', $data); c'est que les noms des colonnes 
                    de la table ciblée doivent être strictement identiques aux attibuts name des champs input, ce qui n'est pas toujours le cas.  */

                    redirect("users/login");   // Redirige le navigateur vers la méthode login() du contrôleur Users.php
                }
            }
            else  // 1er appel de la page: chargement de la vue 'inscription.php' et l'affichage du formulaire d'inscription
            {
                /* Chargement des différents vues
                Notez qu'une vue est apellée par son nom de fichier sans l'extension ".php"
                Attention! Les vues doivent être chargées dans l'ordre de leur affichage (ici header > inscription > footer) :    */
                $this->load->view('header');
                $this->load->view('inscription');   
                $this->load->view('footer');
            } 
        }





    }



?>
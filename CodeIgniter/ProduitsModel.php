<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

/* IMPORTANT
Dans le design pattern M.V.C. les requêtes SQL doivent se trouver dans les modèles. 
Comme pour un contrôleur, le nom de classe de modèle doit commencer par une majuscule et le fichier php doit porter 
le même nom, comme :  classe ProduitsModel et le fichier ProduitsModel.php . 
Il est recommandé d'ajouter le suffixe _model au nom de la classe (et donc au fichier aussi puisqu'ils doivent porter le même nom).
Comme on peut le voir, les modèles héritent la classe CI_model.
On va transférer les appels à la base de données (les requêtes SQL) du contrôleur Produits.php vers le modèle ProduitsModel.php .
Pour cela dans le modèle ProduitsModel.php on va écrire plusieurs méthodes pour effectuer différents requêtes SQL en base de données.
*/

/* ATTENTION
Le modèle contient généralement les méthodes qui effectuent les actions C.R.U.D. : il faudra écrire une méthode par action.
On pourra passer des arguments à ces méthodes pour exécuter des requêtes avec critères (clauses WHERE).
*/


class ProduitsModel extends CI_Model
{
    // liste() est une méthode destinée à sélectionner la liste des produits en base de données 
    public function liste() 
    {
        $this->load->database();  // Connexion à la base de données
        
        $requete = $this->db->query("SELECT * FROM produits");   // Requête de SELECT
        
        $aProduits = $requete->result();    // Récupération des résultats de la requête dans la variable $aProduits

        return $aProduits;            
    }



    // liste2() est une méthode destinée à sélectionner la liste des categories en base de données 
    public function liste2() 
    {
        $this->load->database();   // Connexion à la base de données

        $requete = $this->db->query("SELECT * FROM categories");   // Requête de SELECT
        
        $aCategories = $requete->result();   // Récupération des résultats de la requête dans la variable $aCategories

        return $aCategories;            
    }



    // liste3() est une méthode destinée à sélectionner la liste des produits avec critères (clauses WHERE) en base de données 
    public function liste3($pro_id) 
    {
        $this->load->database();   // Connexion à la base de données

        $requete = $this->db->query("SELECT * FROM produits WHERE pro_id=?", $pro_id);   // Requête de SELECT avec WHERE
        
        $aProduit = $requete->row();   // Récupération de la première ligne avec la méthode row() et on la mets dans tableau associatif $aProduit

        return $aProduit;            
    }



    // liste4() est une méthode destinée à sélectionner la liste des categories avec critères (clauses WHERE) en base de données 
    public function liste4($pro_cat_id) 
    {
        $this->load->database();   // Connexion à la base de données

        $requete = $this->db->query("SELECT * FROM categories WHERE cat_id=?", $pro_cat_id);   // Requête de SELECT avec WHERE
        
        $aCategorie = $requete->row();   // Récupération de la première ligne avec la méthode row() et on la mets dans tableau associatif $aCategorie

        return $aCategorie;            
    }




    // liste5() est une méthode destinée à supprimer la produit avec critères (clauses WHERE) en base de données 
    public function liste5($pro_id) 
    {
        $this->load->database();   // Connexion à la base de données
        
        $requete = $this->db->query("DELETE from produits WHERE pro_id=?", $pro_id);   // Requête DELETE avec WHERE

        $requete = $this->db->query("SELECT * FROM produits");   // Requête de SELECT
        
        $aProduits = $requete->result();    // Récupération des résultats de la requête dans la variable $aProduits

        return $aProduits;                      
    }


}   



/* Maintenant dans le contrôleur Produits.php on va remplacer notre connexion à la base et la requête SQL par l'utilisation de 
modèles (NOUVEAU CODE) comme suit :
    
    Chargement du modèle 
    $this->load->model('produitsModel');

    On appelle la méthode liste() du modèle, qui retourne le tableau de résultat ici affecté dans la variable $aListe (un tableau) 
    * remarque la syntaxe $this->nomModele->methode()       
    
    $aListe = $this->produitsModel->liste();

    $aView["liste"] = $aListe;

    $this->load->view('liste', $aListe);

    --  fin NOUVEAU CODE  --
*/





?>
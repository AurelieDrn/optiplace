<?php
require_once(__DIR__.'/ConnexionException.php');
require_once(__DIR__.'/TableAccesException.php');
require_once(__DIR__.'/../BEAN/Place.php');
require_once(__DIR__.'/../BEAN/Salle.php');
require_once(__DIR__.'/../BEAN/Etudiant.php');
require_once(__DIR__.'/../BEAN/GroupeEtudiant.php');
//require_once(__DIR__.'/../BEAN/SalleAvecEtudiants.php');

class Dao{

	private $connexion;

	//CONNECT TO THE DATABASE
	//Connexion à la base de donnée
	public function connexion(){ 
		try {
			$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
			$this->connexion = new PDO('mysql:host=localhost;dbname=optiplace','root','', $options);
		} catch (PDOException $e){
			throw new ConnexionException("Connexion impossible avec la base de données : " . $e->getMessage());
		}
	}

	//DISCONNECT FROM THE DATABASE
	//Déconexion de la base de donnée
	public function deconnexion(){
		$this->connexion = null;
	}
	
	//RETURN ARRAY OF STRING WITH ALL SALLES IN IT : "<SITE>-<NUMERO>"
	
	public function getAllSallesString() {
		$salles = array();
		try {
			$this->connexion(); //Connexion
			$request = $this->connexion->query("SELECT ID FROM salle order by id;"); 
			$answer = $request->fetchAll(PDO::FETCH_ASSOC); // On fetch tout ça
			foreach($answer as $salle){
				$salles[] = $salle['ID']; 
			}
		} 
		catch (ConnexionException $e){
			throw new ConnexionException("Connexion à la table impossible : " . $e->getMessage());
		} 
		catch (PDOException $e) {
			throw new TableAccesException("Accès à la table impossible : " . $e->getMessage());
		}
		$this->deconnexion(); 
		return $salles;
	}
	
	//CREATE AN OBJECT SALLE FROM DATABASE DATA
	//Créer un salle à partir de la base de donnée
	public function createSalleFromDB($id){
		$salle = null;
		try {
			$this->connexion(); //Connexion
			$request_salle = $this->connexion->query("SELECT * FROM salle where ID = '" . $id . "';");
			//Récupération de de la salle à l'id donnée
			if(($answer_salle = $request_salle->fetch()) !== FALSE){ //Si on récupère bien une salle
				$salle = new Salle($answer_salle['site'], $answer_salle['numero']); //On crée la salle à partir des informations obtenues
				//On récupère la représentation de la salle (toutes ses places)
				$request_places = $this->connexion->query("SELECT * FROM place where id_salle = '" . $id . "' order by x;");
				$answer_places = $request_places->fetchAll(PDO::FETCH_ASSOC); //On fetch
				
				$representation_salle = Array();
				for($i=0; $i <= $this->getMaxXForSalle($id); $i++){ // De 0 au plus grand X (colonnes)
					for($j=0; $j <= $this->getMaxYForSalle($id); $j++){ // De 0 au plus grand Y (lignes)
						foreach($answer_places as $place){ //Pour chaque place
							if ($place['x'] == $i && $place['y'] == $j) {
								//On crée les places à la coordonnée (x,y) qui ont cette coordonnée
								$representation_salle[$i][] = new Place($place['numero'], $place['level_attribution']); 
								
								break;
							}
						}
					}
				}
				$salle->updateRepresentation($representation_salle); //On met à jour la représentation
			} else {
				throw new TableAccesException("La table recherchée n'existe pas !"); //Si elle n'existe pas, on lance une erreur
			}
		} catch (ConnexionException $e){
			throw new ConnexionException("Connexion à la table impossible : " . $e->getMessage());
		} catch (PDOException $e) {
			throw new TableAccesException("Accès à la table impossible : " . $e->getMessage());
		}
		$this->deconnexion(); //Deconnexion
		return $salle;
	}
	
	//INSERT SALLE IN DATABASE FROM AN OBJECT SALLE
	//Créer une salle dans la base de donnée à partir d'un objet salle
	public function createDBfromSalle($salle){
		try {
			$this->connexion();
			$id = $salle->getSite() . "-" .$salle->getNumero(); //Création de l'ID
			#CREATION OF THE SALLE IN DATABASE
			//Création de l'entité salle associée à l'objet salle
			$request = $this->connexion->query("INSERT INTO salle(id, numero, site) VALUES('" . $id . "', '". $salle->getNumero() . "', '" . $salle->getSite() . "' );");
			$array = $salle->getRepresentation(); //Récupération de la représentation
			#IF WE HAVE A REPRESENTATION
			if ($array != null){
				#WE CREATE FOR EVERY PLACE IN THE REPRESENTATION A PLACE MODELISATION IN DATABASE
				for($i = 0; $i < count($array); $i++){ //De 0 à l'indice de la dernière ligne
					for ($j = 0; $j < min(array_map('count', $array)); $j++){ //De 0 à l'indice de la dernière colonne la plus petite 
					//Cette vérification est dû à la dynamicité de PHP et donc nous pourrions avoir une salle qui ne soit pas carré
					//Plutôt que d'inventer le reste de la salle, on prend la plus petite salle
					
						//DELETE IF A PLACE IS ALREADY SAVED AT THESE COORD FOR THIS SALLE IN THE DATABASE
						//Suppression de la salle si elle existe déjà dans la base de donnée 
						//On considère que 2 places sont pareilles si elles ont le même id de salle, le même x et le même y
						$placeUsed = $this->placeUsed($id, $i, $j); 
						if ($placeUsed != false){
							$this->connexion->query("DELETE FROM place WHERE id = ". $placeUsed[0]['ID'] .";");
						}
						
						#CREATION OF THE PLACE IN THE DATABASE
						$numero = $array[$i][$j]->getNumero(); //Récupération du numéro à l'indice voulu
						$levelAttri = $array[$i][$j]->getLevelAttribution(); //Récupération du niveau d'attribution (utilisable ou non)
						//Création de la place
						$request = $this->connexion->query("INSERT INTO place(id, id_salle, numero, x, y, level_attribution) VALUES('', '$id', $numero, $i, $j, $levelAttri);");
					}
				}
			}
		} catch (ConnexionException $e){
			throw new ConnexionException("Connexion à la table impossible : " . $e->getMessage());
		} catch (PDOException $e) {
			throw new TableAccesException("Accès à la table impossible : " . $e->getMessage());
		}
		$this->deconnexion(); //Deconnexion
	}
	
	#INSERT GROUPE IN DATABASE FROM A GROUPEETUDIANT OBJECT
	//Création d'une entité Groupe Etudiant dans la base de donnée à partir d'un objet GroupeEtudiant
	public function createDBfromGroupeEtu($groupe_etu){
		try {
			$this->connexion(); //Connexion
			$id = $groupe_etu->getID(); //Récupération de l'ID
			$dpt = $groupe_etu->getDepartement(); //Récupération du département
			$id_pere = ($groupe_etu->getPere() != null ? $groupe_etu->getPere()->getID() : -1); //Récupération de l'ID de son père, si il n'en a pas : id = -1
			$nom = $groupe_etu->getNom(); //récupération du nom du groupe d'étudiant
			//Création du groupe
			$request = $this->connexion->query("INSERT INTO groupe(nom, departement, id_pere, id) VALUES('$nom', '$dpt', '$id_pere', '$id');");
			$liste_etudiants = $groupe_etu->getEtudiants(); //Récupération de la liste d'étudiants présents dans le groupe
			
			if ($liste_etudiants != null) { //Si il y a des étudiants dans ce groupe
				for ($i = 0; $i < count($liste_etudiants); $i++) {
					$nom = $liste_etudiants[$i]->getNom();
					$prenom = $liste_etudiants[$i]->getPrenom();
					//On crée un étudiant pour chaque entité d'étudiant de cette liste
					$request = $this->connexion->query("INSERT INTO etudiant(ID, nom, prenom, id_groupe) VALUES('', '$nom', '$prenom', '$id');");
				}
			}
		} catch (ConnexionException $e){
			throw new ConnexionException("Connexion à la table impossible : " . $e->getMessage());
		} catch (PDOException $e) {
			throw new TableAccesException("Accès à la table impossible : " . $e->getMessage());
		}
		$this->deconnexion(); //Deconnexion
	}
	
	#GET A GROUPEETUDIANT FROM DATABASE
	//Récupération d'un GroupeEtudiant depuis la base de donnée A REFAIRE !! (AJOUTER L'HEREDITE)
	public function createGroupeEtufromDB($id){
		$groupe = null;
		try {
			$this->connexion(); //Connexion
			//Récupération du groupe
			$request_groupe = $this->connexion->query("SELECT * FROM groupe WHERE id = $id;");
			$answer_groupe = $request_groupe->fetch();
			
			$groupe = new GroupeEtudiant($answer_groupe['nom'], $answer_groupe['departement']);
			
			$request_etu = $this->connexion->query("SELECT * FROM etudiant WHERE id_groupe = $id;");
			$answer_etu  = $request_etu->fetchAll();
			$etudiants = Array();
			foreach($answer_etu as $etudiant) {
				$etudiants[] = new Etudiant($etudiant['nom'], $etudiant['prenom']);
			}
			
			$groupe->setEtudiants($etudiants);
		} catch (ConnexionException $e){
			throw new ConnexionException("Connexion à la table impossible : " . $e->getMessage());
		} catch (PDOException $e) {
			throw new TableAccesException("Accès à la table impossible : " . $e->getMessage());
		}
		$this->deconnexion();
		return $groupe;
	}
	
	public function getAllGroupeEtu(){
		$groupeEtu = array();
		try {
			$this->connexion();
			$request = $this->connexion->query("SELECT ID, id_pere FROM salle order by id;");
			$answer = $request->fetchAll(PDO::FETCH_ASSOC);
			foreach($answer as $groupe) {
				$groupeEtu[] = (isset($answer['id_pere']) ? $answer['id_pere'] . " > " . $answer['id'] : $answer['id']);
			}
		} catch (ConnexionException $e){
			throw new ConnexionException("Connexion à la table impossible : " . $e->getMessage());
		} catch (PDOException $e) {
			throw new TableAccesException("Accès à la table impossible : " . $e->getMessage());
		}
		$this->deconnexion();
		return $groupeEtu;
	}
	
	#### PRIVATE FUNCTION TO DISPATCH THE CODE #####
	
	#RETURN FALSE IF NOT USED AND AN ARRAY OF THE PLACE INFORMATION IF SO
	private function placeUsed($id_salle, $x, $y){
		try {
			$this->connexion();
			$request = $this->connexion->query("SELECT * FROM place WHERE id_salle = '$id_salle' AND x = $x AND y = $y;");
			return $request->fetchAll();
		} catch (ConnexionException $e){
			throw new ConnexionException("Connexion à la table impossible : " . $e->getMessage());
		} catch (PDOException $e) {
			throw new TableAccesException("Accès à la table impossible : " . $e->getMessage());
		}
		$this->deconnexion();
	}

	//GET THE HIGHEST X COORD FOR A GIVEN SALLE
	private function getMaxXForSalle($id){
		try {
			$this->connexion();
			$request = $this->connexion->query("SELECT x FROM place where id_salle = '" . $id . "' order by x DESC limit 0,1;");
			$answer = $request->fetch();
			return $answer['x'];
		} catch (ConnexionException $e){
			throw new ConnexionException("Connexion à la table impossible : " . $e->getMessage());
		} catch (PDOException $e) {
			throw new TableAccesException("Accès à la table impossible : " . $e->getMessage());
		}
		$this->deconnexion();
	}
	
	//GET THE HIGHEST Y COORD FOR A GIVEN SALLE
	private function getMaxYForSalle($id){
		try {
			$this->connexion();
			$request = $this->connexion->query("SELECT y FROM place where id_salle = '" . $id . "' order by y DESC limit 0,1;");
			$answer = $request->fetch();
			return $answer['y'];
		} catch (ConnexionException $e){
			throw new ConnexionException("Connexion à la table impossible : " . $e->getMessage());
		} catch (PDOException $e) {
			throw new TableAccesException("Accès à la table impossible : " . $e->getMessage());
		}
		$this->deconnexion();
	}
}
?>
<?php
require_once(__DIR__.'/ConnexionException.php');
require_once(__DIR__.'/TableAccesException.php');
require_once(__DIR__.'/../BEAN/Place.php');
require_once(__DIR__.'/../BEAN/Salle.php');
require_once(__DIR__.'/../BEAN/Etudiant.php');
require_once(__DIR__.'/../BEAN/GroupeEtudiant.php');


class Dao{

	private $connexion;

	// CONNECT TO THE DATABASE
	public function connexion(){ 
		try {
			$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
			$this->connexion = new PDO('mysql:host=localhost;dbname=optiplace','root','', $options);
		} catch (PDOException $e){
			throw new ConnexionException("Connexion impossible avec la base de données : " . $e->getMessage());
		}
	}

	// DISCONNECT FROM THE DATABASE
	public function deconnexion(){
		$this->connexion = null;
	}
	
	//RETURN ARRAY OF STRING WITH ALL SALLES IN IT : "<SITE>-<NUMERO>"
	public function getAllSallesString(){
		$salles = array();
		try {
			$this->connexion();
			$request = $this->connexion->query("SELECT * FROM salle order by id;");
			$answer = $request->fetchAll(PDO::FETCH_ASSOC);
			foreach($answer as $salle){
				$salles[] = $salle['ID'];
			}
		} catch (ConnexionException $e){
			throw new ConnexionException("Connexion à la table impossible : " . $e->getMessage());
		} catch (PDOException $e) {
			throw new TableAccesException("Accès à la table impossible : " . $e->getMessage());
		}
		$this->deconnexion();
		return $salles;
	}
	
	//CREATE AN OBJECT SALLE FROM DATABASE DATA
	public function createSalleFromDB($id){
		try {
			$this->connexion();
			$request_salle = $this->connexion->query("SELECT * FROM salle where ID = '" . $id . "';");
			$answer_salle = $request_salle->fetch();
			
			$salle = new Salle($answer_salle['site'], $answer_salle['numero']);
			
			$request_places = $this->connexion->query("SELECT * FROM place where id_salle = '" . $id . "' order by x;");
			$answer_places = $request_places->fetchAll(PDO::FETCH_ASSOC);
			
			$representation_salle = Array();
			for($i=0; $i <= $this->getMaxXForSalle($id); $i++){
				for($j=0; $j <= $this->getMaxYForSalle($id); $j++){
					foreach($answer_places as $place){
						if ($place['x'] == $i && $place['y'] == $j) {
							$representation_salle[$i][] = new Place($place['numero'], $place['level_attribution']);
							break;
						}
					}
				}
			}
			$salle->updateRepresentation($representation_salle);
		} catch (ConnexionException $e){
			throw new ConnexionException("Connexion à la table impossible : " . $e->getMessage());
		} catch (PDOException $e) {
			throw new TableAccesException("Accès à la table impossible : " . $e->getMessage());
		}
		$this->deconnexion();
		return $salle;
	}
	
	//CREATE A TABLE ENTITY SALLE FROM AN OBJECT SALLE
	public function createDBfromSalle($salle){
		try {
			$this->connexion();
			$id = $salle->getSite() . "-" .$salle->getNumero();
			#CREATION OF THE SALLE IN DATABASE
			$request = $this->connexion->query("INSERT INTO salle(id, numero, site) VALUES('" . $id . "', '". $salle->getNumero() . "', '" . $salle->getSite() . "' );");
			$array = $salle->getRepresentation();
			#IF WE HAVE A REPRESENTATION
			if ($array != null){
				#WE CREATE FOR EVERY PLACE IN THE REPRESENTATION A PLACE MODELISATION IN DATABASE
				for($i = 0; $i < count($array); $i++){
					for ($j = 0; $j < min(array_map('count', $array)); $j++){
					
						//DELETE IF A PLACE IS ALREADY SAVED AT THESE COORD FOR THIS SALLE IN THE DATABASE
						$placeUsed = $this->placeUsed($id, $i, $j);
						if ($placeUsed != false){
							$this->connexion->query("DELETE FROM place WHERE id = ". $placeUsed[0]['ID'] .";");
						}
						
						#CREATION OF THE PLACE IN THE DATABASE
						$numero = $array[$i][$j]->getNumero();
						$levelAttri = $array[$i][$j]->getLevelAttribution();
						$request = $this->connexion->query("INSERT INTO place(id, id_salle, numero, x, y, level_attribution) VALUES('', '$id', $numero, $i, $j, $levelAttri);");
					}
				}
			}
		} catch (ConnexionException $e){
			throw new ConnexionException("Connexion à la table impossible : " . $e->getMessage());
		} catch (PDOException $e) {
			throw new TableAccesException("Accès à la table impossible : " . $e->getMessage());
		}
		$this->deconnexion();
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

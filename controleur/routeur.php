<?php
require_once "controleurMenuAccueil.php";
require_once "controleurGererEtudiants.php";
require_once "controleurGererSalles.php";
require_once "controleurGererPlacement.php";
require_once __DIR__."/../modele/dao/Dao.php";

class Routeur {
	private $ctrlMenuAccueil;
	private $ctrlGererSalles;
	private $ctrlGererEtudiants;
	private $ctrlGererPlacement;

	public function __construct(){
		$this->ctrlMenuAccueil= new ControleurMenuAccueil();
		$this->ctrlGererSalles= new ControleurGererSalles();
		$this->ctrlGererEtudiants= new ControleurGererEtudiants();
		$this->ctrlGererPlacement= new ControleurGererPlacement();
	}

	//Traite une requête entrante
	public function routerRequete() {
		if(isset($_GET["menu"])){
			$this->ctrlMenuAccueil->accueilMenu();
		}
		else if(isset($_GET["placerPage"])){
			$this->ctrlGererPlacement->accueilPla();
		}
		else if(isset($_GET["etuPage"])){
			$this->ctrlGererEtudiants->accueilEtu();
		}
		else if(isset($_GET["sallesPage"])){
			$this->ctrlGererSalles->accueilSal();
		}
		else {
			$this->ctrlMenuAccueil->accueilMenu();
		}	
	}
}

?>

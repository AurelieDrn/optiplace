<?php
require_once "controleurGererEtudiants.php";
require_once "controleurGererSalles.php";
require_once "controleurGererPlacement.php";
require_once __DIR__."/../modele/dao/Dao.php";

class Routeur {
	private $ctrlGererSalles;
	private $ctrlGererEtudiants;
	private $ctrlGererPlacement;

	public function __construct(){
		$this->ctrlGererSalles= new ControleurGererSalles();
		$this->ctrlGererEtudiants= new ControleurGererEtudiants();
		$this->ctrlGererPlacement= new ControleurGererPlacement();
	}

	//Traite une requête entrante
	public function routerRequete() {
		if(isset($_GET["placerPage"])){
			$this->ctrlGererPlacement->accueilPla();
		}
		else if(isset($_GET["etuPage"])){
			$this->ctrlGererEtudiants->accueilEtu();
		}
		else if(isset($_GET["sallesPage"])){
			$this->ctrlGererSalles->accueilSal();
		}
		else if(isset($_GET["uploadSal"])) {
			$this->ctrlGererSalles->uploadSal();
		}
		else {
			$this->ctrlGererPlacement->accueilPla();
		}	
	}
}

?>

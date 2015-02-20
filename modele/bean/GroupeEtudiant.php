<?php

class GroupeEtudiant {

	private $nom;
	private $etudiants; //Liste d'Etudiant
	private $fils; //Liste des fils du groupe
	
	public function __construct($nom, $etudiants, $fils = null){
		$this->nom = $nom;
		$this->etudiants = $etudiants;
		$this->fils = $fils;
	}
	
	public function addFils($fils){
		$this->fils[] = $fils;
	}
	
	public function getNom(){
		return $this->nom;
	}
	
	public function getEtudiants(){
		return $this->etudiants;
	}
	
	public function getFils() {
		return $fils;
	}
}

?>

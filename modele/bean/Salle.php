<?php

class Salle {
	
	private $representation; //MATRICE DE PLACES
	private $site;
	private $numero;
	
	public function __construct($site, $numero, $represent = null){
		$this->representation = $represent;
		$this->numero = $numero;
		$this->site = $site;
	}
	
	public function updateRepresentation($csv_array) {
		$this->representation = $csv_array;
	}
	
	public function nbr_place_max() {
		$cpt = 0;
		foreach($this->representation as $line){
			foreach($line as $place){
				$cpt += ($place != -1 ? 1 : 0);
			}
			unset($place);
		}
		unset($line);
		return $cpt;
	}
	
	public function getRepresentation(){
		return $this->representation;
	}
	
	public function getNumero() {
		return $this->numero;
	}
	
	public function getSite(){
		return $this->site;
	}
	
	public function getNom(){
		return $this->site . " - " . $this->numero;
	}
}
?>

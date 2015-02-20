<?php
require_once __DIR__."/../vue/vueGererPlacement.php";

class ControleurGererPlacement{
	private $vue;
	
	public function __construct(){
		$this->vue=new VueGererPlacement();
	}
	
	public function accueilPla(){
		$this->vue->genereVueAccueilPla();
	}
}

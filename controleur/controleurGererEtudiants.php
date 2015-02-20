<?php
require_once __DIR__."/../vue/vueGererEtudiants.php";

class ControleurGererEtudiants{
	private $vue;
	
	public function __construct(){
		$this->vue=new VueGererEtudiants();
	}
	
	public function accueilEtu(){
		$this->vue->genereVueAccueilEtu();
	}
}

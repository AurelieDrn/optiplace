<?php
require_once __DIR__."/../vue/vueMenuAccueil.php";

class ControleurMenuAccueil{
	private $vue;
	
	public function __construct(){
		$this->vue=new VueMenuAccueil();
	}
	
	public function accueilMenu(){
		$this->vue->generevueMenuAccueil();
	}
}

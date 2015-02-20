<?php
require_once __DIR__."/../vue/vueGererSalles.php";

class ControleurGererSalles{
	private $vue;
	
	public function __construct(){
		$this->vue=new VueGererSalles();
	}
	
	public function accueilSal(){
		$this->vue->genereVueAccueilSal();
	}
	
	public function uploadSal() {
		$this->vue->genereVueUploadSal();
	}
}

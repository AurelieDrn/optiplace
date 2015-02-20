<?php
require_once __DIR__."/../vue/vueAuthentification.php";

class ControleurAuthentification{
	private $vue;
	
	public function __construct(){
		$this->vue=new VueAuthentification();
	}
	
	public function connexionDir(){
		$dao = new Dao();
		if($dao->verifieMotDePasse($_POST['login'], $_POST['mdp'])){
			$statut = $dao->getUser($_POST['login'])['statut'];
			$_SESSION["TD6TableauPanier"] =  new Panier();
			$_SESSION["TD6Connexion"] = true;
			$_SESSION["TD6USER"] = array("login"=> $_POST['login'], "statut"=>$statut);
			$_SESSION["TD6clicLivre"] = "";
			$this->connexionvalide();
		}
		else{
			$this->connexion();
		}
	}
	
	public function accueil(){
		$this->vue->genereVueAccueil();
	}
	
	public function connexion(){
		$this->vue->genereVueConnexion();
	}
	
	public function connexionvalide(){
		$this->vue->genereVueApresConnexion();
	}
}

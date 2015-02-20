<?php
require_once __DIR__."/../vue/vueAdmin.php";

class ControleurAdmin{
	private $vue;
	
	public function __construct(){
		$this->vue=new vueAdmin();
	}

	public function adminPanel(){
		$dao = new Dao();
		$_SESSION["TD6USERList"] = $dao->getUserList();
		$_SESSION["TD6TableauLivres"] = $dao->getListeLivre();
		$this->vue->genereVueAdmin();
	}
	
	public function editUser(){
		if(!empty($_POST['selectUser'])){
			$dao = new Dao();
			$_SESSION["EditUser"] = $dao->getUser($_POST['selectUser']);
		}
		$this->vue->genereVueEUser();
	}
	
	public function editLivre(){
		if(!empty($_POST['selectLivre'])){
			$dao = new Dao();
			$_SESSION["EditLivre"] = $dao->getLivre($_POST['selectLivre']);
		}
		$this->vue->genereVueELivre();
	}
	
}

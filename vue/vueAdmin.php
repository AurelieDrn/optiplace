<?php
require_once "util/utilitairePageHtml.php";

class VueAdmin{
	public function genereVueAdmin(){
		$utilitaireHtml=new UtilitairePageHtml();
		echo $utilitaireHtml->genereBandeauApresConnexion();
		echo '<div class = "content">';
		echo '<div class = "text">';
		echo '<div class = "subcontent">';
		echo '<h1>Panel admin</h1>';
		
		echo '<table>';
		echo '<form method="post" action="index.php">';
		echo '<tr>';
		
		echo '<td>';
		echo '<h2> Modifier les utilisateur : </h2>';
		echo '<select name="selectUser" multiple size=4 class="select">';
		foreach($_SESSION["TD6USERList"] as $user){
			echo '<option value="'.$user["login"].'">'.$user["identifiant"].'-'.$user["login"];
		}
		echo '</select>';
		echo '</td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '<td>';
		echo '</br><input type="submit" value="Modifier l\'utilisateur">';
		echo '</td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '<td>';
		echo '<form action="index.php" method="GET">';
		echo '<h2> Modifier les livres : </h2>';
		echo '<select name="selectLivre" multiple size=4 class="select">';
		foreach($_SESSION["TD6TableauLivres"] as $livre){
			echo '<option value="'.$livre->getIsbn().'"><p>'.$livre->getTitre().'</p>';
		}
		echo '</select>';
		echo '</td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '<td>';
		echo '</br><input type="submit" value="Modifier le livre">';
		echo'</td>';
		echo '</tr>';
		
		echo '</form>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo $utilitaireHtml->generePied();
	}
	
	public function genereVueEUser(){
		$utilitaireHtml=new UtilitairePageHtml();
		echo $utilitaireHtml->genereBandeauApresConnexion();
		$user = $_SESSION["EditUser"];
		
		echo '<div class = "content">';
		echo '<div class = "text">';
		echo '<div class = "subcontent">';
		echo '<h1>Panel admin</h1>';
		echo '<h2> Modifier un utilisateur : </h2>';
		
		echo '<table>';
		echo '<form method="post" action="index.php">';
		
		echo '<tr>';
		echo '<td class="usrmodif"><p><b> Pseudonyme : </b></p></td>';
		echo '<td><input type="text" name="login" id="login" size="30" maxlength="36" value='.$user["login"].'></td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '<td class="usrmodif"><p><b> Statut : </b></p></td>';
		echo '<td><select name="selectStatut" class="select">';
		if($user["statut"]=="user"){
			$selected1 ='selected';
			$selected2 ='';
		}
		else {
			$selected2 ='selected';
			$selected1 ='';
		}
		echo '<option value="user" '.$selected1.'> Utilisateur';
		echo '<option value="admin" '.$selected2.'> Administrateur </td>';
		echo '</tr>';
		echo '</table>';
		echo '</br>';
		echo '<table>';
		echo '<tr>';
		echo '<td class = "buttonEdit">';
		echo '<form method="post" action="index.php">';
		echo '<input type="submit" value=" Supprimer " onClick="return confirm(" Are you sure to delete the product ? ";)">';
		echo '</form>';
		echo '</td>';
		
		echo '<td class = "buttonEdit">';
		echo '<input type="submit" value="Modifier et sauvegarder">';
		echo '</td>';
		
		echo '</tr>';
		echo '</table>';
     
		echo '</form>';
		echo '</div>';
		
		echo '</div>';
		echo '</div>';
		echo $utilitaireHtml->generePied();
	}
	
	public function genereVueELivre(){
		$utilitaireHtml=new UtilitairePageHtml();
		echo $utilitaireHtml->genereBandeauApresConnexion();
		$livre = $_SESSION["EditLivre"];
		echo '<div class = "content">';
		echo '<div class = "text">';
		echo '<div class = "subcontent">';
		echo '<h1>Panel admin</h1>';
		echo '<h2> Modifier un livre : </h2>';
		
		echo '<p><b> Titre : </b>'.$livre->getTitre().'</p>';
		echo '<p><b> Auteur : </b>'.$livre->getAuteur().'</p>';
		echo '<p><b> ISBN : </b>'.$livre->getIsbn().'</p>';
		echo '<p><b> Quantite en stock : </b>'.$livre->getQuantite().'</p>';
		echo '<p><b> Prix : </b>'.$livre->getPrix().'</p>';
		echo '<p><b> Lien Image : </b>'.$livre->getImage().'</p>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo $utilitaireHtml->generePied();
	}
}

?>

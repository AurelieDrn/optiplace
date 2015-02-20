<?php

class UtilitairePageHtml{

public function baniere(){
	$baniere = '<body>';
	$baniere.= '<header>';
	$baniere.= '<div id="Baniere">';
	$baniere.= '<a href=index.php?menu="true"> <img src="images/OptiPlaceLogoVRouge.png"> </a>';
	$baniere.= '</div>';
	return $baniere;
}

public function generePied(){
	$pied= "</body>";
	$pied.= "</html>";
return $pied;
}

public function itemsBandeau(){
	/*
	$menu = '<nav id="menu">';
	$menu.= '<ul id="onglets">';
	$menu.= '<li class="item"><a href=index.php?placerPage="true"> Placer les étudiants </a></li>';  
	$menu.= '<li class="item"><a href=index.php?etuPage="true"> Gérer les étudiants </a></li>';
	$menu.= '<li class="item"><a href=index.php?sallesPage="true"> Gérer les salles </a></li>';        
	$menu.= '</ul></nav>';
	*/
	$menu = '</header>';
	return $menu;
}

public function genereEnteteHtml(){
	$entete = '<html>';
	$entete.= '<head>';
	$entete.= '<meta charset="utf-8">';
	$entete.= '<link href="vue/css/style.css" type="text/css" rel="stylesheet" />';
	$entete.= '</head>';	
	return $entete;
}

public function genereBandeau(){
	$entete=$this->baniere();
	$entete.=$this->genereEnteteHtml();
	$entete.=$this->itemsBandeau();
	return $entete;
}


}

?>

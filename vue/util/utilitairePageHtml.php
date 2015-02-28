<?php

class UtilitairePageHtml{

public function baniere(){
	$baniere = '<body style="background-color:#EEEEEE">';
	$baniere.= '<header>';
	$baniere.= '<div id="Baniere">';
	$baniere.= '<a href=index.php?menu="true"> <img src="vue/images/OptiPlaceLogoTranS.png"> </a>';
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
	//$entete.= '<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">';
	//$entete.='<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">';
	//$entete.='<script src="http://code.jquery.com/jquery.min.js"></script>';
	//$entete.='<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>';
	$entete.='<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">';
    $entete.='<link rel="stylesheet" href="https://bootflat.github.io/bootflat/css/bootflat.css">';
	$entete.='<script src="http://bootflat.github.io/js/site.min.js" type="text/javascript"></script>';
	$entete.='<link rel="stylesheet" href="css/site.min.css">';
	$entete.='<script src="vue/js/javascript.js"></script>';
	$entete.='<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.0/jquery.cookie.min.js"></script>';
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

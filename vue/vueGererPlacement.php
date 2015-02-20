<?php
	require_once "util/utilitairePageHtml.php";
	
	class VueGererPlacement{
		public function genereVueAccueilPla(){
			$utilitaireHtml=new UtilitairePageHtml();
			echo $utilitaireHtml->genereBandeau();
			echo '<div class = "content">';
			echo '<div class = "text">';
			echo '<div class = "subcontent">';
			echo "<h2> Placer les étudiants <h2>";
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo $utilitaireHtml->generePied();
		}
		
	}
	?>

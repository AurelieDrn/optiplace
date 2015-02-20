<?php
	require_once "util/utilitairePageHtml.php";
	
	class VueGererEtudiants{
		public function genereVueAccueilEtu(){
			$utilitaireHtml=new UtilitairePageHtml();
			echo $utilitaireHtml->genereBandeau();
			echo '<div class = "content">';
			echo '<div class = "text">';
			echo '<div class = "subcontent">';
			echo "<h2> Modifier les listes des étudiants <h2>";
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo $utilitaireHtml->generePied();
		}
		
	}
	?>

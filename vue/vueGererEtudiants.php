<?php
	require_once "util/utilitairePageHtml.php";
	
	class VueGererEtudiants{
		public function genereVueAccueilEtu(){
			$utilitaireHtml=new UtilitairePageHtml();
			// Display header
			echo $utilitaireHtml->genereBandeau();
			?>
				<div class="jumbotron">
					<h1>Gestion des étudiants</h1>	
				</div>
			<?php
			// Display footer
			echo $utilitaireHtml->generePied();
		}
		
	}
	?>

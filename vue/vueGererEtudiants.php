<?php
	require_once "util/utilitairePageHtml.php";
	
	class VueGererEtudiants{
		public function genereVueAccueilEtu(){
			$utilitaireHtml = new UtilitairePageHtml();
			// Display header
			echo $utilitaireHtml->genereBandeau();
			?>
			<div class="container documents">	
				<h1>Gestion des étudiants</h1>	
				
				<div class="col-md-3">
					<button type="button" class="btn btn-danger btn-block bouton-creer">Créer</button>
					<button type="button" class="btn btn-danger btn-block bouton-afficher">Afficher</button>
					<button type="button" class="btn btn-danger btn-block bouton-importer">Importer</button>
					<button type="button" class="btn btn-danger btn-block bouton-exporter">Exporter</button>
				</div>

				
			
			<?php
			// Display footer
			echo $utilitaireHtml->generePied();
		}
		
	}
	?>

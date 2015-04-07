<?php
	require_once "util/utilitairePageHtml.php";
	require_once "/../modele/dao/Dao.php";
	
	class VueGererSalles{
		public function genereVueAccueilSal() {
			$utilitaireHtml = new UtilitairePageHtml();
			// Display header
			echo $utilitaireHtml->genereBandeau();
			?>
			<div class="container documents">
				<h1>Gestion des salles</h1>	
				
				<div class="col-md-3">
					<button type="button" class="btn btn-danger btn-block bouton-creer">Créer</button>
					<button type="button" class="btn btn-danger btn-block bouton-afficher">Afficher</button>
					<button type="button" class="btn btn-danger btn-block bouton-importer">Importer</button>
					<button type="button" class="btn btn-danger btn-block bouton-exporter">Exporter</button>
				</div>

				<div class="col-md-9">
						<div class="well modal-creer cacher">Créer!</div>
						
						<!-- Affichage des salles -->
						<div class="well modal-afficher cacher">
							<div id="accordion" class="panel-group">
							<?php
								$id = 1;
								$dao = new Dao();
								$idSalles = $dao->getAllSallesString();
								foreach ($idSalles as $value) {
								?>
										<div class="panel panel-warning">
											<div class="panel-heading">
												<h4 class="panel-title">
													<?php
													// Nom de la salle
													echo "<a data-toggle='collapse' data-parent='#accordion' href='#collapse1'>".$value."</a>"
													?>
												</h4>
											</div>
											
											<!-- Affichage de la salle -->
											<div id="collapse1" class="panel-collapse collapse">
												<div class="panel-body">
													
												</div>
											</div>
										</div>
								<?php
								}
							?>
						
								<div class="panel panel-warning">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">1. What is HTML?</a>
										</h4>
									</div>

									<div id="collapse2" class="panel-collapse collapse">
										<div class="panel-body">
											<p>HTML stands for HyperText Markup Language. HTML is the main markup language for describing the structure of Web pages. <a href="http://www.tutorialrepublic.com/html-tutorial/" target="_blank">Learn more.</a></p>
										</div>
									</div>
								</div>

								<div class="panel panel-warning">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">2. What is Bootstrap?</a>
										</h4>
									</div>

									<div id="collapse3" class="panel-collapse collapse collapse">
										<div class="panel-body">
											<p>Bootstrap is a powerful front-end framework for faster and easier web development. It is a collection of CSS and HTML conventions. <a href="http://www.tutorialrepublic.com/twitter-bootstrap-tutorial/" target="_blank">Learn more.</a></p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="well modal-importer cacher">
							
						<div class="alert alert-info" role="alert"><strong>Important!</strong> Le fichier à importer doit être nommé de la façon suivante : &lt;site&gt; - &lt;numero&gt;.xlsx</div>		
							<!-- Form -->
							<form onSubmit="return testTypeFichier();" enctype="multipart/form-data" action="index.php?uploadSal=true" method="post">
								<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
							    <div class="input-group">
									<span class="input-group-btn">
										<span class="btn btn-primary btn-file">
											Parcourir <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span><input id="userfile" name="userfile" type="file" multiple>
										</span>
										<span class="btn btn-primary btn-file">
											Envoyer <span class=" glyphicon glyphicon-import" aria-hidden="true"></span><input type="submit" value="Envoyer le fichier" />
										</span>
									</span>
									<input type="text" class="form-control" readonly>
								</div>		
							</form>
						</div>
						<div class="well modal-exporter cacher">Exporter!</div>
				</div>	
			</div>	

			<?php
				echo $utilitaireHtml->generePied();
		}
		
		public function genereVueUploadSal() {
			// Display errors
			ini_set ("display_errors", "1");
			error_reporting(E_ALL);
				
			// Move uploaded file
			$new_path = 'modele/tmp/'.$_FILES['userfile']['name'];
			if (rename($_FILES['userfile']['tmp_name'], $new_path))
			{	
				require_once('vue/lib/PHPExcel.php');
				
				$reader = PHPExcel_IOFactory::createReader('Excel2007'); 
				$reader->setReadDataOnly(true);
				 
				$path = 'modele/tmp/'.$_FILES['userfile']['name'];
				$excel = $reader->load($path);
				 
				$writer = PHPExcel_IOFactory::createWriter($excel, 'CSV');
				
				$csvFile_path = 'modele/tmp/'.basename($_FILES['userfile']['name'], '.xlsx').'.csv';
				$writer->save($csvFile_path);
								
				// Delete old Excel file
				unlink('modele/tmp/'.$_FILES['userfile']['name']);
				
				// Redirect
				header('Location: index.php?sallesPage=true&msg=true');
			}
			else
			{
				// Redirect
				header('Location: index.php?sallesPage=true&msg=false');
			}
		}	
	}
	?>

	

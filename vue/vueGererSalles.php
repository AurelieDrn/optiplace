<?php
	require_once "util/utilitairePageHtml.php";
	
	class VueGererSalles{
		public function genereVueAccueilSal() {
			$utilitaireHtml=new UtilitairePageHtml();
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
					<?php							
						// Alert messages
						if (isset($_GET['msg'])) {
							if ($_GET['msg']) {
								echo '<div class="alert alert-success alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<strong>Bravo!</strong> Votre fichier a été téléchargé avec succès.
									</div>';
							}
							else {
								echo '<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<strong>Erreur!</strong> Le fichier n\'a pas pu être téléchargé.
									</div>';
							}
						}	
						if (isset($_GET['erreurType'])) {
							echo '<div class="alert alert-warning alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<strong>Attention!</strong> Le fichier doit être issu d\'une version Excel 2003 à 2010. 
									</div>';
						}
					?>
						<div class="well modal-creer cacher">Créer!</div>
						<div class="well modal-afficher cacher">Afficher!</div>
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
				
				// Redicrect
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
	

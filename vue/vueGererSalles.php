<?php
	require_once "util/utilitairePageHtml.php";
	
	class VueGererSalles{
		public function genereVueAccueilSal() {
			$utilitaireHtml=new UtilitairePageHtml();
			echo $utilitaireHtml->genereBandeau();
			?>
			<div class="jumbotron">
				<h1>Gestion des salles</h1>	
					<p>Ici, il vous sera possible d'importer une salle à partir d'un fichier Excel, de visualiser, de créer et d'exporter vos salles.</p>
			</div>
			
			<div class="panel-group" id="accordion">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#accordionOne">Importer une salle</a></h4>
					</div>
					<div id="accordionOne" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="alert alert-info" role="alert"><strong>Important!</strong> Le fichier à importer doit être nommé de la façon suivante : &lt;site&gt; - &lt;numero&gt;.xlsx</div>	
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
					</div>
				</div>
				<div class="panel panel-success">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#accordionTwo">Collapsible Accordion 2</a>
					  </h4>
					</div>
					<div id="accordionTwo" class="panel-collapse collapse">
						<div class="panel-body">
							Change does not roll in on the wheels of inevitability,
							but comes through continuous struggle.
							And so we must straighten our backs and work for
							our freedom. A man can't ride you unless your back is bent.
						</div>
					</div>
				</div>
				<div class="panel panel-warning">
					<div class="panel-heading">
					  <h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#accordionThree">Collapsible Accordion 3</a>
					  </h4>
					</div>
					<div id="accordionThree" class="panel-collapse collapse">
						<div class="panel-body">
							You must take personal responsibility.
							You cannot change the circumstances,
							the seasons, or the wind, but you can change yourself.
							That is something you have charge of.
						</div>
					</div>
				</div>
			</div>		
			
			<?php
				echo $utilitaireHtml->generePied();
		}
		
		public function genereVueUploadSal() {
			$utilitaireHtml=new UtilitairePageHtml();
			
			// Create header
			echo $utilitaireHtml->genereBandeau();
			?>
			<div class="jumbotron">
				<h1>Gestion des salles</h1>	
			</div>
			<?php
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
				
			//	Convert excel file to csv
			 
			// Various excel formats supported by PHPExcel library
			$excel_readers = array(
				'Excel5' ,
				'Excel2003XML' ,
				'Excel2007' ,
			);
			 
			// Create footer
			echo $utilitaireHtml->generePied();
		}	
	}
	?>
	

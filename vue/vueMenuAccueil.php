<?php
	require_once "util/utilitairePageHtml.php";
	
	class VueMenuAccueil{
		public function generevueMenuAccueil(){
			$utilitaireHtml=new UtilitairePageHtml();
			echo $utilitaireHtml->genereBandeau();
			?>
			<div id = "MenuContent">
				<table>
					<tr>
						<td class="cadre"><a href=index.php?placerPage="true">
							<div>
								<img src="vue/images/PlacementICN.png"></br>
								 Placer les étudiants
							</div>
						</a>
						</td>
						<td class="cadre"><a href=index.php?etuPage="true">
							<div>
								<img src="vue/images/EtudiantICN.png"></br>
								 Gérer les étudiants
							</div>
						</a>
						</td>
						<td class="cadre"><a href=index.php?sallesPage="true">
							<div>
								<img src="vue/images/AmphiICN.png"></br>
								 Gérer les salles
							</div>
						</a>
						</td>
					</tr>
				</table>
			</div>
		<?php
			echo $utilitaireHtml->generePied();
		}
		
	}
	?>

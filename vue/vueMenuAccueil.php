<?php
	require_once "util/utilitairePageHtml.php";
	
	class VueMenuAccueil{
		public function generevueMenuAccueil(){
			$utilitaireHtml=new UtilitairePageHtml();
			echo $utilitaireHtml->genereBandeau();
			?>
			<div id = "MenuContent2"> 
			   <div id="SubMenu"> 
			      Exemple de texte centré <br /> sur plusieurs lignes 
			   </div> 
			</div>
			<!--
			<div id = "MenuContent">
				<a href=index.php?placerPage="true"> Placer les étudiants </a>
				<a href=index.php?etuPage="true"> Gérer les étudiants </a>
				<a href=index.php?sallesPage="true"> Gérer les salles </a>
				<table>
					<tr>
						<td class="cadre"></td>
						<td class="cadre"></td>
						<td class="cadre"></td>
					</tr>
				</table>
		</div>
			-->
			<!--
			<div class = "content">
			<div class = "text">
			<div class = "subcontent">
				<table>
					<tr>
						<td><a href=index.php?placerPage="true"> Placer les étudiants </a></td>
						<td><a href=index.php?etuPage="true"> Gérer les étudiants </a></td>
						<td><a href=index.php?sallesPage="true"> Gérer les salles </a></td>
					</tr>
				</table>
			<h2> Modifier les salles <h2>
			</div>
			</div>
			</div>
			-->
		<?php
			echo $utilitaireHtml->generePied();
		}
		
	}
	?>

<?php
	function makeheader(){
		echo "<!DOCTYPE html>
		<html>

		  <head>
			  <title>Test</title>
		  </head>
			<body>
		";
	}

	function makefooter(){
		echo "
			</body>
		</html>";
	}

	function display_salle($salle){
			$tab = $salle->getRepresentation();
			$l = 0;
			echo '<center><h1>' . $salle->getNom() . '</h1></center>';
			echo '<table id = "tableSalle" align="center" valign="middle" >';
			foreach ($tab as $i){
				echo '<tr id = "trSalle">';
				foreach($i as $j){
					if($j[0] == -1){
						echo '<td bgcolor = "transparent" style="width: 20px; height: 20px"></td>';
					}
					else if($j[0] == 0){
						echo '<td bgcolor = "GREY" style="width:100px ; height: 60px"></td>';
					}
					else if($j[0] == 1){
						echo '<td bgcolor = "BLUE" style="width:100px ; height: 60px"><p> ' . $l . ' </p></td>';
					}
					else{
						echo '<td></td>';
					}
					$l++;
				}
				echo "</tr>";
			}
			echo '</table>';
	}
?>

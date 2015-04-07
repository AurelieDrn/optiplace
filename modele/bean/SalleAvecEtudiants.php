<?php 
	//Exportation en CSV
	//Ameliorer l'exportation PDF
	require_once __DIR__ . '/Place.php';
	require_once __DIR__ . '/Salle.php';
	require_once __DIR__ . '/Etudiant.php';
	require_once __DIR__ . '/GroupeEtudiant.php';
	require_once __DIR__ . '/SalleAvecEtudiantsException.php';

	class SalleAvecEtudiants {
		
		private $salle; //Salle
		private $etudiants; //GroupeEtudiant
		private $map; //Tableau assiocatif {numeroPlace => Etudiant}
		
		public function __construct($salle, $etudiants){
			if ($salle instanceof Salle && $etudiants instanceof GroupeEtudiant){
				$this->salle = $salle;
				$this->etudiants = $etudiants;
				if ($salle->getRepresentation() != null){
					if ($salle->nbr_place_max() < $etudiants->nbr_etudiants()){
						throw new SalleAvecEtudiantsException("Trop d'étudiants pour une si petite salle.");
					}
				} else {
					throw new SalleAvecEtudiantsException("La salle n'a pas de représentation !");
				}
			} else {
				throw new SalleAvecEtudiantsException("Respecter les classes suivantes => salles : Salle | etudiants : GroupeEtudiant !");
			}
			$map = array();
		}
		
		public function placer(){
			$liste_etu = $this->etudiants->getEtudiants();
			if ($this->salle->nbr_place_optimal() >= $this->etudiants->nbr_etudiants())
			{
				$places_opti = $this->salle->getPlacesOptimales();
				$MAX = ceil($this->salle->nbr_place_optimal() / floor($this->salle->nbr_place_optimal() / $this->etudiants->nbr_etudiants()));
				foreach($liste_etu as $etudiant) {
					do {
						$i = $places_opti[rand(0, ($MAX - 1))]->getNumero();
					} while (isset($this->map[$i]));
					$this->map[$i] = $etudiant;
				}
			} 
			else 
			{
				//PLACEMENT DES LIGNES GENERAL (1 place sur 2)
				$placesDispo = $this->salle->getPlacesDispo();
				$etuTMP = $this->etudiants->getEtudiants();
				
				$stop = False;
				for($i = 0; $i < 2; $i++){ 
					$places = $this->getPlacesDispoModLine($placesDispo, $i, 2);
					foreach($places as $row){
						$row_wanted = $this->getPlacesDispoModCol($row, 0, 2);
						foreach($row_wanted as $place){
							if(count($etuTMP) == 0){
								$stop = True;
								break;
							}
							$rand = rand(0, count($etuTMP) -1);
							$this->map[$place->getNumero()] = $etuTMP[$rand];
							unset($etuTMP[$rand]);
							$etuTMP = array_values($etuTMP);
						}
						if ($stop){
							break;
						}
					}
					if ($stop){
						break;
					}
				}
				unset($places);
				
				//REMPLISSAGE
				if(!$stop){
					$impair = True;
					$posMod = 1;
					while(count($etuTMP) > 0){
						foreach($placesDispo as $row){
							if ($impair){
								$posMod = 1;
							} else {
								$posMod = 3;
							}
							$line = $this->getPlacesDispoModCol($row, $posMod, 4);
							foreach($line as $place){
								if (count($etuTMP) == 0){
									break;
								}
								$rand = rand(0, count($etuTMP) - 1);
								$this->map[$place->getNumero()] = $etuTMP[$rand];
								unset($etuTMP[$rand]);
								$etuTMP = array_values($etuTMP);
							}
							$impair = !$impair;
						}
						$impair = !$impair;
						if (count($etuTMP) == 0){
							break;
						}
					}
				}
			}
			asort($this->map);
		}
		
		// RETOURNE LES PLACES UTILISABLE QUI SONT A UN CERTAIN ENDROIT (comme nous travaillons avec des matrices : nous utilisons des modulos)
		// row : ligne sur laquelle nous allons travailler
		private function getPlacesDispoModCol($row, $posMod, $mod) {
			$places_mod_n = Array();
			$j = 0;
			foreach($row as $place){
				if ($j % $mod == $posMod){
					$places_mod_n[] = $place;
				}
				$j++;
			}
			return $places_mod_n;
		}
		
		// mat : matrices sur laquelle nous allons travailler
		private function getPlacesDispoModLine($mat, $posMod, $mod) {
			$places_l = Array();
			$i = 0;
			foreach($mat as $row){
				if ($i % $mod == $posMod){
					$places_l[] = $row;
				}
				$i++;
			}
			return $places_l;
		}
		
		private function nombrePlaceEntreEtu(){
			$nombreEtu = $etudiants->nbr_etudiants();
			$nombrePlace = $salle->nbr_place_max();
			$nbrplaceetu = $nombrePlace / $nombreEtu;
			return (floor($nbrplaceetu) == $nbrplaceetu ? $nbrplaceetu - 1 : floor($nbrplaceetu));	
		}
		
		private function proportionPlaceEtu() {
			return ($salle->nbr_place_max() / $etudiants->nbr_etudiants());
		}
		
		public function getEtudiants(){
			return $this->etudiants;
		}
		
		public function getSalle() {
			return $this->salle;
		}
		
		public function getPlacementEtudiants() {
			return $this->map;
		}
	}

?>
<?php

class Place {

	private $numero;
	private $level_attribution;
	
	public function __construct($numero, $level_attribution){
		$this->numero = $numero;
		$this->level_attribution =$level_attribution;
	}
	
	public function getNumero(){
		return $this->numero;
	}
	
	public function getLevelAttribution(){
		return $this->level_attribution;
	}
	
	public function toString() {
		return $this->numero . " : " . $this->level_attribution;
	}
}

?>

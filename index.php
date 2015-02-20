<?php

require_once "controleur/routeur.php";
session_start();
$routeur=new Routeur();

$routeur->routerRequete();

?>

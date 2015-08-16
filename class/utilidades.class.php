<?php
/*
*Nombre del módulo: Utilidades
*Objetivo: Utilidades para el desarrollo de los moduos de proyectos, eventos y streaming
*Dirección física: /plugins/plugin-sigoes/class/utilidades.class.php
*/

/*Inicio de Funcion para obtener url en formato correcto*/
 	function nowww($text) {
 		$word = array(
 		"http://" => "",
 		"www." => "",
 		);
 		
 		foreach ($word as $bad => $good) {
 		$text = str_replace($bad, $good, $text);
 		}
 		$oldurl = explode("/", $text);
 		$newurl = $oldurl[0];
 		$text = "$newurl";
 		$text = strip_tags(addslashes($text));
 		return $text;
 	}
/*Fin de Funcion para obtener url en formato correcto*/

/*Funciones de Validación*/

?>
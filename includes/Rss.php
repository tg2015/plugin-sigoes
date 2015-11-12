<?php
/*
*Nombre de la clase: Rss
*Objetivo: Operaciones sobre los feed del Modulo SIGOES 
*Dirección física: /plugins/plugin-sigoes/includes/Rss.php
*/

require_once 'Utilidad.php';

class Rss
{
	public function __Construct()   
    {
    	set_time_limit(20);
    }

	public function obtenerFeed($url)
	{
		/*Inicio Validar si las entradas del feed son validas*/
		libxml_use_internal_errors(true);
				//Creamos la variable $rss para cargar el feed xml
				$rss = new DOMDocument();
				//cargamos el documento
				$rss->load($url);

		if (strpos($http_response_header[0], '404')) {
    		wp_die('Archivo No Encontrado.');
			}
		/*Fin Validar si las entradas del feed son validas*/
		$feed = array();
		foreach ($rss->getElementsByTagName('item') as $node) {
		$item = array ( 
			'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
			'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
			'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
			'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
			'category' => $node->getElementsByTagName('category')->item(0)->nodeValue,
			'content' => $node->getElementsByTagName('encoded')->item(0)->nodeValue
			);
			//feed es un arreglo que recibe los elementos leidos del feed xml
			array_push($feed, $item);
			}
		//retorna el arreglo feed a los widgets
		return $feed;
		}

}
?>
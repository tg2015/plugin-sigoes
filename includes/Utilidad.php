<?php
/*
*Nombre del módulo: Utilidad
*Objetivo: Utilidad extraer urls, chequeo de Estado de Servidor
*Dirección física: /plugins/plugin-sigoes/includes/Utilidad.php
*/

/*Inicio de Funcion para obtener url en formato correcto*/
class Utilidad
{
    function nowww($url) {
 		$word = array(
 		"http://" => "",
 		"www." => "",
 		);
 		
 		foreach ($word as $bad => $good) {
 		$url = str_replace($bad, $good, $url);
 		}
 		$oldurl = explode("/", $url);
 		$newurl = $oldurl[0];
 		$url = "$newurl";
 		$url = strip_tags(addslashes($url));
 		return $url;
 	}

/*Fin de Funcion para obtener url en formato correcto*/

/*Inicio de Funcion para Verificar que Url este activa*/
/*para que funcione debe de ser instalada la libreria curl de php
sudo apt-get install php5-curl*/
function chequearUrl($url)
{
    if($url == NULL) 
    {
    return false; 
    }
    $ch = curl_init($url);  
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
    $data = curl_exec($ch);  
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
    curl_close($ch);  
    if($httpcode>=200 && $httpcode<304){  
        return true; 
    } else {  
        return false;   
    }
    //echo $httpcode;
}
/*Fin de Funcion para Verificar que Url este activa*/

/*Inicio de Funcion para contar los proyectos de un tipo, streaming, eventos, otros*/
function contarProyectos($tipoProyecto, $feed)
{
        $limite = count($feed);
        $proyectos=0;
        for($i=0;$i<$limite;$i++) 
        {
        $categoria = $feed[$i]['category'];
        if($categoria==$tipoProyecto)
            {
             $proyectos++;
            }
        }
        return $proyectos;
}
/*Fin de Funcion para contar los proyectos de un tipo, streaming, eventos, otros*/

/*Inicio de Funcion para obtener src de imagen en formato correcto*/
function extraersrc($description){
    $description=strip_tags($description, '<img>');
    if(!empty($description))
        {
        $doc = new DOMDocument();
        $doc->loadHTML($description);
        $xpath = new DOMXPath($doc);
        $src = $xpath->evaluate("string(//img/@src)");
        }
    return $src;
    }
/*Fin de Funcion para obtener src de imagen en formato correcto*/

/*Inicio de Funcion para obtener url*/
function extraerUrl($description){
    preg_match('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $description, $match);
    $dir=$match[0];
    return ($dir);
}
/*Fin de Funcion para obtener url*/

/*Inicio de Funcion para extraer el primer enlace dentro de una descripcion*/
function extraerEnlace($description)
{
    $vinculo=strip_tags($description, '<a>');
    preg_match('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $vinculo, $matches);
    $enlace = $matches[0];
    return $enlace;
}
/*Fin de Funcion para extraer el primer enlace dentro de una descripcion*/


/*Funciones de Validación*/
/*
\d digitos decimales
\w cualquier caracter, tildes,ñ,_,digitos...
\s caracter en blanco , tabulación, retorno, nueva linea.
\D inversa de \d
\W inversa w
\S inversa s
 
i no distingue mayúsculas minúsculas
 
*/
 
function resultado($valor)
    {
    if ($valor)
        echo "<p>El patron esta contenido en la cadena</p>";
         
    else
        echo "<p>El patron <b>no</b> esta contenido en la cadena</p>";
    }
 
/*
Esta regla es para permitir usuarios de 4 hasta 28 caracteres de longitud, alfanuméricos y permitir guiones bajos.
*/
function validar_nombre_usuario ($nombre)
    {
    resultado(preg_match('/^[a-z\d_]{4,28}$/i', $nombre)); 
    }
 
 
function validar_nombre_completo ($nombre)
    {
    resultado(preg_match('/^[a-zñÑáéíóú\d_\s]{4,28}$/i', $nombre)); 
    }
     
/*Números telefónicos
Esto es para validar números de teléfono españoles sin código de pais es decir: 924870975
*/
function validar_telefono ($telefono)
    {
    resultado(preg_match('/^[0-9]{9,9}$/', $telefono)); 
    }
/*
Esta función valida un email de esta forma:
Primer caracter, no será un número
Luego cualquier caracter normal numero letra . _ tantas veces como sea (no puede ser arroba)
Luego una arroba
Cualquier caracter normal incluyendo _  pero no el . por lo menos de longitud. Seguido de cualquier caracter normal incluido el punto tantas veces como sea.
Necesariamente deberá acabar en . y estará seguido de caracteres mayusculas o minuscula de longitud 2 o 4.
*/
function validar_email ($email)
    {
    resultado(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)); 
    }
 
/*
fución que valida fechas dd/mm/anio
*/
function validar_fecha ($fecha)
    {
    resultado(preg_match('/^(\d\d\/\d\d\/\d\d\d\d){1,1}$/', $fecha));
    }
function validar_web ($url)
    {
    if (strlen($url)>0)
        return (preg_match('/^[http:\/\/|www.|https:\/\/]/i', $url));
    return TRUE;
    }
}

?>
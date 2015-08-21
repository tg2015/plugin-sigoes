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


?>
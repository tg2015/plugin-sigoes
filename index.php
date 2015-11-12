<?php

/*
Plugin Name: plugin-sigoes
Plugin URI: http://modulos.egob.sv
Description: Plugin para la implementacion de modulos de proyectos, eventos coyunturales, transmision de streaming y otros
Author: Equipo de desarrollo SIGOES
Author URI: http://modulos.egob.sv
*/


/**
 * Registrar Clases a utilizar dentro del Plugin
 **/
define('SIGOES_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('Servidor', 'http://modulos.egob.sv/');
define('INDEX', __FILE__);
require_once (SIGOES_PLUGIN_DIR.'controller/EventoController.php');
require_once (SIGOES_PLUGIN_DIR.'controller/ProyectoController.php');
require_once (SIGOES_PLUGIN_DIR.'controller/StreamingController.php');
require_once (SIGOES_PLUGIN_DIR.'controller/OtroController.php');
require_once (SIGOES_PLUGIN_DIR.'controller/ComunicadoController.php');

/**
 * Registrar Plugin y Widgets
 **/
add_action('widgets_init','register_wp_my_plugin');
function register_wp_my_plugin(){
    register_widget('EventoController');
    register_widget('ProyectoController');
    register_widget('StreamingController');
    register_widget('OtroController');
}



/**
 * Registrar hojas de estilos
 **/

add_action( 'wp_enqueue_scripts', 'registrar_css' );
function registrar_css() 
{
    wp_register_style( 'estilo', plugins_url( 'plugin-sigoes/includes/css/estilo.css' ) );
    wp_enqueue_style( 'estilo' );

    wp_register_style( 'slide', plugins_url( 'plugin-sigoes/includes/css/slide.css' ) );
    wp_enqueue_style( 'slide' );

    wp_register_style( 'eventos', plugins_url( 'plugin-sigoes/includes/css/li-scroller.css' ) );
    wp_enqueue_style( 'eventos' );
     
}

/**
 * Registrar scripts
 **/

add_action('init','registrar_jquery');
function registrar_jquery(){

$jslibs = array('jquery');
 foreach($jslibs as $lib) wp_enqueue_script($lib);
}

add_action( 'wp_enqueue_scripts', 'registrar_js' );
function registrar_js()
{    

    wp_register_script( 'jquery.min', plugins_url('plugin-sigoes/includes/js/jquery.min.js') );
    wp_enqueue_script( 'jquery.min' );
    //utilizado para animacion de carrusel cycle2 y cycle2.carousel
    wp_register_script( 'jquery.cycle2', plugins_url('plugin-sigoes/includes/js/jquery.cycle2.js') );
    wp_enqueue_script( 'jquery.cycle2' );

    wp_register_script( 'jquery.cycle2.carousel', plugins_url('plugin-sigoes/includes/js/jquery.cycle2.carousel.js') );
    wp_enqueue_script( 'jquery.cycle2.carousel' );
    //animacion eventos coyunturales
    wp_register_script( 'jqueryliscroller', plugins_url('plugin-sigoes/includes/js/jquery.li-scroller.1.0.js') );
    wp_enqueue_script( 'jqueryliscroller' );
    
}


?>
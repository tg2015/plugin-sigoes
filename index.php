<?php

/*
Plugin Name: plugin-sigoes
Plugin URI: http://modulos.egob.sv
Description: Plugin para la implementacion de modulos de proyectos, eventos coyunturales y transmision de streaming
Author: Equipo de desarrollo SIGOES
Author URI: http://modulos.egob.sv
*/


/**
 * Registrar Clases a utilizar dentro del Plugin
 **/
require_once 'class/postthumbnails.class.php';
require_once 'class/eventos.class.php';
require_once 'class/proyectos.class.php';
require_once 'class/streaming.class.php';


/**
 * Registrar Plugin y Widgets
 **/
add_action('widgets_init','register_wp_my_plugin');
function register_wp_my_plugin(){
    register_widget('eventos');
    register_widget('proyectos');
    register_widget('streaming');
}



/**
 * Registrar hojas de estilos
 **/

add_action( 'wp_enqueue_scripts', 'registrar_css' );
function registrar_css() 
{
    wp_register_style( 'mod', plugins_url( 'plugin-sigoes/public/css/mod.css' ) );
    wp_enqueue_style( 'mod' );

    wp_register_style( 'js-image-slider', plugins_url( 'plugin-sigoes/public/css/js-image-slider.css' ) );
    wp_enqueue_style( 'js-image-slider' );

    wp_register_style( 'slide', plugins_url( 'plugin-sigoes/public/css/slide.css' ) );
    wp_enqueue_style( 'slide' );
     
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
    
    wp_register_script( 'js-image-slider', plugins_url('plugin-sigoes/public/js/js-image-slider.js') );
    wp_enqueue_script( 'js-image-slider' );


    wp_register_script( 'jquery.min', plugins_url('plugin-sigoes/public/js/jquery.min.js') );
    wp_enqueue_script( 'jquery.min' );

    wp_register_script( 'jquery.cycle2', plugins_url('plugin-sigoes/public/js/jquery.cycle2.js') );
    wp_enqueue_script( 'jquery.cycle2' );

    wp_register_script( 'jquery.cycle2.carousel', plugins_url('plugin-sigoes/public/js/jquery.cycle2.carousel.js') );
    wp_enqueue_script( 'jquery.cycle2.carousel' );
   
}


/**
 * Registrar scripts en pie de pagina
 **/
add_action('wp_footer','activate_gallery');
function activate_gallery() {
?>

 <script type="text/javascript">

 </script>

<?php
}


?>
<?php

/*
Plugin Name: plugin-sigoes
Plugin URI: http://modulos.egob.sv
Description: Plugin para la implementacion de modulos de proyectos, eventos coyunturales y transmision de streaming
Author: Equipo de desarrollo SIGOES
Author URI: http://modulos.egob.sv

*/

require_once 'class/postthumbnails.class.php';
require_once 'class/eventos.class.php';
require_once 'class/proyectos.class.php';
require_once 'class/streaming.class.php';

add_action('widgets_init','register_wp_my_plugin');
function register_wp_my_plugin(){
    register_widget('eventos');
    register_widget('proyectos');
    register_widget('streaming');
}



/**
 * Registrar hoja de estilos
 **/
/*
add_action( 'wp_enqueue_scripts', 'register_plugin_styles' );
function register_plugin_styles() {
    wp_register_style( 'sigoes_gallery', plugins_url( 'plugin-sigoes/public/css/galeria.css' ) );
    wp_enqueue_style( 'sigoes_gallery' );
}
*/

add_action( 'wp_enqueue_scripts', 'registrar_css' );
function registrar_css() {
    wp_register_style( 'sigoes_css', plugins_url( 'plugin-sigoes/public/css/ninja-slider.css' ) );
    wp_enqueue_style( 'sigoes_css' );

    wp_register_style( 'iframe_css', plugins_url( 'plugin-sigoes/public/css/iframe.css' ) );
    wp_enqueue_style( 'iframe_css' );
}

add_action( 'wp_enqueue_scripts', 'registrar_js' );
function registrar_js()
{
    wp_register_script( 'sigoes_js', plugins_url( 'plugin-sigoes/public/js/ninja-slider.js' ) );
    wp_enqueue_script( 'sigoes_js' );
}


/*
add_filter( 'the_excerpt_rss', 'wcs_post_thumbnails_in_feeds' );
add_filter( 'the_content_feed', 'wcs_post_thumbnails_in_feeds' );
function wcs_post_thumbnails_in_feeds( $content ) {
    global $post;
    if( has_post_thumbnail( $post->ID ) ) {
        $content = '<p>' . get_the_post_thumbnail( $post->ID ) . '</p>' . get_the_content();
    }
    return $content;
}
*/


?>
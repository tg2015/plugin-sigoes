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
 * Registrar hojas de estilos
 **/


add_action( 'wp_enqueue_scripts', 'registrar_css' );
function registrar_css() 
{
    
    wp_register_style( 'carousel', plugins_url( 'plugin-sigoes/public/css/carousel.css' ) );
    wp_enqueue_style( 'carousel' );

    wp_register_style( 'mod', plugins_url( 'plugin-sigoes/public/css/mod.css' ) );
    wp_enqueue_style( 'mod' );
}

/**
 * Registrar scripts
 **/

add_action( 'wp_enqueue_scripts', 'registrar_js' );
function registrar_js()
{    
    
    wp_register_script( 'jquery_min', plugins_url('plugin-sigoes/public/js/jquery.min.js') );
    wp_enqueue_script( 'jquery_min' );

    wp_register_script( 'jquery_roundabout', plugins_url('plugin-sigoes/public/js/jquery.roundabout.min.js') );
    wp_enqueue_script( 'jquery_roundabout' );

}

 
add_action('wp_footer','activate_gallery');
function activate_gallery() {
?>
 
    <script type="text/javascript">
    (function($) {

    var $descriptions = $('#carousel-descriptions').children('li'),
        $controls = $('#carousel-controls').find('span'),
        $carousel = $('#carrusel')
            .roundabout({childSelector:"img", minOpacity:1, autoplay:true, autoplayDuration:2000, autoplayPauseOnHover:true })
            .on('focus', 'img', function() {
                var slideNum = $carousel.roundabout("getChildInFocus");
            
                $descriptions.add($controls).removeClass('current');
                    $($descriptions.get(slideNum)).addClass('current');
                $($controls.get(slideNum)).addClass('current');
            });

        $controls.on('click dblclick', function() {
            var slideNum = -1,
            i = 0, len = $controls.length;

        for (; i<len; i++) {
            if (this === $controls.get(i)) {
            slideNum = i;
            break;
            }
         }
    
        if (slideNum >= 0) {
            $controls.removeClass('current');
            $(this).addClass('current');
            $carousel.roundabout('animateToChild', slideNum);
        }
        });

    }(jQuery));
    </script>
     
<?php
}


?>
<?php
/*
*Nombre del módulo: ComunicadoController
*Objetivo: Crear el Acuse de Recibo en las paginas institucionales
*Dirección física: /plugins/plugin-sigoes/controller/ComunicadoController.php
*/
/*class ComunicadoController
{
	public function __Construct()   
    {

    }
 */

/**
 * Verificando Estado de Servidor
 **/
if(Utilidad::chequearUrl(Servidor."feed"))
    {
        define('estadoServidor', true);       
    }
    else {
        define('estadoServidor', false);    
     } 

/**
 * crear ACK de instalacion de plugin en Feed de Institucion
 **/
add_action('init','crearACK');
function crearACK()
{

//$args = array('post_type' => "post", 'nopaging' => true, 'post_status' => 'publish');
$args = array('post_type' => "post", 'orderby' => 'date', 'order' => 'DESC', 'post_status' => 'publish');
$mis_posts= get_posts( $args );

require_once(SIGOES_PLUGIN_DIR.'/model/ComunicadoModel.php');//Modelo Para comunicados
$model = new  ComunicadoModel(); //Instanciar La clase ComunicadoModel
$resultado = $model->get_Categoria("sin-categoria");

$instalado=0;
$ip=get_site_url();  
foreach ( $mis_posts as $mi_post ) 
{
        $titulo=$mi_post->post_title;
        if($titulo=='plugin-sigoes')
        {
        $instalado=1;
        $ID=$mi_post->ID;
        $update_post = array(
        'ID'            =>     $ID,
        'post_content'  => 'version 1.0/'.$ip,
        'post_date'     => the_date(),
        'post_date_gmt'     => the_date(),
        'post_category' => array($resultado)
         );
        $post_id=wp_update_post( $update_post );
        }
}

if ($instalado==0)
{
    global $user_ID;

    $new_post = array(
    'post_title'    => 'plugin-sigoes',
    'post_content'  => 'version 1.0/'.$ip,
    'post_status'   => 'publish',
    'post_date'     => the_date(),
    'post_author'   => $user_ID,
    'post_type'     => 'post',
    'comment_status'  => 'closed',
    'post_category' => array($resultado));
    $post_id = wp_insert_post( $new_post );
}

global $pagenow;
    //echo $pagenow;
if ( in_array( $pagenow, array( 'edit.php' ) ) )
    {
      //echo ">Entro post-new  ";
     echo '
     <style type="text/css">
        #post-'.$post_id.'{ display:none; }
    </style>
            ';
    }

}

/**
 * Borrar ACK de instalacion de plugin en Feed de Institucion al desinstalar
 **/
register_uninstall_hook( INDEX, 'borrarACK' );
function borrarACK()
{
	$args = array('post_type' => "post", 'orderby' => 'date', 'order' => 'DESC', 'post_status' => 'publish');
	$mis_posts= get_posts( $args );
	foreach ( $mis_posts as $mi_post ) 
	{
        $titulo=$mi_post->post_title;
        if($titulo=='plugin-sigoes')
        {
        	$ID=$mi_post->ID;
        	wp_delete_post($ID, true);
        }
    }
}

//}
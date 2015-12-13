<?php
/*
*Nombre del módulo: ProyectoController
*Objetivo: Mostrar los proyectos realizados por la presidencia de El Salvador
*Dirección física: /plugins/plugin-sigoes/controller/ProyectoController.php
*/

require_once SIGOES_PLUGIN_DIR.'/includes/Utilidad.php';
require_once SIGOES_PLUGIN_DIR.'/includes/Rss.php';

class ProyectoController extends WP_Widget 

{
/*Inicio de Funcion Constructor de Widget Proyectos*/
	public function __construct() {

		parent::WP_Widget(

			'proyectos', 
			
			__('sigoes-proyectos'), 

			array('description'=>'proyectos', 'class'=>'codewrapperwidget')

		);

	}
/*Fin de Funcion Constructor Proyectos*/
	

/*Inicio de Funcion para crear el Form de Proyectos*/
	/**
	 * @param type $instance
	 */
	public function form($instance)

	{
		$default = array( 

			'titulo' => __(''),

			'url'=> __('')

			);

		$instance = wp_parse_args( (array)$instance, $default );

		echo "\r\n";

		echo "<p>";
		echo "<label for='".$this->get_field_id('titulo')."'>" . __('Titulo') . ":</label> " ;
		echo "<input type='text' class='widefat' id='".$this->get_field_id('titulo')."' name='".$this->get_field_name('titulo')."' value='" . esc_attr($instance['titulo'] ) . "' />" ;
		echo "</p>";
		echo "<p>";
		echo "<label for='".$this->get_field_id('url')."'>" . __('url del sitio web') . ":</label> " ;
		echo "<input type='text' class='widefat' id='".$this->get_field_id('url')."' name='".$this->get_field_name('url')."' value='" . esc_attr( $instance['url'] ) . "' placeholder='http://www' />" ;
		echo "</p>";

	}
/*Fin de Funcion para crear el Form de Proyectos*/
		

/*Inicio de Funcion para Actualizar Datos de Formulario*/
	/**
	 * @param type $new_instance
	 * @param type $old_instance
	 * @return type
	 */

	public function update($new_instance, $old_instance) 

	{
		$instance = $old_instance;
		$instance['titulo'] = strip_tags($new_instance['titulo']);
		$instance['url'] = $new_instance['url'];
		return $instance;

	}
/*Fin de Funcion para Actualizar Datos de Formulario*/
		

/*Inicio de Funcion para Mostrar el Widget Actual*/
	/**
	 * Renders the actual widget
	 * @global post $post
	 * @param array $args 
	 * @param type $instance
	 */

	public function widget($args, $instance) 

	{

		extract($args, EXTR_SKIP);
		
		//inicio de widget
		echo $before_widget;
		
		
		if(estadoServidor)
		{
			$url = Servidor."feed";
			$check=true;
		}
		else
		{
			$url = $instance['url']."feed";
			$check = Utilidad::chequearUrl($url);	
		}

		if ($check)
		{		
		$feed = array();
		//Recibe la data del feed
		$feed = Rss::obtenerFeed($url);
		$limit = count($feed);
		$existe = Utilidad::contarProyectos('proyectos', $feed);
		
		if($existe>0)
		{	
		$proyectos=0;
		echo '<br/>';
		echo '<div class="col-sm-12"><center>';
		

		for($x=0;$x<$limit;$x++) 
		{
		$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
		$link = $feed[$x]['link'];
		$description = $feed[$x]['desc'];
		$category = $feed[$x]['category'];
		$orden = $feed[$x]['orden'];
		$date = date('l F d, Y', strtotime($feed[$x]['date']));
		
		//si no se pudo obtener el enlace redirigira al SIGOES		
		$enlace=Utilidad::extraerEnlace($description);
		if(empty($enlace))
		{
			//obtiene la permantlink del servidor
			$enlace=$link;
		}
		
		$description=strip_tags($description, '<img>');
		$src=" ";
    	if(!empty($description))
		{
		$doc = new DOMDocument();
		$doc->loadHTML($description);
		$xpath = new DOMXPath($doc);
		//obtenemos el source de la imagen
		$src = $xpath->evaluate("string(//img/@src)");
		}//fin de $descripcion vacia
		//verificamos que la entrada sea de la categoria proyectos
		if($category == 'proyectos')
			{
				if ($proyectos==0)
				{
				echo '<h3>PROYECTOS DE GOBIERNO</h3>';
				}
				if(!empty($src))
				{
				echo '<a href="'.$enlace.'" target="_blank"> <img class="hvr-pop" src="'.$src.'" alt="'.$title.'" title="'.$title.'"></a>';
				$proyectos++;
				}
				
			}//fin de category
			//definimos cuantos proyectos queremos que despliegue el plugin
			if($proyectos==PROYECTOS)
			{
				$x=$limit;
			}
		}
		echo '</center></div>';
		echo '<br/>';
		}//fin si hay proyectos
		}//fin de check
		
		//fin de widget
		echo $after_widget;
	}
/*Fin de Funcion para Mostrar el Widget Actual*/
 
}
?>
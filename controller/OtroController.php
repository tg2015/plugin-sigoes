<?php
/*
*Nombre del módulo: OtroController
*Objetivo: Mostrar los otro tipo de proyectos realizados por la presidencia de El Salvador
*Dirección física: /plugins/plugin-sigoes/controller/OtroController.php
*/

require_once SIGOES_PLUGIN_DIR.'/includes/Utilidad.php';
require_once SIGOES_PLUGIN_DIR.'/includes/Rss.php';

class OtroController extends WP_Widget 

{
/*Inicio de Funcion Constructor de Widget Proyectos*/
	public function __construct() {

		parent::WP_Widget(

			'otros', 
			
			__('sigoes-otros'), 

			array('description'=>'otros', 'class'=>'codewrapperwidget')

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
		$feed = Rss::obtenerFeed($url);
		$limit = count($feed);
		$existe = Utilidad::contarProyectos('otros', $feed);
		if ($existe>0)
		{
		echo '<div class="post-content clearfix">';
		$otros=0;
		for($x=0;$x<$limit;$x++) 
		{
		$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
		$link = $feed[$x]['link'];
		$description = $feed[$x]['desc'];
		$category = $feed[$x]['category'];
		$content = $feed[$x]['content'];
		$date = date('l F d, Y', strtotime($feed[$x]['date']));
		
		//si no se pudo obtener el enlace redirijira al SIGOES
		$enlace=Utilidad::extraerEnlace($content);
		if(empty($enlace))
		{
			$enlace=$link;
		}
		
		$description=strip_tags($description, '<img>');
		if(!empty($description))
		{
		$doc = new DOMDocument();
		$doc->loadHTML($description);
		$xpath = new DOMXPath($doc);
		$src = $xpath->evaluate("string(//img/@src)");
		}
		if($category == 'otros')
			{
				echo '<div>';
				echo '<a href="'.$enlace.'" target="_blank"> <img src="'.$src.'" alt="'.$title.'" title="'.$title.'"></a>';
				echo '</div>';

			}
		}
		//echo utilidades::extraerUrl($description);
		echo '</div>';
		if($otros==OTROS)
			{
			$x=$limit;
			}
		}//fin de existe
		}//fin de check
		
		//fin de widget
		echo $after_widget;
	}
/*Fin de Funcion para Mostrar el Widget Actual*/
 
}//fin de clase
?>
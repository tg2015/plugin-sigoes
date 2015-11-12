<?php
/*
*Nombre del módulo: StreamingController
*Objetivo: Mostrar el streaming de video realizados por la presidencia de El Salvador
*Dirección física: /plugins/plugin-sigoes/controller/StreamingController.php
*/

require_once SIGOES_PLUGIN_DIR.'/includes/Utilidad.php';
require_once SIGOES_PLUGIN_DIR.'/includes/Rss.php';

class StreamingController extends WP_Widget 

{
/*Inicio de Funcion Constructor de Widget Streaming*/
	public function __construct() {

		parent::WP_Widget(
			'streaming', 			
			//titulo del widget en la WP dashboard
			__('sigoes-streaming'), 
			array('description'=>'streaming de video', 'class'=>'codewrapperwidget')

		);

	}
/*Fin de Funcion Constructor de Widget Streaming*/
	

/*Inicio de Funcion para crear el Form de Streaming*/
	/**
	 * @param type $instance
	 */
	public function form($instance)

	{
		$default = array( 
			'titulo' => __(''),
			'url'=> __(''),
			'div'=> __('')
			);

		$instance = wp_parse_args( (array)$instance, $default );
		echo "\r\n";
		echo "<p>";
		echo "<label for='".$this->get_field_id('titulo')."'>" . __('Titulo') . ":</label> " ;
		echo "<input type='text' class='widefat' id='".$this->get_field_id('titulo')."' name='".$this->get_field_name('titulo')."' value='" . esc_attr($instance['titulo'] ) . "' />" ;
		echo "</p>";
		
		echo "<p>";
		echo "<label for='".$this->get_field_id('url')."'>" . __('url de video') . ":</label> " ;
		echo "<input type='text' class='widefat' id='".$this->get_field_id('url')."' name='".$this->get_field_name('url')."' value='" . esc_attr( $instance['url'] ) . "' placeholder='http://www.ejemplo.com' />" ;
		echo "</p>";

		echo "<p>";
		echo "<label for='".$this->get_field_id('div')."'>" . __('ocultar div personalizado') . ":</label> " ;
		echo "<input type='text' class='widefat' id='".$this->get_field_id('div')."' name='".$this->get_field_name('div')."' value='" . esc_attr( $instance['div'] ) . "' placeholder='SliderPersonalizado' />" ;
		echo "</p>";
	}
/*Fin de Funcion para crear el Form de Streaming*/
		
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
		$instance['div'] = $new_instance['div'];
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
		
		
		echo $before_widget;		
		
		$embed_code = wp_oembed_get($instance['url']);
		
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
		
		$existe = Utilidad::contarProyectos('streaming', $feed);
		$streaming=0;
		if($existe>0)
		{
		echo '<div class="streaming">';	
		echo '<div class="post-content clearfix">';
		for($x=0;$x<$limit;$x++) 
		{
		$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
		$link = $feed[$x]['link'];
		$description = $feed[$x]['desc'];
		$category = $feed[$x]['category'];
		$content = $feed[$x]['content'];
		$date = date('l F d, Y', strtotime($feed[$x]['date']));
			
			$src = Utilidad::extraersrc($description);
			//con esta funcion recortamos el string del contenido si es demasiado grande
			$resumen=substr(strip_tags($content), 0, 950).'...';
			$content=strip_tags($content, '<iframe>');
			preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $content, $matches);
			if($category=='streaming')
			{	
			//En esta seccion div se muestra el iframe del streaming
			echo '<div class="col-sm-5">';	
			if(!empty($matches))
			{
				//primera ocurrencia de iframes encontrados en la entrada
				echo $matches[0];
				$transmision = "TRANSMISION EN VIVO";
			}
			else
			{
				echo '<img src="'.$src.'" alt="'.$title.'" target="_blank">';
				$transmision = "A PUNTO DE INICIAR TRANSMISION EN VIVO";

			}
				echo '</div>';
				//En esta seccion se muestra la descripcion del streaming
				echo '<div class="col-sm-7">';	
				echo '<div id="titulo-streaming">'.$title.'</div><br/>';
				echo '<div class="blinker">'.$transmision.' [ &bull; ]</div>';
				echo '<div id="cuerpo-streaming">'.$resumen.' <span class="read-more2"><a href="'.$link.'" target="_blank">Leer Mas</a></span></div>';
				echo '</div>';
			$streaming++;
				if($streaming==1)
				{
					$x=$limit;
				}
			}

		}		
		echo '</div>';
		echo '</div><br/>';
		//Estilos que hacen que se oculten los Slider de las cabeceras
		echo '<style>div.Newslider, div.vwpc-section-featured_post_slider, div.vwpc-section-featured_news-headline, a.flex-next, a.flex-prev{display: none;}</style>';
			if(!empty($instance['div']))
			{
				echo '<style>div.'.$instance['div'].' {display: none;}</style>';
			}
		}
		
		}//fin de check
		//fin de widget
		echo $after_widget;
	}
/*Fin de Funcion para Mostrar el Widget Actual*/

}
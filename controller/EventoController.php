<?php
/*
*Nombre del módulo: EventoController
*Objetivo: Mostrar los eventos realizados por la presidencia de El Salvador
*Dirección física: /plugins/plugin-sigoes/controller/EventoController.php
*/

require_once SIGOES_PLUGIN_DIR.'/includes/Utilidad.php';
require_once SIGOES_PLUGIN_DIR.'/includes/Rss.php';

class EventoController extends WP_Widget 

{
/*Inicio de Funcion Constructor de Widget Eventos*/
	public function __construct() {

		parent::WP_Widget(

			'eventos', 
			
			//title of the widget in the WP dashboard
			__('sigoes-eventos'), 

			array('description'=>'eventos coyunturales', 'class'=>'codewrapperwidget')

		);

	}
/*Fin de Funcion Constructor de Widget Eventos*/
	
/*Inicio de Funcion para crear el Form de Eventos*/
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
/*Fin de Funcion para crear el Form de Eventos*/
		
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
		$existe = Utilidad::contarProyectos('eventos', $feed);
		
		if($existe>0)
		{
		echo '<div class="bannereventos">';
		echo '<div class="col-sm-2" style="padding-left:0px; padding-right:0px"><center>';
		//echo '<div id="titulo">Gobierno Informa</div>';
		echo '<img src="'.plugins_url( 'plugin-sigoes/includes/img/P1.png' ).'" id="informa">';
		echo '</center></div>';
		echo '<div class="col-sm-10" style="padding-left:0px; padding-right:0px">';
				
		$eventos=0;
		echo '<br/>';
		echo '<div class="eventos">';
		if($existe>1)//inicio de evento
		{
		echo '<ul id="ticker">';
		for($x=0;$x<$limit;$x++) 
		{
		$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
		$link = $feed[$x]['link'];
		$description = $feed[$x]['desc'];
		$category = $feed[$x]['category'];
		$date = date('d/m/Y h:i a', strtotime($feed[$x]['date']));
		
		//si no se pudo obtener el enlace redirijira al SIGOES
		$enlace=Utilidad::extraerEnlace($description);
		if(empty($enlace))
		{
			$enlace=$link;
		}	

			if($category == 'eventos')
			{
	 			
				echo '<li><span>--'.$date.'</span><a rel="bookmark" href="'.$enlace.'" title="'.$title.'" target="_blank">'.$title.'</a>--</li>';
				$eventos++;
			}
			//si necesitamos desplegar mas de 5 eventos cambiamos la condicion
			if($eventos==5)
			{
				$x=$limit;
			}
		}
		echo '</ul>';
		}//fin de if($event>1)
		else//si solamente es un evento coyuntural $existe==1
		{//inicio de else

			for($x=0;$x<$limit;$x++) 
			{
			$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
			$link = $feed[$x]['link'];
			$description = $feed[$x]['desc'];
			$category = $feed[$x]['category'];
			$date = date('d/m/Y H:i a', strtotime($feed[$x]['date']));
		
			$enlace=Utilidad::extraerEnlace($description);
			if(empty($enlace))
			{
				$enlace=$link;
			}
				if($category == 'eventos')
				{
				echo '<div id="evento"><span>--'.$date.' </span><a href="'.$enlace.'" title="'.$title.'">'.$title.'</a>--</div>';
				$eventos++;
				}
			}	
		}//fin de else


		echo '</center>';
		echo '</div></div></div>';
		echo '&nbsp;&nbsp;';
		}//fin si hay mas de un evento


		?>
		<script>
  		$("#ticker").webTicker({
    	"travelocity" : 0.03,
    	moving: true,
  		});
		</script>
		<?php
		
		}//fin if de check
		else
		{
			echo '<br/>&nbsp;&nbsp;';
		}
		//fin de widget
		echo $after_widget;
	}
/*Fin de Funcion para Mostrar el Widget Actual*/

}
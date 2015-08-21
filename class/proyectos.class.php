<?php
/*
*Nombre del módulo: Proyectos
*Objetivo: Mostrar los proyectos realizados por la presidencia de El Salvador
*Dirección física: /plugins/plugin-sigoes/class/proyectos.class.php
*/

include 'utilidades.class.php';

class proyectos extends WP_Widget 

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
		
		$site = nowww($instance['url']); 
 		$check = @fsockopen($site, 80); 

		if ($check)
		{
		$rss = new DOMDocument();
		$url = $instance['url']."/feed";
		$rss->load($url);
		$feed = array();
		foreach ($rss->getElementsByTagName('item') as $node) {
		$item = array ( 
			'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
			'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
			'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
			'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
			'category' => $node->getElementsByTagName('category')->item(0)->nodeValue, 
			);
		array_push($feed, $item);
		}
		$limit = count($feed);
		
		//echo '<div id="sliderFrame"><div id="slider">';
		echo '<center><div class="slideshow" data-cycle-fx=carousel data-cycle-timeout=3000 data-cycle-slides="> div" data-cycle-carousel-visible=3 data-cycle-next="#next" data-cycle-prev="#prev" data-cycle-carousel-fluid=true data-cycle-pager="#pager" data-cycle-pause-on-hover="true">';
		
		
		for($x=0;$x<$limit;$x++) 
		{
		$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
		$link = $feed[$x]['link'];
		$description = $feed[$x]['desc'];
		$category = $feed[$x]['category'];
		$date = date('l F d, Y', strtotime($feed[$x]['date']));
				
		$description=strip_tags($description, '<img>');
		$doc = new DOMDocument();
		$doc->loadHTML($description);
		$xpath = new DOMXPath($doc);
		$src = $xpath->evaluate("string(//img/@src)");
		
		if($category == 'proyectos')
			{
			//echo '<a href="'.$link.'"> <img src="'.$src.'" alt="'.$title.'"></a>';
				echo '<div>';
				echo '<a href="'.$link.'"> <img src="'.$src.'" alt="'.$title.'"></a>';
				echo '<div class="cycle-overlay">'.$title.'</div>';
				echo '</div>';
			}
		}

		//echo '</div></div><br/><br/><br/>';
		echo '</div></center>';
		}

	echo '<a href="#" id="prev"><img src="'.plugins_url( 'plugin-sigoes/public/img/left.png' ).'"> </a>';
    echo '<a href="#" id="next" class="next"><img src="'.plugins_url( 'plugin-sigoes/public/img/right.png' ).'"> </a>';
	?>
		
	<div class="cycle-pager" id="pager"></div>

	<script type="text/javascript">$.fn.cycle.defaults.autoSelector = '.slideshow';</script>
	<?php
	
		//fin de widget
		echo $after_widget;
	}
/*Fin de Funcion para Mostrar el Widget Actual*/
 
}
?>
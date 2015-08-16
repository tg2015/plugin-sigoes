<?php
/*
*Nombre del módulo: Eventos
*Objetivo: Mostrar los eventos realizados por la presidencia de El Salvador
*Dirección física: /plugins/plugin-sigoes/class/eventos.class.php
*/


class eventos extends WP_Widget 

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
		echo '<center><table border="0"> <tr>';
		for($x=0;$x<$limit;$x++) 
		{
		$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
		$link = $feed[$x]['link'];
		$description = $feed[$x]['desc'];
		$category = $feed[$x]['category'];
		$date = date('l F d, Y', strtotime($feed[$x]['date']));
		if($x==0)
			{
			 echo '<td><b>Gobierno Informa</b><br/><center>';
			 echo '<img src="'.plugins_url( 'plugin-sigoes/public/img/megafono.png' ).'" width=50% height=50% class="info"></center></td>';
			}
		if($category == 'eventos')
			{
			echo '<td><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br /></td>';
			}
		}
		echo '</tr></table></center><br/><br/>';
		//fin de widget
		echo $after_widget;
	}
/*Fin de Funcion para Mostrar el Widget Actual*/

}
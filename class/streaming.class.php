<?php

/*constructor*/
class streaming extends WP_Widget 

{

	public function __construct() {

		parent::WP_Widget(

			'streaming', 
			
			//title of the widget in the WP dashboard
			__('sigoes-streaming'), 

			array('description'=>'streaming de video', 'class'=>'codewrapperwidget')

		);

	}

	

	/**
	 * @param type $instance
	 */

	public function form($instance)

	{
		// these are the default widget values
		$default = array( 

			'titulo' => __(''),

			'url'=> __('')

			);

		$instance = wp_parse_args( (array)$instance, $default );

		//this is the html for the fields in the wp dashboard
		echo "\r\n";
		echo "<p>";
		echo "<label for='".$this->get_field_id('titulo')."'>" . __('Titulo') . ":</label> " ;
		echo "<input type='text' class='widefat' id='".$this->get_field_id('titulo')."' name='".$this->get_field_name('title')."' value='" . esc_attr($instance['title'] ) . "' />" ;
		echo "</p>";
		
		echo "<p>";
		echo "<label for='".$this->get_field_id('url')."'>" . __('url de video') . ":</label> " ;
		echo "<input type='text' class='widefat' id='".$this->get_field_id('url')."' name='".$this->get_field_name('url')."' value='" . esc_attr( $instance['url'] ) . "' placeholder='http://www.ejemplo.com' />" ;
		echo "</p>";

	}

		

	/**
	 * 
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

		

	/**
	 * Renders the actual widget
	 * @global post $post
	 * @param array $args 
	 * @param type $instance
	 */

	public function widget($args, $instance) 

	{
		extract($args, EXTR_SKIP);
		
		//global WP theme-driven "before widget" code
		echo $before_widget;
		
		// code before your user input
		echo '<div class="wrapper"><div class="h_iframe"><center>';
		
		//echo $instance['url'];
		
		echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/zmUGnL80kIg" frameborder="0" allowfullscreen></iframe>';
		
		// code after your user input
		echo '</center></div></div>';
			
		//global WP theme-driven "after widget" code
		echo $after_widget;
	}

}
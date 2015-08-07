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
		
		
		echo $before_widget;		
		$embed_code = wp_oembed_get($instance['url'], array('width'=>600, 'height'=>480));
		echo '<div class="post-content clearfix">';
		echo '<center>'.$embed_code.'</center>';
		echo '</div>';
		
		echo $after_widget;
	}

}
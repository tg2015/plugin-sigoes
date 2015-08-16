<?php
include 'utilidades.class.php';
/*constructor*/
class proyectos extends WP_Widget 

{

	public function __construct() {

		parent::WP_Widget(

			'proyectos', 
			
			//title of the widget in the WP dashboard
			__('sigoes-proyectos'), 

			array('description'=>'proyectos', 'class'=>'codewrapperwidget')

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
		echo "<input type='text' class='widefat' id='".$this->get_field_id('titulo')."' name='".$this->get_field_name('titulo')."' value='" . esc_attr($instance['titulo'] ) . "' />" ;
		echo "</p>";
		echo "<p>";
		echo "<label for='".$this->get_field_id('url')."'>" . __('url del sitio web') . ":</label> " ;
		echo "<input type='text' class='widefat' id='".$this->get_field_id('url')."' name='".$this->get_field_name('url')."' value='" . esc_attr( $instance['url'] ) . "' placeholder='http://www' />" ;
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
		
		echo '<div id="sliderFrame"><div id="slider">';
		for($x=0;$x<$limit;$x++) 
		{
		$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
		$link = $feed[$x]['link'];
		$description = $feed[$x]['desc'];
		$category = $feed[$x]['category'];
		$date = date('l F d, Y', strtotime($feed[$x]['date']));
		
		$description=str_replace("<p>", " ", $description);
		$description=str_replace("</p>", " ", $description);
		if($category == 'proyectos')
			{
			echo $description;
			}
		}		
		echo '</div></div><br/><br/><br/>';
		}

		//global WP theme-driven "after widget" code
		echo $after_widget;
	}
 
}
?>
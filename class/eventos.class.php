<?php

/*constructor*/
class eventos extends WP_Widget 

{

	public function __construct() {

		parent::WP_Widget(

			'eventos', 
			
			//title of the widget in the WP dashboard
			__('sigoes-eventos'), 

			array('description'=>'eventos coyunturales', 'class'=>'codewrapperwidget')

		);

	}

	

	/**
	 * @param type $instance
	 */

	public function form($instance)

	{
		// these are the default widget values
		$default = array( 

			'title' => __(''),

			'url'=> __('')

			);

		$instance = wp_parse_args( (array)$instance, $default );

		//this is the html for the fields in the wp dashboard
		echo "\r\n";

		echo "<p>";
		echo "<label for='".$this->get_field_id('title')."'>" . __('Title') . ":</label> " ;
		echo "<input type='text' class='widefat' id='".$this->get_field_id('title')."' name='".$this->get_field_name('title')."' value='" . esc_attr($instance['title'] ) . "' />" ;
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
		$instance['title'] = strip_tags($new_instance['title']);
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
		
		//http://www.presidencia.gob.sv/feed
		//echo $instance['url'];
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
		$limit = 3;
		echo '<center><table border="0"> <tr>';
		for($x=0;$x<$limit;$x++) 
		{
		$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
		$link = $feed[$x]['link'];
		$description = $feed[$x]['desc'];
		$category = $feed[$x]['category'];
		$date = date('l F d, Y', strtotime($feed[$x]['date']));
		if($x==0 && $category == 'eventos')
			{
			 echo '<td><b>Gobierno Informa</b><br/><center>';
			 echo '<img src="'.plugins_url( 'plugin-sigoes/public/img/megafono.png' ).'" width=50% height=50%></center></td>';
			}
		if($category == 'eventos')
			{
			echo '<td><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br /></td>';
			}
		}
		echo '</tr></table></center><br/>';
		
		//global WP theme-driven "after widget" code
		echo $after_widget;
	}

}
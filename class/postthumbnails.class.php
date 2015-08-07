<?
function ptif_do_post_thumbnail_feeds($content) {
    global $post;
    
    // Get current options
	$ptif_size = get_option('ptif_size');
    
    if(has_post_thumbnail($post->ID)) {
        $content = '<div class="post-thumbnail-feed">' . get_the_post_thumbnail($post->ID, $ptif_size) . '</div>' . $content;
    }
    return $content;
}
add_filter('the_excerpt_rss', 'ptif_do_post_thumbnail_feeds');
add_filter('the_content_feed', 'ptif_do_post_thumbnail_feeds');


// This function adds a menu item
function ptif_admin_menu() {
	add_options_page('Post Thumbnails in Feed', 'Post Thumbnails in Feed', 'manage_options', 'ptif-post-thumbnails-in-feed', 'ptif_admin_page');
}
// Tell wordpress to use our menu item function
add_action('admin_menu', 'ptif_admin_menu');

// This functions is the admin page itself
function ptif_admin_page() {
	// Start wrap div
	echo '<div class="wrap">' . "\n"; 

		// Fancy title
		echo '<div id="icon-themes" class="icon32"><br /></div>' . "\n";
		echo '<h2>'.__('Post Thumbnails in Feed','post-thumbnails-in-feed').'</h2>' . "\n"; 

		// Get current options
		$ptif_size    = get_option('ptif_size');
		

		// Description
		echo __('<br />Elija el tamaño de las imagenes que apareceran en las entradas.<br /><br />','post-thumbnails-in-feed') . "\n";

		// Start form
		echo '<form method="post" action="options.php">' . "\n";

		// Magic wordpress function, adds hidden inputs to help redirect the user back to the right page after submit
		wp_nonce_field('update-options');

		// Start table
		echo '<table class="form-table">' . "\n";

			echo '<tr valign="top">' . "\n";
				echo '<th scope="row">'.__('Size','post-thumbnails-in-feed').'</th>' . "\n";
				echo '<td><input type="radio" name="ptif_size" value="thumbnail"'; if($ptif_size == 'thumbnail'){ echo " checked"; } echo ' /> Thumbnail <input type="radio" name="ptif_size" value="medium"'; if($ptif_size == 'medium'){ echo " checked"; } echo ' /> Medium <input type="radio" name="ptif_size" value="large"'; if($ptif_size == 'large'){ echo " checked"; } echo ' /> Large <input type="radio" name="ptif_size" value="full"'; if($ptif_size == 'full'){ echo " checked"; } echo ' /> Full</td>' . "\n";
				//echo '<td><span class="description">'.__('Require visitors to login before viewing any content (except feeds) on your site.','post-thumbnails-in-feed').'</span></td>' . "\n";
			echo '</tr>' . "\n";

		// End table
		echo '</table><br />' . "\n";

		// Magic hidden inputs to make wordpress update our options
		echo '<input type="hidden" name="action" value="update" />' . "\n";
		echo '<input type="hidden" name="page_options" value="ptif_size" />' . "\n";

		// Submit button
		echo '<input type="submit" name="ptif_submit" class="button-primary" value="'.__('Save Changes','post-thumbnails-in-feed').'" />' . "\n";

		// End form
		echo '</form>' . "\n";

	// End wrap div
	echo '</div>' . "\n";
}
?>

<?php
/**
 *
 *
 * New Community Photos Widget
 *
 *
 ***********************************************************************************/
class UW_Widget_CommunityPhotos extends WP_Widget 
{
  function UW_Widget_CommunityPhotos() 
  {
		// widget actual processes
		parent::WP_Widget( $id = 'community-photos', $name = 'Community Photos', $options = array( 'description' => 'Display the UW Community Photos', 'classname' => 'community-photos-widget' ) );
	}

  function form($instance) 
  {
    $title = isset($instance['title']) ? esc_attr($instance['title']) : 'Community Photos'; ?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

<?php
	}

  function update( $new_instance, $old_instance ) 
  {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

  function widget($args, $instance) 
  {
    extract( $args );
		// outputs the content of the widget
    $URL = 'http://depts.washington.edu/newscomm/photos/feed';
    $rss = fetch_feed($URL);
		$title = apply_filters( 'widget_title', $instance['title'] );

    $placeholder = get_bloginfo('template_url') . '/img/placeholder.gif';

    if (!is_wp_error( $rss ) ) { 
      $url = $rss->get_permalink();
      $maxitems = $rss->get_item_quantity(20); 

      $rss_items = $rss->get_items(0, $maxitems); 
      
      $content = '<span class="showcase-bar community-photos"></span><div class="communityphotos">';
      if ( ! empty( $title ) ) $content .= $before_title . $title . $after_title;
      foreach ($rss_items as $item) {
        $title = $item->get_title();
        $link = $item->get_link();
        $src = ereg_replace("(https?)://", "//",$item->get_enclosure()->get_link());
        $content .= "
          <a href='$link' title='$title'>
            <span>
              <img data-src='$src' src='$placeholder' width='110' height='100' alt='$title'/>
            </span>
            <div style='width:110px'>
              <img data-src='$src' src='$placeholder' width='110' height='110' alt='$title'/>
              <p>View Full Size</p>
            </div>
          </a>
        ";
      }
      $content .= "<a class='more' href='http://depts.washington.edu/newscomm/photos/'>More</a></div>";

      echo $before_widget . $content . $after_widget;
    }
	}
}



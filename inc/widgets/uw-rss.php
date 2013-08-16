<?php
/**
 * UW RSS Widget 
 *  - Only difference between this and WP one is this shows images
 */

class UW_RSS_Widget extends WP_Widget 
{

  function UW_RSS_Widget() 
  {
    $options = array( 
      'description' => 'Similar to the Wordpress RSS widget but allows a blurb before the RSS feed is listed.',
      'classname'   => 'uw-rss-widget'
    );
		$control_ops = array('width' => 400, 'height' => 350);
		parent::WP_Widget( $id = 'uw-rss', $name = 'UW RSS', $options , $control_ops );
	}

  function form($instance) 
  {
    $default_inputs = array( 'url' => true, 'title' => true, 'items' => true, 'show_summary' => true, 'show_author' => true, 'show_date' => true, 'show_image' => true );
    $inputs = wp_parse_args( $inputs, $default_inputs );

    extract( $inputs, EXTR_SKIP);

    $number = esc_attr( $number );
    $title  = esc_attr( $title );
    $url    = esc_url( $url );
    $items  = (int) $items;
    if ( $items < 1 || 20 < $items )
      $items  = 10;
    $show_summary   = (int) $show_summary;
    $show_author    = (int) $show_author;
    $show_date      = (int) $show_date;

    if ( !empty($error) )
      echo '<p class="widget-error"><strong>' . sprintf( __('RSS Error: %s'), $error) . '</strong></p>';
  ?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Give the feed a title (optional):' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title']); ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Featured blurb:' ); ?></label> 
		<textarea class="widefat" style="resize:vertical" rows="14" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea($instance['text']); ?></textarea>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Enter the RSS feed URL here:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $instance['url']); ?>" />
		</p>

    <p>
    <label for="<?php echo $this->get_field_id( 'items' ) ?>"><?php _e('Number of items to display:'); ?></label>
    <select id="<?php echo $this->get_field_id( 'items' ) ?>" name="<?php echo $this->get_field_name( 'items' ) ?>">
      <?php
          for ( $i = 1; $i <= 20; ++$i )
            echo "<option value='$i' " . selected( $instance['items'], $i ) . ">$i</option>";
      ?>
    </select>
    </p>

		<!--p>
      <input id="<?php echo $this->get_field_id( 'show_image' ); ?>" name="<?php echo $this->get_field_name( 'show_image' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_image']); ?>/>
      <label for="<?php echo $this->get_field_id( 'show_image' ); ?>"><?php _e( 'Display item image?' ); ?></label> 
		</p>

		<p>
      <input id="<?php echo $this->get_field_id( 'show_summary' ); ?>" name="<?php echo $this->get_field_name( 'show_summary' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_summary']); ?>/>
      <label for="<?php echo $this->get_field_id( 'show_summary' ); ?>"><?php _e( 'Display item content?' ); ?></label> 
		</p>
  
		<p>
      <input id="<?php echo $this->get_field_id( 'show_author' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_author']); ?>/>
      <label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php _e( 'Display item author?' ); ?></label> 
		</p>

		<p>
      <input id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_date']); ?>/>
      <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display item date?' ); ?></label> 
		</p-->

<?php

  }

  function update( $new_instance, $old_instance ) 
  {
		$instance = array();
		$instance['url']   = esc_url_raw(strip_tags( $new_instance['url'] ));
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['items'] = (int) ( $new_instance['items'] );
		$instance['show_image'] = (int) ( $new_instance['show_image'] );
		$instance['show_summary'] = (int) ( $new_instance['show_summary'] );
		$instance['show_author'] = (int) ( $new_instance['show_author'] );
		$instance['show_date'] = (int) ( $new_instance['show_date'] );

		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
    
		return $instance;
	}

  function widget($args, $instance) 
  {
    extract($args);

    $title = apply_filters( 'widget_title', $instance['title'] );
    $text  = $instance['text'];
    $URL = $instance['url'];

    $content = '<span></span>';

    if ( ! empty( $title ) ) $content .= $before_title . $title . $after_title;

    $content .= "<div class=\"featured\">$text</div>";


    if ( strlen($URL) > 0 ) {
    
      $rss = fetch_feed($URL);

      if (!is_wp_error( $rss ) ) { 
        $url = $rss->get_permalink();
        $maxitems = $rss->get_item_quantity($instance['items']); 

        $rss_items = $rss->get_items(0, $maxitems); 
        
        $content .= "<ul>";

        foreach ($rss_items as $index=>$item) {
          $title = $item->get_title();
          $link  = $item->get_link();
          $attr  = esc_attr(strip_tags($title));

          $content .= "<li><a href='$link' title='$attr'>$title</a></li>";
        }

        $content .= '</ul>';
        $content .= "<a class=\"rss-more\" href=\"$url\">More</a>";
      }
    }

    echo $before_widget . $content . $after_widget;
	}
}


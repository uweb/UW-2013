<?php
/**
 *
 * Headline Horizontal Rule Widget
 *
 */

class UW_Headline_Widget extends WP_Widget 
{

  function UW_Headline_Widget() 
  {
		parent::WP_Widget( 'headline-separator', __('Page title H1'), array( 
      'description' => __('This creates a headline for the top of the page with the gold notch'),
      'classname'   => 'headline-widget'
    ) );
	}

  function widget($args, $instance) 
  {

    extract( $args );

    extract( $instance );

    echo '<h1 class="entry-title">'; 
    apply_filters('italics', $headlineContent);
    echo '</h1>';
    
	}

  function update($new_instance, $old_instance) 
  {
		$instance = array();
		$instance['headlineContent'] = strip_tags( $new_instance['headlineContent'] );
		return $instance;
	}

  function form($instance) 
  {

		$headlineContent = isset( $instance['headlineContent'] ) ? esc_attr( $instance['headlineContent'] ) : '';
?>

		<p><label for="<?php echo $this->get_field_id('headlineContent'); ?>"><?php _e('Headline:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('headlineContent'); ?>" name="<?php echo $this->get_field_name('headlineContent'); ?>" type="text" value="<?php echo $headlineContent; ?>" /></p>

<?php
	}
}



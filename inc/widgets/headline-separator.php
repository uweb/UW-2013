<?php
/**
 *
 * Headline Horizontal Rule Widget
 *
 */

class UW_Headline_Separator_Widget extends WP_Widget 
{

  function UW_Headline_Separator_Widget() 
  {
		parent::WP_Widget( 'headline-separator', __('Horizontal rule with headline'), array( 
      'description' => __('This creates a horizontal rule with a headline'),
      'classname'   => 'headline-separator-widget'
    ) );
	}

  function widget($args, $instance) 
  {

    extract( $args );

    extract( $instance );

    $content = '<h2 class="break"><span>'. $separatorContent . '</span></h2>';

    echo $before_widget . $content . $after_widget;
	}

  function update($new_instance, $old_instance) 
  {
		$instance = array();
		$instance['separatorContent'] = strip_tags( $new_instance['separatorContent'] );
		return $instance;
	}

  function form($instance) 
  {

		$separatorContent = isset( $instance['separatorContent'] ) ? esc_attr( $instance['separatorContent'] ) : '';
?>

		<p><label for="<?php echo $this->get_field_id('separatorContent'); ?>"><?php _e('Headline:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('separatorContent'); ?>" name="<?php echo $this->get_field_name('separatorContent'); ?>" type="text" value="<?php echo $separatorContent; ?>" /></p>

<?php
	}
}



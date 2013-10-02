<?php
/**
 *
 * Headline Horizontal Rule Widget
 *
 */

class UW_Intro_Widget extends WP_Widget 
{

  function UW_Intro_Widget() 
  {
		parent::WP_Widget( 'headline-separator', __('Intro block of text'), array( 
      'description' => __('This widgets creates a italicized block of intro text'),
      'classname'   => 'intro-widget'
    ) );
	}

  function widget($args, $instance) 
  {

    extract( $args );

    extract( $instance );

    $content = '<p class="intro">'. $introContent . '</p>';

    echo $content;
	}

  function update($new_instance, $old_instance) 
  {
		$instance = array();
		$instance['introContent'] = strip_tags( $new_instance['introContent'] );
		return $instance;
	}

  function form($instance) 
  {

		$introContent = isset( $instance['introContent'] ) ? esc_attr( $instance['introContent'] ) : '';
?>

		<p><label for="<?php echo $this->get_field_id('introContent'); ?>"><?php _e('Intro text:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('introContent'); ?>" name="<?php echo $this->get_field_name('introContent'); ?>" type="text" value="<?php echo $introContent; ?>" /></p>

<?php
	}
}



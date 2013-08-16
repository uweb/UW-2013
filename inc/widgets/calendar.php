<?php
/**
 * UW Calendar
 */

class UW_Calendar extends WP_Widget 
{

  const CALENDAR = "https://www.google.com/calendar/feeds/%s/public/basic";

  function UW_Calendar() 
  {
		parent::WP_Widget( 'uw-calendar', __('UW Calendar'), array( 
      'description' => __('Show a Google calendar on your site.'),
      'classname'   => 'widget-uw-calendar'
    ) );
	}

  function widget($args, $instance) 
  {
    extract( $args );

		$title  = apply_filters( 'widget_title', $instance['title'] );
    ?>
          <div class="widget calendar-widget-wrapper">
            <div class="calendar-widget" data-events="<?php echo $this->calendarUrl($instance['calendar']); ?>"> </div>
              <div class="calendar-widget-event-pane">
                <a href="#" class="calendar-widget-close"> Close </a>
                <div class="calendar-events"></div> 
            </div>
          </div>

    <?php
    echo $before_widget . $content . $after_widget;
	}

  function update($new_instance, $old_instance) 
  {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['calendar'] = strip_tags( $new_instance['calendar'] );
		return $instance;
	}

  function form($instance) 
  {

		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$calendar = isset($instance['calendar']) ? esc_attr($instance['calendar']) : '';
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('calendar'); ?>"><?php _e('Email'); ?> <small>(or <a href="https://support.google.com/calendar/answer/63962?hl=en" target="_blank">Calendar ID</a>)</small></label>
		<input class="widefat" id="<?php echo $this->get_field_id('calendar'); ?>" name="<?php echo $this->get_field_name('calendar'); ?>" type="text" value="<?php echo $calendar; ?>" /></p>

<?php
	}

  private function calendarUrl( $calendar ) 
  {
    return ( is_email($calendar) ) ?  sprintf( self::CALENDAR, $calendar ) : $calendar ; 
  }
}

<?php
/**
 * UW Custom Menu 
 *
 * Add's an anchor around the title that links to the homepage of the site
 * Only the display is custom, everything else is using the default WP_Nav_Menu_Widget
 */

class UW_Nav_Menu_Widget extends WP_Nav_Menu_Widget {

	function widget($args, $instance) {
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		if ( !$nav_menu )
			return;

    echo '<div aria-label="'. $instance['title'] .'" role="navigation">';

		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];

		if ( !empty($instance['title']) )
			echo $args['before_title'] . '<a href="'. home_url('/') .'" title="' . esc_attr(strip_tags($instance['title'])) . '">' . $instance['title'] .'</a>'. $args['after_title'];

		wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu ) );

		echo $args['after_widget'];

    echo '</div>';
	}

}


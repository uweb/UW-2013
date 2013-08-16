<?php

/**
 * Add span to titles
 */
if ( ! function_exists( ' uw_add_spans_to_widget_titles' ) ) :
function uw_add_spans_to_widget_titles( $title ) 
{
  return "<span>$title</span>";
}
endif;
add_filter('widget_title', 'uw_add_spans_to_widget_titles');

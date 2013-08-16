<?php

/**
 * UW Link Widget
 *    - Instead of overriding the link widget we will patch it via filter's it provides
 */

if ( ! function_exists('uw_patch_link_widget' ) ) :

  function uw_patch_link_widget( $args ) 
  {
    $category = get_term_by('id', $args['category'], 'link_category');

    $args['title_before']     = '<h2 class="widgettitle"><span>';

    $args['title_after']      = '</span></h2>';

    $args['category_before']  = '<div id="%id" class="%class">';

    $args['category_after']   = '</div>';

    $args['class']           .= " widget widget_links $category->slug";

    return $args;
  }

endif;

add_filter('widget_links_args', 'uw_patch_link_widget');

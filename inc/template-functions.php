<?php

/**
 * Banner
 *
 */

if ( ! function_exists( 'banner_class' ) ): 
  function banner_class() 
  {
    $option = get_option('patchband');

    if ( ! is_array($option) )
      return;

    $patch    = (object) $option['patch'];
    $band     = (object) $option['band'];
    $wordmark = (object) $option['wordmark'];

    $classes[] = 'header';

    if ( !$patch->header['visible'] ) 
      $classes[] = 'hide-patch';

    if ( $patch->header['color']== 'purple' )
      $classes[] = 'purple-patch';

    if ( $band->header['color']== 'tan' )
      $classes[] = 'tan-band';

    if ( $wordmark->header['color']== 'white' )
      $classes[] = 'wordmark-white';

    echo 'class="'. join(' ', $classes ) . '"';
  }
endif;


/**
 * Wordmark 
 *
 */

if ( ! function_exists( 'is_custom_wordmark' ) ): 
  function is_custom_wordmark()
  {
    $option = get_option('patchband'); 

    if ( ! is_array( $option) )
      return false;

    $wordmark = (array) $option['wordmark'];
    if ( isset($wordmark['custom'] )) 
      return true;

    return false;
  }
endif;

if ( ! function_exists( 'custom_wordmark' ) ): 
  function custom_wordmark() 
  {
    $option = get_option('patchband');

    if ( ! is_array( $option) )
      return;

    $wordmark = (array) $option['wordmark'];
    if ( isset($wordmark['custom'] )) {
      echo ' style="background:url('.$wordmark['custom']['url'].') no-repeat transparent; height:75px; width:445px;" ' ;
    }
  }
endif;

/**
 * Breadcrumbs 
 *
 */

if( ! function_exists('get_uw_breadcrumbs') ) :
  function get_uw_breadcrumbs()
  {
    global $post;

    $ancestors = array_reverse(get_post_ancestors($post->ID));
    $ancestors[] = $post->ID;
    $len = count($ancestors);
    if ( $len == 1 )
      return '';

    foreach ($ancestors as $index=>$ancestor) 
    {
      $class = $index+1 == count($ancestors) ? ' class="current" ' : '';
      $page  = get_post($ancestor);
      $url   = get_permalink($page->ID);
      $html .= "<li $class><a href=\"$url\" title=\"{$page->post_title}\">{$page->post_title}</a>";
    }
    return "<div class=\"breadcrumbs-container\"><ul class=\"breadcrumbs-list\">$html</ul></div>";
  }
endif;

if( ! function_exists('uw_breadcrumbs') ) :
  function uw_breadcrumbs()
  {
    echo get_uw_breadcrumbs();
  }
endif;

if( ! function_exists('uw_breadcrumbs_on') ) :
  function uw_breadcrumbs_on()
  {
    return strlen(get_uw_breadcrumbs()) > 0;
  }
endif;


/**
 * Dropdowns 
 */

if ( ! function_exists( 'uw_dropdowns' ) ): 

  function uw_dropdowns() 
  {
    $nav = has_nav_menu('primary');

    if ( ( !$nav ) && ( is_multisite() ) )
    {
      switch_to_blog(1);
    }

    wp_nav_menu( array( 
      'theme_location'  => 'primary',
      'container_class' => 'dawgdrops-inner',
      'menu_class'      => 'dawgdrops-nav',
      'fallback_cb'     => '',
      'walker'          => new UW_Dropdowns_Walker_Menu()
    ) );

    if ( ( !$nav ) && ( is_multisite() ) )
    {
      restore_current_blog();
    }
  }

endif;

/**
 * Footer Menu
 */

if ( ! function_exists( 'uw_footer_menu') ) :
  function uw_footer_menu() 
  {
    $nav = has_nav_menu('footer');
    if ( ( !$nav ) && ( is_multisite() ) )
    {
      switch_to_blog(1);
    }

    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object($locations['footer']);

    echo "<h2>{$menu->name}</h2>";
    wp_nav_menu( array( 
      'theme_location'  => 'footer',
      'menu_class'      => 'footer-navigation',
      'fallback_cb'     => '',
    ) );
    if ( ( !$nav ) && ( is_multisite() ) )
    {
      restore_current_blog();
    }
  }
endif;


/**
 * Previous/Next links
 */
if ( ! function_exists( 'uw_prev_next_links') ) :
  function uw_prev_next_links( $nav_id='prev-next' ) 
  {
    global $wp_query;

    if ( $wp_query->max_num_pages > 1 ) :

        $big = 999999999; // need an unlikely integer
        $current = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $links = paginate_links( array(
          'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
          'format' => '?paged=%#%',
          'type' => 'array',
          'current' => max( 1, get_query_var('paged') ),
          'total' => $wp_query->max_num_pages
        ) ); 

      echo '<div class="pagination pagination-centered"><ul>';

      foreach ($links as $index=>$link) :

        $link = str_replace('span', 'a', $link);
        if ( strip_tags($link) == $current ) 
          echo "<li class=\"disabled\"><a href='javascript:void(0);'>$current</a></li>";
        else
          echo "<li>$link</li>";

      endforeach;

      echo '</ul></div>';

   endif;
  }
endif;



/**
 * Excerpt more filter
 */
add_filter('excerpt_more', 'uw_excerpt_more');
if ( ! function_exists( 'uw_excerpt_more') ):

   function uw_excerpt_more( $more ) 
   {
	  global $post;
   	return '... <a href="'. get_permalink($post->ID) . '">Read More</a>';
   }
endif;



/**
 * Body classnames
 *  @requires: uw_breadcrumbs_on()
 */
add_filter('body_class','uw_custom_body_classes');
if ( ! function_exists( 'uw_custom_body_classes' ) ):
  function uw_custom_body_classes($classes) 
  {
    if ( is_multisite() )
        $classes[] = 'site-'. sanitize_html_class( str_replace( 'cms', '', get_blog_details( get_current_blog_id() )->path ) );
    $classes[] = is_home() && get_option('blogroll-banner') ? 'featured-image' : '';
    $classes[] = uw_breadcrumbs_on() ? 'breadcrumbs' : '';
    return $classes;
  }
endif;





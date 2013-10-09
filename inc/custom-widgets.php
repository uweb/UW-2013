<?php
/**
 * Custom Widgets:
 *  - Registers the default widget locations: Sidebar and Homepage Sidebar
 *  - Registers all of the UW custom widgets
 *  - Removes all unwanted widgets
 */

if ( ! function_exists( 'uw_widgets_init' ) ): 

  function uw_widgets_init() 
  {
    $args = array(
      'name'          => 'Sidebar',
      'id'            => 'sidebar',
      'description'   => 'Widgets for the right column of the all '. get_bloginfo('name') . ' subpages',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>'
    );

    register_sidebar($args);    

    $args = array(
      'name'          => 'Homepage Sidebar',
      'id'            => 'homepage-sidebar',
      'description'   => 'Widgets for the right column of the '. get_bloginfo('name') . ' homepage',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>'
    ); 
        
    register_sidebar($args);
    
  }

endif;


function uw_register_widgets() {

	if ( !is_blog_installed() )
		return;

  unregister_widget('Widget_Akismet');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Recent_Posts');
  unregister_widget('WP_Widget_RSS');

  register_widget('UW_Widget_Single_Image');
  register_widget('UW_RSS_Widget');
	register_widget('UW_Widget_Recent_Posts');
  register_widget('UW_Widget_CommunityPhotos');
  register_widget('UW_Widget_Categories');
  register_widget('UW_Widget_Twitter');
  //register_widget('UW_KEXP_KUOW_Widget');
  register_widget('UW_Showcase_Widget');
  register_widget('UW_Subpage_Menu');
  register_widget('UW_Nav_Menu_Widget');
  register_widget('UW_Calendar');
  register_widget('UW_Campus_Map');
  register_widget('UW_Slideshow');
  // Specific to Page Builder only
  register_widget('UW_Headline_Separator_Widget');
  register_widget('UW_Headline_Widget');
  register_widget('UW_Intro_Widget');
  register_widget('UW_YouTube_Playlist_Widget');

  if ( is_multisite() && get_blog_details('marketing') )
    register_widget('UW_Pride_Points');
}

require( get_template_directory() . '/inc/widgets/widget-settings.php' );
require( get_template_directory() . '/inc/widgets/slideshow.php' );
require( get_template_directory() . '/inc/widgets/single-image.php' );
require( get_template_directory() . '/inc/widgets/uw-recent-posts.php' );
require( get_template_directory() . '/inc/widgets/uw-rss.php' );
require( get_template_directory() . '/inc/widgets/subpage-menu.php' );
require( get_template_directory() . '/inc/widgets/pride-points.php' );
require( get_template_directory() . '/inc/widgets/community-photos.php' );
require( get_template_directory() . '/inc/widgets/twitter.php' );
//require( get_template_directory() . '/inc/widgets/kexp-kuow.php' );
require( get_template_directory() . '/inc/widgets/showcase.php' );
require( get_template_directory() . '/inc/widgets/calendar.php' );
require( get_template_directory() . '/inc/widgets/campus-map.php' );
require( get_template_directory() . '/inc/widgets/headline-separator.php' );
require( get_template_directory() . '/inc/widgets/headline.php' );
require( get_template_directory() . '/inc/widgets/intro.php' );

// The following widgets just override parts of the core Wordpress Widgets
require( get_template_directory() . '/inc/widgets/uw-link.php' );
require( get_template_directory() . '/inc/widgets/uw-categories.php' );
require( get_template_directory() . '/inc/widgets/uw-nav-menu.php' );
require( get_template_directory() . '/inc/widgets/youtube-playlist.php' );

add_action( 'widgets_init', 'uw_widgets_init' );
add_action( 'widgets_init', 'uw_register_widgets', 1);
remove_action( 'widgets_init', 'akismet_register_widgets' ); // unregister_widget doesn't work

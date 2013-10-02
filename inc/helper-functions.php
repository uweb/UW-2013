<?php

/**
* Image helpers to display caption and description
*/

if (!function_exists('get_the_post_thumbnail_caption')) :

  function get_the_post_thumbnail_caption() 
  {
    return get_post(get_post_thumbnail_id())->post_excerpt; 
  }

endif;

if (!function_exists('the_post_thumbnail_caption')) :

  function the_post_thumbnail_caption() 
  {
    echo apply_filters('the_content', get_the_post_thumbnail_caption());
  }

endif;

if ( ! function_exists( 'is_pdf' ) ):

  function is_pdf() 
  {
    return get_post_mime_type() == 'application/pdf';
  }

endif;

if ( ! function_exists( 'is_local' ) ):

  function is_local() 
  {
    return defined('WP_LOCAL');
  }

endif;

if ( ! function_exists( 'get_iframe_domains' )):
  function get_iframe_domains() 
  {
    return array(
      'uw.edu',
      'washington.edu',
      'uwtv.org',
      'www.uwtv.org',
      'google.com',
      'youtube.com',
      'excition.com',
      'www.uw.edu',
      'www.washington.edu',
      'www.google.com',
      'www.excition.com',
      'www.youtube.com'
    );
  }
endif;

if ( ! function_exists('gravatar_exists') ) :
  function gravatar_exists($email) 
  {
    $uri = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?d=404';
    $headers = @get_headers($uri);
    return ! preg_match("|200|", $headers[0]) ? false : true;
  }
endif;

if ( ! function_exists('uw_the_author_meta') ) :
  function uw_the_author_meta($meta, $before = "", $after = "") 
  {
    $data = get_the_author_meta($meta);
    echo !!$data ? $before . $data . $after : '';
  }
endif;

if ( ! function_exists('uw_check_author') ) :

  function uw_check_author()
  {
    if ( ! function_exists('uw_get_coauthors') )
      return true;

    $authors = uw_get_coauthors();
    return ( sizeof($authors) == 1 && isset( $authors[0]->ID ));
  }

endif;

if ( ! function_exists( 'uw_title' ) ) : 

  function uw_title() 
  {

    /*
         * Print the <title> tag based on what is being viewed.
         */
        global $page, $paged;

        wp_title( '|', true, 'right' );

        // Add the blog name.
        bloginfo( 'name' );

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) )
          echo " | $site_description";

        // Add a page number if necessary:
        if ( $paged >= 2 || $page >= 2 )
          echo ' | ' . sprintf( __( 'Page %s', 'uw' ), max( $paged, $page ) );

  }

endif;

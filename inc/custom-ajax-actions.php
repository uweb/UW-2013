<?php

/**
 * Returns a list of posts in json form filtered by a search parameter
 */
class UW_Search_Posts
{

  const NAME = 'search-posts';
  
  function UW_Search_Posts()
  {
    add_action( 'wp_ajax_' . self::NAME , array( $this, 'search_posts' ) );
    //add_action( 'init' , array( $this, 'search_posts' ) );
  }

  function search_posts()
  {
    $query = $_GET['s'];
    $post_types = get_post_types( array('public'=>true ) );
    $index = 0;
    foreach ( $post_types as $post_type ) 
    {
      $posts = get_posts( 'numberposts=10&s=' . $query . '&post_type=' . $post_type );

      foreach ( $posts as $post ) 
      {
        $res[ $index ][ 'title' ]       = $post->post_title;
        $res[ $index ][ 'url' ]       = get_permalink( $post->ID );
        $res[ $index ][ 'category' ]  = ucfirst( $post->post_type ) . 's';
        $index++;
      }

    }
    echo json_encode( $res ); 
    wp_die();
  }

  

}

new UW_Search_Posts;



<?php

/**
 * Returns a search list of all post types in json form filtered by a search parameter
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
    $post_types = empty($_GET['posttype']) ? get_post_types( array('public'=>true ) ) : array($_GET['posttype']);
    $index = 0;
    foreach ( $post_types as $post_type ) 
    {
      $posts = get_posts( 'numberposts=10&s=' . $query . '&post_type=' . $post_type );

      foreach ( $posts as $post ) 
      {
        $res[ $index ][ 'id' ]        = $post->ID;
        $res[ $index ][ 'title' ]     = $post->post_title;
        $res[ $index ][ 'image' ]     = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
        $res[ $index ][ 'imageID' ]   = get_post_thumbnail_id( $post->ID );
        $res[ $index ][ 'excerpt' ]   = $post->post_excerpt;
        $res[ $index ][ 'url' ]       = get_permalink( $post->ID );
        $res[ $index ][ 'category' ]  = ucfirst( $post->post_type ) . 's';
        $index++;
      }

    }
    wp_send_json_success( $res ); 
  }

  

}

new UW_Search_Posts;



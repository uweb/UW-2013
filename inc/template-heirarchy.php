<?php

class UW_Template_Redirect
{

  function UW_Template_Redirect()
  {

    add_filter( 'page_template', array( $this, 'page_site_template' ) );
  
  }

  function page_site_template( $templates='' )
  {
    $page = get_queried_object();
    $slug = $page->post_name;

    $site = basename( get_blog_details()->path );

    if ( !is_array( $templates ) )
      $templates = basename( $templates );

    $template = "site-templates/page-$site-$slug.php";

    if( !is_array($templates) && !empty($templates) ) 
    {

      $templates = locate_template( array($template, $templates), false );

    } elseif ( empty($templates) ) {

      $templates = locate_template( $template, false );

    } else {

      $new_template = locate_template( array( $template ) );

      if( !empty($new_template) ) 
        array_unshift( $templates, $new_template );

    }
    
    return $templates;

  }

}

new UW_Template_Redirect;

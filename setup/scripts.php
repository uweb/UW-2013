<?php
/**
 * This is where all the JS files are registered
 *    - bloginfo('template_directory')  gives you the url to the parent theme
 *    - bloginfo('stylesheet_directory')  gives you the url to the child theme
 */

class UW_Install_Scripts
{

  public $SCRIPTS;


  function UW_Install_Scripts() 
  {

    $this->SCRIPTS = array( 

      'jquery' => array ( 
        'id'      => 'jquery',
        'url'     => 'https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',
        'deps'    => array(),
        'version' => '1.9.1'
      ),

      'site'   => array ( 
        'id'      => 'site',
        'url'     => get_bloginfo('template_directory') . '/js/site.js',
        'deps'    => array( 'jquery', 'swfobject' ),
        'version' => '1.0.1'
      ),

//      'jquery.searchposts' => array ( 
//        'id'      => 'jquery.searchposts',
//        'url'     => get_bloginfo('template_directory') . '/js/admin/jquery.wp.searchposts.js',
//        'deps'    => array( 'jquery' ),
//        'version' => '1.0',
//        'admin'   => true
//      )

    );

    add_action( 'wp_enqueue_scripts', array( $this, 'uw_register_default_scripts' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'uw_enqueue_default_scripts' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'uw_enqueue_admin_scripts' ) );

  }

  function uw_register_default_scripts() 
  {
      wp_deregister_script( 'jquery' ); 

      foreach ( $this->SCRIPTS as $script ) 
      {
        $script = (object) $script;

        wp_register_script( 
          $script->id,
          $script->url,
          $script->deps,
          $script->version
        );

      }

  }

  function uw_enqueue_default_scripts() 
  {
      foreach ( $this->SCRIPTS as $script ) 
      {
        $script = (object) $script;

        wp_enqueue_script( $script->id );
      }
  }

  function uw_enqueue_admin_scripts()
  {
      if ( ! is_admin() )
        return;

      foreach ( $this->SCRIPTS as $script ) 
      {
        $script = (object) $script;

        if ( array_key_exists( 'admin', $script ) 
              && $script->admin ) 
        {

          wp_register_script( 
            $script->id,
            $script->url,
            $script->deps,
            $script->version
          );

          wp_enqueue_script( $script->id );

        }
      }
  
  }

}
new UW_Install_Scripts;

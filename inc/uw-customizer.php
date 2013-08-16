<?php
/**
 *
 * Uses the Wordpress theme customizer for patch and band 
 * options in the theme's header.
 *
 */
class UW_Customizer
{
  const PRIORITY = 130;

  static $COLOR_SCHEMES = array(
            'blue'    => 'Blue',
            'green'   => 'Green',
            'gold'    => 'Gold',
            'purple'  => 'Purple',
  );

  static $PATCH_COLORS = array(
      'gold-patch'    => 'Gold',
      'purple-patch'  => 'Purple' 
  );

  static $BAND_COLORS = array(
      'purple-band'   => 'Purple',
      'tan-band'      => 'Tan',
  );

  static $WORDMARK_COLORS = array(
      'wordmark-purple'   => 'Purple',
      'wordmark-white'    => 'White',
  );
  
  function UW_Customizer()
  {
    add_action( 'customize_register', array( $this, 'uw_customize_register_patch_band') );
    add_action( 'customize_register', array( $this, 'uw_customize_register_color_schemes') );
    add_action( 'customize_preview_init', array( $this, 'uw_customizer_live_preview' ) );
  }

  function uw_customizer_live_preview()
  {
    wp_enqueue_script( 'uw-theme-customizer', get_template_directory_uri().'/js/theme-customizer.js', array( 'jquery','customize-preview' ), '', true );
  }

  function uw_customize_register_patch_band( $wp_customize ) 
  {

      $wp_customize->add_section('patch_band', array(
          'title'    => 'Patch & Band',
          'priority' => self::PRIORITY,
      ));

    /**
     * Show/Hide Patch
     */
      $wp_customize->add_setting('patch_visible', array(
          'default'   => 1,
      ));
   
      $wp_customize->add_control('display_patch', array(
          'settings'  => 'patch_visible',
          'label'     => 'Show Patch',
          'section'   => 'patch_band',
          'type'      => 'checkbox',
      ));

    /**
     * Patch Color
     */
      $wp_customize->add_setting('patch_color', array(
          'default'    => key( self::$PATCH_COLORS )
      ));
   
      $wp_customize->add_control('patch_color_controller', array(
          'label'      => 'Patch Color',
          'section'    => 'patch_band',
          'settings'   => 'patch_color',
          'type'       => 'radio',
          'choices'    => self::$PATCH_COLORS
      ));
      
    /**
     * Band Color
     */
      $wp_customize->add_setting('band_color', array(
          'default'        => key( self::$BAND_COLORS )
      ));
   
      $wp_customize->add_control('band_color_controller', array(
          'label'      => 'Band Color',
          'section'    => 'patch_band',
          'settings'   => 'band_color',
          'type'       => 'radio',
          'choices'    => self::$BAND_COLORS
      ));
      

      /**
       * Wordmark 
       */

      $wp_customize->add_setting( 'wordmark' );
      $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'wordmark_controller', array(
          'label'    => 'Wordmark',
          'section'  => 'patch_band',
          'settings' => 'wordmark',
      ) ) );

      /**
       * Wordmark Color
       */
      //if ( ! get_theme_mod( 'wordmark' ) ) :
        $wp_customize->add_setting('wordmark_color', array(
            'default'    => key( self::$WORDMARK_COLORS )
        ));
     
        $wp_customize->add_control('wordmark_color_controller', array(
            'label'      => 'Wordmark Color',
            'section'    => 'patch_band',
            'settings'   => 'wordmark_color',
            'type'       => 'radio',
            'choices'    => self::$WORDMARK_COLORS
        ));
      //endif;


      // allows live javascript updates
      $wp_customize->get_setting('patch_visible')->transport    = 'postMessage';
      $wp_customize->get_setting('patch_color')->transport      = 'postMessage';
      $wp_customize->get_setting('band_color')->transport       = 'postMessage';
      $wp_customize->get_setting('wordmark')->transport         = 'postMessage';
      $wp_customize->get_setting('wordmark_color')->transport   = 'postMessage';
   
  }


  function uw_customize_register_color_schemes( $wp_customize )
  {

      $wp_customize->add_section('color_schemes', array(
          'title'    => 'Color Scheme',
          'priority' => self::PRIORITY,
      ));
   
      $wp_customize->add_setting('color_scheme', array(
          'default'  => key( self::$COLOR_SCHEMES )
      ));

      $wp_customize->add_control( 'color_scheme_controller', array(
        'settings'  => 'color_scheme',
        'label'     => 'Select color:',
        'section'   => 'color_schemes',
        'type'      => 'select',
        'choices'   => self::$COLOR_SCHEMES,
      ));

      // allows live javascript updates
      $wp_customize->get_setting('color_scheme')->transport = 'postMessage';
    
  }

}

new UW_Customizer;

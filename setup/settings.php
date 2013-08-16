<?php

//// Header image width and height
//define( 'HEADER_IMAGE_WIDTH', apply_filters( 'uw_header_image_width', 1280 ) );
//define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'uw_header_image_height', 193 ) );

// No header text in the Appearance->Header page
//define( 'NO_HEADER_TEXT', true );

// Wordpress 3.5 oEmbed max-width
if ( ! isset( $content_width ) ) 
  $content_width = 620;

/**
 * Disable new user notification emails
 */
if ( !function_exists('wp_new_user_notification') ) :

  function wp_new_user_notification() { return; };

endif;


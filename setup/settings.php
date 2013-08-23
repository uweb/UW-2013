<?php


// Wordpress 3.5 oEmbed max-width
if ( ! isset( $content_width ) ) 
  $content_width = 620;

/**
 * Disable new user notification emails
 */
if ( !function_exists('wp_new_user_notification') ) :

  function wp_new_user_notification() { return; };

endif;


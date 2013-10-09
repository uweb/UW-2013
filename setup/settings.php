<?php


// Wordpress 3.5 oEmbed max-width
if ( ! isset( $content_width ) ) 
  $content_width = 620;

/**
 * Disable new user notification emails
 */
add_filter( 'wpmu_signup_user_notification', '__return_false' );

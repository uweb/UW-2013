<?php
/**
 * Adds a media credit to images in the media library
 */

class UW_Media_Credit
{

  function UW_Media_Credit()
  {
    add_filter( 'img_caption_shortcode', array( $this, 'add_media_credit_to_caption_shortcode_filter'), 10, 3 );

    add_filter("attachment_fields_to_edit", array( $this, "image_attachment_fields_to_edit"), 100, 2);
    add_filter("attachment_fields_to_save", array( $this, "custom_image_attachment_fields_to_save" ), null, 2);
  
  }

  /**
   * Override the caption html - original in wp-includes/media.php
   */
  function add_media_credit_to_caption_shortcode_filter($val, $attr, $content = null)
  {
    extract(shortcode_atts(array(
      'id'	=> '',
      'align'	=> '',
      'width'	=> '',
      'caption' => ''
    ), $attr));
    
    if ( 1 > (int) $width || empty($caption) )
      return $content;

    if ( $id ) $id = 'id="' . esc_attr($id) . '" ';

    preg_match('/([\d]+)/', $id, $match);

    if ( $match[0] ) $credit = get_post_meta($match[0], '_media_credit', true);

    if ( $credit ) $credit = '<p class="wp-media-credit">'. $credit . '</p>';

    return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . (10 + (int) $width) . 'px">'
    . do_shortcode( $content ) . $credit . '<p class="wp-caption-text">' . $caption . '</p></div>';
  }

  /**
   * Adding the custom fields to the $form_fields array
   */
  function image_attachment_fields_to_edit($form_fields, $post) 
  {
    if ( ! in_array( $_REQUEST['context'],
      array( 'custom-header-blogroll-banner', 'custom-header' ) ) && 
        wp_attachment_is_image( $post->ID ) )
    {
      $form_fields["media_credit"] = array(
        "label" => __("Image Credit"),
        "input" => "text", 
        "value" => get_post_meta($post->ID, "_media_credit", true)
      );

      $form_fields["media_credit"]["label"] = __( "Image Credit" );
      $form_fields["media_credit"]["input"] = "text";
      $form_fields["media_credit"]["value"] = get_post_meta( $post->ID, "_media_credit", true );
    }

    return $form_fields;
  }

  /**
   * Save the media credit
   */
  function custom_image_attachment_fields_to_save($post, $attachment) {
    if( isset( $attachment['media_credit'] ) ) 
    {
      update_post_meta($post['ID'], '_media_credit', $attachment['media_credit']);
    }
    return $post;
  }



}

new UW_Media_Credit;

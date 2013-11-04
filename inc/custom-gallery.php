<?php

/**
 * UW Gallery - Custom template for the built in WP gallery shortcode
 */

class UW_Gallery
{

  function UW_Gallery()
  {
    add_filter( 'post_gallery', array( $this, 'uw_gallery_template' ), 10, 2 );
  }

  function uw_gallery_template( $output, $attr )
  {
    extract(shortcode_atts(array(
      'order'      => 'ASC',
      'orderby'    => 'menu_order ID',
      'id'         => $post->ID,
      'itemtag'    => 'dl',
      'icontag'    => 'dt',
      'captiontag' => 'dd',
      'columns'    => 3,
      'size'       => 'thumbnail',
      'include'    => '',
      'exclude'    => ''
    ), $attr));

    $id = intval($id);

    if ( 'RAND' == $order )
      $orderby = 'none';
    
    $attachments = get_posts( array(
      'include' => $include,
      'post_status' => 'inherit',
      'post_type' => 'attachment',
      'post_mime_type' => 'image',
      'order' => $order,
      'orderby' => $orderby) 
    );
    
    if ( empty($attachments) )
      return '';

    $len = sizeof($attachments);

    $groups = array_chunk($attachments, 5);

    $html = '<div class="gallery"><a href="#" class="slideshow-left"></a><a href="#" class="slideshow-right"></a><div class="gallery-viewport-wrapper"><div class="gallery-viewport">';
    $menu = '';
    
    foreach ($groups as $i=>$images) 
    {
      $group = '';
      $large = '';

      foreach ($images as $index=>$image) 
      {

        $url = wp_get_attachment_image_src($image->ID);
        $url_large = wp_get_attachment_image_src($image->ID, 'thumbnail-large');
        $med_url = wp_get_attachment_image_src($image->ID, array(620, 620));
        $permalink = get_permalink($image->ID);
        $credit = get_post_meta($image->ID, "_media_credit", true);
        
        if ( $index == 4 || $len < 5 ) {

          $large = '<div class="gallery-image" data-permalink-url="'.$permalink.'" data-url="'.$med_url[0].'" data-wp-url="'. $permalink .'" style="background-image:url('.$url_large[0].')"><span><p class="image-title">'. $image->post_title .'</p><p>' . $image->post_excerpt .' <em>'.$credit.'</em></p></span></div>';

          if ( $len < 5 )  
            $html .= "<div class=\"large\">$large</div>";

        } else {

          $group .= '<div class="gallery-image" data-permalink-url="'.$permalink.'" data-url="'. $med_url[0] .'" data-wp-url="'. $permalink .'" style="background-image:url('.$url[0].');"><span><p class="image-title">'. $image->post_title . '</p><p>' . $image->post_excerpt . ' <em>'.$credit.'</em></p><p class="text-shadow"></p></span></div>';

        }

      };

      $menu .= '<li>'.$i.'</li>';

      if ( $len > 4 ) 
      {
        $html .= ( $i % 2 ) ? 
          "<div class=\"large\">$large</div><div class=\"group\">$group</div>" :
          "<div class=\"group\">$group</div><div class=\"large\">$large</div>";
      }
    }

    $html .= '</div></div><div class="gallery-table"><ul class="gallery-menu">'.$menu.'</ul></div></div><!-- .gallery -->';

    $overlay = '<div id="gallery-overlay-image" style="display:none">
                  <img />
                  <div class="description">
                    <div class="image-description"></div>
                    <div class="share">
                      <a class="gallery-facebook" data-href="http://www.facebook.com/sharer.php?u=" title="Facebook" target="_blank">Facebook</a>
                      <a class="gallery-twitter" data-href="http://twitter.com/?status=" title="Twitter" target="_blank">Twitter</a>
                      <span class="separator"></span>
                      <a class="gallery-original" href="#" title="Original Image" target="_blank">Original Image</a>
                    </div>
                  </div>
                  <a class="gallery-close">Close</a><a class="gallery-caption visible-phone" href="#">Show caption</a></div>';
    
    return $html . $overlay;

  }

}

new UW_Gallery;

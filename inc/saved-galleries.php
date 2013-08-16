<?php

/**
 *
 * "Saved Galleries" Tab 
 *  - this file and javascript file admin/js/saved-galleries.js
 *
 **/

class UW_Saved_Galleries 
{

  public $MINUTE = 60;

  function UW_Saved_Galleries()
  {
    add_action( 'admin_footer', array( $this,  'uw_print_javascript_templates' ) );
    add_filter('media_view_strings', 'uw_gallery_list_menu_item', 10, 2);
    add_action('wp_ajax_get-galleries', 'uw_get_galleries');
  }

  function uw_print_javascript_templates() 
  {
    ?>
    
    <script type="text/html" id="tmpl-gallery-list">
      <div class="attachment-preview type-{{ data.type }} subtype-{{ data.subtype }} {{ data.orientation }}">
          <div class="thumbnail">
            <div class="centered">
              <img src="{{ data.url }}" draggable="false" />
            </div>
          </div>
          <a class="check" href="#" title="<?php _e('Deselect'); ?>"><div class="media-modal-icon"></div></a>
      </div>
      {{ data.post_title }} <br/> <small>{{ data.count }} Photos</small>
    </script>

    <?php

  }
 
  function uw_gallery_list_menu_item($strings,  $post)
  {
      $strings['savedGalleriesMenuTitle'] = __('Saved Galleries', 'custom');
      $strings['savedGalleriesButton'] = __('Insert Gallery', 'custom');
      return $strings;
  }


  function uw_get_galleries() 
  {

    $gallery_posts = get_transient('gallery-list');

    if ( false == $gallery_posts ) 
    {

        $gallery_posts_query_args = array(
            's' => '[gallery'
        );

        $gallery_posts = get_posts( $gallery_posts_query_args );

        set_transient('gallery-list', $gallery_posts, $this->MINUTE);
    
    }

    echo json_encode($gallery_posts);

    wp_reset_postdata();
    
    die(); 
  }


}

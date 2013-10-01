<?php
/**
 *
 * Slideshow widget
 *
 * Choose a series of images from the media library to display as a slideshow
 *
 *
 * This widget just stores the ids for the images selected from the gallery and uses either JS or PHP 
 *  to fetch the attachments from the backend. (JS for fetching on the admin side and PHP for fetching 
 *  on the public side)
 *
 * [TODO]: CSS is being used for now to hide the custom 'External Link' field from showing up in the 
 *          Media Library outside of the slideshow.
 *
 */

class UW_Slideshow extends WP_Widget
{

  public $ALLOWED_SCREENS = array( 
    'widgets',
    'appearance_page_so_panels_home_page'
  );

  function UW_Slideshow()
  {
    parent::WP_Widget( 
      $id = 'slideshow',
      $name = 'Slideshow',
      $options = array( 
        'description' => 'Select and display a slideshow of images.',
        'classname'   => 'slideshow-widget'
      )
    );

    if ( is_admin() ) 
    {
      add_action( 'admin_enqueue_scripts', array( $this , 'scripts') );
      add_action( 'admin_print_styles', array( $this , 'styles' ) );
      add_filter( 'attachment_fields_to_edit', array( $this , 'external_link_to_field_edit' ), 101, 2 );
		  add_filter( 'attachment_fields_to_save', array( $this , 'external_link_to_field_save' ), null , 2 );
      
    }
  }

  function scripts() 
  {
    wp_enqueue_script('slideshow-js',  get_bloginfo('template_directory') . '/js/admin/widgets/slideshow.js' , null, null, true );
    wp_enqueue_media();
  }

  function styles() 
  {
    $screen = get_current_screen();

    //Bug fix: some form elements in the media library aren't clickable and conflict with the panels page builder
    echo '<style type="text/css"> .media-sidebar { z-index:0 !important; } </style>';

    if ( ! in_array( $screen->id, $this->ALLOWED_SCREENS ))
      echo '<style type="text/css"> .compat-field-external_link { display:none !important; }; </style>';
  }

  function form( $instance ) 
  {

    $title   = isset($instance['title']) ? esc_attr($instance['title']) : 'Slideshow';
    $slideshow = isset($instance['slideshow']) ? esc_attr($instance['slideshow']) : '';

    ?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

    <p>

      <ul class="slideshow-preview" style="float:left;width:100%;"></ul>

      <input id="<?php echo $this->get_field_id( 'slideshow' ); ?>" name="<?php echo $this->get_field_name( 'slideshow' ); ?>" type="hidden" value="<?php echo esc_attr( $slideshow ); ?>"/>

      <a class="select-a-gallery button" href="#">Select Images</a>

    </p>

    <script type="text/template" id="tmpl-slideshow-images">
      <li class="attachment selection selected save-ready">
        <div class="attachment-preview type-image subtype-png {{ data.sizes.thumbnail.orientation }}" style="width:80px;height:80px;">
            <div class="thumbnail">
              <div class="centered">
                <img src="{{ data.sizes.thumbnail.url }}" alt="{{ data.title }}" style="max-height:80px; width:auto;"/>
              </div>
            </div>
        </div>
      </li>
    </script>

  <?php
  
  }

  function update($new_instance, $old_instance)
  {
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['slideshow'] = $new_instance['slideshow'];
    return $instance;
  }

  function widget($args, $instance) 
  {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
    $ids   = explode(',', $instance['slideshow']);
    ?>

    <?php  echo $before_widget; ?>

    <div class="canvas">

      <?php foreach ( $ids as $index=>$id ) : $attachment = get_post( $id ); $link = get_post_meta( $attachment->ID, '_external_link', true ); ?>

        <div class="slide<?php echo ( $index == 0 ) ? ' active-slide' : ''; ?>">

        <?php echo wp_get_attachment_image( $id, 'original' ); ?>

          <div class="slide-info">
            <h3><a href="<?php echo $link ?>"><?php echo $attachment->post_title; ?></a></h3>
            <?php echo wpautop( $attachment->post_excerpt ); ?>
          </div>

        </div>

      <?php endforeach; ?>

    <?php if ( count($ids) - 1 ) : ?>

      <ul>
        <li><a class="active-slide" href="#"></a></li>
        <?php echo str_repeat('<li><a href="#"></a></li>', count($ids) - 1); ?>
      </ul>

    <?php endif; ?>

    </div>

    <?php echo $after_widget; 

  }

  function external_link_to_field_edit( $form_fields, $post ) 
  {
		$form_fields['external_link'] = array(
			'label' => 'External Link',
			'input' => 'text',
      'show_in_edit' => false,
			'value' => get_post_meta( $post->ID, '_external_link', true )
		);

		return $form_fields;
  }

  function external_link_to_field_save( $post, $attachment ) 
  {
    $link = $attachment['external_link'];

    if ( isset( $attachment['external_link'] ) ) 
			update_post_meta( $post['ID'], '_external_link', $link );

    return $post;
  }

}

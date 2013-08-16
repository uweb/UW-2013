<?php
/**
 *
 * UW Showcase widget
 *   - This is the Uber , cross site widget
 */

class UW_Showcase_Widget extends WP_Widget 
{

  public function UW_Showcase_Widget() 
  {
    parent::WP_Widget( 'uw_showcase_widget', 'UW Showcase', array( 
      'classname' => 'widget-uw-showcase',
      'description' => __( "Display a UW Showcase widget on your site") 
    ) );
	}

  public function widget( $args, $instance ) 
  {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

    echo $before_widget;

    if ( ! empty( $title ) ) echo $before_title . $title . $after_title;

    if (is_multisite())
        switch_to_blog(1);
    $post = get_post($instance['id']);
    echo apply_filters('the_content', $post->post_content);
    if (is_multisite())
        restore_current_blog();

    if (is_super_admin()) 
      echo '<a class="pull-right" target="_blank" href="' . $instance['edit'] . '">Edit</a>';
    
		echo $after_widget;
	}

  public function update( $new_instance, $old_instance ) 
  {
		$instance = array();
    if (is_multisite())
        switch_to_blog(1);
    $post = get_post($new_instance['id']);
    $edit = get_edit_post_link($post->ID);
    if (is_multisite())
        restore_current_blog();

		$instance['id'] = $new_instance['id'];
		$instance['title']   = strip_tags( $post->post_title );
    $instance['edit'] = $edit;

		return $instance;
	}

  public function form( $instance ) 
  {
    wp_enqueue_script('jquery-ui-dialog');
    $cat = get_term_by('slug','showcase-widget', 'category');
    $args = array(
      'numberposts' => -1,
      'category' => $cat->term_id
    );
    if (is_multisite())
        switch_to_blog(1);
    $posts = get_posts($args);
    if (is_multisite())
        restore_current_blog();
    
    $title  = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : __( 'Showcase', '' );  ?>

		<input class="widefat hidden" disabled="disabled" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

		<label for="<?php echo $this->get_field_id('id'); ?>"><?php _e( 'Choose content:' ); ?></label>
      <a class="alignright preview-showcase" id="preview-widget-<?php echo $this->get_field_id('id'); ?>" href="#preview">Preview</a>
			<select name="<?php echo $this->get_field_name('id'); ?>" id="<?php echo $this->get_field_id('id'); ?>" class="widefat showcase-select">

      <?php foreach($posts as $post) : ?>
        <option value="<?php echo $post->ID; ?>"<?php selected( $instance['id'], $post->ID); ?>><?php _e($post->post_title); ?></option>
      <?php endforeach; ?>

			</select>

      <style type="text/css">
        .preview-showcase-widget h2 {
          font-family: 'Open Sans', sans-serif; font-weight: 400; letter-spacing: -.05em; color: #39275B;
        }
        .preview-showcase-widget a {
          color: #3089C2;
          text-decoration:none;
        }
        .preview-showcase-widget li {
          margin-left: 0;
          margin-bottom: 5px;
          background: url('/cms/wp-content/themes/uw/img/bullet-gold.png') no-repeat left 7px transparent;
          list-style: none;
          padding-left: 12px;
         }
        .preview-showcase-widget p {
          font-size: 14px; line-height: 21px; 
          color: #333;
          font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
      </style>

      <?php foreach($posts as $post) : ?>

        <div class="hidden preview-showcase-widget post-<?php echo $post->ID; ?>">
          <h2><span><?php echo$post->post_title; ?></span></h2>
          <?php echo apply_filters('the_content', $post->post_content); ?>
        </div>

      <?php endforeach; ?>

      <script type="text/javascript">
        jQuery(document).ready(function($) {
          
                // set up a jquery boolean so this script only runs once on the page and not once per showcase widget
                if ( $.fn.showcase_widget_preview_enabled ) 
                  return;

                var length = $('select.showcase-select').first().find('option').length

                $('.preview-showcase-widget').slice(0,length)
                  .dialog({
                    autoOpen: false,
                    width:265,
                    modal:true
                 })

               $('body').on('click', 'a.preview-showcase', function() {
                 var $this = $(this)
                   , id    = $this.siblings('select').val()

                 $('.post-'+id).dialog('open');

               });

                $.fn.showcase_widget_preview_enabled = true;

        });
      </script>
		</p>
		<?php 
	}
} 

<?php
class UW_Pride_Points extends WP_Widget 
{

  function UW_Pride_Points() 
  {
    parent::WP_Widget( 'uw-pride-points', __('UW Pride Points'), array( 
      'description' => __('Show a UW pride point on your site!') 
    ) );
	}

  function widget($args, $instance) 
  {
    extract( $args );
		// outputs the content of the widget
		$title = apply_filters( 'widget_title', $instance['title'] );

    $content .= '<span>Pride Points</span>
      <div style="min-height:100px;">
      <div class="pride-point" style="display:none;z-index:0;" data-category="'.$instance['category'].'"></div>
      </div>
      <script type="text/javascript">
        jQuery(document).ready(function($){
          
          var $widget = $("#'.$widget_id.'").find(".pride-point");
          var data = {
            json : "pride_points.get_pride_point",
            cat  : $widget.data("category")
          }
          $.ajax({
            type: "GET",
            url : "/cms/marketing/",
            data: data, 
            success : function(json) {
              if ( json.status == "ok" && json.count === 1) 
                $widget.fadeIn().html(json.posts.content)

              if ( $widget.find("p").length > 1 )
                $widget.find("p:last").addClass("pride-src")
            },
            cache:false
          })
        });
      </script> 
      ';

    echo $before_widget . $content . $after_widget;
	}

  function update($new_instance, $old_instance) 
  {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		return $instance;
	}

  function form($instance) 
  {

		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$category = isset($instance['category']) ? esc_attr($instance['category']) : '';
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo $category; ?>" /></p>

<?php
	}
}



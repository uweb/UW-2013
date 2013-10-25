<?php
class UW_Pride_Points extends WP_Widget {

	function UW_Pride_Points() {
		$widget_ops = array( 'description' => __('Show a UW pride point on your site!') );
		parent::__construct( 'uw-pride-points', __('UW Pride Points'), $widget_ops );
	}

	function widget($args, $instance) {
		extract( $args );
		// outputs the content of the widget
		$url = network_site_url();

		$content .= '<div class="pride-point" style="display:none" data-category="'.$instance['category'].'"><span class="trophy"></span></div>
		  <script type="text/javascript">
			jQuery(document).ready(function($){
			  
			  var $widget = $("#'.$widget_id.'").find(".pride-point");
			  var data = {
				json : "pride_points.get_pride_point",
        count: 1,
				cat  : $widget.data("category")
			  }
			  $.ajax({
				type: "GET",
				url : "'. $url . 'marketing/",
				data: data, 
				success : function(json) {

				  if ( json.status == "ok" && json.count === 1) 
					  $widget.fadeIn().append(json.posts[0].content)

				  $widget.find("p").filter(function(i,el) {
					if ( /source/i.test(el.innerHTML ) )
					  $(el).addClass("pride-src")
				  })

				},
				cache:false
	  })
			});
		  </script> 
		  ';

		echo $before_widget . $content . $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		return $instance;
	}

	function form($instance) {

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


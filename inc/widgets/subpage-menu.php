<?php
/**
 *
 * Subpage Menu Widget - shows current page and all subpages
 *
 *
 ***********************************************************************************/
class UW_Subpage_Menu extends WP_Widget 
{

  public function UW_Subpage_Menu() 
  {
    parent::WP_Widget( 'uw_subpage_menu', 'Subpage Menu', array( 
      'classname' => 'subpage_menu',
      'description' => __( "Displays a menu of child pages of the current page"), 
    ));
	}

  public function widget( $args, $instance ) 
  {
		extract( $args );
		$id    = $this->get_post_top_ancestor_id();

    if ( ! count(get_pages("child_of=$id"))) 
      return;

    $title = '<a href="' . get_permalink($id) .'" title="'. esc_attr(strip_tags(get_the_title($id))) .'">'.get_the_title($id).'</a>';
    $depth = isset( $instance[ 'depth' ] ) ? $instance[ 'depth' ] : 1;  

    echo $before_widget;?>

    <?php echo $before_title . $title . $after_title; ?>
    <?php echo '<ul class="menu">';?>
    <?php wp_list_pages( array('title_li'=>'','depth'=>$depth,'child_of'=>$id) ); ?>
    <?php echo '</ul>'; ?>
    <?php
		echo $after_widget;
	}

  function update($new_instance, $old_instance) 
  {
		$instance = array();
		$instance['depth'] = (int) $new_instance['depth'];
		return $instance;
	}

  public function form( $instance ) 
  {

    $depth = isset( $instance[ 'depth' ] ) ? $instance[ 'depth' ] : 1;  

  ?>

		<p>
			<label for="<?php echo $this->get_field_id('depth'); ?>"><?php _e( 'Depth:' ); ?></label>
			<select name="<?php echo $this->get_field_name('depth'); ?>" id="<?php echo $this->get_field_id('depth'); ?>" class="widefat">
				<option value="1"<?php selected( $depth, 1 ); ?>>1</option>
				<option value="2"<?php selected( $depth, 2 ); ?>>2</option>
			</select>
		</p>

		<?php 
	}

  function get_post_top_ancestor_id() 
  {
      global $post;
      
      if($post->post_parent){
          $ancestors = array_reverse(get_post_ancestors($post->ID));
          return $ancestors[0];
      }
      
      return $post->ID;
  }
  
} 


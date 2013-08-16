<?php

/**
 * NOT CURRENTLY USED
 *
 * Showcase Links Widget
 */

class UW_Widget_Showcase_Links extends WP_Widget 
{

  public function UW_Widget_Showcase_Links() 
  {
    parent::WP_Widget( 'widget_showcase_links', 'Showcase Links', array( 
      'classname' => 'widget_showcase_links',
      'description' => __( "Showcase your links" ) 
    ) );
	}

  public function widget( $args, $instance ) 
  {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
    $category = $instance['category'];

    echo $before_widget;?>

    <div class="sub-block">
      <span class="showcase-bar <?php echo sanitize_title($instance['title']); ?>"></span>
      <?php if ( ! empty( $title ) ) echo $before_title . $title . $after_title; ?>
      <?php $links = get_bookmarks("category=$category&orderby=rating"); ?>

    <?php foreach($links as $index=>$link) : ?>
      <?php list($title, $source) = explode('-', $link->link_name); ?>
      <?php if($index == 0) :  ?>

      <a href="<?php echo $link->link_url;?>"> <img src="<?php echo $link->link_image; ?>"/> </a>
      <p>
        <a href="<?php echo $link->link_url;?>"> <?php echo $title; ?></a> -
        <?php echo $link->link_description; ?>
        <a href="<?php echo $link->link_url;?>"> <?php echo $source; ?></a>
      </p>
      <ul>

      <?php else: ?>

        <li><a href="<?php echo $link->link_url; ?>"><?php echo $link->link_name; ?></a></li>

      <?php endif; ?>

    <?php endforeach; ?>
      </ul>
    </div>

    <?php
		echo $after_widget;
	}

  public function update( $new_instance, $old_instance ) 
  {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = intval($new_instance['category']);

		return $instance;
	}

  public function form( $instance ) 
  {

  	$link_cats = get_terms( 'link_category');
    $title  = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : __( 'Showcased Links', '' );  ?>

		<p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
      <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select link category to display:'); ?></label>
      <select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">


      <?php foreach ( $link_cats as $link_cat ) {
        echo '<option value="' . intval($link_cat->term_id) . '"'
          . ( $link_cat->term_id == $instance['category'] ? ' selected="selected"' : '' )
          . '>' . $link_cat->name . "</option>\n";
      } ?>

      </select>
		</p>

		<?php 
	}

} 

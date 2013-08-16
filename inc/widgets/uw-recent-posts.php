<?php
/**
 *
 *
 * Updated Recent Posts widget that includes the featured image
 *
 *
 **************************************************************/

class UW_Widget_Recent_Posts extends WP_Widget 
{

	function UW_Widget_Recent_Posts() {

    parent::WP_Widget('recent-posts', __('Recent Posts'), array(
      'classname' => 'widget_recent_entries',
      'description' => __( "The most recent posts on your site") 
    ) ) ;

		$this->alt_option_name = 'widget_recent_entries';
		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

  function widget($args, $instance) 
  {
		$cache = wp_cache_get('widget_recent_posts', 'widget');

    $show_popular = class_exists('GADWidgetData') && $instance['show-popular'];

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;

		$r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true));
		if ($r->have_posts()) :

    if ( $show_popular ) {
      $blog_details = get_blog_details(get_current_blog_id());
      $path = str_replace('/cms', '', $blog_details->path);

      $start_date = date('Y-m-d', strtotime('-1 week', time()));
      $end_date   = date('Y-m-d', time());

      $login = new GADWidgetData();

      if($login->auth_type == 'oauth') {
        $ga = new GALib('oauth', NULL, $login->oauth_token, $login->oauth_secret, $login->account_id);
      } else {
        $ga = new GALib('client', $login->auth_token, NULL, NULL, $login->account_id);
      }

      $wp_posts = array();
      $pop_posts = $ga->pages_for_date_period($start_date, $end_date, $number+1);
      foreach ($pop_posts as $index=>$post) {
        if( $post['value'] == $path ) 
          unset($pop_posts[$index]);
        else {
          $wp_post = get_page_by_path(basename($post['value']), OBJECT, 'post');
          if (isset($wp_post) && !in_array($wp_post, $wp_posts)) {
            $wp_posts[] = $wp_post;
            $wp_post_views[$wp_post->ID] = $post['children']['children']['ga:pageviews'];
          }
        }
      }
      $pop_posts = array_slice($wp_posts, 0, $number ); // the first, most popular page, is always /news/ (the homepage)
    }
    

?>
		<?php echo $before_widget; ?>

      <?php  if ( $show_popular ) : ?>
    <ul id="news-tab-nav" data-tabs="toggle" tab-index="0">
        <li class="selected"><a class="recent-popular-widget" href="#tab-popular" title="Most popular">Most Popular</a></li>
        <li><a class="recent-popular-widget" href="#tab-recent" title="Most recent">Recent</a></li>
    </ul>
      <?php else: ?>
        <?php echo $before_title . $title . $after_title; ?>
      <?php endif; ?>
    
    <ul id="tab-recent" tab-index="0" class="recent-posts" <?php if( $show_popular ) : ?> style="display:none;" <?php endif; ?>>
		<?php  while ($r->have_posts()) : $r->the_post(); ?>
      <li>
        <?php if (has_post_thumbnail()) :  ?>
        <a class="widget-thumbnail" href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
          <?php the_post_thumbnail( 'thumbnail' ); ?>
        </a>
        <?php endif; ?>
        <span>
	        <a class="widget-link" href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
	          <?php if ( get_the_title() ) the_title(); else the_ID(); ?>
	        </a>
	        <p> <small><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago</small> </p>
        </span>
      </li>
		<?php endwhile; ?>
      <?php if ( $instance['show-more-link'] ): ?>
        <li>
        <a class="more" href="<?php echo get_permalink(get_option('page_for_posts')) ?>" title="Go to blog page">More</a>
        </li>
      <?php endif; ?>
		</ul>


    <?php  wp_reset_postdata(); ?>

    <?php  if ( $show_popular ) : ?>

    <ul id="tab-popular" class="popular-posts" tab-index="0">

      <?php foreach( $pop_posts as $post ): ?>
          <li>
            <?php if (get_the_post_thumbnail($post->ID)) :  ?>
            <a class="widget-thumbnail" href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr($post->post_title); ?>">
              <?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>
            </a>
            <?php endif; ?>
            <a class="widget-link" href="<?php echo get_permalink($post->ID) ?>" title="<?php echo esc_attr($post->post_title); ?>">
              <?php echo $post->post_title; ?>
            </a>
            <p><small><?php echo $wp_post_views[$post->ID]; ?> views</small></p>
          </li>

      <?php endforeach; ?>
    </ul>

    <?php endif; ?>

		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts', $cache, 'widget');
	}

  function update( $new_instance, $old_instance ) 
  {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show-popular'] = (bool) $new_instance['show-popular'];
		$instance['show-more-link'] = (bool) $new_instance['show-more-link'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

  function flush_widget_cache() 
  {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

  function form( $instance ) 
  {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

    <?php if (class_exists('GADWidgetData') ) : ?>
		<p> <input id="<?php echo $this->get_field_id('show-popular'); ?>" name="<?php echo $this->get_field_name('show-popular'); ?>" type="checkbox" value="1" <?php checked( $instance['show-popular']) ?> />
    <label for="<?php echo $this->get_field_id('show-popular'); ?>"><?php _e('Show popular posts'); ?></label> </p>
    <?php endif; ?>

		<p> <input id="<?php echo $this->get_field_id('show-more-link'); ?>" name="<?php echo $this->get_field_name('show-more-link'); ?>" type="checkbox" value="1" <?php checked( $instance['show-more-link']) ?> />
    <label for="<?php echo $this->get_field_id('show-more-link'); ?>"><?php _e('Show more link'); ?></label> </p>

<?php
	}
}


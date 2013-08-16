<?php
/**
 * UW Categories Widget overrides of WP's core Categories widget
 *   - Changes the default arguments to exlude the first category, which is (but may not always be) Uncategorized
 */

class UW_Widget_Categories extends WP_Widget_Categories 
{

  function widget( $args, $instance ) 
  {
      extract( $args );

      $title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title'], $instance, $this->id_base);
      $c = ! empty( $instance['count'] ) ? '1' : '0';
      $h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
      $d = ! empty( $instance['dropdown'] ) ? '1' : '0';

      echo $before_widget;
      if ( $title )
        echo $before_title . $title . $after_title;

      $cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h, 'exclude' => '1');

      if ( $d ) {
        $cat_args['show_option_none'] = __('Select Category');
        wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
  ?>

  <script type='text/javascript'>
  /* <![CDATA[ */
        jQuery(document).ready(function($) {
          $("#cat").change(function() {
            var val = $(this).val();
            if ( val > 0 ) {
              location.href = "<?php echo home_url(); ?>/?cat="+val;
            }
          })
        });
  /* ]]> */
  </script>

  <?php
      } else {
  ?>
      <ul>
  <?php
      $cat_args['title_li'] = '';
      wp_list_categories(apply_filters('widget_categories_args', $cat_args));
  ?>
      </ul>
  <?php
      }

		echo $after_widget;
	}

}

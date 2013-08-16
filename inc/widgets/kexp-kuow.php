<?php
/**
 *
 * KEXP/KUOW Widget
 *
 */

class UW_KEXP_KUOW_Widget extends WP_Widget 
{

  function UW_KEXP_KUOW_Widget() 
  {

    parent::WP_Widget( 'kexp-kuow', __('KEXP/KUOW'), array( 
      'description' => __('The latest news from KEXP and KUOW') 
    ) );
	}

  function widget($args, $instance) 
  {

		if ( isset($instance['error']) && $instance['error'] )
			return;

		extract($args, EXTR_SKIP);

    $kexp_url = 'http://blog.kexp.org/feed/';
    $kuow_url = 'http://feeds2.feedburner.com/KUOW';

		$kexp = fetch_feed($kexp_url);
		$kuow = fetch_feed($kuow_url);

		$url = esc_url(strip_tags($kexp_url));
    $title = "<ul id='radio-tab-nav' data-tabs='toggle'>
                <li class='selected'><a class='rsswidget' href='#tab-kexp' title='KEXP'>KEXP</a></li>
                <li><a class='rsswidget' href='#tab-kuow' title='KUOW'>KUOW</a></li>
              </ul>";


		echo $before_widget;
    echo '<div class="kexp-kuow">';
    echo $title;
    echo '<div class="radio-tab-content" id="tab-kexp"><span>';
		wp_widget_rss_output( $kexp, $instance );
    echo "<a href='$kexp_url' class='more'>More</a>";
    echo '</span></div>';
    echo '<div class="radio-tab-content" id="tab-kuow" style="display:none;"><span>';
		wp_widget_rss_output( $kuow, $instance );
    echo "<a href='$kuow_url' class='more'>More</a>";
    echo '</span></div>';
    echo '</div>';
		echo $after_widget;

		if ( ! is_wp_error($kexp) )
			$kexp->__destruct();
		unset($kexp);

		if ( ! is_wp_error($kuow) )
			$kuow->__destruct();
		unset($kuow);
	}

  function update( $new_instance, $old_instance )   
  {
		$testurl = ( isset( $new_instance['url'] ) && ( !isset( $old_instance['url'] ) || ( $new_instance['url'] != $old_instance['url'] ) ) );
		return wp_widget_rss_process( $new_instance, $testurl );
	}

  function form( $instance ) 
  {

		if ( empty($instance) )
			$instance = array( 'title' => '', 'url' => '', 'items' => 10, 'error' => false, 'show_summary' => 0, 'show_author' => 0, 'show_date' => 0 );

		$instance['number'] = $this->number;

		//wp_widget_rss_form( $instance );
	}
}


<?php
/**
 *
 * Twitter widget
 *
 * Uses the Twitter 1.1 API requiring oAuth authentication just 
 * to read tweets. Because of the new Twitter request limit this 
 * widget caches a user's latest tweets for a minute.
 *
 */

class UW_Widget_Twitter extends WP_Widget 
{

  const URL             = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
  const AUTHOR_URL      = 'https://api.twitter.com/1.1/users/show.json';
  const REQUESTMETHOD   = 'GET';
  const GETFIELD        = '?include_entities=true&include_rts=true&screen_name=%s&count=%u';
  const RETWEET_TEXT    = '<small>Retweeted by <a href="//twitter.com/%s"> @%s</a></small>'; 

  static $EXPIRES  = 60;

  static $SETTINGS = array(
      'oauth_access_token' => "27103822-QSTDJWTC84cH1QsEWKlifhjzLhIdX0bcXHWMFKbH9",
      'oauth_access_token_secret' => "VhMI8TF6gsGjXdOlab6HLqvanmO1V2EAMYOrYlSFVU",
      'consumer_key' => "3CNAYpZpWmF5v90Oje2Esw",
      'consumer_secret' => "OFeAmUwNBe05w23uQPFIkVNQ1abwhZFuU4iktDckGWk"
  );

  
  function UW_Widget_Twitter() 
  {

		parent::WP_Widget( $id = 'twitter-feed', $name = 'Twitter Feed', $options = array( 'description' => 'Display your latest tweets', 'classname' => 'twitter-feed-widget' ) );

	}

  function form($instance) 
  {
    $title = isset($instance['title']) ? esc_attr($instance['title']) : 'Twitter Feed';
    $name  = isset($instance['name']) ? esc_attr($instance['name']) : 'twitter';
    $count = isset($instance['count']) ? esc_attr($instance['count']) : 5; 
?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e( 'Twitter screen name:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of tweets to show:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
<?php
	}

  function update( $new_instance, $old_instance ) 
  {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );
		$instance['count'] = intval( $new_instance['count'] );
		return $instance;
	}

  function widget($args, $instance) 
  {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );

    $name  = $instance['name'];
    $count = $instance['count'];

    $tweets = $this->getLatestTweets( $name, $count );

?>

    <?php echo $before_widget; ?>
      <div class="twitter-box">
        <?php echo $before_title; ?>
        <?php if ( ! empty( $title ) ) echo $title  ?>
        <?php echo $after_title; ?>
        <div class="twitter-feed" data-name="<?php echo $name; ?>" data-count="<?php echo $count; ?>">

          <?php foreach ( $tweets as $tweet ) : $tweet = (object) $tweet;  ?>

          <div class="tweet">
            <a href="//twitter.com/<?php echo $tweet->author; ?>">
              <img src="<?php echo $tweet->img; ?>" alt="<?php echo $tweet->author; ?>" />
            </a>
            <p>
              <a href="//twitter.com/<?php echo $tweet->author; ?>"> 
                <?php echo $tweet->author; ?> <small>@<?php echo $tweet->author; ?></small>
              </a>
              <?php echo $tweet->text; ?>
              <?php echo $tweet->retweet; ?>
            </p>
          </div>

          <?php endforeach; ?>

          <a class="more" href="//twitter.com/<?php echo $instance['name'] ?>">More</a>
        </div>
      </div>
    <?php echo $after_widget;?>

<?php  
	}

  private function getLatestTweets( $name = 'uw', $count = 5 )
  {

    $transientName = 'twitter-feed-'. $name . '-' . $count;

    if ( false == get_transient( $transientName ) ) {

      $parameters = sprintf(self::GETFIELD, $name, $count );

      $twitter    = new TwitterAPIExchange(self::$SETTINGS);

      $twitter->setGetfield( $parameters )
              ->buildOauth(self::URL, self::REQUESTMETHOD);

      $tweets = json_decode( $twitter->performRequest() );

      foreach ($tweets as $index => $tweet) 
      {
        $hasAuthor = ( count($tweet->entities->user_mentions) > 0 );
        $retweet   = ( strpos( $tweet->text , 'RT' ) > 0 );

        $latest[$index]['author'] = $hasAuthor ? $tweet->entities->user_mentions[0]->screen_name :
                                                 $tweet->user->screen_name; 

        if ( $hasAuthor ) 
        {

          $twitter->setGetfield( '?screen_name=' . $latest[$index]['author'] )           
                  ->buildOauth( self::AUTHOR_URL, self::REQUESTMETHOD );

          $user = json_decode( $twitter->performRequest() );

        }

        $latest[$index]['img']    = $hasAuthor ? $user->profile_image_url_https : 
                                                 $tweet->user->profile_image_url_https;

        $latest[$index]['text']   = $this->formatText( $tweet->text );

        $latest[$index]['retweet'] = $retweet ? sprintf( self::RETWEET_TEXT, $tweet->user->screen_name, $tweet->user->screen_name ) : '';


      }

      // json_encode fixed get_transient returning serialized string instead of array for some tweets
      set_transient( $transientName , json_encode( $latest ) , self::$EXPIRES );
    }

    return json_decode( get_transient( $transientName ) );


  }

  private function formatText( $text ) 
  {
  
    $text = preg_replace( '/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&~\?\/.=]+/', 
                          '<a href="\\0">\\0</a>', $text );

    $text = preg_replace_callback(  '/[#]+[A-Za-z0-9-_]+/',
                                    array( $this, 'encodeHashTag'),
                                    $text);

    $text = preg_replace_callback(  '/[@]+[A-Za-z0-9-_]+/',
                                    array( $this, 'normalizeScreenName'),
                                    $text );
    return $text;
  }

  private function encodeHashTag( $hashTag ) 
  {
    return '<a href="//twitter.com/search?q=' . urlencode($hashTag[0]) . '"> ' . $hashTag[0] . ' </a>';
  }

  private function normalizeScreenName( $screenname ) 
  {
    return '<a href="//twitter.com/' . str_replace( '@', '', $screenname[0] ) . '">' . $screenname[0] . '</a>';
  }

}

require( get_template_directory() . '/inc/frameworks/TwitterAPIExchange.php' );

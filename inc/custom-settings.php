<?php 

class UW_Custom_Settings
{

  function UW_Custom_Settings()
  {

    // Reading Settings Init
    add_action('admin_init', array( $this, 'uw_reading_settings_api_init') );

    // General Settings Init
    add_action('admin_init', array( $this, 'uw_general_settings_api_init') );
  
  }

  /**
   * Settings to put in the Reading Settings page
   *  - Italic words
   */

  function uw_reading_settings_api_init() 
  {
    add_settings_section('italics_section',
      '',
      array( $this, '_italics_howto' ),
      'reading');
    
    add_settings_field('italicized_words',
      'Words to italicize',
      array( $this, 'italicized_words_form_html' ),
      'reading',
      'italics_section');

    register_setting('reading','italicized_words');

  }
 
 function _italics_howto() { echo ''; }
 
 function italicized_words_form_html() 
 {
   echo '<textarea name="italicized_words" rows="10" cols="50" class="large-text code">' .
            get_option('italicized_words') . 
        '</textarea>';
 }

  /**
   * Settings to put in the General Settings page
   *  - Abbreviated Title
   *
   */

  function uw_general_settings_api_init() 
  {

      add_settings_field('Abbreviated',
        'Abbreviated Title',
        array( $this, 'abbreviation_form_html' ),
        'general',
        'default');
      register_setting('general','abbreviation');

   }
 
  function abbreviation_form_html() 
  {
    echo '<input type="text" name="abbreviation" value="'.get_option('abbreviation').'"/>

          <p class="howto">An abbreviated title used in some circumstances when the full title is too long.</p>

        <script type="text/javascript">
         jQuery(document).ready(function($){
            var input = $("input[name=abbreviation]").closest("tr");
            $(".form-table tr").eq(1).after(input);
         });
        </script>';

  }

}
 
new UW_Custom_Settings;

/**
 * Add an option for which slider to put on the front-page 
 */

if ( class_exists('RoyalSliderAdmin') ): 

  function slider_royalslider_settings_api_init() {
    add_settings_section('royalslider',
    '',
    '_slider_howto',
    'reading');
    
    add_settings_field('homepage_royalslider',
    'Royalslider to show on homepage',
    'slider_royalslider_homepage_html',
    'reading',
    'royalslider');
    register_setting('reading','homepage_royalslider');

    add_settings_field('posts_per_frontpage',
      'Front page shows at most',
      'posts_per_frontpage_input_html',
      'reading',
    'default');
    register_setting('reading','posts_per_frontpage');

  }

  add_action('admin_init', 'slider_royalslider_settings_api_init');

  function _slider_howto() { echo ''; }

  function slider_royalslider_homepage_html() {
    $slider = get_option('homepage_royalslider');
    $output = "<input type=\"text\" name=\"homepage_royalslider\" value=\"$slider\" size=\"4\"/>";
    echo $output;
  }

  function posts_per_frontpage_input_html() {
    echo '<input name="posts_per_frontpage" type="number" step="1" min="1" value="'.get_option('posts_per_frontpage').'" class="small-text">';
  }

endif;
  


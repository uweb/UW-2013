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

jQuery(document).ready(function($){

  var frame
    , JS_TEMPLATE = 'slideshow-images'
    , WIDGET_ID   = 'slideshow'

  $('body').on('click', '.select-a-gallery', function(e) {

      e.preventDefault();

      var $this    = $(this)
        , $preview = $this.siblings('.slideshow-preview')
        , $inputs  = $this.siblings('input')

      if ( ! frame ) {

      frame = wp.media.frames.frame = wp.media({

          className: 'media-frame uw-gallery-media-frame',

          frame: 'post',

          state: $preview.children().length > 0 ? 'gallery-edit' : 'gallery',

          multiple: true,

          title: 'Select an image',

      });
      }

      frame.on('update', function(){

        var media = frame.state().get('library').toJSON()
          , $preview = $this.siblings('.slideshow-preview')
          , template = wp.media.template( JS_TEMPLATE )
          , ids = urls = []

        $preview.empty()

        $.each(media, function(index, image) {

          $preview.append( template( image ) )

          ids.push( image.id )

        })

        $inputs.first().val( ids )

      });

      frame.on('activate', function() {
      
        var selection = frame.state().get('library')
          , value     = $inputs.first().val()
          , ids = !value ? false : value.split(',')

      
        if ( ids )
          $.each( ids, function( index, id ) {
            selection.add( wp.media.attachment(id) )
          });
        
      })

      frame.open();
  });


  /** Setup previews of existing gallery 
   * ([todo]: is a function for the ajax save widget, there should be a way around this 
   */

  var setup_initial_images = function() 
  {

    $('.slideshow-preview').each(function() {

      var $this = $(this)
        , template = wp.media.template( JS_TEMPLATE )
        , images = $this.siblings('input').first().val()

      if ( ! images ) return;

      $.each( images.split(','), function( index, id ) {

        // make divs to keep the order correct while ajaxing each image separately
        var $div = $('<div />').attr( 'id', id )
        $this.append( $div )
           
        wp.media.attachment( id )
          .fetch()
          .done( function( image ) {
        
            $this
              .find('div#'+id)
              .append( template( image ) )
                .find('li')
                .unwrap()
          
          })

      })

    })
  }


  /** Save widget ajax hook **/
  $(this).ajaxSuccess(function(e, xhr, settings) {

    if( !!settings.data 
        && settings.data.indexOf('action=save-widget') != -1 
        && settings.data.indexOf('id_base=' + WIDGET_ID ) != -1) 
    {
      setup_initial_images();
    }

  });
  

  setup_initial_images();
});

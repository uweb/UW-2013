jQuery(document).ready(function( $ ) {
  
  var frame;

  $('body').on('click', '.select-an-image', function(e){

      e.preventDefault();

      var $this    = $(this)
        , $preview = $this.siblings('.image-preview')
        , $inputs  = $this.siblings('input')

      if ( frame ) {
          frame.open();
          return;
      }

      frame = wp.media.frames.frame = wp.media({

          className: 'media-frame single-image-media-frame',

          frame: 'select',

          multiple: false,

          title: 'Select an image',

      });

      frame.on('select', function(){

          var media = frame.state().get('selection').first().toJSON()
            , $img  = $('<img/>').attr({
              'src'   : media.url,
              'width' : '100%'
            })

          $preview.width('33%').html( $img )

          $inputs.first().val( media.id ).end()
            .last().val( media.url )

      });

      frame.open();
  });

})

/** Panels fix: preview of the image doesn't show otherwise **/
jQuery.noConflict()(window).load( function() {

  if ( typeof panelsData == "undefined" ) 
    return;

  var $widgets = jQuery('.site-panels-image-fix')

  $widgets.each( function() {
    var $this = jQuery(this)

    var $img   = jQuery('<img/>').attr({
        'src'   : $this.val(),
        'width' : '100%'
    })

    $this.siblings('.image-preview').html( $img )
  
  })

})

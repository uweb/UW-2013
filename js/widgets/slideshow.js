$(document).ready( function() {

/**
 * Regular
 */
  var $slideshows  = $('.slideshow-widget')
    , $window      = $(window)
    , ACTIVE_SLIDE = 'active-slide'
    , DURATION     = 100

  $slideshows.on('click', 'li > a', function() {

    var $this       = $(this)
      , $slideshow  = $this.closest('.widget')
      , $slides     = $slideshow.find('.slide')
      , $navs       = $slideshow.find('li a')

    if ( $this.hasClass( ACTIVE_SLIDE ) )
      return false;

    $navs.removeClass( ACTIVE_SLIDE )
    $this.addClass( ACTIVE_SLIDE )

    // animation is done with css
    $slides
      .filter( '.' + ACTIVE_SLIDE )
      .removeClass( ACTIVE_SLIDE )
        .end()
      .eq( $this.parent().index() )
        .addClass( ACTIVE_SLIDE )

      $slideshow.data('currentSlide', $this.parent().index() )
  
    return false;

  } )


/**
 * Mobile
 */
  $slideshows
    .data('currentSlide', 0 )
    .on('touchstart touchmove touchend', '.slide', function(e) {

    if ( $.uw.screensize !== 'mobile' ) return false;

    var $this   = $(this)
      , $canvas = $this.closest('.widget')
      , $slides = $this.siblings('.slide').andSelf()
      , $navs   = $canvas.find('li a')
      , width   = $this.width()
      , target  = 'IMG' //e.target.nodeName 

    switch(e.type) 
    {

      case 'touchstart':

        // resize/reset the slideshow
        $window.trigger('resize.slideshow')

        $canvas.data({ 
          'touchStartPosition': e.originalEvent.touches[0].pageX,
          'originalLeft'  : $this.position().left
        })

        break;

      case 'touchmove':

        var del         = e.originalEvent.changedTouches[0].pageX - $canvas.data('touchStartPosition') + $canvas.data('originalLeft')
          , anim        = del < 0 ? $slides.slice($this.index()+1) : $slides.slice($this.index())
          , $nextSlide  = del < 0 ? $this : $this.prev()
          

        anim.transition({
          x : del + width * $canvas.data('currentSlide'),
        } , { 
            queue: false 
        })

        $nextSlide.transition({
          opacity : del < 0 ? 1 -  Math.abs(del/width) : Math.abs(del/width)
        }, {
          queue: false
        })

        break;
      
      case 'touchend':

        var del         = e.originalEvent.changedTouches[0].pageX - $canvas.data('touchStartPosition')
          , current     = $canvas.data('currentSlide') 
          , move        = Math.max( Math.abs(del/width), 0.3 ) == 0.3 ? 0 : del/width
          , anim        = del < 0 ? $slides.slice($this.index()+1) : $slides.slice($this.index())
          , $nextSlide  = del < 0 ? $this : $this.prev()
          , opacity     = del > 0                  ? 1 : 
                          ! move                   ? 1 : 
                          $this.is($slides.last()) ? 1 : 0
          , current     = ( move === 0 ||
                              move > 0 && ! $this.prev('.slide').length || 
                              move < 0 && ! $this.next('.slide').length ) ? $canvas.data('currentSlide') :
                           move > 0.3 ? current += 1 : current -= 1;

        $canvas.data( 'currentSlide', current )

        anim.transition( { 
          x : width * current
        })

        $nextSlide.transition({
          opacity : opacity
        })

        $navs.removeClass( ACTIVE_SLIDE )
          .eq( Math.abs(current) ).addClass( ACTIVE_SLIDE )


        break;

      case 'default':

        return false;

    }

    return false;
    
  })


  $window.bind( 'scroll', function() {

    if ( $.uw.screensize != 'desktop' )
      return;

    var $this = $(this)
      , diff  = Math.max( -40 * $this.scrollTop() / $this.height() , -15 )

    $slideshows
      .find('img').css('margin-top', diff + '%' )

  }).bind( 'resize.slideshow', function() {

    if ( $.uw.screensize === 'mobile' ) 
    {
      $('.slide').width( $window.width() ) 
    } else {

      $slideshows.removeAttr('style')
        .find('.slide').removeAttr('style')
    }

  }).trigger('resize.slideshow')

});

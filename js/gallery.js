$(document).ready(function() {

  if ( $('.gallery').length == 0 )
    return;

  var $body    = $('body')
    , $opaque  = $('<div class="opaque"/>')
    , $overlay = $('#gallery-overlay-image')
    , $images  = $('div.gallery-image')
    , $arrows  = $('.slideshow-right, .slideshow-left')
    , $canvas  = $('.gallery-viewport') 
    , $groups  = $('.group')

  $('.gallery-menu li:first').addClass('active')

  $opaque.hide()
  //$arrows.hide()
  $canvas.data('showing', 1)

  $('div.large').each(function() {
    var $this = $(this)
    if ( ! $this.children().length ) $this.remove()
  })

  $body.first().append($opaque)
    
  $body.on('click', 'div.gallery-image', function() {
    var $this = $(this)
      , $gallery = $this.closest('.gallery')
      , wp_url = $this.data('wp-url')
      , perm_url = $this.data('permalink-url')
      , pos   = $gallery.position()
      , mobile = $(window).width() < 767

      $overlay.find('.share a')
        .each(function() {
          var $this = $(this)
            , href  = $this.data('href')

          switch($this.attr('class')) {
            case 'gallery-facebook':
              $this.attr('href', href + perm_url + '&t='+ (new Date().getTime()) )
              break;

            case 'gallery-twitter':
              $this.attr('href', href + perm_url )
              break;
            
            case 'gallery-original':
              $this.attr('href', wp_url)
              break;
          }
          
        })

      $canvas.closest('.gallery').addClass('image-showing')

      $overlay
        .hide()
        .css({
                position:'absolute',
                zIndex:1
              })
        .find('.image-description').html($this.children('span').html())
          .end()
        .find('img')
          .attr({
            src: $this.data('url')
          })
        
        
        $overlay
          .imagesLoaded(function(  $images, $proper, $broken ) {

            // ie fix
            var img = new Image()
            img.src = $images.get(0).src

            var height = img.height // $images.get(0).height
              , width  = img.width  // $images.get(0).width
              , buffer = !mobile ? 27 : 0

//            if ($.support.opacity)
              $opaque.show()

            $overlay
              .hide().fadeIn()
              .css({
                'top'  : (height === 0 || mobile ) ? $gallery.position().top : $gallery.position().top + ( $gallery.height() - height )/ 2 ,
                'left' : (width === 0 || mobile ) ? buffer : (($gallery.width() - width) / 2) + buffer
              })

          })
          
        var index = $images.index(this)
        $overlay.data({
          'prev' : index-1,
          'selected': index,
          'next': index+1 === $images.length ? 0 : index+1
        })

  }).on('click', '.opaque, .gallery-close', function() {
    $canvas.closest('.gallery').removeClass('image-showing')
    $opaque.fadeOut() 
    $overlay.hide()
  }).on('click', '.slideshow-right, .slideshow-left', function(e) {
    if ( $overlay.is(':visible') ) {
      var dir  = $(e.target).hasClass('slideshow-right') ? 'next' : 'prev'
          , next = $overlay.data(dir)

      $images.eq(next).trigger('click')
    } else {
      var dir  = $(e.target).hasClass('slideshow-right') ? '-=' : '+='
          , dis = $canvas.children().first().outerWidth()

      if ( $canvas.data('showing') == 1 && dir == '+=' ||
            $canvas.data('showing') == $canvas.data('slides') && dir == '-=')
        return false;

      if ( $canvas.parent().width() >= 2 * dis ) dis *= 2

      $canvas.animate({'marginLeft': dir+dis }, 400 )
        .data('showing', dir === '-=' ? $canvas.data('showing') + 1 : $canvas.data('showing') - 1)
    }

    $(this).siblings('.gallery-table').find('li').removeClass('active')
      .eq($canvas.data('showing')-1).addClass('active');
    
    return false;
  }).on('click', '.gallery-menu li', function(){

    var $this = $(this)
      , dis =  $canvas.children().first().outerWidth()

    if ( $canvas.parent().width() >= 2 * dis ) dis *= 2

    $this.addClass('active').siblings().removeClass('active')
    $canvas.animate({'marginLeft': -1*$this.index() * dis}, 400 )
      .data('showing', $this.index() + 1)
  
  } )

  // menu

  $(window).resize(function() {
  
  var num = Math.ceil(( $canvas.children().length * $canvas.children().first().width() ) / $canvas.closest('.gallery').width())
    , $menu = $('.gallery-menu').first()

    $canvas.data('slides', num)

    if (num == $menu.children().length)
      return false;

    $menu.html('')
    while (num--) {
      $menu.append($('<li/>').text(num))
    }
    $menu.children('li').first().trigger('click')


  }).trigger('resize')
  

})

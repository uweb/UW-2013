$(document).ready(function() {

  var $submenus         = $('ul.dawgdrops-menu, #sidebar ul.sub-menu')
    , $caret            = $('span.navbar-caret')
    , KEYDOWN_EVENT     = 'keydown.dawgdrops'
    , DROPDOWN_AS       = 'ul.dawgdrops-menu a, #sidebar ul.sub-menu a'
    , DROPDOWN_TOGGLE   = 'a.dropdown-toggle, #sidebar ul.menu > li > a'
    , CARET_ADJUST      = 20
    , ANIMATION_DELAY   = 300
    , keys  = {
          enter :   13,
          esc   :   27,
          tab   :   9,
          left  :   37,
          up    :   38,
          right :   39,
          down  :   40,
          spacebar : 32
      } 
    , clearMenus = function() {
      $submenus.removeClass('open').attr('aria-expanded','false')
      $caret.hide();
    }

  $(document).on( KEYDOWN_EVENT , DROPDOWN_AS , function(e)  
  {
      
        if (e.altKey || e.ctrlKey)
          return true;

        var $this    = $(this)
          , $anchors = $this.closest('ul.open').find('a')

        switch(e.keyCode) {

          case keys.spacebar:
            document.location.href = $this.attr('href');
            return false;

          case keys.tab:
            clearMenus();
            return true;

          case keys.esc:
            $this.blur().closest('ul.open').siblings('a').focus();
            clearMenus();
            return true;

          case keys.down:
            var index = $anchors.index($this)
            //fix last anchor to circle focus back to first anchor
            index = index === $anchors.length-1 ? -1 : index; 
            $anchors.eq(index+1).focus();
            return false;

          case keys.up:
            var index = $anchors.index($this)
            $anchors.eq(index-1).focus();
            return false;

          case keys.left:
            $this.blur().closest('ul.open').siblings('a').focus();
            clearMenus();
            return false;

          case keys.right:
            $this.blur().closest('ul.open').parent().next('li').children('a').focus();
            clearMenus();
            return false;

          default:
            var chr = String.fromCharCode(e.which)
              , exists = false;
            $anchors.filter(function() {
              exists = this.innerHTML.charAt(0) === chr
              return exists;
            }).first().focus();
            return !exists;
      
        }
      
      }).on( KEYDOWN_EVENT , DROPDOWN_TOGGLE , function(e) {

        if (e.altKey || e.ctrlKey)
          return true;

        var $this = $(this)
          , $ul   = $this.siblings('ul')
          , $anchors = $( DROPDOWN_TOGGLE )

        switch(e.keyCode) {
          case keys.enter:

            if ( ! $ul.length )
              return true;

            $caret
              .css('left', $this.position().left + CARET_ADJUST )
              .show();

      
            $ul
              .addClass('open')
              .attr('aria-expanded','true')

            // [TODO] settimeout wasn't necessary last time. 
            setTimeout(function() {
            
              $ul
                .find('a')
                .first()
                .focus()
            
            }, ANIMATION_DELAY / 2 );

            return false;

          case keys.spacebar:
          case keys.up:
          case keys.down:
            var fake_event = jQuery.Event( 'keydown', { keyCode: keys.enter } );
            $this.trigger(fake_event);
            return false;

          case keys.esc:
            clearMenus();
            return false;

          case keys.tab:
            clearMenus();
            return true;
          
          case keys.left:
            var index = $anchors.index($this)
            $anchors.eq(index-1).focus()
            return false;

          case keys.right:
            var index = $anchors.index($this)
            //fix last anchor to circle focus back to first anchor
            index = index === $anchors.length-1 ? -1 : index; 
            $anchors.eq(index+1).focus()
            return false;

          default:
            return true;
        }
    
      });

})

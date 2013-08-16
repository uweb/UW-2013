;(function( $ ) {

  var INITIAL_INPUTS = 'input.wp-get-posts'
    , URL            = '?action=search-posts'
    , DELAY          = 500
    , MINLENGTH      = 2

  $.widget( "custom.catcomplete", $.ui.autocomplete, {
    _renderMenu: function( ul, items ) {
      var that = this,
        currentCategory = "";
      $.each( items, function( index, item ) {
        if ( item.category != currentCategory ) {
          ul.append( "<li class='ui-autocomplete-category' style='margin:5px'><b>" + item.category + "</b></li>" );
          currentCategory = item.category;
        }
        that._renderItemData( ul, item );
      });
    }
  });
  
  $.fn.extend({
        getPosts: function( options ) 
        {
            this.options = {
              'ajaxurl'   : ajaxurl,
              'url'       : URL,
              'delay'     : DELAY,
              'minLength' : MINLENGTH
            };

            var settings = $.extend( {}, this.options, options);

            return this.each( function() {

                var $this = $(this);

                $this.catcomplete({
                  //source : settings.url, //+ this.value,
                  source: function( request, response ) {
                    $.ajax( {
                      url: ajaxurl+'?action=search-posts', 
                      data : {
                        action : 'search-posts',
                        s      : $this.val()
                      },
                      success: function( res ) {
                        var posts = $.parseJSON( res )
                        response( $.map( posts, function( post ) {
                          console.log( post );
                          return {
                            label    : post.title,
                            value    : post.url,
                            category : post.category
                          }
                        }));
                      }
                    });
                  },
                  delay  : settings.delay,
                  minlength : settings.minLength
                })

            });
        }
    });

  $( INITIAL_INPUTS ).getPosts()

})(jQuery)

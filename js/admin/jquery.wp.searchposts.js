;(function( $ ) {

  var INITIAL_INPUTS = 'input.wp-get-posts'
    , ACTION         = 'search-posts' 
    , URL            = '?action='+ACTION
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

            var settings = $.extend( this.options, options);

            return this.each( function() {

                var $this = $(this)
                $.extend(settings, $this.data());

                $this.catcomplete({
                  source: function( request, response ) {
                    $.ajax( {
                      url: ajaxurl + URL,
                      data : {
                        action   : 'search-posts',
                        posttype : settings.posttype || null,
                        s        : $this.val()
                      },
                      success: function( posts ) {

                       if ( !posts.success || !posts.data ) 
                        response([{ label:'No results found', value:'', category:''}] )

                        response( $.map( posts.data, function( post ) {
                          return {
                            label    : post.title.length > 75 ? post.title.substring(0,75)+'...' : post.title,
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

  $(document).ready(function() {
    $('body').on( 'keyup', INITIAL_INPUTS, function() {
      var $this = $(this)
      $this.getPosts( $this.data() ) 
    })
  })

})(jQuery)


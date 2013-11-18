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

                          console.log(posts)
                        response( $.map( posts.data, function( post ) {
                          return {
                            label    : post.title.length > 75 ? post.title.substring(0,75)+'...' : post.title,
                            value    : post.title,
                            category : post.category,
                            image    : _.first(post.image),
                            imageID  : post.imageID,
                            url      : post.url,
                            excerpt  : post.excerpt
                          }
                        }));

                      }
                    });
                  },
                  select : function( event, ui ) {
                    _.each( ui.item, function(value, key) {
                      var field = $this.closest('div').find('.wp-get-posts-'+key)  
                      if ( key === 'image' ) {
                        field.filter('img').attr( 'src', value ) 
                        // siteorigin panels bug
                        $this.closest('div').find('.wp-get-posts-'+key+'-preview')
                            .children('img').attr('src', value)
                      }

                      field.val( value )
                    })
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


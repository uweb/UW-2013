/**
 * Sidebar menu
 *
 */

$(document).ready(function() {

  var $sidebar        = $('#sidebar')
    , $menu           = $sidebar.find('.menu')
    , $li_elements    = $menu.children('li')
    , LI_INTERVAL     = 10
    , WIDTH_DIVISION  = 10
    , WIDTH_MULTIPLY  = 240
    , LI_WRAP_ELEMENT = '<ul class="pull-left" style="width:200px"/>'
    , SIDEBAR_HEADER  = 'Browse '


    
    $li_elements.each(function() {
    
      var $this = $(this)
        , $lis  = $this.find('li')
        , width = Math.ceil( $lis.length / WIDTH_DIVISION )

      if (  width > 0 ) 
      {
        $this.children('ul').first().width( width * WIDTH_MULTIPLY ) 

        for ( var i = 0; i < $lis.length; i += LI_INTERVAL ) 
        {
          $lis.slice( i, i+LI_INTERVAL ).wrapAll( LI_WRAP_ELEMENT )
        };

      }

    })
  
  
    $sidebar.find('.menu').tinyNav({
      //active: 'current-menu-item',
      header: SIDEBAR_HEADER + $sidebar.find('.widgettitle a').prop('title')
    });   	  

});

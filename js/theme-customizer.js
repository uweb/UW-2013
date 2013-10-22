/**
 * Live updates for patch band 
 */
( function( $ ) {

  var WORDMARK_DISTANCE = 125
    , DURATION = 200 

	wp.customize( 'patch_visible', function( value ) {
		value.bind( function( newval ) {

        var distance = ( !! newval ) ? WORDMARK_DISTANCE : 0;

        $('.wordmark').animate({ left : distance }, DURATION );

        $('.patch').fadeToggle( DURATION, function(){ 
          $('header').toggleClass('hide-patch')
        });

		} );
	} );
  
	wp.customize( 'patch_color', function( value ) {
		value.bind( function( newval , oldval ) {
      $('#branding').removeClass( [newval, oldval].join(' ') ).addClass( newval )
		} );
	} );

	wp.customize( 'band_color', function( value ) {
		value.bind( function( newval , oldval ) {
      $('#branding').removeClass( oldval ).addClass( newval )
		} );
	} );

	wp.customize( 'wordmark', function( value ) {
		value.bind( function( newval , oldval ) {
      if ( newval.match(/\.(jpeg|jpg|gif|png)$/) != null ) {
        $('a.wordmark').css('background', 'url(' + newval + ')')	
          $('#branding').removeClass( oldval ).addClass( 'wordmark-custom' )
      
      } else {
        $('a.wordmark').removeAttr( 'style' )
      }

    } );
	} );

	wp.customize( 'wordmark_color', function( value ) {
		value.bind( function( newval , oldval ) {
      $('#branding').removeClass( oldval ).addClass( newval )
    } );
	} );

	wp.customize( 'color_scheme', function( value ) {
		value.bind( function( newval , oldval ) {
      $('html').removeClass( oldval ).addClass( newval )
    } );
	} );

} )( jQuery );


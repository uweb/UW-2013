$(document).ready(function() {
  
    var $cals      = $('.calendar-widget')
      , $calpane   = $('.calendar-widget-event-pane')
      , $calevents = $calpane.children('div')
      , $close     = $calpane.children('a')

    $close.click(function() {
      $calevents.empty()
      $calpane.hide()
      return false;
    })

    $cals.each(function() {
      
      var $this = $(this);

      $this.fullCalendar({
      
        dayNamesShort: ['S','M','T','W','T','F','S'],
         
        events: $this.data('events'),

        eventRender : function( event, element, view ) {
            var start = event.start.getDate() + ( view.start.getDay() - 1 )
              , edate = $.fullCalendar.formatDate(event.start, 'yyyy-MM-dd')
            if( event.start >= view.visStart && event.end < view.visEnd && 
                    event.start.getMonth() == view.start.getMonth() ) {
                $this.find( '[data-date='+edate+']' ).addClass( 'event-today' );
            }

        },

        dayClick: function( date, allDay, jsEvent, view ) {

          var events = $this.fullCalendar( 'clientEvents' )

          var todays_events = jQuery.grep( events , function ( event , index ) {

              return ( event.start.getDate() == date.getDate() && 
                          event.start.getMonth() == date.getMonth() ); 

          });

          $.each( todays_events.reverse() , function() {
            var title = this.title + ( this.allDay ? ' (All Day)' : '')
              , time  = !this.allDay ? $.fullCalendar.formatDate(this.start, 'h:mm tt') : '' 
              , loc   = this.location ? 'Location: ' + this.location : ''

            $calevents
              .append( '<div class="calendar-event">' + 
                       '<span class="title">' + title + '</span>' + 
                       '<span class="time">' + time + '</span>' + 
                       '<span class="location">'+ loc + '</span>' +
                       '</div>' );

            $calpane.fadeIn()
          })
            
        },

        viewDisplay: function( view ) {
          if (view.name == 'month' ) $calevents.html('')
        },
        
        
        
        eventClick: function(event) {
          // opens events in a popup window
          window.open(event.url, 'gcalevent', 'width=700,height=600');
          return false;
        },
        
        loading: function(bool) {
          if (bool) {
            $('#loading').show();
          }else{
            $('#loading').hide();
          }
        }
        
    });
  });
});

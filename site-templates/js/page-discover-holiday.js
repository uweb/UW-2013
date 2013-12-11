jQuery(function() {

	$('#snowy').snowfall({
     minSize: 1,
     maxSize:2,
     minSpeed : 1,
     maxSpeed : 4,
     flakeCount : 100,
	});

  $.fn.staggerLoad = function( options ) {
    return this.each( function( index ) {
      if ( $(this).hasClass('animated') )
        return false;
      $(this).addClass('animated').delay( index * 100 )
        .transit({
          opacity   : 1, 
          marginTop : 0,
          duration  : 700
        })
    });
  }

  $.fn.animateData = function( options ) {
    return this.each(function(index) {
      var $this = $(this)
        , props = $this.data()
      $this.addClass('animated').transit( props )
    })
  }

  var lastSection;

	$.fn.fullpage({
    fixedElements: '#branding',
    anchors: ['intro', 'secondPage', '3rdPage', '4thPage', 'lastPage'],
		menu: '#menu-dots',
    afterRender: function() {
      if ( ! window.location.hash )
        $('#section0 img').animateData()
    },
    afterLoad: function(anchorLink, index){
      
      //if ( lastSection < 3 )
        //$('#section'+lastSection).find('[style]').removeAttr('style')
        $('#section'+lastSection).find('.animated').removeAttr('style').removeClass('animated')

      if ( index === 1 ) $('#section0 img').animateData()
      if ( index === 2 ) $('#section1 img').staggerLoad()
      if ( index === 3 ) {
        $('#border').animateData()
        $('#holiday-video').animateData()
      }
      if ( index === 4 ) {
        $('#youtube-videos a').each(function() {
          var $this = $(this)
          $this.attr( 'style',  $this.data().css )
        }).staggerLoad()
      }

    },
    afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex) {
      //if ( slideIndex > 0 ) $('.slide.active a').staggerLoad()
    },
    onLeave: function(index, direction){
      lastSection = index-1;
    }

	});

  var Video = Backbone.Model.extend({})

  var Videos = Backbone.Collection.extend({

    model: Video,

    totalItems: null,

    settings : {
      v : 2,
      alt :'jsonc',
      method : 'playlists',
      'start-index' : 1,
      'max-results' : 12
    },
  
    url: 'https://gdata.youtube.com/feeds/api/playlists/PLgNkGpnjFWo91-ltPkhAYOkMGhVzhRLJH/',

    parse: function( response ) {
      this.totalItems = response.data.totalItems
      var plucked = _.pluck( response.data.items, 'video' )
        , items   = _.compact( plucked ).length ? plucked : response.data.items
        , videos  = _.filter( items, function( video ) {
            return ! _.has( video, 'status' )
          })
      return !_.compact( videos ).length ? response.data.items : videos;
    },

    initialize: function( options ) {
      this.fetch({ dataType: 'jsonp', data: this.settings })
    }
     
  })

  var Grid = Backbone.View.extend({

    el : '#section3',

    initialized : false,

    slideIndex : 0,

    template : _.template( $('#video-grid').html() ),
    itemplate : _.template( $('#iframe-grid').html() ),

    events : {
      'click .grid' : 'video',
      'click #more-videos' : 'refresh'
    },

    initialize: function() {
      this.collection.on( 'sync', this.addItems, this ) 
    },

    render: function() {
      var index = this.slice()
      this.$('#youtube-videos').html( this.template({ 
        videos: this.collection.toJSON().slice(index, index+this.collection.settings['max-results']) 
      }) )

      if ( this.initialized )
        this.$('#youtube-videos a').staggerLoad()

      this.initialized = true;
      //this.addItems()
    },

    slice: function() {
      this.slideIndex++;
      var index = this.collection.settings['max-results'] * this.slideIndex-1
      if ( this.collection.totalItems - index < this.collection.settings['max-results'])
        this.slideIndex = 0
      return index;
    },

    addItems: function() {
      this.collection.settings['start-index'] += this.collection.settings['max-results']

      if ( this.collection.totalItems >= this.collection.settings['start-index'] )
        this.collection.fetch({ data: this.collection.settings, remove:false })
      else 
        this.render()
    },

    refresh: function() {
      this.addItems()    
    },

    video: function(e ) {

      var $this = $(e.currentTarget)
        , iframe = this.itemplate({ id: $this.data().id })

      $this
      .clone()
      .addClass('clone')
      .data({
        position: {
          top: $this.position().top,
          left: $this.position().left,
          borderRadius: $this.css('borderRadius'),
          backgroundSize: $this.css('backgroundSize'),
          width: $this.width(),
          height: $this.height(),
          duration: 700 
        }
      })
      .css({
        position:'absolute',
        visibility:'visible',
        top: $this.position().top,
        left: $this.position().left
      })
      .insertAfter($this)
      .transit({
        top  : 0,
        left : '-20%',
        width: '140%',
        height: '80%',
        duration: 700,
        borderRadius   : 0,
        backgroundSize : '100%',
        easing: 'easeOutQuart',
        complete: function() { $(this).html(iframe) }
      })

    }

  })

  var videos = new Videos({})
    , grid   = new Grid({ collection: videos })


  $('body').on('click', function() {
    var data = $('iframe.iframe-grid').parent().data()
    if ( !data) return;
    $('iframe.iframe-grid').remove()
    $('a.clone').transit( data.position, function() {
      $(this).remove()
    } )
    
  })

});

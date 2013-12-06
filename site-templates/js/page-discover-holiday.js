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
      $(this).delay( index * 100 )
        .transit({
          opacity   : 1, 
          marginTop : 0,
          duration  : 700
        })
    });
  }

	$.fn.fullpage({
    fixedElements: '#branding',
    anchors: ['intro', 'secondPage', '3rdPage', '4thPage', 'lastPage'],
		menu: '#menu-dots',
    afterLoad: function(anchorLink, index){
      if ( index === 4 ) $('.slide.active a').staggerLoad()
    },
    afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex) {
      if ( slideIndex > 0 ) $('.slide.active a').staggerLoad()
    },
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

    slideIndex:0,

    template : _.template( $('#video-grid').html() ),

    events : {},

    initialize: function() {
      this.collection.on( 'sync', this.render, this ) 
    },

    render: function() {
      var index = this.collection.settings['start-index'] - 1;
      this.getCurrentSlide().append( this.template({ videos: this.collection.toJSON().slice(index) }) )//.find('img').hide()
      this.addItems()
    },

    addItems: function() {
      this.slideIndex++;
      this.collection.settings['start-index'] += this.collection.settings['max-results']

      if ( this.collection.totalItems > this.collection.settings['start-index'] )
        this.collection.fetch({ data: this.collection.settings, remove:false })
    },

    getCurrentSlide: function() {
      return this.$el.find('div.tableCell').eq( this.slideIndex )
    },


  })

  var videos = new Videos({})
    , grid   = new Grid({collection:videos})


});

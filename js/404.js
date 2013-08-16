jQuery(window).load(function(){
  // Declare parallax on layers
  jQuery('.parallax-layer').imagesLoaded(function() {
    $(this).parallax(
      {},
      { xparallax: 1, yparallax: 0 },    // background
      { xparallax: 1, yparallax: 0 },    // woof
      { xparallax: .3, yparallax: 0 },    // doghouse
      { xparallax: .3, yparallax: 0 }     // dubs
      )}
  );

});

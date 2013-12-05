jQuery(function() {

	$('#snowy').snowfall({
	 minSize: 1, maxSize:2, minSpeed : 1, maxSpeed : 4, flakeCount : 100  
	});

	$.fn.fullpage({
        fixedElements: '#branding',
        anchors: ['intro', 'secondPage', '3rdPage', '4thPage', 'lastPage'],
		menu: '#menu-dots'
	});

});

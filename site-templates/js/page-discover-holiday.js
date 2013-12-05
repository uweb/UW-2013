jQuery(function() {

	$('#snowy').snowfall({image :"/cms/president/wp-content/themes/uw-2013/img/misc/template-holiday/snowflake-1.png",
	 minSize: 10, maxSize:60, minSpeed : 1, maxSpeed : 4, flakeCount : 50  
	});

	$.fn.fullpage({
        fixedElements: '#branding',
        anchors: ['intro', 'secondPage', '3rdPage', '4thPage', 'lastPage'],
		menu: '#menu-dots'
	});

});

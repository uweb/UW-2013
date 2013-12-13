<?php wp_enqueue_style( 'discover-holiday-2013', get_bloginfo( 'template_directory') . '/site-templates/css/page-discover-holiday.css', array('uw-master') ); ?>
<?php wp_enqueue_script('backbone'); ?>
<?php wp_enqueue_script( 'fullPage.js', get_bloginfo('template_directory') . '/site-templates/js/fullPage.js' ); ?>
<?php wp_enqueue_script( 'jqueryrain', get_bloginfo('template_directory') . '/site-templates/js/jquery.rain.js' ); ?>
<?php wp_enqueue_script( 'discover-holiday-2013', get_bloginfo('template_directory') . '/site-templates/js/page-discover-holiday.js' ); ?>
<!doctype html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
  <title> <?php uw_title() ?> </title>
  <?php wp_head(); ?>

  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/print.css" type="text/css" media="print" />

  <!--[if lt IE 9]>
    <script src="<?php bloginfo("template_directory"); ?>/js/html5shiv.js" type="text/javascript"></script>
    <script src="<?php bloginfo("template_directory"); ?>/js/respond.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo("template_directory"); ?>/css/ie8-and-down.css" />
  <![endif]-->

</head>

<body <?php body_class(); ?>>

<div id="branding" role="banner" class="purple-patch tan-band wordmark-white">


<?php // Thin strip ?>

  <div id="thin-strip">
    <div role="navigation">
      <ul>
        <li><a href="http://www.washington.edu/">UW Home</a></li>
        <li><a href="http://www.washington.edu/home/directories.html">Directories</a></li>
        <li><a href="http://www.washington.edu/discover/visit/uw-events">Calendar</a></li>
        <li><a href="http://www.lib.washington.edu/">Libraries</a></li>
        <li><a href="http://www.washington.edu/maps">Maps</a></li>
        <li><a href="http://myuw.washington.edu/">My UW</a></li>
        <li class="visible-desktop"><a href="http://www.bothell.washington.edu/">UW Bothell</a></li>
        <li class="visible-desktop"><a href="http://www.tacoma.uw.edu/">UW Tacoma</a></li>
        <li class="visible-phone"><a href="http://www.uw.edu/news">News</a></li>
        <li class="visible-phone"><a href="http://www.gohuskies.com/">UW Athletics</a></li>
      </ul>
    </div>	
  </div>

<div id="header"<?php echo get_theme_mod( 'patch_visible', 1 ) === false ? ' class="hide-patch"' : ''; ?>>
		<div class="skip-link"><a class="assistive-text" href="#content" title="Skip to primary content">Skip to primary content</a></div>
		<div class="skip-link"><a class="assistive-text" href="#secondary" title="Skip to sidebar content">Skip to sidebar content</a></div>

		
		<a class="patch" href="http://www.uw.edu" title="University of Washington"><div class="w1"></div><div class="w2"></div><div class="w3"></div><div class="w4"></div><div class="w5"></div><div class="w6"></div><div class="w7"></div><div class="w8
"></div></a>

		<!--[if IE 8]>
			<a class="patch" href="http://www.uw.edu" title="University of Washington">University of Washington</a>
		<![endif]-->	
		
		<a class="wordmark" <?php if ( get_theme_mod('wordmark')) : ?> style="background:url(<?php echo get_theme_mod('wordmark') ?>)" <?php endif; ?> href="<?php echo home_url('/'); ?>">University of Washington</a>

		<?php get_template_part('uw-search'); ?>

		<a title="Show menu" role="button" href="#listicon-wrapper" id="listicon-wrapper" class="visible-phone" aria-controls="thin-strip">Menu</a>

</div><!-- #header -->

<!--  End Temporary Fill   -->

  <div id="dawgdrops" aria-label="Main menu" role="navigation">
    <h3 class="assistive-text">Main menu</h3>
    <?php uw_dropdowns(); ?>
  </div>

</div><!-- Header -->


<ul id="menu-dots">
	<li data-menuanchor="intro" class="active"><a href="#intro">Intro</a></li>
	<li data-menuanchor="secondPage"><a href="#secondPage">Holiday Video</a></li>
	<li data-menuanchor="thirdPage"><a href="#thirdPage">Holiday Message</a></li>
	<li data-menuanchor="fourthPage"><a href="#fourthPage">Your Videos</a></li>
</ul>

<div class="section" id="section0">
    <div id="holiday-logo-image">
    	<img class="holiday-logo-1" data-top="270" data-opacity="1" data-duration="1200" src="/wp-content/themes/uw-2013/img/misc/template-holiday/slide1-best-full.png" />
    	<img class="holiday-logo-2" data-opacity="1" data-duration="1200" src="/wp-content/themes/uw-2013/img/misc/template-holiday/slide1-husky.png" />
    	<img class="holiday-logo-3" data-top="640" data-duration="4000" data-opacity="1"  src="/wp-content/themes/uw-2013/img/misc/template-holiday/slide1-moments-full.png" />
    </div>
  <a href="#secondPage" class="scroll">Scroll</a>  
</div>

<div class="section" id="section1">
     <div id="border" data-width="877" data-duration="1200"></div>
     <iframe id="holiday-video" data-opacity="1" data-duration="1200" src="//www.youtube.com/embed/xIIQOsGYuG8" frameborder="0" allowfullscreen></iframe>   
     <p id="ie-only">
        <a href="http://www.youtube.com/playlist?list=PLgNkGpnjFWo91-ltPkhAYOkMGhVzhRLJH" title="Husky Moments">See more great Husky moments</a> and send us your best moment to <a href="mailto:bestof13@uw.edu" title="Submit a video">bestof13@uw.edu</a>!
    </p>
     <a href="#4rdPage" class="scroll-1">Scroll</a> 
</div>

<div class="section" id="section2">
    <div class="holiday-message-image">
    	<img class="holiday-message-1" src="/wp-content/themes/uw-2013/img/misc/template-holiday/slide2-thankyou-full.png" />
    	<img class="holiday-message-2" src="/wp-content/themes/uw-2013/img/misc/template-holiday/slide2-forsharing-full.png" />
    	<img class="holiday-message-3" src="/wp-content/themes/uw-2013/img/misc/template-holiday/slide2-yourbest-full.png" />
    	<img class="holiday-message-4" src="/wp-content/themes/uw-2013/img/misc/template-holiday/slide2-husky-full.png" />
    	<img class="holiday-message-5" src="/wp-content/themes/uw-2013/img/misc/template-holiday/slide2-moments-full.png" />
      <div class="holiday-message">    
        <p>
            The Husky family achieved great things in 2013, and we want to hear what made the year memorable for you.
            Was it joining hoards of enthusiastic Huskies to show purple pride during ESPN's GameDay on Red Square? Studying abroad? Going back to school?
            See more great Husky moments below and send us your best moment to <a href="mailto:bestof13@uw.edu" title="Submit a video">bestof13@uw.edu</a>
        </p>
      </div>
    </div>

    <a href="#3rdpage" class="scroll-1">Scroll</a>
</div>

<div class="section" id="section3">
  <div id="youtube-videos">
  <span id="more-videos" href="#">More videos</span>
  </div>
</div>

<script type="text/template" id="video-grid">

<% _.each( videos, function(video, index) {  %>

    <a class="grid" data-id="<%= video.id %>" style="background-image:url(<%= video.thumbnail.hqDefault %>)" data-css="background-image:url(<%= video.thumbnail.hqDefault %>)"></a>

<% }) %>

<% _.each( blank, function(blank, index) {  %>
    <a class="grid blank"></a>
<% }) %>
</script>

<script type="text/template" id="iframe-grid">
  <iframe class="iframe-grid" src="//www.youtube.com/embed/<%= id %>" frameborder="0" allowfullscreen></iframe>
</script>

<div id="pattern"></div>
<div id="snowy"></div>

<?php get_footer(); ?>

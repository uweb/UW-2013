<?php wp_enqueue_style( 'discover-holiday-2013', get_bloginfo( 'stylesheet_directory') . '/site-templates/css/page-discover-holiday.css', array('uw-master') ); ?>
<?php wp_enqueue_script('backbone'); ?>
<?php wp_enqueue_script( 'fullPage.js', get_bloginfo('stylesheet_directory') . '/site-templates/js/fullPage.js' ); ?>
<?php wp_enqueue_script( 'jqueryrain', get_bloginfo('stylesheet_directory') . '/site-templates/js/jquery.rain.js' ); ?>
<?php wp_enqueue_script( 'discover-holiday-2013', get_bloginfo('stylesheet_directory') . '/site-templates/js/page-discover-holiday.js' ); ?>
<?php get_header(); ?>

<ul id="menu-dots">
	<li data-menuanchor="intro"><a href="#intro">Intro</a></li>
	<li data-menuanchor="secondPage"><a href="#secondPage">Holiday Message</a></li>
	<li data-menuanchor="3rdPage"><a href="#3rdPage">Holiday Video</a></li>
	<li data-menuanchor="4thPage"><a href="#4thPage">Your Videos</a></li>
</ul>

<div class="section " id="section0">
	<img class="holiday-logo-1" data-top="270" data-opacity="1" data-duration="1200" src="/cms/president/wp-content/themes/uw-2013/img/misc/template-holiday/slide1-best.png" />
	<img class="holiday-logo-2" data-opacity="1" data-duration="1200" src="/cms/president/wp-content/themes/uw-2013/img/misc/template-holiday/slide1-husky.png" />
	<img class="holiday-logo-3" data-top="640" data-duration="4000" data-opacity="1"  src="/cms/president/wp-content/themes/uw-2013/img/misc/template-holiday/slide1-moments.png" />
  <a href="#secondPage" class="scroll">Scroll</a>  
</div>

<div class="section" id="section1">

	<img class="holiday-message-1" src="/cms/president/wp-content/themes/uw-2013/img/misc/template-holiday/slide2-thankyou.png" />
	<img class="holiday-message-2" src="/cms/president/wp-content/themes/uw-2013/img/misc/template-holiday/slide2-forsharing.png" />
	<img class="holiday-message-3" src="/cms/president/wp-content/themes/uw-2013/img/misc/template-holiday/slide2-yourbest.png" />
	<img class="holiday-message-4" src="/cms/president/wp-content/themes/uw-2013/img/misc/template-holiday/slide2-husky.png" />
	<img class="holiday-message-5" src="/cms/president/wp-content/themes/uw-2013/img/misc/template-holiday/slide2-moments.png" />

    <div class="holiday-message">    
            <p>The Husky family achieved great things in 2013, and we want to hear straight from the source what made the year memorable to you. Was it joining hoards of enthusiastic Huskies to show purple pride during ESPN's GameDay on Red Square Studying abroad? Going back to school? </p>
    </div>
    <a href="#3rdPage" class="scroll-1">Scroll</a>
</div>

<div class="section" id="section2">
     <div id="border" data-width="877" data-duration="1200"></div>
     <iframe id="holiday-video" width="853" height="480" data-opacity="1" data-duration="1200" src="//www.youtube.com/embed/KsDQPY_3lZ0" frameborder="0" allowfullscreen></iframe>   
     <a href="#4rdPage" class="scroll-1">Scroll</a> 
</div>

<div class="section" id="section3">
    <div class="slide-1 slide"></div>
    <div class="slide-2 slide"></div>
    <div class="slide-3 slide"></div>
    <div class="slide-4 slide"></div>
</div>

<script type="text/template" id="video-grid">

<% _.each( videos, function(video, index) {  %>

    <a class="grid" data-id="<%= video.id %>" style="background-image:url(<%= video.thumbnail.hqDefault %>)" data-css="background-image:url(<%= video.thumbnail.hqDefault %>)"></a>

<% }) %>
</script>

<script type="text/template" id="iframe-grid">
  <iframe class="iframe-grid" src="//www.youtube.com/embed/<%= id %>" frameborder="0" allowfullscreen></iframe>
</script>

<div id="snowy"></div>

<?php get_footer(); ?>

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
	<img class="holiday-logo" src="/cms/president/wp-content/themes/uw-2013/img/misc/template-holiday/logo.png" />
  <a href="http://128.208.132.220/cms/president/holiday/#secondPage" class="scroll">Scroll</a>  
</div>

<div class="section" id="section1">
    <div class="holiday-message">
            <p>The Husky family achieved great things in 2013, and we want to hear straight from the source what made the year memorable to you. Was it joining hoards of enthusiastic Huskies to show purple pride during ESPN's GameDay on Red Square Studying abroad? Going back to school? </p>
    </div>
    <a href="#" class="scroll-1">Scroll</a>      
</div>

<div class="section" id="section2">
     <iframe width="853" height="480" src="//www.youtube.com/embed/KsDQPY_3lZ0" frameborder="0" allowfullscreen></iframe>    
</div>

<div class="section" id="section3">
    <div class="slide-1 slide active">Slide 1</div>
    <div class="slide-2 slide"><h1>This is an awesome plugin</h1></div>
    <div class="slide-3 slide"><h1>Which enables you to create awesome websites</h1></div>
    <div class="slide-4 slide"><h1>In the most simple way ever</h1></div>
</div>

<script type="text/template" id="video-grid">
  <div class="grid">
    <img src="<%= video.src =>" />
  </div>
</script>

<div id="snowy"></div>

<?php get_footer(); ?>

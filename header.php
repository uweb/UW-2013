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
  <meta http-equiv="X-UA-Compatible" content="IE=Edge"> 
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

<div id="branding" role="banner" class="<?php echo get_theme_mod('patch_color'); ?> <?php echo get_theme_mod('band_color'); ?> <?php if ( get_theme_mod('wordmark') ) echo 'wordmark-custom' ?> <?php echo get_theme_mod( 'wordmark_color' ); ?>" style="background-image:url(<?php echo get_header_image(); ?>);" >


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

    <div id="search">

      <form role="search" class="main-search" action="http://www.washington.edu/search" id="searchbox_008816504494047979142:bpbdkw8tbqc" name="form1">
          <input value="008816504494047979142:bpbdkw8tbqc" name="cx" type="hidden">
          <input value="FORID:0" name="cof" type="hidden">
          <label for="q" class="hide">Search the UW</label>
          <input id="q" class="wTextInput" placeholder="Search the UW" title="Search the UW" name="q" type="text" autocomplete="off">
          <input value="Go" name="sa" class="formbutton" type="submit">
      </form>	

      <!--span class="search-toggle search-toggle"></span-->

      <div class="search-options">
        <label class="radio">
          <input type="radio" name="search-toggle" value="main" checked="checked" data-placeholder="the UW">
          UW.edu
        </label>
        <label class="radio">
          <input type="radio" name="search-toggle" value="directory" data-placeholder="the Directory"/>
          UW Directory
        </label>
              <label class="radio">
          <input type="radio" name="search-toggle" value="site" data-site="<?php echo home_url('/') ?>" data-placeholder="<?php bloginfo(); ?>"/>
          This site
        </label>
        
        <span class="search-options-notch"></span>
      </div>

		</div><!-- #search -->

		<a title="Show menu" role="button" href="#listicon-wrapper" id="listicon-wrapper" class="visible-phone" aria-controls="thin-strip">Menu</a>

</div><!-- #header -->

<!--  End Temporary Fill   -->

  <div id="dawgdrops" aria-label="Main menu" role="navigation">
    <h3 class="assistive-text">Main menu</h3>
    <?php uw_dropdowns(); ?>
  </div>

</div><!-- Header -->

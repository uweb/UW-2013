<?php
/*
Template Name: Teaching Calendar
*/
?>

<?php get_header(); ?>

		<div id="primary">
			<div id="content" role="main" class="container">
									
			<div class="row show-grid">
				<div class="span8">
				<span id="arrow-mark"></span>
				<h1><?php echo get_the_title(); ?></h1>
				
					
<script type="text/javascript">
$Trumba.addSpud({webName: "sea_ctl",spudType : "main" });
</script> 

<noscript>Your browser must support JavaScript to view this content. 
Please enable JavaScript in your browser settings then try again. 
<a href='http://www.trumba.com'>Events calendar powered by Trumba</a></noscript>



				</div>
				<div id="secondary" class="span4 right-bar" role="complementary">
					<div class="stripe-top"></div><div class="stripe-bottom"></div>				
          <div id="sidebar">
	          <?php dynamic_sidebar('sidebar'); ?>
          </div>
				</div>
 			 </div>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>

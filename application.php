<?php get_header(); ?>

		<div id="primary">
			<div id="content" role="main" class="container image-page">
			
						
			<div class="row show-grid">
				<div class="span12 paginated-center">
					
					
			<?php while ( have_posts() ) : the_post(); ?>

      <span id="arrow-mark" <?php the_blogroll_banner_style(); ?> ></span>
				
      <article id="post-<?php the_ID(); ?>" <?php post_class( str_replace( 'application/', '', get_post_mime_type() ) . '-attachment' ); ?>>
			
				<div class="entry-content">
					<h1 class="entry-title"><?php the_title(); ?></h1>
          <div><a href="<?php echo wp_get_attachment_url(get_the_ID());?>" title="<?php the_title(); ?>" target="_blank">Download</a></div>
					<?php the_excerpt(); ?>
				</div><!-- .entry-content -->

				<footer class="entry-meta">
          <iframe class="uw-pdf-view" style="<?php echo(is_pdf() ? 'width:100%;height:900px;' : 'width:0px;height:0px;'); ?>" src="<?php echo wp_get_attachment_url(get_the_ID()); ?>?<?php echo time() ?>"></iframe>
					<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-meta -->
			</article><!-- #post-<?php the_ID(); ?> -->

			<?php endwhile; // end of the loop. ?>

				</div>

 			 </div>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>

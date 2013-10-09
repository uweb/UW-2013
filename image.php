<?php get_header(); ?>

		<div id="primary">
			<div id="content" role="main" class="container image-page">
			
						
			<div class="row show-grid">
				<div class="span12 paginated-center">
					
					
			<?php while ( have_posts() ) : the_post(); ?>

      <span id="arrow-mark" <?php the_blogroll_banner_style(); ?> ></span>
				
      <article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>

			
				<div class="entry-content">
					<?php echo wp_get_attachment_image($post->ID, 'full'); ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php the_excerpt(); ?>
          <div><a href="<?php echo wp_get_attachment_url(get_the_ID());?>" title="<?php the_title(); ?>" target="_blank" download="<?php the_title() ?>">Download</a></div>
				</div><!-- .entry-content -->
				<footer class="entry-meta">
					<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-meta -->
			</article><!-- #post-<?php the_ID(); ?> -->

			<?php endwhile; // end of the loop. ?>

				</div>
 			 </div>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>

<?php get_header(); ?>

		<div id="primary">
			<div id="content" role="main" class="container">
			
						
			<div class="row show-grid">
				<div class="span8">
				<span id="arrow-mark" <?php the_blogroll_banner_style(); ?> ></span>
								
			<?php while ( have_posts() ) : the_post(); ?>

				
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">

					<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php if ( comments_open() && ! post_password_required() && get_comments_number() > 0 ): ?>
              <span class="comments-link">
                <?php comments_popup_link( '<span class="leave-reply">' . __( 'Reply', 'uw' ) . '</span>', _x( '1', 'comments number', 'uw' ), _x( '%', 'comments number', 'uw' ) ); ?>
              </span>
            <?php endif; ?>

					<span class="post-info"><p><?php the_time('F j, Y'); ?></p><p class="author-info">By <?php the_author(); ?></p></span>
				</header><!-- .entry-header -->
			
				<div class="entry-content">
					<?php the_post_thumbnail(array(100,100));?>
                    <?php the_excerpt();  ?>
				</div><!-- .entry-content -->
				<hr>
				<footer class="entry-meta">
					<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-meta -->
			</article><!-- #post-<?php the_ID(); ?> -->

					<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

        <?php uw_prev_next_links(); ?>

				</div>
				<div id="secondary" class="span4 right-bar" role="complementary">
					<div class="stripe-top"></div><div class="stripe-bottom"></div>				
          <div id="sidebar">
          <?php if (is_active_sidebar('homepage-sidebar')) : dynamic_sidebar('homepage-sidebar'); else: dynamic_sidebar('sidebar'); endif; ?>
          </div>
				</div>
 			 </div>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>

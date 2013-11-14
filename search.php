<?php get_header(); ?>

		<div id="primary">
			<div id="content" role="main" class="container">
			
						
			<div class="row show-grid">
				<div class="span8">
					
            <h1>Search results for: <span><?php the_search_query(); ?></span></h1>
					
            <?php if (have_posts() ): while ( have_posts() ) : the_post(); ?>

              
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
              <header class="entry-header">
                <h2 class="entry-title"><a href="<?php the_permalink()?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
              </header><!-- .entry-header -->
            
              <div class="entry-content">
                <?php the_excerpt(); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
              </div><!-- .entry-content -->
              <footer class="entry-meta">
                <?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
              </footer><!-- .entry-meta -->
            </article><!-- #post-<?php the_ID(); ?> -->

                <?php comments_template( '', true ); ?>

            <?php endwhile; else : ?>

              No results found.
              
            <?php endif; ?>

            <?php uw_prev_next_links(); ?>

				</div>
				<div id="secondary" class="span4 right-bar" role="complementary">
					<div class="stripe-top"></div><div class="stripe-bottom"></div>				
          <div id="sidebar">
          <?php if (is_active_sidebar('homepage-sidebar') && is_front_page() ||
                    is_active_sidebar('homepage-sidebar') && is_home() ) : dynamic_sidebar('homepage-sidebar'); else: dynamic_sidebar('sidebar'); endif; ?>
          </div>
				</div>
 			 </div>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>

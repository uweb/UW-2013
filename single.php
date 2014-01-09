<?php get_header(); ?>

		<div id="primary">
			<div id="content" role="main" class="container">
			
						
			<div class="row show-grid">
				<div class="span8">
					<span id="arrow-mark"></span>
						
					<?php while ( have_posts() ) : the_post(); ?>
				
						
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <p class="date"><?php the_date(); ?></p>

						<header class="entry-header">
							<?php $title = get_the_title();
							if (!empty($title)): ?>
							<h1 class="entry-title"><?= $title ?></h1>
							<?php endif; ?>
              <p class="author-info">By <?php the_author(); ?></p>
						</header><!-- .entry-header -->
					
						<div class="entry-content">
							<?php the_content(); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'uw' ) . '</span>', 'after' => '</div>' ) ); ?>
						</div><!-- .entry-content -->
						<footer class="entry-meta">
              <?php the_tags('This article was posted under: ', ', ', '<br />'); ?> 
							<?php edit_post_link( __( 'Edit', 'uw' ), '<span class="edit-link">', '</span>' ); ?>
						</footer><!-- .entry-meta -->
					</article><!-- #post-<?php the_ID(); ?> -->
				
							<?php comments_template( '', true ); ?>
				
					<?php endwhile; // end of the loop. ?>
				</div>

				<div id="secondary" class="span4 right-bar" role="complementary">
					<div class="stripe-top"></div><div class="stripe-bottom"></div>				
          <div id="sidebar">
            <?php dynamic_sidebar('post-sidebar'); ?>
          </div>
        </div><!-- .span4 -->

 			 </div>
			</div><!-- #content -->
		</div><!-- #primary -->


<?php get_footer(); ?>

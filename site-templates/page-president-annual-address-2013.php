<?php get_header(); ?>

<style>
body {
        background: url('http://www.uw.edu/president/wp-content/themes/uw-2013/img/misc/template-president/letterhead.jpg') no-repeat center 270px;

}
#content.annual-address {
    font-family: 'Droid Serif', serif;
    padding-top: 310px;
}
.opener {
    text-align: center;
    margin-bottom: 50px;
}   
.opener p {
    margin-bottom: 5px
}
.opener span {
    display: inline-block;
    width: 100px;
    background-color: #ddd;
    height: 1px;
}
.annual-address-pad {
    padding: 0 100px;
}
.address-place {
    font-weight: bold;
    font-size: 1.4em;
    font-style: italic;
}
.address-date {
    font-style: italic;
}
.pull-quote-right {
    float: right;
    font-size: 1.5em;
    width: 40%;
    font-style: italic;
    line-height: 37px;
    margin: 20px -60px 40px 30px;
    padding-left: 30px;
    border-left: 2px solid #DDD;
}

.pull-quote-left {
    float: left;
    font-size: 1.5em;
    width: 40%;
    font-style: italic;
    line-height: 37px;
    margin: 20px 40px 30px -60px;
    padding-right: 30px;
    border-right: 2px solid #DDD;
}

@media (max-width: 767px) {
    body {
        background-position: center 50px;
    }
    #content.annual-address {
        padding-top: 230px;
    }
    .annual-address-pad {
        padding: 0 40px;
    }
    .pull-quote-left {
        margin: 20px 40px 30px -30px;
    }
    .pull-quote-right {
        margin: 20px -30px 40px 30px;
    }
}


</style>

		<div>
			<div id="content" role="main" class="container annual-address">
									
			<div class="row show-grid ">
				<div class="span12">
			
				<div class="annual-address-pad">	
			<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'uw' ) . '</span>', 'after' => '</div>' ) ); ?>
				</div><!-- .entry-content -->
				<footer class="entry-meta">
					<?php edit_post_link( __( 'Edit', 'uw' ), '<span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-meta -->
			</article><!-- #post-<?php the_ID(); ?> -->

			<?php endwhile; // end of the loop. ?>
				</div>

				</div>
 			 </div>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>

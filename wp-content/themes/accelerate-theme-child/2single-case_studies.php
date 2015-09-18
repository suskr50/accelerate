<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
get_header(); ?>

	<!-- BLOG PAGE -->
	<section class="blog-page">
		<div class="container wrap">

			<div class="main-cs-content ">
<?php
				// Start the Loop.
				while ( have_posts() ) : the_post(); ?>

				<article class="post-entry individual-post">
					<div class="entry-wrap">
						<header class="entry-header">
							
						<!---	<h2 class="entry-title"><?php the_title(); ?></h2> ---->

						</header>
						<div class="entry-summary">
							
							<?php the_content(); ?>
						</div>
						<footer class="entry-footer">
							
						</footer>
					</div>
				</article>

			</div>


		</div>
	</section>
	<!-- END blog page -->

	<footer class="navigation container">
		<div class="left">&larr;<a href="">back to work</a></div>
	</footer>
	
				<?php endwhile; ?>

<?php
get_footer();

    Status API Training Shop Blog About Pricing 

    © 2015 GitHub, Inc. Terms Privacy Security Contact Help 
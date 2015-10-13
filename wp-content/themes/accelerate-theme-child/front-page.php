<?php
/**
 * The template for displaying the homepage
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Accelerate Marketing
 * @since Accelerate Marketing 1.0
 */

get_header(); ?>

<section class="home-page">
	<div class="site-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class='homepage-hero'>
				<?php the_content(); ?>
				<a class="button" href="<?php echo home_url(); ?>/blog">View Our Work</a>
			</div>
		<?php endwhile; // end of the loop. ?>
	</div><!-- .container -->
</section><!-- .home-page -->

<section class="feature-posts">
	<div class="site-content">
		
			<h4 class="center"> Featured Work </h4>
			<?php query_posts('posts_per_page=3&post_type=case_studies')?>

			<ul class="featured-list ">

				<?php while ( have_posts() ) : the_post(); 
				$image1 = get_field("image1");
				?>
				<li class="individual-list">	
					<figure>
						<?php echo wp_get_attachment_image($image1,'medium'); ?>
					</figure>


					<a href="<?php the_permalink(); ?>" class="center "><?php the_title(); ?></a>
				</li>
			<?php endwhile; // end of the loop. ?>


			<?php wp_reset_query(); // resets the altered query back to the original ?>
		</ul>
	</div>
</section>


<section class="front-services center">
	<?php query_posts('pagename=about'); ?>
	<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); 
	$picture_1 = get_field("picture_1");
	$title_1 = get_field("title_1");
	$picture_2 = get_field("picture_2");
	$title_2 = get_field("title_2");
	$picture_3 = get_field("picture_3");
	$title_3 = get_field("title_3");
	$picture_4 = get_field("picture_4");
	$title_4 = get_field("title_4");
	?>

	<h3> Our Services </h3>
	<ul class="front-service-list">
		<li> <img src="<?php echo $picture_1; ?>" ><h4><?php echo $title_1; ?></h4> </li>
		<li> <img src="<?php echo $picture_2; ?>" ><h4><?php echo $title_2; ?></h4> </li>
		<li> <img src="<?php echo $picture_3; ?>" ><h4><?php echo $title_3; ?></h4> </li>
		<li> <img src="<?php echo $picture_4; ?>" ><h4><?php echo $title_4; ?></h4> </li>
	</ul>


<?php endwhile; ?>
<?php endif; ?>

</section>

<div style="clear: both;"></div>

<section class="fp-recent-post">
	<div class="site-content">

		<div class="twitter-post">
			<div class="moveover">
		<h4>Recent Tweets</h4>
		<h5>@susan_schrum</h5>
	</div>
			<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
			<div id="secondary" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div>
			<?php endif; ?>



		</div>

	<div class="fpblog-post">
		<h4>From the Blog</h4>
		<?php query_posts('posts_per_page=1'); ?>
		<?php while ( have_posts() ) : the_post(); ?>
		<h2><?php the_title(); ?></h2>
		<?php the_excerpt(); ?>
		<a href="<?php the_permalink(); ?>" class="read-more-link">Read More <span>&rsaquo;</span></a>
	<?php endwhile; // end of the loop. ?>
	<?php wp_reset_query(); // resets the altered query back to the original ?>
</div>

</div>
</section>



<?php get_footer(); ?>
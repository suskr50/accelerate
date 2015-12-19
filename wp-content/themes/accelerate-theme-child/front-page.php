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
			<a class="button" href="http://localhost:8888/accelerate/case-studies/">View Our Work</a>
		</div>
	<?php endwhile; // end of the loop. ?>
</div><!-- .container -->
</section><!-- .home-page -->

<!---- Feature Posts ---->

<div class="site-content">
<section class="feature-posts">
	
		
		<h4 class="center"> FEATURED WORK </h4>
		<?php query_posts('posts_per_page=3&post_type=case_studies')?>



		<ul class="our-features">
			<?php while ( have_posts() ) : the_post(); 
			$image1 = get_field("image1");
			?>

			<li> <?php echo wp_get_attachment_image($image1,'medium'); ?> 
				<a href="<?php the_permalink(); ?>" class="center"><?php the_title(); ?></a>
			</li>

		<?php endwhile; // end of the loop. ?>

		<?php wp_reset_query(); // resets the altered query back to the original ?>
	</ul>

</section>



<section class ="front-services ">
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

	<h4> OUR SERVICES </h4>
	<ul class="frservices">
		<li> <img src="<?php echo $picture_1; ?>" ><?php echo $title_1; ?> </li>
		<li> <img src="<?php echo $picture_2; ?>" ><?php echo $title_2; ?></li>
		<li> <img src="<?php echo $picture_3; ?>" ><?php echo $title_3; ?></li>
		<li> <img src="<?php echo $picture_4; ?>" ><?php echo $title_4; ?> </li>
	</ul>


<?php endwhile; ?>
<?php endif; ?>

</section>

<div style="clear: both;"></div>




<section class="fp-recent-post">
	

	<div class="twitter-post">

		<h4>Recent Tweets</h4>
		<h5>@susan_schrum</h5>

		<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div>
		<?php endif; ?>
	</div>

	<div class="blog-post">
		<h4>From the Blog</h4>
		<?php query_posts('posts_per_page=1'); ?>
		<?php while ( have_posts() ) : the_post(); ?>
		<h2><?php the_title(); ?></h2>
		<?php the_excerpt(); ?>
		<a href="<?php the_permalink(); ?>" class="read-more-link">Read More <span>&rsaquo;</span></a>
	<?php endwhile; // end of the loop. ?>
	<?php wp_reset_query(); // resets the altered query back to the original ?>
</div>
</section>

</div>
</div>
</section>



<?php get_footer(); ?>
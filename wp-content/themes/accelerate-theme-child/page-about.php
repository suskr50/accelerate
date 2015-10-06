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

<section class="about-page">
	<div class="site-content">
		<?php while ( have_posts() ) : the_post(); 
		$content_1 = get_field("content_1");
		$picture_1 = get_field("picture_1");
		$title_1 = get_field("title_1");
		$service = get_field("services");
		$content_2 = get_field("content_2");
		$picture_2 = get_field("picture_2");
		$title_2 = get_field("title_2");
		$content_3 = get_field("content_3");
		$picture_3 = get_field("picture_3");
		$title_3 = get_field("title_3");
		$content_4 = get_field("content_4");
		$picture_4 = get_field("picture_4");
		$title_4 = get_field("title_4");
		?>
			<div class="about-top">
				<?php the_content(); ?>
			</div>
		<?php endwhile; // end of the loop. ?>
	</div><!-- .container -->
</section><!-- .home-page -->

<section class="about-services">
	<div class="site-content">
		<div>
			<h3 > OUR SERVICES </h3>
			<p> <?php echo $service ?> </p>
		</div>
	</div>
</section>

	

<section class="about-content">
	<div >
		<h2><img class="picleft" src="<?php echo $picture_1 ?>" ><?php echo $title_1; ?></h2>
		<p> <?php echo $content_1; ?> </p>
	</div>
</section>

<section class="about-content">
	<div >
		<h2><img class="picright" src="<?php echo $picture_2 ?>" ><?php echo $title_2; ?></h2>
		<p> <?php echo $content_2; ?> </p>
	</div>
</section>

<section class="about-content">
	<div >
		<h2><img class="picleft" src="<?php echo $picture_3 ?>" ><?php echo $title_3; ?></h2>
		<p> <?php echo $content_3; ?> </p>
	</div>
</section>


<section class="about-content">
	<div >
		<h2><img class="picright" src="<?php echo $picture_4 ?>" ><?php echo $title_4; ?></h2>
		<p> <?php echo $content_4; ?> </p>
	</div>
</section>


<section id="call-to-action">	
	<p > Interested in working with us? &nbsp&nbsp&nbsp&nbsp&nbsp  <span > <a  href="<?php home_url().'/contact-us'; ?>">Contact Us</a> </p>
</section>

</div>


<?php get_footer(); ?>
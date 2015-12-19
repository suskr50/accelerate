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


<section class="ahome-page">
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
			<div class='about-top'>
				<?php the_content(); ?>
			</div>
		<?php endwhile; // end of the loop. ?>
	</div><!-- .container -->
</section><!-- .home-page -->



<div id="primary" class="site-content">
		<div id="content" role="main">

<section class="about-page">
	

<section class="about-services">
	<h3 > OUR SERVICES </h3>
	<p> <?php echo $service ?> </p>
</section>

<div class="about-content">

	<section class="about-content-left">
		<img src="<?php echo $picture_1 ?>" >
		<div class="inside">
			<h2><?php echo $title_1; ?></h2>
			<p> <?php echo $content_1; ?> </p>
		</div>
	</section>
	<div class="clear">

		<section class="about-content-right">
			<img class="picright" src="<?php echo $picture_2 ?>" >
			<div class="inside">
				<h2><?php echo $title_2; ?></h2>
				<p> <?php echo $content_2; ?> </p>
			</div>
		</section>
		<div class="clear">
			<section class="about-content-left">
				<img class="picleft" src="<?php echo $picture_3 ?>" >
				<div class="inside">
					<h2><?php echo $title_3; ?></h2>
					<p> <?php echo $content_3; ?> </p>
				</div>
			</section>
			<div class="clear">

			</div>

<section class="about-content-right">
	<img class="picright" src="<?php echo $picture_4 ?>" >
	<div class="inside">
		<h2><?php echo $title_4; ?></h2>
		<p> <?php echo $content_4; ?> </p>
	</div>
</section>
<div class="clear">


<hr>
<section id="call-to-action">	
	
	<h2> Interested in working with us? </h2> 
	<a href="<?php home_url().'/contact-us'; ?>">Contact Us</a> </p>
	
</section>
<hr>

</div>
</div>


<?php get_footer(); ?>
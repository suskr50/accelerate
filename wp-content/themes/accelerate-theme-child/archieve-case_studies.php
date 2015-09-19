<?php
/**
 * The template for displaying archieve of all case studies
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<h3> Is this working </h3>
		<div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); 
			$services = get_field('services');
			$client = get_field('client');
			$link = get_field('link');
			$image1 = get_field('image1');
			$image2 = get_field('image2');
			$image3 = get_field('image3');
			$size = "full";
			?>
				<article class="case-study">	
			<aside class="case-study-left">
				<div class="entry-wrap">			
					<h2><?php the_exceprt(); ?></h2>
					<h5><?php echo $services; ?></h5>
					<h6>Client: <?php echo $client; ?></h6>
					<?php the_content(); ?>
					<a href="<?php $link ?>"><strong>Visit Live Site</strong></a>
				</div>
			</aside>

			<section class="case-study-right">
				<ul class="case-study-list">
					<?php if ($image1) ?>
					<li><?php echo wp_get_attachment_image($image1,$size); ?></li>
					<li><?php echo wp_get_attachment_image($image2,$size); ?></li>
					<li><?php echo wp_get_attachment_image($image3,$size); ?></li>
				</ul>
			</section>
		</article>




			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->


<?php get_footer(); ?>
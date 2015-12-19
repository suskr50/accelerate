<?php
/**
 * The template for displaying archieve of all case studies
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Acclerate Theme
 * @since Acclerate Theme 1.0
 */

get_header(); ?>

<section class="feature-work">
	<div class="container wrap">
		<div class="main-cs-content  ">

			<?php while ( have_posts() ) : the_post(); 
			$services = get_field('services');
			$link = get_field('link');
			$image1 = get_field('image1');
			$size = "full";
			?>

			<section class="client-info">
				<aside class="cpost-entry">			
					<a href="<?php the_permalink(); ?>"><h1><?php the_title(); ?></h1></a>
					<h4><?php echo $services; ?></h4>
					<p><?php the_excerpt() ?></p>
					<a href="<?php the_permalink(); ?>"><strong>Visit Project ></strong></a>
					
				</aside>

				<section class="cpost-pic">
					<ul class="cpost-list">
						<li> <?php if ($image1)  { 
							echo wp_get_attachment_image($image1,$size);
						} ?></li>
					</ul>
				</section>
			</section>
			<div class="clear"></div>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
</div><!-- #primary -->
<section>


	<?php get_footer(); ?>
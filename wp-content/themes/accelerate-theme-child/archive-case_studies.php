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
	<div class="container ">
		<div class="main-acs-content  ">

			<?php while ( have_posts() ) : the_post(); 
			$services = get_field('services');
			$link = get_field('link');
			$image1 = get_field('image1');
			$size = "full";
			?>

<article class="case-study">	
			<aside class="case-study-left">
				<div class="entry-wrap">			
					<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
					<h5><?php echo $services; ?></h5>
					<?php the_excerpt() ?>
					<a href="<?php the_permalink(); ?>"><strong>Visit Project ></strong></a>
				</div>
			</aside>

			<section class="case-study-right">
				<ul class="case-study-list">
					<li> <?php if ($image1)  { 
						echo wp_get_attachment_image($image1,$size);
					} ?></li>
					</ul>
			</section>
		</article>






			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
	<section>


<?php get_footer(); ?>
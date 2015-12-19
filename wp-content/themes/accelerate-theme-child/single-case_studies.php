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
	<div class="container ">
		<div class="main-cs-content  ">
			<?php
				// Start the Loop.
			while ( have_posts() ) : the_post(); 

			$services = get_field('services');
			$client = get_field('client');
			$link = get_field('link');
			$image1 = get_field('image1');
			$image2 = get_field('image2');
			$image3 = get_field('image3');
			$size = "full";

			?>

			<section class="client-info">

				<aside class="cpost-entry">

					<h1><?php echo the_title(); ?></h1>
					<h4><?php echo $services; ?></h4>
					<h2>Client: <?php echo $client; ?></h2>
					<p><?php the_content(); ?></p>
					<a href="<?php $link ?>"><strong>Visit Live Site</strong></a>

				</aside>

				<section class="cpost-pic">
					<ul class="cpost-list">
						<?php if ($image1) ?>
						<li><?php echo wp_get_attachment_image($image1,$size); ?></li>
						<li><?php echo wp_get_attachment_image($image2,$size); ?></li>
						<li><?php echo wp_get_attachment_image($image3,$size); ?></li>
					</ul>
				</section>

<div class='clear'></div>
			
			<section class="cback-nav">
				<div class="left">&larr;<a href="http://localhost:8888/accelerate/case-studies/">back to work</a></div>
			</section>
			</section>
			

		</div>
	</div>
</section>




<!-- END blog page -->



<?php endwhile; ?>

<?php
get_footer();

    
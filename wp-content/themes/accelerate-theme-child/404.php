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

<!-- ABOUT ME -->


<section class="the404-page">
	<div class="site-content">
<section class="the404-content">
	<div >
		<h2><img class="picleft picsize" src="<?php echo home_url();?>/wp-content/uploads/2015/10/yellowlight.png "/>HEY THERE! SLOW DOWN:  404 Error</h2>
		<p> Sorry, you arrived at a page that is not here. <br> 
			Please return to the <a href="<?php echo home_url()?>">home page</a> and start over.</p>
	</div>
</section>
</div>
</section>

<?php get_footer(); ?>
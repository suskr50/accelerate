<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

		</div><!-- #main -->


		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info">
				<div class="site-description">
				<p><?php bloginfo('description'); ?></p>
				<p>&copy; <?php bloginfo('title'); ?>, LLC
				</div>
				
			<div id="social">
				<ul>
					<li><img src="<?php echo home_url()."/wp-content/uploads/2015/10/linkedin-icon.png"?>"></li>
					<li><img src="<?php echo home_url()."/wp-content/uploads/2015/10/facebook-icon.png"?>"></li>
					<li><img src="<?php echo home_url()."/wp-content/uploads/2015/10/twitter-icon.png"?>"></li>
					
				</ul>
			</div>	


			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
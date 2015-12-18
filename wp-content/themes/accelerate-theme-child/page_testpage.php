<?php
/**
 * Archive page template
 */

get_header();

the_post();

$content = apply_filters( 'the_content', get_the_content() );
$content = str_replace( ']]>', ']]&gt;', $content );

list($contentleft, $contentright) = explode('<!--column-->', $content);

$contentleft = str_replace( array( '<p></p>', '</p>' ), '', $contentleft );
$contentright = str_replace( array( '<p></p>', '</p>' ), '', $contentright );

?>
<header class="home">
	<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/large-top-houses.jpg" alt="..." class="large-top-houses">
	<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/large-gray-banner.jpg" alt="..." class="large-gray-banner">
</header>
<div class="page-archive container960">
	<header class="news-sheet-archive">
		<div class="site-navigation">
			<?php
		   /**
			* Displays a navigation menu
			* @param array $args Arguments
			*/
			$args = array(
				'theme_location' => 'primary',
				'menu' => '',
				'container' => 'nav',
				'container_class' => 'menu-primary-container',
				'container_id' => '',
				'menu_class' => 'menu-primary',
				'menu_id' => '',
				'depth' => 1
				);

			wp_nav_menu( $args );
			?>
			<nav class="alignright">
				<ul>
					<li class="ico email"><a href="mailto:archive@jjdownthestreet.com">Email</a></li>
				</ul>
			</nav>
		</div>
		
		<h1>Archive</h1>
	</header>
	<?php
	$paid = filter_input(INPUT_GET, 'paid');
	if( isset( $paid ) && $paid == 1) 
	{
		?>
		<div class="success-message">Thank you for your purchase. Your order has been placed.</div>
		<?php
	}
	?>
	<div class="nsa-content">
		<div class="nsa-order">
			<aside>
				<?php echo $contentleft; ?>
				<!-- <h2 class="greenish">$6 Special Edition</h2>
				<p>For our Special Editions, which are 4-12 pp standard tabloid size issues published in both print and e-form, the cost is $6 per back issue.</p>
				<p>All issues will be sent electronically to the customer's provided e-email address. Due to our tabloid size print run policy, we do not send hard copies out via standard mail.<br/><br/></p> -->
			</aside>
			<form name="nsa-order-form" id="nsa-order-form" action="https://www.paypal.com/cgi-bin/webscr" method="post" onsubmit="return setCustomData(this);">
				<h2>Order Back Issues</h2>
				<input type="text" name="nsa-order-name" id="nsa-order-name" value="" placeholder="Name" onblur="updateHiddenField(this, 'name');" required>
				<input type="text" name="nsa-order-date" id="nsa-order-date" class="ele-date-picker" value="<?php echo date('m/d/Y');?>" placeholder="Date" readonly="readonly" required>
				<input type="text" name="nsa-order-address" id="nsa-order-address" value="" placeholder="Address" onblur="updateHiddenField(this, 'address');" required>
				<input type="tel"  name="nsa-order-phone" id="nsa-order-phone" value="" placeholder="Phone" onblur="updateHiddenField(this, 'phone');" required>
				<input type="text" name="city" id="nsa-order-city" value="" placeholder="City" class="short" required>
				<input type="text" name="state" id="nsa-order-state" value="" placeholder="State" class="short" required>
				<input type="text" name="zip" id="nsa-order-zip" value="" placeholder="Zip" class="short" required>
				<input type="email" name="nsa-order-email" value="" placeholder="Email" required>
				<!-- <select name="nsa-issue" id="nsa-issue" onchange="updateHiddenField(this, 'issue');" required>
					<option value="$6 Special Edition">$6 Special Edition</option>
					<option value="$3 Per Back Issue">$3 Per Back Issue</option>
				</select> -->
				<div class="payment-method">
					<label>Payment Method</label>
					<label for="nsa-order-payment-method-paypal">
						<input type="radio" name="nsa-order-payment-method" value="" placeholder="" id="nsa-order-payment-method-paypal" checked="checked">
						Paypal
					</label>
					<!-- <label for="nsa-order-payment-method-zencart">
						<input type="radio" name="nsa-order-payment-method" value="" placeholder="" id="nsa-order-payment-method-zencart">
						ZenCart
					</label> -->
				</div>
				<div class="submit-btn">
					<input type="submit" name="submit" id="nsa-order-submit" value="SUBMIT">
				</div>

				<!-- PAYPAL / HIDDEN FIELDS -->
				<INPUT TYPE="hidden" NAME="return" value="<?php echo esc_url( home_url() . $_SERVER['REQUEST_URI'] );?>/?paid=1">
					<INPUT TYPE="hidden" NAME="currency_code" value="USD">
						<input type="hidden" name="cmd" value="_cart">
						<input type="hidden" name="upload" value="1">

						<input type="hidden" name="first_name" id="nsa-first-name" value="">
						<input type="hidden" name="last_name" id="nsa-last-name" value="">
						<input type="hidden" name="business"  id="nsa-business" value="publisher@jjdownthestreet.com">
						<input type="hidden" name="address1" id="nsa-address-1" value="">
						<input type="hidden" name="address2" id="nsa-address-2" value="">

				<!-- <input type="hidden" name="item_number_1" id="nsa-item-number" value="NSA01SE06">
				<input type="hidden" name="item_name_1" id="nsa-item-name" value="$6 Special Edition">
				<input type="hidden" name="amount_1" id="nsa-item-amount" value="6.00">

				<input type="hidden" name="item_number_2" id="nsa-item-number" value="NSA02PBI03">
				<input type="hidden" name="item_name_2" id="nsa-item-name" value="$3 Per Back Issue">
				<input type="hidden" name="amount_2" id="nsa-item-amount" value="3.00"> -->
				<div id="news_archive_selections"></div>

				<input type="hidden" name="news_archive_selected_count" id="news_archive_selected_count" value="0">
				<input type="hidden" name="night_phone_a" id="nsa-phone-a" value="">
				<input type="hidden" name="night_phone_b" id="nsa-phone-b" value="">
				<input type="hidden" name="night_phone_c" id="nsa-phone-c" value="">
				<input type="hidden" name="custom" id="custom-field-data" value="">
			</form>
			<aside>
				<?php echo $contentright; ?>
				<!-- <h2 class="greenish">$3 Per Back Issue</h2>
				<p><em><strong>News Sheets<sup>&trade;</sup></strong></em> back issues will be sent to the customer's provided e-mail account. If there are surplus print versions available, the hard copy will also be sent to the customer's postal address at no additional cost. For non-US orders, only e-copies are available. <br>If you have questions about ordering, please ask:<br><a href="mailto:archive@jjdownthestreet.com" class="greenish"><em>archive@jjdownthestreet.com</em></a></p> -->
			</aside>
		</div>

<div>
		<h1> Test Area </h1>
		<?php $artno="1";?>

		<?php query_posts('post_type=news-sheets&post_status=publish&order=ASC&posts_per_page=-1')?>



		<?php while ( have_posts() ) : the_post(); 
		?>

		<ul class="archive-list">

			<li>
				<?php

				the_post_thumbnail( 'thumbnail', array( 'class' => 'nsa-thumbnail' ) );

				?>
				<div class="counter"> No.<?php echo $artno; $artno=$artno+1;?> </div>
				<?php

				the_date( 'F j, Y', '<div class="date">', '</div>', true );
				the_title( '<div class="title">', '</div>', true );
				?>
				<div class="selecion">
					<input type="checkbox" class="news-archive-select-checkbox" id="archive_selection_<?php echo ($counter+$i); ?>" name="archive_selection[]" value="<?php echo 'No.' . ($counter+$i) . ' ' . get_the_date( 'F j, Y' ) . ' - ' . get_the_title();?>" onchange="addNewsSheetArchiveItemHTML();">
					<label for="archive_selection_<?php echo ($counter+$i); ?>">Add to selection </label>
				</div>


			</li>
			




		<?php endwhile; // end of the loop. ?>


		<?php wp_reset_query(); // resets the altered query back to the original ?>

		
		<?php 

		for ($i=$artno; $i < 50 ; $i++) {?>
		<li> 
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/site-icon.png" alt="<?php the_title();?>" class="nsa-thumbnail">
			<div class="counter"> No.<?php echo $artno; $artno=$artno+1;?> </div>
			<div class="date">Date: 0000</div>

			<div class="title">Joe &amp; Jane<br>Down the Street</div>


		</li>
		<?php 
	}


	?>

</ul>








<?php $artno=1;?>


<?php
$total_news_sheets = wp_count_posts( 'news-sheets' )->publish;

$query = new WP_Query( array(
	'post_type'			=> 'news-sheets',
	'post_status'		=> 'publish',
	'order'				=> 'ASC',
	'posts_per_page'	=> -1,
	) );


?><ul class="archive-list"><?php
$counter = 1;
while ( $query->have_posts() ) 
{
	$query->the_post();
	for ($i=0; $i < 50 - $counter; $i++) 
	{ 
					/*if( $i > 0 && $i % 7 == 0 )
					{
						?></ul><ul class="archive-list"><?php
					}*/
					?>
					<li>
						<?php
						if( has_post_thumbnail( get_the_ID() ) && $counter+$i <= $total_news_sheets )
						{
							the_post_thumbnail( 'thumbnail', array( 'class' => 'nsa-thumbnail' ) );
						}
						else
						{
							?><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/site-icon.png" alt="<?php the_title();?>" class="nsa-thumbnail"><?php
						}
						?>
						<div class="counter"> No.<?php echo $artno; $artno=$artno+1;?> </div>
						<?php
						if( $counter+$i > $total_news_sheets )
						{
							echo '
							<div class="date">Date: 0000</div>
							<div class="title">Joe &amp; Jane<br>Down the Street</div>
							<div class="selecion">
							<input type="checkbox" class="news-archive-select-checkbox" id="archive_selection_'.($counter+$i).'" name="archive_selection[]" value="No.' . ($counter+$i) . ' 0000 - Joe &amp; Jane Down the Street" onchange="addNewsSheetArchiveItemHTML();">
							<label for="archive_selection_'.($counter+$i).'">Add to selection </label>
							</div>
							';
						}
						else
						{
							the_date( 'F j, Y', '<div class="date">', '</div>', true );
							the_title( '<div class="title">', '</div>', true );
							?>
							<div class="selecion">
								<input type="checkbox" class="news-archive-select-checkbox" id="archive_selection_<?php echo ($counter+$i); ?>" name="archive_selection[]" value="<?php echo 'No.' . ($counter+$i) . ' ' . get_the_date( 'F j, Y' ) . ' - ' . get_the_title();?>" onchange="addNewsSheetArchiveItemHTML();">
								<label for="archive_selection_<?php echo ($counter+$i); ?>">Add to selection </label>
							</div>
							<?php
						}
						?>

					</li>
					<?php
					$counter++;
				}
				
			}
			?></ul><?php

			wp_reset_postdata();
			wp_reset_query();
			?>
		</div> <!-- News Sheets Archive Contents -->

	</div>
	<?php
	get_footer( 'copy-nav-social' );
	get_footer();
	?>
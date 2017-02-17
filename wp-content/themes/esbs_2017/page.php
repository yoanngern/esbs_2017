<?php get_header( 'header' ); ?>

<section id="content">


	<?php if ( get_field( 'background' ) ): ?>

		<article class="title"
		         style="background-image: url('<?php echo get_field( 'background' )['sizes']['banner']; ?>')">

			<a class="logo" href="/"></a>

			<?php if ( get_field( 'title' ) ):
				echo "<h1>" . get_field( 'title' ) . "</h1>";
			endif; ?>

			<?php if ( get_field( 'button_link' ) ):

				if ( get_field( 'button_label' ) ) {
					$button_text = get_field( 'button_label' );
				} else {
					$button_text = get_field( 'button_link' );
				}

				?>

				<div class="button"><a class="button"
				                       href="<?php echo get_field( 'button_link' ); ?>"><?php echo $button_text; ?></a>
				</div>

			<?php endif; ?>

		</article>

	<?php else: ?>

		<div class="spacer"></div>

	<?php endif; ?>

	<div class="platter">

		<?php
		// TO SHOW THE PAGE CONTENTS
		while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->
			<article class="content-page">
				<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>

				<?php if ( get_field( 'lead_paragraph' ) ):

					echo '<div class="lead">' . get_field( 'lead_paragraph' ) . '</div>';

				endif; ?>


				<?php
				echo '<div class="content">';
				the_content();
				echo '</div>';
				?> <!-- Page Content -->

			</article><!-- .entry-content-page -->

			<?php if ( get_field( 'footer_button_link' ) ):

				if ( get_field( 'footer_button_label' ) ) {
					$button_text = get_field( 'footer_button_label' );
				} else {
					$button_text = get_field( 'footer_button_link' );
				}

				?>

				<div class="footer_button"><a class="button"
				                       href="<?php echo get_field( 'footer_button_link' ); ?>"><?php echo $button_text; ?></a>
				</div>

			<?php endif; ?>


			<?php
		endwhile; //resetting the page loop
		wp_reset_query(); //resetting the page query
		?>



	</div>


</section>


<?php get_footer(); ?>


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

				<a class="button" href="<?php echo get_field( 'button_link' ); ?>"><?php echo $button_text; ?></a>

			<?php endif; ?>

		</article>

	<?php endif; ?>

	<div class="platter">

		<?php
		// TO SHOW THE PAGE CONTENTS
		while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->
			<article class="content-page">
				<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
				<?php the_content(); ?> <!-- Page Content -->

			</article><!-- .entry-content-page -->


			<?php
		endwhile; //resetting the page loop
		wp_reset_query(); //resetting the page query
		?>

	</div>


</section>


<?php get_footer(); ?>


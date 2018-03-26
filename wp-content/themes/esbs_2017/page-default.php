<?php /* Template Name: Default new */ ?>

<?php get_header(); ?>

<section id="content">


	<?php if ( get_field( 'background' ) ): ?>

        <article class="title"
                 style="background-image: url('<?php echo get_field( 'background' )['sizes']['banner']; ?>')">
            <div class="title">

				<?php the_title( '<h1>', '</h1>' ); ?>

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

            </div>

        </article>

	<?php else: ?>

        <div class="spacer"></div>

	<?php endif; ?>

    <div class="platter">

		<?php
		// TO SHOW THE PAGE CONTENTS
		while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->
            <article class="content-page">

				<?php if ( ! get_field( 'background' ) ) {

					the_title( '<h1 class="page-title">', '</h1>' );
				}
				?>

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

	<?php if ( get_field( 'blogroll' ) ) {
		get_template_part( 'template-parts/blog/blogroll' );
	} ?>


</section>

<?php get_template_part( 'template-parts/form/simple' ); ?>


<?php get_footer(); ?>


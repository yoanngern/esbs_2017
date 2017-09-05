<?php /* Template Name: Elementor */ ?>

<?php get_header( 'campaign' ); ?>


<section id="content">

	<?php
	// TO SHOW THE PAGE CONTENTS
	while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?> <!-- Page Content -->
		<?php
	endwhile; //resetting the page loop
	wp_reset_query(); //resetting the page query
	?>


</section>

<?php get_template_part( 'template-parts/form/simple' ); ?>


<?php get_footer(); ?>


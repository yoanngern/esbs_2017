<?php

?>

<?php if ( have_rows( 'social_links', 'option' ) ): ?>


	<?php while ( have_rows( 'social_links', 'option' ) ): the_row();

		$social  = get_sub_field( 'social' );
		$link    = get_sub_field( 'link' );
		$display = get_sub_field( 'display' );

		?>

		<?php if ( $display ): ?>
            <a id="<?php echo $social ?>" target="_blank" href="<?php echo $link; ?>">
				<svg class="icon" viewBox="0 0 30 30">
                <?php echo get_icons( $social ); ?>
                </svg>
            </a>
		<?php endif; ?>

	<?php endwhile; ?>

<?php endif; ?>
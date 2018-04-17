<header>

	<?php

	if ( is_user_logged_in() ) : ?>

        <div class="private-nav">

			<?php
			wp_nav_menu( array(
				'theme_location' => 'admin'
			) );
			?>

        </div>
	<?php endif; ?>

    <a href="<?php echo home_url(); ?>" id="simple_logo"></a>

    <a href="<?php echo home_url(); ?>" id="mobile_esbs">ESBS</a>




    <div class="principal-nav">
		<?php

		wp_nav_menu( array(
			'theme_location' => 'principal'
		) );

		?>

        <div class="right">

            <div class="button-social">
				<?php get_template_part( 'template-parts/divers/social_networks' ); ?>
            </div>

			<?php
			$action_button = get_field( 'action_button', 'option' );

			if ( $action_button ):


				$link = $action_button['url'];
				$name      = $action_button['title'];
				$target    = $action_button['target'];

				?>

                <div class="action-header">
                    <a target="<?php echo $target; ?>" href="<?php echo $link; ?>"><?php echo $name; ?></a>
                </div>

			<?php endif; ?>

        </div>


    </div>


    <a href="/" id="burger"></a>

</header>
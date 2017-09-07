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

	<a href="<?php echo pll_home_url(); ?>" id="simple_logo"></a>

    <a href="<?php echo pll_home_url(); ?>" id="mobile_esbs">ESBS</a>


	<?php if ( is_user_logged_in() ) : ?>
		<div id="language">
			<a id="open_lang" href="#"><?php echo pll_current_language( 'name' ) ?></a>
			<select name="lang_switch" id="lang_switch">
				<?php
				$languages = pll_the_languages( array( 'raw' => 1 ) );

				foreach ( $languages as $lang ) : ?>

					<option <?php
					if ( $lang['current_lang'] ) {
						echo 'selected="selected"';
					}

					?> id="<?php echo $lang['slug'] ?>"
					   value="<?php echo $lang['url'] ?>"><?php echo $lang['name'] ?></option>

				<?php endforeach;

				?>
			</select>
		</div>
	<?php endif; ?>

	<div class="principal-nav">
		<?php

		wp_nav_menu( array(
			'theme_location' => 'principal'
		) );

		?>
	</div>

	<a href="/" id="burger"></a>

</header>
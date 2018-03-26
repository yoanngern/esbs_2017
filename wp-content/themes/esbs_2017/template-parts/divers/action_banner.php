<?php if ( have_rows( 'banner_buttons', 'option' ) ):

	$video = get_field( 'banner_video', 'option' );

	?>

    <section id="action_banner">

        <div class="buttons">
            <div class="box">

				<?php while ( have_rows( 'banner_buttons', 'option' ) ): the_row();

					$text = get_sub_field( 'text' );
					$link = get_sub_field( 'link' );
					$type = get_sub_field( 'type' );

					?>

					<?php if ( $link ): ?>

                        <article class="<?php echo $type ?>">
                            <a target="<?php echo $link['target']; ?>" href="<?php echo $link['url']; ?>"
                               class="icon">
                                <svg class="col_white" viewBox="0 0 100 100">
									<?php echo get_icons( $type ) ?>
                                </svg>
                            </a>
                            <a href="<?php echo $link['url']; ?>" class="button"><?php echo $text; ?></a>
                        </article>
					<?php endif; ?>

				<?php endwhile; ?>

            </div>

        </div>

        <div class="video">
            <video id="bgvid" autoplay loop>
                <source src="<?php echo $video; ?>"
                        type="video/mp4">
            </video>
        </div>

    </section>

<?php endif; ?>




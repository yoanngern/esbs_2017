<?php get_header(); ?>

<section id="content" class="blog">

	<?php

	$bg       = get_field_or_parent( 'thumb', get_the_ID() );
	$title    = get_the_title();
	$video    = get_iframe_video( get_field( 'video', get_the_ID() ) );
	$type     = get_field( 'type', get_the_ID() );
	$subtitle = get_field('subtitle', get_the_ID());
	$link     = "";


	switch ( $type ) {
		case "testimony":

			$id = get_the_ID();

			$color_index = 1;

			$nb_color = 6;

			for ( $i = $id; $i > 0; $i -- ) {
				$color_index ++;

				if ( $color_index == $nb_color ) {
					$color_index = 1;
				}
			}

			$header_title = $title;
			$class        = "story color-" . $color_index;

			$bg = get_field( 'thumb', $id );

			if ( $bg ) {
				$class .= " image";
			}

			break;
		case "video":

			$class = "video_banner";

			break;
		case "facebook":
		case "tweet":
		case "instagram":

			$class   = "facebook";
			$picture = $bg['sizes']['full_hd'];

			break;
		case "article":
		default;

			$header_title = $title;
			$class        = "post";

			break;
	}

	?>


    <section class="title">


		<?php if ( $bg || $type == "testimony" ): ?>

            <article class="title <?php echo $class ?>">

                <div class="dark"></div>

				<?php if ( $picture ): ?>
                    <div class="image">
                        <figure style="background-image: url('<?php echo $picture ?>')"></figure>
                    </div>
				<?php endif; ?>

				<?php if ( $video ): ?>
                    <div class="video_box">
                        <div class="video">
							<?php echo $video; ?>
                        </div>
                    </div>
				<?php endif; ?>

				<?php if ( $header_title ): ?>
                    <div class="text">
                        <h1><?php echo $header_title; ?></h1>

						<?php if ( $subtitle ):
							echo "<h2>" . $subtitle . "</h2>";
						endif; ?>
                    </div>
				<?php endif; ?>

                <div class="bg_color"></div>

				<?php if ( $bg ): ?>
                    <div class="bg_blur"
                         style="background-image: url('<?php echo $bg['sizes']['banner_blur']; ?>')"></div>

                    <div class="bg" style="background-image: url('<?php echo $bg['sizes']['banner']; ?>')"></div>
				<?php endif; ?>
            </article>

		<?php else: ?>

            <div class="spacer"></div>

		<?php endif; ?>

    </section>

    <div class="platter">


		<?php

		if ( have_posts() ) : the_post() ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header>

					<?php if ( $video || $type == "facebook" ): ?>
                        <h1><?php echo $title; ?></h1>
					<?php endif; ?>

                    <time><?php echo get_the_date(); ?></time>
					<?php if ( get_field( "author" ) ): ?><span
                            class="author"><?php echo get_field( "author" ) ?></span><?php endif; ?>
                </header>

                <div class="entry-content">

					<?php

					the_content();

					?>
                </div>


            </article>


		<?php else :

			get_template_part( 'template-parts/blog/none' );

		endif;
		?>

    </div>

	<?php get_template_part( 'template-parts/blog/related_posts' ); ?>

</section>

<?php get_template_part( 'template-parts/form/simple' ); ?>


<?php get_footer(); ?>




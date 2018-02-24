<?php get_header(); ?>

<section id="content" class="blog">

	<?php

	$bg       = get_field_or_parent( 'thumb', get_the_ID() );
	$title    = get_the_title();
	$video    = get_iframe_video( get_field( 'video', get_the_ID() ) );
	$type     = get_field( 'type', get_the_ID() );
	$subtitle = "";
	$link     = "";

	?>


    <section class="title">
		<?php if ( $video ): ?>

            <article class="title video_banner">

                <div class="video_box">
                    <div class="video">
						<?php echo $video; ?>
                    </div>
                </div>

                <div class="bg" style="background-image: url('<?php echo $bg['sizes']['banner_blur']; ?>')"></div>
            </article>


		<?php elseif ( $type == "facebook" ): ?>

            <article class="title facebook">

                <div class="image">
                    <figure style="background-image: url('<?php echo $bg['sizes']['full_hd']; ?>')"></figure>
                </div>

                <div class="bg" style="background-image: url('<?php echo $bg['sizes']['banner_blur']; ?>')"></div>
            </article>

		<?php elseif ( $bg ): ?>

            <article class="title post"
                     style="background-image: url('<?php echo $bg['sizes']['banner']; ?>')">

                <div class="dark"></div>

                <div class="text">
                    <h1><?php echo $title; ?></h1>

					<?php if ( $subtitle ):
						echo "<h2>" . $subtitle . "</h2>";
					endif; ?>
                </div>

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




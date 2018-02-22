<?php get_header(  ); ?>

<section id="content" class="blog">

	<?php

	$bg       = get_field_or_parent( 'thumb', get_the_ID() );
	$title    = get_the_title();
	$subtitle = "";
	$link     = "";

	?>

	<?php if ( $bg ): ?>

        <article class="title"
                 style="background-image: url('<?php echo $bg['sizes']['banner']; ?>')">

            <div class="dark"></div>

            <a class="logo" href="<?php echo pll_home_url(); ?>blog"></a>

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


    <div class="platter">


		<?php

		if ( have_posts() ) : the_post() ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header>
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




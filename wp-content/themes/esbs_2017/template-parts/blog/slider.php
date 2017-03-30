<?php


if ( is_category() ):

	if ( get_field( 'thumb', get_queried_object() ) ):
		$bg = get_field( 'thumb', get_queried_object() );
	else:
		$bg = get_field( 'background', get_option( 'page_for_posts' ) );
	endif;


	$title = get_the_archive_title();

	if ( get_field( 'subtitle', get_queried_object() ) ):
		$subtitle = get_field( 'subtitle', get_queried_object() );
	else:
		$subtitle = pll__('Discover this subject');
	endif;

	$link = "";


else:

	$bg       = get_field( 'background', get_option( 'page_for_posts' ) );
	$title    = pll__('ESBS Blog');
	$subtitle = get_field( 'title', get_option( 'page_for_posts' ) );
	$link     = "";

endif;


if ( $bg ): ?>
    <section class="title" id="slider">

        <article class="current" data-slide="1" style="background-image: url('<?php echo $bg['sizes']['banner']; ?>')">

            <div class="dark"></div>

            <a class="logo" href="<?php echo pll_home_url(); ?>blog"></a>

            <div class="text">
                <h1><?php echo $title; ?></h1>

				<?php if ( $subtitle ):
					echo "<h2>" . $subtitle . "</h2>";
				endif; ?>
            </div>

        </article>


		<?php

		if ( is_category() ):
			$cat_id = get_queried_object_id();
		else:
			$cat_id = 0;
		endif;

		$recent_posts = wp_get_recent_posts( array(
			'numberposts'      => 3,
			'offset'           => 0,
			'category'         => $cat_id,
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'post_type'        => 'post',
			'suppress_filters' => true
		) );

		foreach ( $recent_posts as $key => $recent ) :

			$curr_post = get_post( $recent["ID"] );

			?>

            <article data-slide="<?php echo $key + 2 ?>"
                     style="background-image: url('<?php echo get_field_or_parent( 'thumb', $recent["ID"] )['sizes']['banner']; ?>')">

                <div class="dark"></div>

                <a class="logo" href="<?php echo get_permalink( $recent["ID"] ) ?>"></a>

                <div class="text">
                    <h1><a href="<?php echo get_permalink( $recent["ID"] ) ?>"><?php echo $recent["post_title"] ?></a>
                    </h1>

                    <a href="<?php echo get_permalink( $recent["ID"] ) ?>" class="button"><?php echo pll_e('Read this'); ?></a>
                </div>


            </article>

		<?php endforeach; ?>

        <div class="bullets">

            <a href="#" class="current" data-slide="1"></a>

			<?php foreach ( $recent_posts as $key => $recent ) : ?>
                <a href="#" data-slide="<?php echo $key + 2 ?>"></a>

			<?php endforeach;

			wp_reset_query();

			?>

        </div>

    </section>

<?php else: ?>

    <div class="spacer"></div>

<?php endif; ?>
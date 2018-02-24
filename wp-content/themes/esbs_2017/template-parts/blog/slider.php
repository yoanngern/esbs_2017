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
		$subtitle = pll__( 'Discover this subject' );
	endif;

	$link = "";


else:

	$bg       = get_field( 'background', get_option( 'page_for_posts' ) );
	$title    = pll__( 'ESBS Blog' );
	$subtitle = get_field( 'title', get_option( 'page_for_posts' ) );
	$link     = "";

endif;


if ( $bg ): ?>
    <section class="title" id="slider">

        <article class="current" data-slide="1" style="background-image: url('<?php echo $bg['sizes']['banner']; ?>')">

            <div class="dark"></div>


            <div class="text">
                <h1><?php echo $title; ?></h1>

				<?php if ( $subtitle ):
					echo "<h2>" . $subtitle . "</h2>";
				endif; ?>
            </div>

        </article>


		<?php

		$query = new WP_Query( array(
			'posts_per_page' => 3,
			'orderby'        => 'post_date',
			'order'          => 'DESC',
			'post_type'      => 'post',
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'type',
					'compare' => '!=',
					'value'   => 'video'
				),
				array(
					'key'     => 'type',
					'compare' => '!=',
					'value'   => 'facebook'
				),
				array(
					'key'     => 'type',
					'compare' => '!=',
					'value'   => 'twitter'
				),
				array(
					'key'     => 'type',
					'compare' => '!=',
					'value'   => 'instagram'
				)
			),
		) );


		if ( is_category() ):

			$query->set( 'tax_query', array(
				array(
					'taxonomy' => 'category',
					'field'    => 'id',
					'terms'    => get_queried_object_id(),
				)
			) );

		endif;


		$recent_posts = $query->get_posts();

		foreach ( $recent_posts as $key => $recent ) :


			?>

            <article data-slide="<?php echo $key + 2 ?>"
                     style="background-image: url('<?php echo get_field_or_parent( 'thumb', $recent->ID )['sizes']['banner']; ?>')">

                <div class="dark"></div>

                <div class="text">
                    <h1><a href="<?php echo get_permalink( $recent->ID ) ?>"><?php echo $recent->post_title ?></a>
                    </h1>

                    <a href="<?php echo get_permalink( $recent->ID ) ?>"
                       class="button"><?php echo pll_e( 'Read this' ); ?></a>
                </div>


            </article>

		<?php endforeach; ?>

		<?php if ( $recent_posts ): ?>

            <div class="bullets">

                <a href="#" class="current" data-slide="1"></a>

				<?php foreach ( $recent_posts as $key => $recent ) : ?>
                    <a href="#" data-slide="<?php echo $key + 2 ?>"></a>

				<?php endforeach;

				wp_reset_query();

				?>

            </div>
		<?php endif; ?>
    </section>

<?php else: ?>

    <div class="spacer"></div>

<?php endif; ?>
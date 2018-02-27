<?php /* Template Name: News */

get_header( 'campaign' );

$exclude_posts = array();

?>


<section id="content" class="harvest-cycle news-feed">

	<?php

	$bg    = get_field( 'background' );
	$title = get_field( 'title' );

	?>

	<?php if ( $bg ): ?>

        <article class="title-bg"
                 style="background-image: url('<?php echo $bg['sizes']['banner']; ?>')">

            <div class="text">

                <div class="container">

                    <div class="title">
                        <h1><?php echo $title; ?></h1>
                    </div>
                </div>

            </div>

        </article>

	<?php else: ?>

        <div class="spacer"></div>

	<?php endif; ?>

    <article class="blog" id="zone1">

		<?php

		$items_1 = get_field( 'zone_1' );

		if ( $items_1 != null ) : ?>

            <div class="blog_wall black">

				<?php foreach ( $items_1 as $item ) :

					$exclude_posts[] = $item->ID;

					set_query_var( 'item', $item );
					get_template_part( 'template-parts/blog/item_wall' );

				endforeach; ?>

            </div>

		<?php endif; ?>

    </article>

    <article class="blog">

		<?php

		$cat = get_field( 'blog_category' );

		$query = new WP_Query( array(
			'posts_per_page'   => 10,
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'post_type'        => 'post',
			'suppress_filters' => true,
			'post__not_in'     => $exclude_posts,
			'meta_query'       => array(
				'relation' => 'AND',
				array(
					'key'     => 'latest_news',
					'compare' => '=',
					'value'   => true
				),
			),
		) );

		$items = $query->get_posts();

		if ( $items != null ) : ?>

            <div class="blog_wall">

				<?php foreach ( $items as $item ) :

					set_query_var( 'item', $item );
					get_template_part( 'template-parts/blog/item_wall' );

				endforeach; ?>

            </div>

		<?php endif; ?>

    </article>


</section>

<?php get_template_part( 'template-parts/form/simple' ); ?>


<?php get_footer(); ?>




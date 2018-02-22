<?php get_header(); ?>

<?php

$exclude_posts = array();

?>


<section id="content" class="harvest-cycle">

	<?php

	$bg       = get_field( 'background' );
	$title    = get_field( 'title' );
	$subtitle = "";
	$link     = "";

	?>

	<?php if ( $bg ): ?>

        <article class="title-bg"
                 style="background-image: url('<?php echo $bg['sizes']['banner']; ?>')">

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

    <article class="blog" id="zone1">

		<?php

		$items_1 = get_field( 'zone_1' );

		if ( $items_1 != null ) : ?>

            <div class="blog_wall">

				<?php foreach ( $items_1 as $item ) :

					$exclude_posts[] = $item->ID;

					set_query_var( 'item', $item );
					get_template_part( 'template-parts/blog/item_wall' );

				endforeach; ?>

            </div>

		<?php endif; ?>

    </article>

    <article class="presentation">
        <div class="content">

			<?php

			$pres = get_field( 'presentation_text' );

			?>

			<?php echo $pres; ?>

			<?php print_buttons( 'action_buttons', $_POST ) ?>

        </div>
    </article>

    <article class="form">
        <div class="content">

			<?php

			$form_id    = get_field( 'form' )->ID;
			$form_title = get_field( 'form_title' );

			?>

            <h2><?php echo $form_title; ?></h2>

            <div class="small_form">

				<?php echo do_shortcode( '[mc4wp_form id="' . $form_id . '"]' ); ?>

            </div>
        </div>

    </article>

    <article class="blog" id="zone2">

		<?php

		$items_2 = get_field( 'zone_2' );

		if ( $items_2 != null ) : ?>

            <div class="blog_wall black">

				<?php foreach ( $items_2 as $item ) :

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


		$items = wp_get_recent_posts( array(
			'numberposts'      => 8,
			'offset'           => 0,
			'category'         => $cat,
			'suppress_filters' => true,
			'exclude'          => $exclude_posts,

		), OBJECT );

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




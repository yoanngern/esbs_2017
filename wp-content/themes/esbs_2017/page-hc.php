<?php /* Template Name: Harvest Cycle */

get_header( 'campaign' ); ?>

    <section id="content" class="harvest-cycle">

        <article class="title">
            <div class="content">

				<?php

				$title = get_field( 'title' );
				$video = get_iframe_video( get_field( 'video', $_POST ) );
				$pres  = get_field( 'presentation' );

				?>

                <h1><?php echo $title; ?></h1>


				<?php if ( $video ): ?>
                    <div class="video_box">
                        <div class="video">
							<?php echo $video; ?>
                        </div>
                    </div>
				<?php endif; ?>


				<?php echo $pres; ?>
            </div>

        </article>

        <article class="schema" style="display: none">
            <div class="content">

                <h3>Pray & Declare</h3>
                <p>Christians will be led into a prayer, fasting and intercession lifestyle for the harvest. Starting in
                    March</p>
                <h3>Equip & Send</h3>
                <p>Christians will be equipped and motivated to develop an evangelistic lifestyle. Starting in May.</p>
                <h3>Disciple & Plant</h3>
                <p>Christians will be trained to disciple new believers and to plant new churches. Starting in
                    August</p>
                <h3>Celebrate & Worship</h3>
                <p>Christians will be led in a lifestyle of gratitude and praise. Starting in November.</p>
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

        <article class="blog">

			<?php

			$blog_title = get_field( 'blog_title' );

			?>

			<?php

			$cat = get_field( 'blog_category' );

			$child_cats = (array) get_term_children( $cat, 'category' );

			$post_in = get_objects_in_term( $cat, 'category' );

			$unwanted_children = get_term_children( $cat, 'category' );
			$unwanted_post_ids = get_objects_in_term( $unwanted_children, 'category' );


			$items = wp_get_recent_posts( array(
				'numberposts'      => 30,
				'offset'           => 0,
				'suppress_filters' => true,
				'post__in'         => $post_in,
				'post__not_in'     => $unwanted_post_ids,

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
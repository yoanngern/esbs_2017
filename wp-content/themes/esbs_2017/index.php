<?php get_header(); ?>

<section id="content" class="blog">

	<?php

	if ( is_single() ):

		$bg = get_field_or_parent( 'thumb', get_the_ID() );
		$title = get_the_title();
		$subtitle = "";
		$link = "";

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

	<?php else:

		get_template_part( 'template-parts/blog/slider' );

	endif; ?>


    <div class="platter">


		<?php

		if ( ! is_single() ): ?>

            <header>

				<?php if ( is_home() && ! is_front_page() ) : ?>


                    <div id="categories">
                        <div class="box">
                            <span><?php pll_e('Latest from');?></span>
                            <span data-url="<?php echo pll_home_url(); ?>" id="current_act"><?php pll_e('All categories');?></span>
							<?php

                            wp_dropdown_categories( array(
								'show_option_all' => pll__('All categories'),
								'value_field'     => 'slug',
							) ); ?>
                        </div>

                    </div>

				<?php else : ?>

                    <div id="categories">
                        <div class="box">
                            <span><?php pll_e('Latest from');?></span>
                            <span data-url="<?php echo pll_home_url(); ?>" id="current_act"><?php echo get_the_archive_title(); ?></span>
							<?php
                            wp_dropdown_categories( array(
								'show_option_all' => pll__('All categories'),
								'value_field'     => 'slug',
								'selected'        => get_queried_object()->slug
							) ); ?>
                        </div>
                    </div>

				<?php endif; ?>

                <div class="search">
                    <div class="outliner">
                        <div class="box">
                            <div class="icon"></div>
                            <input data-url="<?php echo pll_home_url(); ?>" type="text" id="search_input" placeholder="<?php pll_e('Search in the blog');?>"
                                   value="<?php echo get_search_query() ?>">
                        </div>
                    </div>
                </div>

            </header>


		<?php else: ?>


		<?php endif; ?>

		<?php

		if ( have_posts() ) :

			if ( ! is_single() ): echo '<div class=list>'; endif;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/blog/index' );

			endwhile;

			echo '</div>';

			?>

            <nav class="nav_bottom">
                <div class="nav-previous alignleft"><?php previous_posts_link( 'Previous' ); ?></div>
                <div class="nav-next alignright"><?php next_posts_link( 'Next' ); ?></div>
            </nav>

			<?php

		else :

			get_template_part( 'template-parts/blog/none' );

		endif;
		?>

    </div>

	<?php if ( is_single() ) {

		get_template_part( 'template-parts/blog/related_posts' );

	} ?>

</section>

<?php get_template_part( 'template-parts/form/simple' ); ?>


<?php get_footer(); ?>


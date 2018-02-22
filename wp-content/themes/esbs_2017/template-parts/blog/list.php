<?php get_header( 'campaign' ); ?>

<section id="content" class="blog">

	<?php get_template_part( 'template-parts/blog/slider' ); ?>


    <div class="platter">

        <header>

			<?php if ( is_home() && ! is_front_page() ) : ?>


                <div id="categories">
                    <div class="box">
                        <span><?php pll_e( 'Latest from' ); ?></span>
                        <span data-url="<?php echo pll_home_url(); ?>"
                              id="current_act"><?php pll_e( 'All categories' ); ?></span>
						<?php

						wp_dropdown_categories( array(
							'show_option_all' => pll__( 'All categories' ),
							'value_field'     => 'slug',
						) ); ?>
                    </div>

                </div>

			<?php else : ?>

                <div id="categories">
                    <div class="box">
                        <span><?php pll_e( 'Latest from' ); ?></span>
                        <span data-url="<?php echo pll_home_url(); ?>"
                              id="current_act"><?php echo get_the_archive_title(); ?></span>
						<?php
						wp_dropdown_categories( array(
							'show_option_all' => pll__( 'All categories' ),
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
                        <input data-url="<?php echo pll_home_url(); ?>" type="text" id="search_input"
                               placeholder="<?php pll_e( 'Search in the blog' ); ?>"
                               value="<?php echo get_search_query() ?>">
                    </div>
                </div>
            </div>

        </header>


		<?php

		if ( have_posts() ) :

			echo '<div class=list>';

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/blog/item' );

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

</section>

<?php get_template_part( 'template-parts/form/simple' ); ?>


<?php get_footer(); ?>


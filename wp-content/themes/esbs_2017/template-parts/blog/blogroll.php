<?php

$posts = wp_get_recent_posts( array(
	'numberposts'      => 3,
	'offset'           => 0,
	'category'         => get_field( 'blogroll' ),
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'post_type'        => 'post',
	'suppress_filters' => true
), OBJECT );

if ( $posts != null ) :

	?>

    <section class="related_posts">

        <div class="platter">
            <h1><?php echo pll_e( 'See more about this theme' ); ?></h1>


			<?php


			echo '<div class="list nb_' . sizeof( $posts ) . '">';


			foreach ( $posts as $curr_post ) :

				?>

                <article id="post-<?php echo $curr_post->ID; ?>" class="post">

                    <div class="box">
                        <figure>
                            <a href="<?php echo esc_url( get_the_permalink( $curr_post->ID ) ) ?>">

                                <img src="<?php echo get_field_or_parent( 'thumb', $curr_post->ID )['sizes']['blog'] ?>"
                                     alt="">

                                <div class="button"><?php echo pll_e( 'Read' ); ?></div>
                            </a>
                        </figure>

                        <h2>
                            <a href="<?php echo esc_url( get_the_permalink( $curr_post->ID ) ) ?>"><?php echo get_the_title( $curr_post->ID ); ?></a>
                        </h2>

                    </div>

                </article>

			<?php endforeach;


			echo '</div>';

			?>

        </div>

    </section>

	<?php
endif;
?>
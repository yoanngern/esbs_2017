<?php
$orig_post = $post;
global $post;

$posts = get_related_posts( $post, 3 );

if ( $posts ) :

	?>

    <section class="related_posts">

        <div class="platter">
            <h1><?php echo pll_e('You may also like'); ?></h1>

            <div class="list">

				<?php foreach ( $posts as $curr_post ) :

					$id = $curr_post->ID;

					$color_index = 1;

					$nb_color = 6;

					for ( $i = $id; $i > 0; $i -- ) {
						$color_index ++;

						if ( $color_index == $nb_color ) {
							$color_index = 1;
						}
					}

					$class = "color-" . $color_index;

                    ?>

                    <article id="post-<?php echo $id; ?>" class="post <?php echo $class ?>">

                        <div class="box">

                            <a class="image" href="<?php echo esc_url( get_the_permalink( $id ) ) ?>">

	                            <?php if ( get_field( 'thumb', $id ) ): ?>
                                    <figure style="background-image: url('<?php echo get_field_or_parent( 'thumb', $id )['sizes']['blog'] ?>')"></figure>
	                            <?php else: ?>
                                    <div class="bg_color"></div>
	                            <?php endif; ?>



                                <div class="button"><?php echo pll_e( 'Read' ); ?></div>
                            </a>

                            <h2>
                                <a href="<?php echo esc_url( get_the_permalink( $id ) ) ?>"><?php echo get_the_title( $id ); ?></a>
                            </h2>

                        </div>

                    </article>

				<?php endforeach; ?>

            </div>
        </div>
    </section>
<?php endif; ?>
<?php
$orig_post = $post;
global $post;

$posts = get_related_posts( $post, 3 );

if ( $posts ) :

	?>

    <section class="related_posts">

        <div class="platter">
            <h1><?php echo __('You may also like'); ?></h1>

            <div class="list">

				<?php foreach ( $posts as $curr_post ) :

					$id = $curr_post->ID;

					$type = get_field( 'type', $id );

					$color_index = 1;

					$nb_color = 6;

					for ( $i = $id; $i > 0; $i -- ) {
						$color_index ++;

						if ( $color_index == $nb_color ) {
							$color_index = 1;
						}
					}

					$link = esc_url( get_permalink($id) );
					$img  = get_field_or_parent( 'thumb', $id )['sizes']['blog'];


					$class = "color-" . $color_index;


					switch ( $type ) {
						case "testimony":

							if(get_field( 'subtitle', $id )) {
								$title = get_field( 'subtitle', $id );
							} else {
								$title = get_the_title($id);
							}

							break;
						case "video":
						case "facebook":
						case "tweet":
						case "instagram":
						case "article":
						default;

							$title    = get_the_title($id);

							break;
					}

					?>

                    <article id="post-<?php echo $id; ?>" class="post <?php echo $class ?>">

                        <div class="box">

                            <a class="image" href="<?php echo $link; ?>">

	                            <?php if ( get_field( 'thumb', $id ) ): ?>
                                    <figure style="background-image: url('<?php echo $img ?>')">

			                            <?php if ( $type == 'testimony' ): ?>
                                            <div class="dark"></div>
                                            <h2><?php echo get_the_title($id) ?></h2>
			                            <?php endif; ?>

                                    </figure>
	                            <?php else: ?>
                                    <div class="bg_color">
                                        <h2><?php echo get_the_title($id) ?></h2>
                                    </div>
	                            <?php endif; ?>

                                <div class="button"><?php echo __( 'Read' ); ?></div>
                            </a>

                            <h2 class="entry-title"><a href="<?php echo $link; ?>" rel="bookmark"><?php echo $title; ?></a></h2>

                        </div>

                    </article>

				<?php endforeach; ?>

            </div>
        </div>
    </section>
<?php endif; ?>
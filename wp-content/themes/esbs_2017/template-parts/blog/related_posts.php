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

				<?php foreach ( $posts as $curr_post ) : ?>

                    <article id="post-<?php echo $curr_post->ID; ?>" class="post">

                        <div class="box">
                            <figure>
                                <a href="<?php echo esc_url( get_the_permalink( $curr_post->ID ) ) ?>">

                                    <img src="<?php echo get_field_or_parent( 'thumb', $curr_post->ID )['sizes']['blog'] ?>"
                                         alt="">

                                    <div class="button"><?php echo pll_e('Read'); ?></div>
                                </a>
                            </figure>

                            <h2>
                                <a href="<?php echo esc_url( get_the_permalink( $curr_post->ID ) ) ?>"><?php echo get_the_title( $curr_post->ID ); ?></a>
                            </h2>

                        </div>

                    </article>

				<?php endforeach; ?>

            </div>
        </div>
    </section>
<?php endif; ?>
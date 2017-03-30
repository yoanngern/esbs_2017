

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="box">
        <figure>
            <a href="<?php echo esc_url( get_permalink() ) ?>">

                <img src="<?php echo get_field_or_parent('thumb', get_the_ID())['sizes']['blog'] ?>" alt="">
            </a>
        </figure>

        <span><?php the_category() ?></span>

		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<?php the_excerpt() ?>

        <div class="button"><a href="<?php echo esc_url( get_permalink() ) ?>" class="button"><?php echo pll_e('Read'); ?></a></div>

    </div>

</article>
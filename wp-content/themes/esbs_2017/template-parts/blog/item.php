<?php

$id = get_the_ID();

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

<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>

    <div class="box">

        <a class="image" href="<?php echo esc_url( get_permalink() ) ?>">
			<?php if ( get_field( 'thumb', get_the_ID() ) ): ?>
                <figure style="background-image: url('<?php echo get_field_or_parent( 'thumb', get_the_ID() )['sizes']['blog'] ?>')"></figure>
	        <?php else: ?>
            <div class="bg_color"></div>
            <?php endif; ?>
        </a>
        <span><?php the_category() ?></span>

		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<?php the_excerpt() ?>

        <div class="button"><a href="<?php echo esc_url( get_permalink() ) ?>"
                               class="button"><?php echo pll_e( 'Read' ); ?></a></div>

    </div>

</article>
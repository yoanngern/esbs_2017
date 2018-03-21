<?php

$id = get_the_ID();

$type = get_field( 'type', $id );

$color_index = 1;

$nb_color = 6;

for ( $i = $id; $i > 0; $i -- ) {
	$color_index ++;

	if ( $color_index == $nb_color ) {
		$color_index = 1;
	}
}

$link = esc_url( get_permalink() );
$img  = get_field_or_parent( 'thumb', get_the_ID() )['sizes']['blog'];


$class = "color-" . $color_index;


switch ( $type ) {
	case "testimony":

	    if(get_field( 'subtitle' )) {
		    $title = get_field( 'subtitle' );
        } else {
		    $title = get_the_title();
        }

		break;
	case "video":
	case "facebook":
	case "tweet":
	case "instagram":
	case "article":
	default;

		$title    = get_the_title();

		break;
}

?>

<article id="post-<?php echo $id; ?>" <?php post_class( $class ); ?>>

    <div class="box">

        <a class="image" href="<?php echo $link ?>">
			<?php if ( get_field( 'thumb', $id ) ): ?>
                <figure style="background-image: url('<?php echo $img ?>')">

					<?php if ( $type == 'testimony' ): ?>
                        <div class="dark"></div>
                        <h2><?php echo get_the_title() ?></h2>
					<?php endif; ?>

                </figure>
			<?php else: ?>
                <div class="bg_color">
                    <h2><?php echo get_the_title() ?></h2>
                </div>
			<?php endif; ?>
        </a>
        <span><?php the_category() ?></span>

        <h2 class="entry-title"><a href="<?php echo $link; ?>" rel="bookmark"><?php echo $title; ?></a></h2>

		<?php the_excerpt() ?>

        <div class="button"><a href="<?php echo esc_url( get_permalink() ) ?>"
                               class="button"><?php pll_e( 'Read' ); ?></a></div>

    </div>

</article>
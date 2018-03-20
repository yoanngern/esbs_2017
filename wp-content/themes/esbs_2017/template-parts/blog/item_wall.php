<?php


$id    = $item->ID;
$title = get_the_title( $item );

$link = esc_url( get_permalink( $item ) );

$date = get_the_date( '', $item );


$type = get_field( 'type', $item );

$text = $item->post_content;

$thumb = get_field( 'thumb', $id );


$url_encoded = urlencode( $link );

$link_facebook = "https://www.facebook.com/sharer/sharer.php?u=$url_encoded";

$link_twitter = "https://twitter.com/intent/tweet?url=$url_encoded&text=$title&original_referer=$url_encoded";

$link_email = "mailto:?subject=$title&body=$url_encoded";


$color_index = 1;

$nb_color = 6;

for ( $i = $id; $i > 0; $i -- ) {
	$color_index ++;

	if ( $color_index == $nb_color ) {
		$color_index = 1;
	}

}

switch ( $type ) {
	case "testimony":
		$img      = $thumb['sizes']['blog_story'];
		$subtitle = get_field('subtitle', $id);
		break;
	case "article":
		$img      = $thumb['sizes']['blog_wall'];
		$subtitle = wp_trim_words( $text, 20 );
		break;
}


?>

<article id="post-<?php echo $id; ?>" class="<?php echo $type; ?> color-<?php echo $color_index ?> <?php if ( $img ) {
	echo 'image';
} ?>">
    <div class="box">

        <div class="hide">

            <a class="item_link" href="<?php echo $link; ?>">

                <div class="item_content">

                    <div class="container">

                        <span class="date"><?php echo $date ?></span>

                        <div class="text">
                            <h2><?php echo $title; ?></h2>

                            <p><?php echo $subtitle; ?></p>
                        </div>

                    </div>
                </div>
            </a>

            <figure style="background-image: url('<?php echo $img; ?>')">

                <div class="play"></div>

            </figure>

            <div class="share">

                <div class="container">

                    <a id="facebook" target="_blank" href="<?php echo $link_facebook; ?>">
                        <svg class="icon" viewBox="0 0 30 30">
							<?php echo get_icons( 'facebook' ); ?>
                        </svg>
                    </a>

                    <a id="twitter" target="_blank" href="<?php echo $link_twitter; ?>">
                        <svg class="icon" viewBox="0 0 30 30">
							<?php echo get_icons( 'twitter' ); ?>
                        </svg>
                    </a>

                    <a id="email" target="_blank" href="<?php echo $link_email ?>">
                        <svg class="icon" viewBox="0 0 30 30">
							<?php echo get_icons( 'email' ); ?>
                        </svg>
                    </a>

                </div>
            </div>

        </div>
    </div>

</article>
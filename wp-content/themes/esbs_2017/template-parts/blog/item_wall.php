<?php


$id    = $item->ID;
$title = get_the_title( $item );

$link = esc_url( get_permalink( $item ) );

$date = get_the_date( '', $item );


$type = get_field( 'type', $item );

$text = $item->post_content;


$url_encoded = urlencode( $link );

$link_facebook = "https://www.facebook.com/sharer/sharer.php?u=$url_encoded";

$link_twitter = "https://twitter.com/intent/tweet?url=$url_encoded&text=$title&original_referer=$url_encoded";

$link_email = "mailto:?subject=$title&body=$url_encoded";


?>

<article id="post-<?php echo $id; ?>" class="<?php echo $type; ?>">
    <div class="box">

        <div class="hide">

            <a class="item_link" href="<?php echo $link; ?>">

                <div class="item_content">

                    <div class="container">

                        <span class="date"><?php echo $date ?></span>

                        <h2><?php echo $title; ?></h2>

                        <p><?php echo wp_trim_words( $text, 20 ); ?></p>

                    </div>
                </div>
            </a>

            <figure style="background-image: url('<?php echo get_field( 'thumb', $id )['sizes']['banner'] ?>')">

                <div class="play"></div>
            </figure>

            <div class="share">

                <div class="container">

                    <a id="facebook" target="_blank" href="<?php echo $link_facebook; ?>">
						<?php echo get_icons( 'facebook' ); ?>
                    </a>

                    <a id="twitter" target="_blank" href="<?php echo $link_twitter; ?>">
						<?php echo get_icons( 'twitter' ); ?>
                    </a>

                    <a id="email" target="_blank" href="<?php echo $link_email ?>">
						<?php echo get_icons( 'email' ); ?>
                    </a>


                </div>
            </div>

        </div>
    </div>

</article>
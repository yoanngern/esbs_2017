<?php

$title    = get_field( 'landing_title', $_POST );
$subtitle = get_field( 'landing_subtitle', $_POST );
$button   = get_field( 'landing_button', $_POST );
$form_id  = get_field( 'landing_form', $_POST );
$image    = get_field( 'landing_bg' )['sizes']['fullscreen'];
$video    = get_field( 'landing_video', $_POST );
$video_bg = get_field( 'landing_video_bg', $_POST );
$video_end = get_field( 'landing_video_end', $_POST );


if ( preg_match( "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $video, $regs ) ) {
	$video_id = $regs[0];
}

?>


<section id="custom-page" class="landing_page">

	<?php if ( $video ): ?>

        <div id="video_id" class="video_full" data-video="<?php echo $video_id; ?>" data-end="<?php echo $video_end ?>">

            <a href="#" class="close"></a>

            <script type="text/javascript"
                    src="<?php echo get_stylesheet_directory_uri(); ?>/js/youtube_player.min.js"></script>

            <div id="player"></div>
        </div>

	<?php endif; ?>



    <article class="center">

        <div id="logo"></div>

        <h1><?php echo $title; ?></h1>
        <h2><?php echo $subtitle; ?></h2>

		<?php if ( $video ): ?>
            <a href="#" class="play"></a>

		<?php endif; ?>

        <div class="small_form">
			<?php echo do_shortcode( '[mc4wp_form id="' . $form_id . '"]' ); ?>
        </div>

    </article>

    <a href="<?php echo home_url(); ?>" class="home"><?php echo $button; ?></a>

	<?php if ( $video_bg ): ?>

        <div class="bg_black"></div>

        <div class="video">
            <video id="bgvid" autoplay loop muted plays-inline>
                <source src="<?php echo $video_bg; ?>"
                        type="video/mp4">
            </video>
        </div>
	<?php endif; ?>

    <div class="bg" style="background-image: url('<?php echo $image; ?>')"></div>

</section>
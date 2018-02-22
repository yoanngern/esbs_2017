<?php

$title    = get_field( 'join_title', $_POST );
$subtitle = get_field( 'join_subtitle', $_POST );
$button   = get_field( 'join_button', $_POST );
$form_id  = get_field( 'join_form', $_POST );

?>


<section id="custom-page" class="join">


    <div class="video_full">

        <a href="#" class="close"></a>

        <script type="text/javascript"
                src="<?php echo get_stylesheet_directory_uri(); ?>/js/youtube_player.min.js"></script>

        <div id="player"></div>
    </div>


    <div class="bg_black"></div>

    <article class="center">

        <div id="logo"></div>

        <h1><?php echo $title; ?></h1>
        <h2><?php echo $subtitle; ?></h2>

        <a href="#" class="play"></a>

        <div class="small_form">
			<?php echo do_shortcode( '[mc4wp_form id="' . $form_id . '"]' ); ?>
        </div>

		<?php //echo do_shortcode('[mc4wp_form id="1255"]'); ?>

    </article>

    <a href="<?php echo pll_home_url(); ?>" class="home"><?php echo $button; ?></a>

    <div class="video">
        <video id="bgvid" autoplay loop muted plays-inline>
            <source src="https://player.vimeo.com/external/231915594.sd.mp4?s=7cba34b8cf0ac668416224e2bed073cff61931d0&profile_id=165"
                    type="video/mp4">
        </video>
    </div>

</section>
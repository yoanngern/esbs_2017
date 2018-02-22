<?php

$title    = get_field( 'landing_title', $_POST );
$subtitle = get_field( 'landing_subtitle', $_POST );
$button   = get_field( 'landing_button', $_POST );
$form_id  = get_field( 'landing_form', $_POST );
$image    = get_field( 'landing_bg' )['sizes']['fullscreen'];

?>


<section id="custom-page" class="landing_page">

    <div class="bg" style="background-image: url('<?php echo $image; ?>')"></div>

    <article class="center">

        <div id="logo"></div>

        <h1><?php echo $title; ?></h1>
        <h2><?php echo $subtitle; ?></h2>

        <div class="small_form">
			<?php echo do_shortcode( '[mc4wp_form id="' . $form_id . '"]' ); ?>
        </div>

    </article>

    <a href="<?php echo pll_home_url(); ?>" class="home"><?php echo $button; ?></a>

</section>
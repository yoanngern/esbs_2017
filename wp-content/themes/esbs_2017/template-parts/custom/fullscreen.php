<?php

$title = get_field( 'fullscreen_title' );
$text  = get_field( 'fullscreen_text' );
$image = get_field( 'fullscreen_bg' )['sizes']['fullscreen'];

?>


<section id="custom-page" class="fullscreen">

    <div class="bg" style="background-image: url('<?php echo $image; ?>')"></div>

    <article class="center">

        <h1><?php echo $title; ?></h1>
		<?php echo $text; ?>


    </article>

</section>
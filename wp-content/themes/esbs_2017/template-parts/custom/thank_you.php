<?php

$image = get_field( 'thank_you_bg' )['sizes']['fullscreen'];

$messages = get_field( 'messages' );

$list_id = get_field( 'thank_you_list_id' );

$email = $_GET['email'];

if ( $list_id != null && $email != null ) {
	$contact = mc4wp_get_api_v3()->get_list_member( $list_id, $email );

	$status = $contact->status;
} else {

	$status = 'pending';
}


?>


<section id="custom-page" class="fullscreen">

    <div class="bg" style="background-image: url('<?php echo $image; ?>')"></div>

    <article class="center">

		<?php if ( have_rows( 'messages' ) ): ?>


			<?php while ( have_rows( 'messages' ) ): the_row(); ?>


				<?php if ( get_sub_field( 'status' ) == $status ): ?>

                    <h1><?php echo get_sub_field( 'thank_you_title' ); ?></h1>
					<?php echo get_sub_field( 'thank_you_text' ) ?>
				<?php endif; ?>


			<?php endwhile; ?>


		<?php endif; ?>

    </article>

</section>


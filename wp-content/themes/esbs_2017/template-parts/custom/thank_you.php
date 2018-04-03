<?php

$image = get_field( 'thank_you_bg' )['sizes']['fullscreen'];

$messages = get_field( 'messages' );

$list_id = get_field( 'thank_you_list_id' );

$email = $_GET['email'];

if ( $list_id != null && $email != null ) {

	try {
		$contact = mc4wp_get_api_v3()->get_list_member( $list_id, $email );
	} catch ( Exception $e ) {
		$contact = null;
	}
}


if ( $contact ) {
	$interests = $contact->interests;
	$status    = $contact->status;
} else {
	$interests = array();
	$status    = 'pending';
}


?>


<section id="custom-page" class="fullscreen">

    <div class="bg" style="background-image: url('<?php echo $image; ?>')"></div>

    <article class="center">

		<?php if ( have_rows( 'messages' ) ): ?>


			<?php while ( have_rows( 'messages' ) ): the_row(); ?>


				<?php if ( get_sub_field( 'status' ) == $status ):

					$show = true;

					if ( get_sub_field( 'subscribe' ) ):
						foreach ( get_sub_field( 'subscribe' ) as $interest ):

							if ( ! $interests->$interest ) {
								$show = false;
							}

						endforeach;
					endif;

					if ( $show ) {
						echo '<h1>' . get_sub_field( 'thank_you_title' ) . '</h1>';

						echo get_sub_field( 'thank_you_text' );

						break;
					}

				endif; ?>


			<?php endwhile; ?>


		<?php endif; ?>

    </article>

</section>


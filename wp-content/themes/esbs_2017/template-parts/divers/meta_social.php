<?php

$post_type = "";


if ( get_queried_object() instanceof WP_Post_Type ) {

	$post_type = get_queried_object()->name;

} else {

	$post_type = get_post_type( $_POST );

}


if ( get_field( 'fb_title' ) ) {

	$meta_fb_title = get_field( 'fb_title' );

} else {

	$meta_fb_title = get_the_title();

}

if ( get_field( 'fb_desc' ) ) {

	$meta_fb_desc = get_field( 'fb_desc' );

} else {

	if ( $post_type == 'post' ) {

		$id = get_the_ID();

		$post = get_post($id);


		$meta_fb_desc = wp_trim_words( $post->post_content, 100 );


	} else {

		$meta_fb_desc = "Together for 100 millions souls. One movement of people from all backgrounds to see the Gospel of Jesus-Christ change Europe.";

	}

}

if ( get_field( 'fb_image' ) ) {

	$meta_fb_image = get_field( 'fb_image' )['sizes']['full_hd'];

} else {

	if ( get_field( 'thumb' ) ) {

		$meta_fb_image = get_field( 'thumb' )['sizes']['full_hd'];

	} else {
		if ( get_field( 'background' ) ) {
			$meta_fb_image = get_field( 'background' )['sizes']['full_hd'];
		} else {
			$meta_fb_image = "http://esbs.org/wp-content/themes/esbs_2017/images/facebook_default_home.png";
		}
	}


}

?>


<meta property="og:title" content="<?php echo $meta_fb_title; ?>"/>
<meta property="og:description"
      content="<?php echo $meta_fb_desc; ?>"/>
<meta property="og:image"
      content="<?php echo $meta_fb_image; ?>"/>

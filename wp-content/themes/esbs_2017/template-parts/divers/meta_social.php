<?php

if ( get_field( 'fb_title' ) ) {

	$meta_fb_title = get_field( 'fb_title' );

} else {

	$meta_fb_title = "Europe Shall Be Saved";

}

if ( get_field( 'fb_desc' ) ) {

	$meta_fb_desc = get_field( 'fb_desc' );

} else {

	$meta_fb_desc = "Together for 100 millions souls. One movement of people from all backgrounds to see the Gospel of Jesus-Christ change Europe.";

}

if ( get_field( 'fb_image' ) ) {

	$meta_fb_image = get_field( 'fb_image' )['sizes']['full_hd'];

} else {

	if ( get_field( 'background' ) ) {
		$meta_fb_image = get_field( 'background' )['sizes']['full_hd'];
	} else {
		$meta_fb_image = "http://esbs.org/wp-content/themes/esbs_2017/images/facebook_default_home.png";
	}

}

?>


<meta property="og:title" content="<?php echo $meta_fb_title; ?>"/>
<meta property="og:description"
      content="<?php echo $meta_fb_desc; ?>"/>
<meta property="og:image"
      content="<?php echo $meta_fb_image; ?>"/>

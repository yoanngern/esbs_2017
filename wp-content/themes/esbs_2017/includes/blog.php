<?php

/**
 * Update Post
 *
 * @param $post_id
 */
function update_post( $post_id ) {

	$post_type = get_post_type( $post_id );

	if ( $post_type != "post" ) {
		return;
	}


	$content_post = get_post( $post_id );
	$content      = $content_post->post_content;
	$title        = $content_post->post_title;

	$type = 'article';

	if ( !$title ) {
		$title = "Draft";
	} else {
		$title = get_the_title();
	}


	$my_post = array(
		'ID'         => $post_id,
		'post_title' => $title,
	);


	// unhook this function so it doesn't loop infinitely
	remove_action( 'save_post', 'update_post' );


	if ( get_field( 'source_url', $post_id ) ) {

		$url = get_field( 'source_url', $post_id );


		if ( get_url_info( $url ) == 'vimeo' ) {

			$infos = get_vimeo_info( $url );

			$type = 'video';
		}


		if ( get_url_info( $url ) == 'youtube' ) {

			$infos = get_youtube_info( $url );

			$type = 'video';

		}

		if ( get_url_info( $url ) == 'facebook' ) {

			//$infos = get_facebook_info( $url );

			$type = 'facebook';

		}

		// Update fields

		if ( $infos['title'] && ! get_the_title( $post_id ) ) {

			$my_post['post_title'] = $infos['title'];

		}

		if ( $infos['desc'] && ! $content ) {

			$my_post['post_content'] = $infos['desc'];
		}

		if ( $infos['image'] && ! get_field( 'thumb', $post_id ) ) {

			$upload_file = crb_insert_attachment_from_url( $infos['image'], $post_id );

			update_field( 'thumb', $upload_file, $post_id );
		}

		if ( $type == 'video' && ! get_field( 'video', $post_id ) ) {

			update_field( 'video', $url, $post_id );
		}


		update_field( 'type', $type, $post_id );

	}


	// update the post, which calls save_post again
	wp_update_post( $my_post );

	// re-hook this function
	add_action( 'save_post', 'update_post' );

}

add_action( 'save_post', 'update_post' );


/**
 * @param $url
 *
 * @return string
 */
function get_url_info( $url ) {

	// YouTube
	if ( strpos( $url, 'youtube' ) > 0 || strpos( $url, 'youtu.be' ) > 0 ) {

		return 'youtube';

		// Vimeo
	} elseif ( strpos( $url, 'vimeo' ) > 0 ) {

		return 'vimeo';


	} elseif ( strpos( $url, 'facebook' ) > 0 ) {

		return 'facebook';


	} else {

		return 'unknown';

	}
}


/**
 * @param $url
 *
 * @return array
 */
function get_youtube_info( $url ) {

	$infos = array();


	$key = get_api( 'youtube' )['key'];


	if ( preg_match( "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $regs ) ) {
		$id = $regs[0];
	}

	$url = "https://www.googleapis.com/youtube/v3/videos?id=$id&key=$key&part=snippet";

	$api = wp_remote_get( $url );

	$result = json_decode( $api['body'] );

	$infos['id']    = $id;
	$infos['title'] = $result->items[0]->snippet->title;
	$infos['desc']  = $result->items[0]->snippet->description;
	$infos['image'] = "https://img.youtube.com/vi/$id/maxresdefault.jpg";

	return $infos;

}


/**
 * @param $url
 *
 * @return array
 */
function get_vimeo_info( $url ) {

	$infos = array();


	if ( preg_match( '%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs ) ) {
		$id = $regs[3];
	}


	$url       = "http://vimeo.com/api/v2/video/$id.php";
	$vimeo     = wp_remote_get( $url );
	$image     = unserialize( $vimeo['body'] )[0]['thumbnail_large'];
	$image_url = str_replace( "640.jpg", "1080.jpg", $image );


	$infos['id']    = $id;
	$infos['title'] = unserialize( $vimeo['body'] )[0]['title'];
	$infos['desc']  = unserialize( $vimeo['body'] )[0]['description'];
	$infos['image'] = $image_url;

	return $infos;

}


/**
 * @param $url
 *
 * @return array
 * @throws \Facebook\Exceptions\FacebookSDKException
 */
function get_facebook_info( $url ) {

	$infos = array();


	$id = '';


	$fb = new Facebook\Facebook( [
		'app_id'                => get_field( 'facebook_app_id', 'option' ),
		'app_secret'            => get_field( 'facebook_app_secret', 'option' ),
		'default_graph_version' => get_field( 'facebook_api_version', 'option' ),
	] );

	$helper = $fb->getCanvasHelper();

	try {
		$accessToken = $helper->getAccessToken();
	} catch ( Facebook\Exceptions\FacebookResponseException $e ) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch ( Facebook\Exceptions\FacebookSDKException $e ) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	if ( ! isset( $accessToken ) ) {
		echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
		exit;
	}

// Logged in
	echo '<h3>Signed Request</h3>';
	var_dump( $helper->getSignedRequest() );

	echo '<h3>Access Token</h3>';
	var_dump( $accessToken->getValue() );


	die();

	$infos['id']    = "";
	$infos['title'] = "";
	$infos['desc']  = "";
	$infos['image'] = "";

	return $infos;

}


/**
 * @param $url
 * @param null $post_id
 *
 * @return bool
 */
function crb_insert_attachment_from_url( $url, $post_id = null ) {

	if ( ! class_exists( 'WP_Http' ) ) {
		include_once( ABSPATH . WPINC . '/class-http.php' );
	}

	$http     = new WP_Http();
	$response = $http->request( $url );
	if ( $response['response']['code'] != 200 ) {
		return false;
	}

	$upload = wp_upload_bits( basename( $url ), null, $response['body'] );
	if ( ! empty( $upload['error'] ) ) {
		return false;
	}

	$file_path        = $upload['file'];
	$file_name        = basename( $file_path );
	$file_type        = wp_check_filetype( $file_name, null );
	$attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
	$wp_upload_dir    = wp_upload_dir();

	$post_info = array(
		'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
		'post_mime_type' => $file_type['type'],
		'post_title'     => $attachment_title,
		'post_content'   => '',
		'post_status'    => 'inherit',
	);

	// Create the attachment
	$attach_id = wp_insert_attachment( $post_info, $file_path, $post_id );

	// Include image.php
	require_once( ABSPATH . 'wp-admin/includes/image.php' );

	// Define attachment metadata
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

	// Assign metadata to attachment
	wp_update_attachment_metadata( $attach_id, $attach_data );

	return $attach_id;

}


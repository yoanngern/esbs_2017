<?php /* Template Name: Custom */

get_header();

global $post;
$post_slug = $post->post_name;

if ( $post_slug == 'join-2' || $post_slug == 'join' || $post_slug == 'join-a' || $post_slug == 'join-b' || $post_slug == 'join-c' ) {
	get_template_part( 'template-parts/custom/join' );
}

if ( $post_slug == 'share' ) {
	get_template_part( 'template-parts/custom/share' );
}

get_footer( 'empty' );

?>


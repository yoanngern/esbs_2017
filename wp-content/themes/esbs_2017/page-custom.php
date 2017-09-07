<?php /* Template Name: Custom */

get_header();

global $post;
$post_slug = $post->post_name;

if ( $post_slug == 'join-2' || $post_slug == 'join' ) {
	get_template_part( 'template-parts/custom/join' );
}

if ( $post_slug == 'share' ) {
	get_template_part( 'template-parts/custom/share' );
}

get_footer( 'empty' );

?>


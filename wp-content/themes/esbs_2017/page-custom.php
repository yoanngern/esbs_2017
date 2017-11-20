<?php /* Template Name: Custom */

get_header();

global $post;

$custom_tmp = get_field('custom_tmp', $_POST);

if ( $custom_tmp != null ) {
	get_template_part( 'template-parts/custom/' . $custom_tmp );
}

get_footer( 'empty' );

?>


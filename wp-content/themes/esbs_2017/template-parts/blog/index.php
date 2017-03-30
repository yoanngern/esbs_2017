<?php


if ( is_single() ) {

	get_template_part( 'template-parts/blog/single');

} else {
	get_template_part( 'template-parts/blog/list');
}
?>

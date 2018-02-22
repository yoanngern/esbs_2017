<?php


if ( is_single() ) {

	get_template_part( 'template-parts/harvest-cycle/single');

} else {
	return false;
}
?>

<?php

/**
 *
 */
function themeslug_enqueue_style() {
	wp_enqueue_style( 'core', get_template_directory_uri() . '/style_v7.css', false );
}

function themeslug_enqueue_script() {
	wp_enqueue_script( 'my-js', get_template_directory_uri() . '/js/main_v4.min.js', false );

	wp_enqueue_script( 'elementor-slider', get_template_directory_uri() . '/js/elementor_slider.min.js', false );
}


add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_script' );


require_once( __DIR__ . '/includes/esbs_harvest-cycle.php' );
require_once( __DIR__ . '/includes/blog.php' );

require_once( __DIR__ . '/options.php' );

flush_rewrite_rules();


function register_my_menu() {
	register_nav_menu( 'principal', __( 'Menu principal', 'esbs_2017' ) );
	register_nav_menu( 'admin', __( 'Menu admin', 'esbs_2017' ) );
}

add_action( 'init', 'register_my_menu' );


add_theme_support( 'post-thumbnails' );

add_image_size( 'banner', 1440, 670, true );
add_image_size( 'full_hd', 1920, 1080, true );
add_image_size( 'hd', 1280, 720, true );
add_image_size( 'blog', 328, 244, true );
add_image_size( 'fullscreen', 1440, 806, true );

add_image_size( 'social', 500, 500, true );


require_once( __DIR__ . '/includes/acf_fields.php' );


add_action( 'elementor/widgets/widgets_registered', function () {

	require( 'widgets/complex-carousel.php' );
	\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ComplexCarouselWidget() );

	require( 'widgets/count_mailchimp.php' );
	\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new CountMailchimplWidget() );

} );


/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 *
 * @return int (Maybe) modified excerpt length.
 */
function wpdocs_custom_excerpt_length( $length ) {
	return 18;
}

add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

function my_theme_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	}

	return $title;
}

add_filter( 'get_the_archive_title', 'my_theme_archive_title' );


function get_attachment_url_by_slug( $slug ) {

	$args    = array(
		'post_type'      => 'attachment',
		'name'           => sanitize_title( $slug ),
		'posts_per_page' => 1,
		'post_status'    => 'inherit',
	);
	$_header = get_posts( $args );

	$header = $_header ? array_pop( $_header ) : null;

	return $header ? wp_get_attachment_url( $header->ID ) : '';
}


function is_child( $pageSlug ) {

	$id = get_the_ID();

	do {

		$parent_id = wp_get_post_parent_id( $id );

		$parent_slug = get_page_uri( $parent_id );

		if ( $parent_slug == $pageSlug ) {

			return true;
		} else {
			$id = $parent_id;
		}

	} while ( $parent_id != 0 && true );

	return false;
}


// add hook
add_filter( 'wp_nav_menu_objects', 'my_wp_nav_menu_objects_sub_menu', 10, 2 );
// filter_hook function to react on sub_menu flag
function my_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {
	if ( isset( $args->sub_menu ) ) {
		$root_id = 0;

		// find the current menu item
		foreach ( $sorted_menu_items as $menu_item ) {
			if ( $menu_item->current ) {
				// set the root id based on whether the current menu item has a parent or not
				$root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
				break;
			}
		}

		// find the top level parent
		if ( ! isset( $args->direct_parent ) ) {
			$prev_root_id = $root_id;
			while ( $prev_root_id != 0 ) {
				foreach ( $sorted_menu_items as $menu_item ) {
					if ( $menu_item->ID == $prev_root_id ) {
						$prev_root_id = $menu_item->menu_item_parent;
						// don't set the root_id to 0 if we've reached the top of the menu
						if ( $prev_root_id != 0 ) {
							$root_id = $menu_item->menu_item_parent;
						}
						break;
					}
				}
			}
		}
		$menu_item_parents = array();
		foreach ( $sorted_menu_items as $key => $item ) {
			// init menu_item_parents
			if ( $item->ID == $root_id ) {
				$menu_item_parents[] = $item->ID;
			}
			if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
				// part of sub-tree: keep!
				$menu_item_parents[] = $item->ID;
			} else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
				// not part of sub-tree: away with it!
				unset( $sorted_menu_items[ $key ] );
			}
		}

		return $sorted_menu_items;
	} else {
		return $sorted_menu_items;
	}
}

function get_field_or_parent( $field, $post_id, $taxonomy = 'category' ) {

	if ( $post_id === null ) {
		global $post;
	} else {
		$post = get_post( $post_id );
	}

	$field_return = get_field( $field, $post->ID );

	if ( ! $field_return ) :


		$categories = get_the_terms( $post->ID, $taxonomy );

		foreach ( $categories as $category ) :

			$field_return = get_field( $field, $category );

			if ( $field_return ) {
				break;
			}

			while ( ! $field_return && $category->parent != null ) {

				$current_cat      = get_term( $category->parent, $taxonomy );
				$new_field_return = get_field( $field, $current_cat );

				if ( $new_field_return ) {
					$field_return = $new_field_return;
				}

				if ( $field_return ) {
					break;
				}

				$category = $current_cat;

			}

		endforeach;

		return $field_return;

	else:

		return $field_return;

	endif;
}

function get_related_posts( $post, $nb = 3 ) {
	$orig_post = $post;
	global $post;

	$posts = Array();

	$tags = wp_get_post_tags( $post->ID );


	if ( $tags ) {
		$tag_ids = array();
		foreach ( $tags as $individual_tag ) {
			$tag_ids[] = $individual_tag->term_id;
		}
		$args = array(
			'tag__in'          => $tag_ids,
			'post__not_in'     => array( $post->ID ),
			'posts_per_page'   => $nb, // Number of related posts to display.
			'caller_get_posts' => 1
		);

		$my_query = new wp_query( $args );


		foreach ( $my_query->get_posts() as $curr_post ) {


			array_push( $posts, $curr_post );
		}

	}


	$categories = get_categories( $post->ID );


	if ( ( sizeof( $posts ) < $nb ) && sizeof( $categories ) ) {


		$nb_needed = $nb - sizeof( $posts );


		foreach ( $categories as $category ) {


			$exclude = Array();

			array_push( $exclude, $post->ID );

			foreach ( $posts as $curr ) {
				array_push( $exclude, $curr->ID );
			}

			$recent_posts = wp_get_recent_posts( array(
				'numberposts'      => $nb_needed,
				'offset'           => 0,
				'category'         => $category->term_id,
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'post_type'        => 'post',
				'suppress_filters' => true,
				'exclude'          => $exclude
			) );

			foreach ( $recent_posts as $curr_post ) {


				$post_obj = get_post( $curr_post['ID'] );


				if ( sizeof( $posts ) < $nb ) {
					array_push( $posts, $post_obj );
				}
			}
		}

	}


	wp_reset_query();

	array_slice( $posts, 0, $nb );

	return $posts;
}

function get_iframe_video( $iframe ) {

	if ( $iframe == null ) {
		return false;
	}

	// use preg_match to find iframe src
	preg_match( '/src="(.+?)"/', $iframe, $matches );
	$src = $matches[1];

	$params = array(
		'controls'       => 1,
		'hd'             => 1,
		'autohide'       => 1,
		'rel'            => 0,
		'showinfo'       => 0,
		'color'          => 'e52639',
		'title'          => 0,
		'byline'         => 0,
		'portrait'       => 0,
		'data-show-text' => 0
	);


	$new_src = add_query_arg( $params, $src );

	$video = str_replace( $src, $new_src, $iframe );

	$attributes = 'frameborder="0"';

	$iframe = str_replace( '></iframe>', ' ' . $attributes . 'class="video"></iframe>', $video );

	return $iframe;


}

/**
 * @param $acf_selector
 * @param $post
 */
function print_buttons( $acf_selector, $post, $style = 'button' ) {
	if ( have_rows( $acf_selector . '_buttons', $post ) ): ?>
        <div class="buttons">

			<?php while ( have_rows( $acf_selector . '_buttons', $post ) ):
				the_row();


				$link    = get_sub_field( 'link' );
				$display = get_sub_field( 'display' );

				$url    = $link['url'];
				$label  = $link['title'];
				$target = $link['target'];

				?>


				<?php if ( $display ): ?>
                <a class="<?php echo $style ?>" target="<?php echo $target ?>"
                   href="<?php echo $url; ?>"><?php echo $label; ?></a>
			<?php endif; ?>

			<?php endwhile; ?>

        </div>

	<?php endif;
}


/**
 * @param string $name
 *
 * @return mixed
 */
function get_icons( $name = 'facebook' ) {
	$icons = array(
		'facebook'  => '<svg class="icon">
		<rect fill-opacity="0"x="0" y="0" width="30" height="30"></rect>
		<path d="M23.4513814,5.5 L6.54861855,5.5 C5.96942232,5.5 5.5,5.96942056 5.5,6.54861462 L5.5,23.4513142 C5.5,24.0304371 5.96942232,24.5 6.54861855,24.5 L15.6485346,24.5 L15.6485346,17.1421851 L13.172428,17.1421851 L13.172428,14.2746904 L15.6485346,14.2746904 L15.6485346,12.1600199 C15.6485346,9.70599112 17.1473544,8.36970157 19.3365681,8.36970157 C20.3852578,8.36970157 21.2865145,8.44772476 21.5491319,8.48260739 L21.5491319,11.0472639 L20.0308062,11.0479758 C18.8402362,11.0479758 18.609654,11.6137151 18.609654,12.4439218 L18.609654,14.2746904 L21.4491821,14.2746904 L21.079496,17.1421851 L18.609654,17.1421851 L18.609654,24.5 L23.4513814,24.5 C24.0305065,24.5 24.5,24.0304371 24.5,23.4513142 L24.5,6.54861462 C24.5,5.96942056 24.0305065,5.5 23.4513814,5.5"></path>
	</svg>',
		'twitter'   => '<svg class="icon">
        <rect fill-opacity="0" x="0" y="0" width="30" height="30"></rect>
        <path d="M22.6439341,9.23672492 C23.4923053,8.7157914 24.1391298,7.89031214 24.450043,6.90614852 C23.6579174,7.3886131 22.7782986,7.73964214 21.8393094,7.92717821 C21.0940552,7.11291906 20.0253886,6.5999999 18.8473557,6.5999999 C16.58347,6.5999999 14.7461136,8.48497778 14.7461136,10.8075398 C14.7461136,11.1393344 14.7836107,11.458306 14.8507929,11.7660575 C11.4385595,11.5897415 8.41848293,9.91794566 6.39207874,7.36937863 C6.03741895,7.98969023 5.8358722,8.7157914 5.8358722,9.486773 C5.8358722,10.9453868 6.56237794,12.2356991 7.66072963,12.9858433 C6.98890712,12.9682117 6.36083119,12.7742642 5.80618702,12.4601012 L5.80618702,12.5113931 C5.80618702,14.5518496 7.22170143,16.2541001 9.09499258,16.643598 C8.75283181,16.7365646 8.38723537,16.7862537 8.01538942,16.7862537 C7.75290993,16.7862537 7.49667995,16.7622106 7.24044996,16.7125215 C7.76540895,18.3843174 9.2777908,19.5976918 11.072963,19.6361607 C9.66838528,20.76298 7.89821108,21.4329806 5.97648621,21.4329806 C5.64682447,21.4329806 5.32341223,21.4137461 5,21.3768801 C6.81860792,22.5726228 8.9731271,23.2666666 11.291696,23.2666666 C18.836419,23.2666666 22.9610968,16.8551772 22.9610968,11.2964159 L22.9501601,10.7514393 C23.7547848,10.1567736 24.450043,9.41784949 25,8.57153289 C24.2672447,8.90493034 23.4735568,9.13574396 22.6439341,9.23672492 Z"></path>
    </svg>',
		'instagram' => '<svg class="icon">
        <rect fill-opacity="0" x="0" y="0" width="30" height="30"></rect>
        <path d="M19.39736,14.7743462 C19.39736,17.1985043 17.42858,19.1643864 15,19.1643864 C12.57161,19.1643864 10.60321,17.198694 10.60321,14.7743462 C10.60321,14.2255912 10.70847,13.7032022 10.8922,13.21875 L5.5,13.21875 L5.5,19.7580965 C5.5,22.3774391 7.62686,24.5 10.25,24.5 L19.75019,24.5 C22.37352,24.5 24.5,22.3774391 24.5,19.7580965 L24.5,13.21875 L19.10761,13.21875 C19.29172,13.7030126 19.39736,14.2255912 19.39736,14.7743462 Z"></path>
        <circle cx="14.703125" cy="14.703125" r="2.671875"></circle>
        <path d="M19.75019,5.5 L10.50023,5.5 L10.50023,10.288982 L9.4615,10.288982 L9.4615,5.56852163 C9.10012,5.62657212 8.75147,5.72081232 8.42277,5.85326297 L8.42277,10.2891657 L7.38423,10.2891657 L7.38423,6.43615606 C6.241,7.27476525 5.5,8.59853694 5.5,10.092786 L5.5,11.4375 L11.89882,11.4375 C12.69416,10.6727399 13.78989,10.1997018 15,10.1997018 C16.21011,10.1997018 17.30565,10.6727399 18.1008,11.4375 L24.5,11.4375 L24.5,10.092786 C24.5,7.55638362 22.37352,5.5 19.75019,5.5 Z M21.8723,9.84331588 C21.8723,10.1278735 21.6329,10.3595244 21.33821,10.3595244 L19.73689,10.3595244 C19.44163,10.3595244 19.2028,10.1286083 19.2028,9.84331588 L19.2028,8.29469037 C19.2028,8.00976532 19.44163,7.77829817 19.73689,7.77829817 L21.33821,7.77829817 C21.6329,7.77829817 21.8723,8.00921421 21.8723,8.29469037 L21.8723,9.84331588 Z"></path>
    </svg>',
		'youtube'   => '<svg class="icon">
        <rect fill-opacity="0" x="0" y="0" width="30" height="30"></rect>
        <path d="M22.4927576,8.27728199 C20.0131463,8.00008605 17.501448,7.99919474 15.0031193,8.00008605 C12.5038992,7.99919474 9.99398354,8.00008605 7.51437222,8.27728199 C6.46708851,8.39493429 5.59806585,9.17928294 5.35295689,10.2426102 C5.00445653,11.7578291 5,13.4112005 5,14.9709847 C5,16.530769 5,18.183249 5.34850037,19.6993593 C5.59271802,20.7617952 6.46263198,21.5470351 7.5099157,21.6629048 C9.98952701,21.9409921 12.500334,21.9418834 14.9986627,21.9409921 C17.4978828,21.9427747 20.0077985,21.9409921 22.4874098,21.6629048 C23.5338022,21.5452525 24.4046075,20.7609039 24.6506077,19.6993593 C24.9982168,18.183249 24.9999994,16.530769 24.9999994,14.9709847 C24.9999994,13.4112005 25.0026733,11.7587205 24.6541729,10.2426102 C24.4099553,9.17928294 23.5400413,8.39404298 22.4927576,8.27728199 Z M13.2009,17.6716397 L13.2009,11.2800895 L18.7350145,14.475419 L13.2009,17.6716397 Z"></path>
    </svg>',
		'email'     => '<svg class="icon">
            <rect fill-opacity="0" x="0" y="0" width="30" height="30"></rect>
            <path d="M25.845033,9.18181818 L19.7142857,14.9876364 L25.8447912,20.7939394 C25.8617143,20.6790303 25.8735604,20.5619394 25.8735604,20.4421818 L25.8735604,9.53309091 C25.8735604,9.41333333 25.861956,9.29672727 25.845033,9.18181818 Z"></path>
            <path d="M4.02852747,9.18181818 C4.01184615,9.29672727 4,9.41381818 4,9.53357576 L4,20.4426667 C4,20.5624242 4.01184615,20.6795152 4.02852747,20.7944242 L10.159033,14.9876364 L4.02852747,9.18181818 Z"></path>
            <path d="M16.1592308,16.4094545 L25.1497363,7.8950303 C24.7056264,7.34981818 24.0308791,7 23.2782857,7 L6.35520879,7 C5.60261538,7 4.92786813,7.34981818 4.48351648,7.89478788 L13.4742637,16.409697 C14.201956,17.0989091 15.4317802,17.0989091 16.1592308,16.4094545 Z"></path>
            <path d="M16.9889451,17.3061818 C16.3898681,17.8739394 15.6031868,18.1575758 14.8165055,18.1575758 C14.0295824,18.1575758 13.2429011,17.8739394 12.6440659,17.3061818 L10.9769011,15.7272727 L4.48351648,21.8780606 C4.92762637,22.4230303 5.60237363,22.7728485 6.35496703,22.7728485 L23.278044,22.7728485 C24.0306374,22.7728485 24.7053846,22.4230303 25.1494945,21.8780606 L18.6561099,15.7275152 L16.9889451,17.3061818 Z"></path>
    </svg>'
	);

	return $icons[ $name ];
}


function get_api( $name ) {

	$api = array(
		'youtube' => array(
			'url' => 'https://www.googleapis.com/youtube/v3/videos?id=hx5TYjlu14A&key=AIzaSyDyF_NOcUN_z2G9IdJb3yf144RiggIOdK8&part=snippet',
			'key' => 'AIzaSyDyF_NOcUN_z2G9IdJb3yf144RiggIOdK8',
		)
	);

	return $api[$name];

}
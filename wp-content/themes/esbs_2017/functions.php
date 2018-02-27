<?php

/**
 *
 */
function themeslug_enqueue_style() {
	wp_enqueue_style( 'core', get_template_directory_uri() . '/style_v6_1.css', false );
}

function themeslug_enqueue_script() {
	wp_enqueue_script( 'my-js', get_template_directory_uri() . '/js/main_v6_1.min.js', false );

	wp_enqueue_script( 'elementor-slider', get_template_directory_uri() . '/js/elementor_slider.min.js', false );
}


add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_script' );


//require_once( __DIR__ . '/options.php' );

//require_once __DIR__ . '/vendor/Facebook/autoload.php'; // change path as needed


require_once( __DIR__ . '/includes/esbs_harvest-cycle.php' );
require_once( __DIR__ . '/includes/blog.php' );
require_once( __DIR__ . '/includes/icons_svg.php' );


require_once( __DIR__ . '/acf_options.php' );

flush_rewrite_rules();


function register_my_menu() {
	register_nav_menu( 'principal', __( 'Menu principal', 'esbs_2017' ) );
	register_nav_menu( 'admin', __( 'Menu admin', 'esbs_2017' ) );
}

add_action( 'init', 'register_my_menu' );


add_theme_support( 'post-thumbnails' );

add_image_size( 'banner', 800, 372, true );
add_image_size( 'full_hd', 1920, 1080, true );
add_image_size( 'hd', 1280, 720, true );
add_image_size( 'blog', 321, 181, true );
add_image_size( 'blog_wall', 640, 360, true );
add_image_size( 'fullscreen', 1440, 806, true );
add_image_size( 'banner_blur', 200, 100, true );

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
			'post_status'      => 'publish',
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




function get_api( $name ) {

	$api = array(
		'youtube' => array(
			'url' => 'https://www.googleapis.com/youtube/v3/videos?id=hx5TYjlu14A&key=AIzaSyDyF_NOcUN_z2G9IdJb3yf144RiggIOdK8&part=snippet',
			'key' => 'AIzaSyDyF_NOcUN_z2G9IdJb3yf144RiggIOdK8',
		)
	);

	return $api[ $name ];

}

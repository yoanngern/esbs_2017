<?php ?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>

    <title><?php echo get_bloginfo( 'title' ); ?></title>


    <meta name="description" content="<?php echo get_bloginfo( 'description' ); ?>">

    <meta charset="<?php bloginfo( 'charset' ); ?>">

    <meta name="viewport"
          content="initial-scale=1, width=device-width, minimum-scale=1, user-scalable=no, maximum-scale=1, width=device-width, minimal-ui">
    <link rel="profile" href="http://gmpg.org/xfn/11">


    <link rel="apple-touch-icon" sizes="57x57"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16"
          href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/images/manifest.json">
    <link rel="mask-icon" href="favicon_hd.svg" color="#BB9446">
    <meta name="msapplication-TileColor" content="#BB9446">
    <meta name="msapplication-TileImage"
          content="<?php echo get_stylesheet_directory_uri(); ?>/images/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

	<?php if ( get_field( 'fb_title' ) ):
		$meta_fb_title = get_field( 'fb_title' );
	else:
        $meta_fb_title = "Europe Shall Be Saved";
    endif; ?>

	<?php if ( get_field( 'fb_desc' ) ):
		$meta_fb_desc = get_field( 'fb_desc' );
	else:
		$meta_fb_desc = "Together for 100 millions souls. One movement of people from all backgrounds to see the Gospel of Jesus-Christ change Europe.";
	endif; ?>

	<?php if ( get_field( 'fb_image' ) ):
		$meta_fb_image = get_field( 'fb_image' )['sizes']['full_hd'];;
	else:
		$meta_fb_image = "http://esbs.org/wp-content/themes/esbs_2017/images/facebook_default_home.png";
	endif; ?>

    <meta property="og:title" content="<?php echo $meta_fb_title; ?>"/>
    <meta property="og:description"
          content="<?php echo $meta_fb_desc; ?>"/>
    <meta property="og:image"
          content="<?php echo $meta_fb_image; ?>"/>


	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>


    <script>

    </script>
	<?php wp_head(); ?>


    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-92172259-1', 'auto');
        ga('send', 'pageview');

    </script>

</head>

<body <?php body_class(); ?>>

<header>

    <a href="/" id="simple_logo"></a>

	<?php
	wp_nav_menu( array(
		'theme_location' => 'principal'
	) );
	?>

    <a href="/" id="burger"></a>

</header>
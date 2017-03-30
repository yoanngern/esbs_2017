<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header>
        <time><?php echo get_the_date(); ?></time>
		<?php if ( get_field( "author" ) ): ?><span
                class="author"><?php echo get_field( "author" ) ?></span><?php endif; ?>
    </header>

    <div class="entry-content">
		<?php
		/* translators: %s: Name of current post */
		the_content( sprintf(
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
			get_the_title()
		) );

		wp_link_pages( array(
			'before'      => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		) );
		?>
    </div>


</article>
<section id="custom-page" class="share">

    <div class="bg"></div>

    <article class="center">

        <h1>Spread the word</h1>
        <h2>Want to tell your friends about ESBS?</h2>
        <h3>Use these social images to spread the word on Facebook.</h3>


		<?php if ( have_rows( 'posts' ) ): ?>

            <div class="posts">


				<?php while ( have_rows( 'posts' ) ): the_row(); ?>

                    <div class="post">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_sub_field( 'link' ) ); ?>"
                           id="post_c"
                           target="_blank"
                           style="background-image: url('<?php echo get_sub_field( 'image' )['sizes']['hd']; ?>')">
                            <span>share</span>
                            <div class="black"></div>
                        </a>
                    </div>
				<?php endwhile; ?>

            </div>

		<?php endif; ?>


    </article>

</section>
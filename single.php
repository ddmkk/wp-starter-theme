<?php

/*
Template Name: single.php
 */

get_header();

	if ( have_posts() ):
		while ( have_posts() ):
			the_post(); ?>

		<article id="post-<?php the_ID(); ?>" class="post">
			<div class="ly_container">
				<h2 class="post-title"><?php the_title(); ?></h2>
				<div class="post-content">
					<?php the_content(); ?>

				</div>
			</div>
		</article><?php
		endwhile;
	endif; ?>

<?php

get_footer();

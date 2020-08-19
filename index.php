<?php

/*
Template Name: index.php
 */

get_header();

if ( have_posts() ): ?>

	<div class="ly_main">

		<section class="ly_posts">

			<?php while ( have_posts() ): the_post(); ?>

			<article class="bl_post">
				<?php if ( has_post_thumbnail() ): ?>
				<figure class="bl_post_imgWrapper">
					<?php the_post_thumbnail(); ?>
				</figure>
				<?php endif; ?>

				<div class="bl_post_txt">
					<h2 class="bl_post_ttl"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<time datetime="<?php the_time( 'Y-m-d H:i:s' ); ?>"><?php the_time( 'Y.m.d' ); ?></time>

					<?php
					// 記事が属するカテゴリー
					$cats = get_the_category();
					if ( $cats ) : ?>

					<div class="bl_cats_wrapper">
						<p class="bl_cats_ttl">カテゴリー</p>
						<ul class="bl_cats">
						<?php foreach ( $cats as $cat ):
							$href = esc_url ( get_category_link( $cat->term_id ) );
							$name = $cat->name; ?>

							<li class="bl_cats_item"><a href="<?php echo $href; ?>"><?php echo $name; ?></a></li>
						<?php endforeach; ?>
						</ul>
					</div>
					<!-- /.bl_cats_wrapper -->
					<?php endif; ?>

					<?php
					// 記事が属するタグ
					$term_list = get_the_terms( get_the_ID(), 'post_tag' );
					if ( $term_list ): ?>

					<div class="bl_tags_wrapper">
						<p class="bl_tags_ttl">関連タグ</p>
						<ul class="bl_tags">
						<?php
						foreach ( $term_list as $term ):
							$href = esc_url ( get_term_link( $term, 'post_tag' ) );
							$name = $term->name; ?>

							<li class="bl_tags_item"><a href="<?php echo $href; ?>"><?php echo $name; ?></a></li>
						<?php endforeach; ?>
						</ul>
					</div>
					<!-- .bl_tags_wrapper -->
					<?php endif; ?>

					<div class="bl_post_exc"><?php the_excerpt(); ?></div>
				</div>
				<!-- .bl_post_txt -->
			</article>

			<?php

			endwhile;

			/**
			 * ページネーション
			 */

			// 新型
			the_posts_pagination( array(
				'prev_text' => '前へ',
				'next_text' => '次へ',
			)); ?>

		</section>
		<!-- /.ly_posts -->
	</div>
	<!-- /.ly_main -->

	<?php if ( is_active_sidebar( 'sidebar-1' ) ): ?>
	<aside class="ly_sidebar">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside>
	<!-- /.ly_sidebar -->
	<?php endif; ?>

<?php

endif;

get_footer();

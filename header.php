<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<?php wp_head(); ?>
</head>
<body <?php body_class();?>>
<?php wp_body_open(); ?>

	<div id="page" class="ly_page">

		<header class="ly_header">
			<?php if ( function_exists( 'the_custom_logo' ) ) the_custom_logo(); ?>
			<!--
			<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
			<p class="site-description"><?php bloginfo( 'description' ); ?></p>
			-->
		</header>
		<!-- .ly_header -->


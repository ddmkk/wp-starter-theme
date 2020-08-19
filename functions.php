<?php

function setup_theme() {

	// ----------------------------------------------------------
	// テーマサポート追加
	// アイキャッチ
	add_theme_support( 'post-thumbnails' );

	// タイトルタグ
	add_theme_support( 'title-tag' );

	// 投稿フォーマット
	add_theme_support( 'post-formats', [
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	]);

	// WordPressコアから出力されるHTMLタグをHTML5仕様にする
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'script', // >= 5.3.0
		'style',  // >= 5.3.0
	]);

	// ブロックエディタで画像配置選択肢に「全幅」が現れる。選択すると「alignfull」クラスが付与される
	add_theme_support( 'align-wide' );

	// YouTube動画を埋め込んだ際に縦横比を整えてくれる
	add_theme_support( 'responsive-embed' );

	// カスタムロゴ＋ファビコンも指定可能になる。
	add_theme_support( 'custom-logo', array(
		// 初期サイズを設定
		'height' => 100,
		'width' => 400,
		// 上記で指定のサイズ以外でも設定できるか
		'flex-height' => true,
		'flex-width' => true,
		// 表示非表示を切り替えられる要素のクラス
		// @XXX 挙動があやしい？
		'header-text' => array( 'site-title', 'site-description' )
	));

	// カスタムヘッダー
	add_theme_support( 'custom-header', array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => 0,
		'height'                 => 0,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => '',
		'header-text'            => true,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
		'video'                  => false,
		'video-active-callback'  => 'is_front_page',
	) );

	// カスタム背景
	add_theme_support( 'custom-background', array(
		'default-image' => '',
		'default-preset' => 'default',
		'default-position-x' => 'left',
		'default-position-y' => 'top',
		'default-size' => 'auto',
		'default-repeat' => 'repeat',
		'default-attachment' => 'scroll',
		'default-color' => '',
		'wp-head-callback' => '_custom_background_cb',
		'admin-head-callback' => '',
		'admin-preview-callback' => '',
	) );

	// テーマカスタマイザーでウィジェットを設置した際に自動で見た目を更新する
	add_theme_support( 'customize-selective-refresh-widgets' );

	// ----------------------------------------------------------
	// 不要なコードをwp_head()から削除する
	// 絵文字関連
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	add_filter( 'emoji_svg_url', '__return_false' );

	// WordPressバージョン情報
	remove_action( 'wp_head', 'wp_generator' );

	// コメントフィード
	remove_action( 'wp_head', 'feed_links_extra', 3 );

	// ブログ投稿の為のツール
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// rel=prev,rel=next
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

	// rel=canonical
	remove_action( 'wp_head', 'rel_canonical' );

	// 短縮URL
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );

	// -----------------------------------------------------------
	// wp_head()で読み込むCSSやJavascriptを管理する
	add_action( 'wp_enqueue_scripts', 'add_style_script' );

}
add_action( 'after_setup_theme', 'setup_theme' );


/*
 * wp_head(),wp_footer()内で読み込むコードを管理する
 */
function add_style_script() {
	// wordpressに元から入っているjqueryの使用をやめる。
	wp_deregister_script( 'jquery' );
	// CDNからjqueryを読込みパフォーマンスアップを試みる。
	wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', array(), null, false );
	// テーマ専用jsファイル。
	wp_enqueue_script( 'main', get_template_directory_uri() . '/main.js', array(), null, true );

	// Gurtenberg（ブロックエディタ）用のスタイルは削除する。
	wp_deregister_style( 'wp-block-library' );
	// テーマオリジナルスタイル。
 	wp_enqueue_style( 'style', get_stylesheet_uri(), array(), null, 'screen' );
}

/**
 * カスタムロゴ機能をさらに便利にする
 */
function my_the_custom_logo() {
	if ( has_custom_logo() ) {
		$logo_id = get_theme_mod( 'custom_logo' );
		$image = wp_get_attachment_image_src( $logo_id, $size );
		$logo = $image[0];
		$html = '<img src="' . $logo . '" class="custom-logo" alt="' . get_bloginfo( 'name' ) . '">';
	} else {
		$html = get_bloginfo( 'name' );
	}

	echo '<a href="' . home_url( '/' ) . '" class="custom-logo-link" rel="home">' . $html . '</a>';
}

/**
 * ウィジェットを追加する
 *
 * @XXX regeister_sidebarはdefault設定だとliタグで囲まれるので必ずbefore_widget,after_widgetを設定しよう。
 */
add_action( 'widgets_init', 'my_widgets_init' );
function my_widgets_init() {
	register_sidebar( array(
		'name' => 'sidebar-1',
		'id' => 'sidebar-1',
		// 管理画面でこの値がウィジェットの説明文として表示されます
		'description' => __( 'メインサイドバーです。' ),
		'class' => 'aside',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => "</section>\n",
	) );
}


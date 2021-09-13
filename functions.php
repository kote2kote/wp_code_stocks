<?php
/**
 * wp_code_stocks functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp_code_stocks
 * 
 * 210813 スースコード整理
 * 210807 テスト
 */

// --------------------------------------------------
// WordPressのViewを無効化(nuxt/next用)
// --------------------------------------------------
add_theme_support('post-thumbnails', array('post'));
add_theme_support('menus'); 
 
function my_customize_rest_cors() {
  remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );
  add_filter( 'rest_pre_serve_request', function( $value ) {
    header( 'Access-Control-Allow-Origin: *' );
    return $value;
  });
}
add_action( 'rest_api_init', 'my_customize_rest_cors', 15 );

// --------------------------------------------------
// 環境変数の定義
// --------------------------------------------------
// 記事データ作成用
$exclude_catid = [1]; // 除外カテゴリID
$no_images_url = 'https://kote2tokyo.kote2.co/wp-content/uploads/2019/05/test.png';

// 本番/開発環境判別用
global $dev_url;
global $prod_url;
global $is_dev;
global $is_prod;
$is_dev = $is_prod = false;
$dev_url = 'http://localhost:10058'; // dev環境のURL 自由に変更してください
$prod_url = 'https://code-stocks.kote2.co'; // prod環境のURL 自由に変更してください

// 現在の環境が本番環境/開発環境か判別フラグ作成
if(home_url() === $dev_url) {
  $is_dev = true;
} else {
  $is_prod = true;
}

$is_prod = true;


// --------------------------------------------------
// default設定
// --------------------------------------------------
// ログイン時の管理バーを消す場合はコメントアウト
add_filter('show_admin_bar', '__return_false');

// PHPのメモリー上限の書き換え
ini_set('memory_limit', '256M');

// 不要タグの削除
remove_action( 'wp_head', 'wp_generator' ); // WordPressのバージョン情報
remove_action( 'wp_head', 'rsd_link' ); // 外部アプリケーションから情報を取得するタグ
remove_action( 'wp_head', 'wlwmanifest_link' ); // Windows Live Writer用のタグ
remove_action( 'wp_head', 'index_rel_link' ); // 現在の文書に対する「索引」であることを示すタグ
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 ); //「?p=投稿ID」形式のデフォルトパーマリンクタグ
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); //以下「link rel=next」等のタグ
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'feed_links', 2);// 以下フィード関連のタグ
remove_action( 'wp_head', 'feed_links_extra', 3);
remove_action( 'wp_head', 'print_emoji_detection_script', 7); // 以下絵文字関連タグ
remove_action( 'admin_print_scripts', 'print_emoji_detection_script');
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'rel_canonical'); // canonicalURLを削除
add_filter( 'emoji_svg_url', '__return_false' );

// add_theme_support
add_action( 'after_setup_theme', function(){
add_theme_support( 'title-tag' ); // tiltleタグの追加
add_theme_support( 'post-thumbnails' ); //サムネイル機能の追加
add_theme_support('menus'); // カスタムメニュー
add_theme_support('widgets'); // ウィジェットの追加
});

// session_start(必要な場合)
// add_action('init', function(){
//   session_start();
// });


// --------------------------------------------------
// 共通js/css
// --------------------------------------------------
function wp_code_stocks_scripts() {

  //キャッシュ対策
  date_default_timezone_set('Asia/Tokyo');
  $id = date("YmdHis"); ;

	//CSS
  wp_enqueue_style( 'wp_code_stocks-animate', '//fonts.googleapis.com/css?family=Anton', array(), $id );
  wp_enqueue_style( 'wp_code_stocks-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), $id );
	wp_enqueue_style( 'wp_code_stocks-style', get_stylesheet_uri(), array(), $id ); // style.css

  //JS
  // IE対策が必要な場合
  // wp_enqueue_script( 'wp_code_stocks-polyfill', '//polyfill.io/v3/polyfill.min.js?features=es6%2CIntersectionObserver%2CIntersectionObserverEntry', array(), $id, true);
  // wp_enqueue_script( 'wp_code_stocks-picturefill-js', '//cdnjs.cloudflare.com/ajax/libs/picturefill/3.0.3/picturefill.js', array(), $id, true);
  // wp_enqueue_script( 'wp_code_stocks-object-fit-images', '//cdnjs.cloudflare.com/ajax/libs/object-fit-images/3.2.4/ofi.min.js', array(), $id, true);

  // smoothscroll-polyfill for I,MSEdge, Safari
  // wp_enqueue_script( 'wp_code_stocks-smoothscroll-polyfill', '//unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.min.js', array(), $id, true);
  wp_enqueue_script( 'wp_code_stocks-script-vue', 'https://unpkg.com/vue@next', array(), $id, true); // isDev
  // wp_enqueue_script( 'wp_code_stocks-script-google-map', 'http://maps.google.com/maps/api/js?key=AIzaSyAAy__ZCpT3NEd7K2i3TBHAJgd66eBpFI0&language=ja', array(), $id, true); // isDev
  // wp_enqueue_script( 'wp_code_stocks-script-vue', 'https://cdn.jsdelivr.net/npm/vue@2', array(), $id, true); // isProd
  wp_enqueue_script( 'wp_code_stocks-script-js', get_template_directory_uri(). '/assets/build/js/scripts.js', array(), $id, true);
  // if($is_prod){

  // } else {

  // }
	
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_code_stocks_scripts' );

// --------------------------------------------------
// サムネイルサイズ カスタマイズ
// --------------------------------------------------
add_image_size('thumb-tb', 520);
add_image_size('thumb-pc', 960);
add_image_size('thumb-sm', 640);
add_image_size('thumb-md', 768);
add_image_size('thumb-lg', 1024);
add_image_size('thumb-xl', 1280);
add_image_size('thumb-wide', 1536);

// 取り出し方
// --------------------------------------------------
// アイキャッチの場合
// the_post_thumbnail( 'thumb-tb' ); 
// 画像idを指定する場合
// echo wp_get_attachment_image( [画像id], 'thumb-tb' )


// --------------------------------------------------
// メニューの設定
// --------------------------------------------------
register_nav_menus( array(
  'mainmenu' => esc_html__( 'サイドバー', 'wp_code_stocks' ),
));

// --------------------------------------------------
// デフォルトrestAPIを修正 tags/categories/prev/nextを追加
// --------------------------------------------------
function editRestAPI( $data ) {
  $data->data['tags'] = get_the_tags(); // タグ
  $data->data['categories'] = get_the_category(); // カテゴリ
  $data->data['prev'] = getPreviousPost(); // 前の記事
  $data->data['next'] = getNextPost(); // 次の記事
  return $data;
}
add_filter( 'rest_prepare_post', 'editRestAPI', 10, 3 );

// -- 前の記事 --------------------
function getPreviousPost() {
  $prev = get_previous_post($excluded_terms = $exclude_catid); // カテゴリid:1(未定義)を除外
  // 前の記事がない場合
  if(empty($prev)) { 
    $prev = []; // 空に
  } else {
    // サムネイルURLを追加
    $prev->featured_image_src = get_the_post_thumbnail_url($prev->ID);
  }

  return $prev;
}

// -- 次の記事 --------------------
function getNextPost() {
  $next = get_next_post($excluded_terms = $exclude_catid);
  if(empty($next)) {
    $next = [];
  } else {
    $next->featured_image_src = get_the_post_thumbnail_url($next->ID);
  }

  return $next;
}

// --------------------------------------------------
// Rest APIにサムネイル追加'featured_image'エンドポイント作成
// --------------------------------------------------

function get_thumbURL($object, $field_name, $request) {
	$feat_img_array = wp_get_attachment_image_src($object['featured_media'], 'large', true);

	// アイキャッチ画像がない場合(返ってきた文字列がdefaultの場合)代わりの画像を表示
	$tmpImg = $feat_img_array[0];
	if(strpos($feat_img_array[0],'wp-includes/images/media/default.png') !== false){
		$tmpImg = $no_images_url;
	}
	
  return [
    'src' => $tmpImg,
    'width' => $feat_img_array[1],
    'height' => $feat_img_array[2],
  ];
}

function add_thumbnail_to_JSON() {
//Add featured image
  register_rest_field('post',
    'featured_image', // このparamで以下を追加
    array(
      'get_callback' => 'get_thumbURL',
      'update_callback' => null,
      'schema' => null,
    )
  );
}
add_action('rest_api_init', 'add_thumbnail_to_JSON');

// --------------------------------------------------
// スラッグ名が日本語だったら自動的に投稿タイプ＋id付与
// --------------------------------------------------
function auto_post_slug( $slug, $post_ID, $post_status, $post_type ) {
  if ( preg_match( '/(%[0-9a-f]{2})+/', $slug ) ) {
      $slug = utf8_uri_encode( $post_type ) . '-' . $post_ID;
  }
  return $slug;
}
add_filter( 'wp_unique_post_slug', 'auto_post_slug', 10, 4  );


// --------------------------------------------------
// 管理画面の投稿一覧にサムネイル追加
// --------------------------------------------------
function customize_manage_posts_columns($columns) {
  $columns['thumbnail'] = __('Thumbnail');
  return $columns;
}
add_filter( 'manage_posts_columns', 'customize_manage_posts_columns' );

//サムネイル画像表示
function customize_manage_posts_custom_column($column_name, $post_id) {
  if ( 'thumbnail' == $column_name) {
      $thum = get_the_post_thumbnail($post_id, 'small', array( 'style'=>'width:100px;height:auto;' ));
  } if ( isset($thum) && $thum ) {
      echo $thum;
  } else {
      echo __('None');
  }
}
add_action( 'manage_posts_custom_column', 'customize_manage_posts_custom_column', 10, 2 );


// --------------------------------------------------
// 管理画面の投稿一覧にタグ一覧を表示(デフォルト非表示)
// --------------------------------------------------
function re_register_post_tag_taxonomy() {
  $tag_slug_args = get_taxonomy('post_tag');
  $tag_slug_args->hierarchical = true;
  $tag_slug_args->meta_box_cb = 'post_categories_meta_box';
  register_taxonomy('post_tag', 'post', (array) $tag_slug_args);
}
add_action( 'init', 're_register_post_tag_taxonomy', 1 );


// --------------------------------------------------
// 検索カスタマイズ(タグ名・カテゴリ名・カスタムフィールド も検索対象にする)
// --------------------------------------------------
function custom_search($search, $wp_query) {
	global $wpdb;

	//検索ページ以外だったら終了
	if (!$wp_query->is_search)
	return $search;

	if (!isset($wp_query->query_vars))
	return $search;

	// タグ名・カテゴリ名・カスタムフィールド も検索対象にする
	$search_words = explode(' ', isset($wp_query->query_vars['s']) ? $wp_query->query_vars['s'] : '');
	if ( count($search_words) > 0 ) {
		$search = '';
		foreach ( $search_words as $word ) {
			if ( !empty($word) ) {
				$search_word = $wpdb->escape("%{$word}%");
				$search .= " AND (
						{$wpdb->posts}.post_title LIKE '{$search_word}'
						OR {$wpdb->posts}.post_content LIKE '{$search_word}'
						OR {$wpdb->posts}.ID IN (
							SELECT distinct r.object_id
							FROM {$wpdb->term_relationships} AS r
							INNER JOIN {$wpdb->term_taxonomy} AS tt ON r.term_taxonomy_id = tt.term_taxonomy_id
							INNER JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
							WHERE t.name LIKE '{$search_word}'
						OR t.slug LIKE '{$search_word}'
						OR tt.description LIKE '{$search_word}'
						)
						OR {$wpdb->posts}.ID IN (
							SELECT distinct p.post_id
							FROM {$wpdb->postmeta} AS p
							WHERE p.meta_value LIKE '{$search_word}'
						)
				) ";
			}
		}
	}

	return $search;
}
add_filter('posts_search','custom_search', 10, 2);


// --------------------------------------------------
// カテゴリー・タグのID列を追加
// --------------------------------------------------
function add_term_columns( $columns ) {
  $index = 2; // 列を追加する位置
     return array_merge(
     array_slice($columns, 0, $index),
     array('id' => 'ID'),
     array_slice($columns, $index)
     );
 }
 add_filter('manage_edit-category_columns' , 'add_term_columns');
 add_filter('manage_edit-post_tag_columns' , 'add_term_columns');
 
 //IDを表示
 function custom_term_columns( $content, $column_name, $term_id ) {
     if ( 'id' === $column_name ) {
         $content = $term_id;
     }
     return $content;
 }
 add_action( 'manage_category_custom_column', 'custom_term_columns', 10, 3 );
 add_action( 'manage_post_tag_custom_column', 'custom_term_columns', 10, 3 );
 
 //ソート可能にする
 function sort_term_columns($columns) {
   $columns['id'] = 'ID';
   return $columns;
 }
 add_filter( 'manage_edit-category_sortable_columns', 'sort_term_columns' );
 add_filter( 'manage_edit-post_tag_sortable_columns', 'sort_term_columns' );
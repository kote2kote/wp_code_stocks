<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_code_stocks
 */

 // -- カテゴリページチェック -------------- //
$cat_id = null;
if( is_category() ){
  $cat = get_the_category();
  $cat_id = $cat[0]->term_id;
}

 // -- タグページチェック -------------- //
 $tag_id = null;
 if( is_tag() ){
   $tag = get_the_tags();
   $tag_id = $tag[0]->term_id;
 }

  // -- 検索ページチェック -------------- //
$search_word = '';
  if( get_search_query() ){
    $search_word = get_search_query();
  }

get_header();
?>
<main class="main w-full">
  　　<div class="inner px-8">
    <h2 class="com_tail mb-8">
      <?php 
        if( is_category() ){
          echo 'カテゴリ: ';
          wp_title('');
        } else if( is_tag() ) {
          echo 'タグ: ';
          wp_title('');
        } else if(get_query_var('s')) {
          echo '検索: ';
          echo get_query_var('s');
        } else {
          echo 'すべての記事';
        }

          ?>

    </h2>
    <div class="">
      <ul class="list-none">
        <?php
          

					// ==================================================
          // WP_Query
          // ==================================================
          $args = array(

            // -- 記事のタイプ --------------------
            'post_type' => 'post', 
            // 'post_type' => 'page', 
            // 'post_type' => 'nav_menu_item', 
            // 'post_type' => 'hero_slider', // 
  
            // -- オプション --------------------
            'cat' => $cat_id,
            'category__not_in' => 1, // acfのカテゴリと未定義は除く
            'tag_id' => $tag_id,
            's' => $search_word,
            'posts_per_page' => 20, // -1は全て
            'no_found_rows' => false, //true => ページングを使用しない
          );

          $the_query = new WP_Query($args);
          if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
              $the_query->the_post();
              
              if(isset($cat[0]) && $cat[0]->slug == 'copipe-tailwindcss'){
                get_template_part( 'template-parts/list-content-copipe-tailwindcss', get_post_type() );
              } else {
                get_template_part( 'template-parts/list-content', get_post_format());
              }
            }
          }
          wp_reset_postdata();

					?>
      </ul>
    </div>
  </div>
</main>
<?php
get_footer();
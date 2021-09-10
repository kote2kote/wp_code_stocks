<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wp_code_stocks
 */

get_header();
?>
<main class="main w-full">
　　<div class="inner px-8">
			
			<div class="">
      <?php 
        while (have_posts()) {
          the_post();
          get_template_part( 'template-parts/post-content', get_post_type() );

          // https://yottagin.com/?p=708
          // 第二引数に get_post_type()を渡すことで、ポストタイプ別に異なるファイルを読み込む処理も使われています
          // template-partsというディレクトリ以下には、content.php以外に、content-page.phpやcontent-none.php、content-search.phpというファイルがあります。get_post_typeでハイフン以下に該当するファイルが見つかればそのファイルを、見つからなければ content.phpを読み込むという処理が行われます。
        }
      ?>
			</div>
		</div>
</main>
<?php
get_footer();
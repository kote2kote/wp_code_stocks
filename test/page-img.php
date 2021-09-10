<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wp_code_stocks
 * Template Name: page-img
 */



get_header('starter');
?>
<main class="main w-full">
　　<div class="inner px-8">
		<!-- h2.com_tail ---------------------------->
		<h2 class="com_tail flex flex-row items-center bg-gray-900 pl-6 pt-3 pb-3 pr-3 mb-8 border-b-2 font-semibold text-3xl text-white">h2.com_tail</h2>

    <!-- h3.com_tail ---------------------------->
    <h3 class="com_tail border border-black pl-4 pt-2 pb-2 pr-2 mb-8 mt-12 font-bold text-3xl">基本的なやり方(pcとtb/sm)</h3>
    <div class="">

      <?php 
        // 画像表示に関して詳しい
        // https://morilog.com/wordpress/template/post_thumbnail_and_image_functions/
        //
        // ===========> アイキャッチのURLを取得したい場合
        // https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/wp_get_attachment_image_src
        $default_thumb = 'https://test.kote2.co/wp-content/uploads/2021/02/screenshot.png';
        $image_tb_url = $default_thumb;
        $image_pc_url = $default_thumb;
        if(has_post_thumbnail()) {
          $image_id = get_post_thumbnail_id ();
          $thumb_tb = wp_get_attachment_image_src ($image_id, 'thumb-lg');
          $thumb_pc = wp_get_attachment_image_src ($image_id, 'thumb-wide');
          $image_tb_url = $thumb_tb[0];
          $image_pc_url = $thumb_pc[0];
        }
      ?>

    <picture class="imgWrapper">
					<source media="(man-width:959px)" srcset="<?php echo $image_tb_url; ?>" />
					<source media="(min-width:960px)" srcset="<?php echo $image_pc_url; ?>" />
					<img src="<?php echo $image_pc_url; ?>" class="w-full object-cover c-object-coverIE" alt="" />
				</picture>
    </div>
    <!-- h3.com_tail ---------------------------->
    <h3 class="com_tail border border-black pl-4 pt-2 pb-2 pr-2 mb-8 mt-12 font-bold text-3xl">レスポンシブ対応(今回はassetsの画像を読み込む)</h3>
    <div class="">
    <picture class="imgWrapper">
					<source media="(man-width:959px)" srcset="<?php echo get_template_directory_uri(); ?>/assets/dist/images/test-tb.png 1x,
					<?php echo get_template_directory_uri(); ?>/assets/dist/images/test-pc.png 2x" />
					<source media="(min-width:960px)" srcset="<?php echo get_template_directory_uri(); ?>/assets/dist/images/test-pc.png" />
					<img src="<?php echo get_template_directory_uri(); ?>/assets/dist/images/test-pc.png" class="w-full object-cover c-object-coverIE" alt="" />
				</picture>
    </div>

    <!-- h3.com_tail ---------------------------->
    <h3 class="com_tail border border-black pl-4 pt-2 pb-2 pr-2 mb-8 mt-12 font-bold text-3xl">WPタグの呼び出し(参考)</h3>
    <div class="">
    <h4 class="com_tail pl-4 py-2 text-xl font-bold relative mb-8 mt-12">wp_get_attachment_image</h4>
    <?php echo wp_get_attachment_image( 76, 'thumb-lg' ) ?>

    <h4 class="com_tail pl-4 py-2 text-xl font-bold relative mb-8 mt-12">the_post_thumbnail()</h4>
    <?php the_post_thumbnail() ?>
    </div>
		</div>
</main>
<?php
get_footer();
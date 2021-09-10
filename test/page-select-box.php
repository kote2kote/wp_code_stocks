<?php
/*
	Template Name: page-select-box
*/
get_header('starter'); ?>
<div class="Starter">
  <div class="inner min-h-screen pb-12">
    <h2 class="com_tail with-margin">select-box</h2>
    <main>
      <div class="inner">
        <h2 class="com_tail with-margin">メイン</h2>
        <div class="">
          <?php $categories = get_categories( $args_cat ); if ( $categories ) { ?>
          <select name="cat-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
            <option value="" selected="selected">カテゴリーを選択</option>
            <?php foreach ( $categories as $category ){ ?>
            <option value="<?php echo esc_html( get_category_link( $category->term_id ) ); ?>"><?php echo esc_html( $category->name ); ?></option>
            <?php } ?>
          </select>
          <?php } ?>
        </div>
        <h3 class="com_tail with-margin">東京都(カテゴリ)かつ墨田区(タグ)を普通に表示</h3>
        <div class="">
          <?php 
					// ==================================================
          // WP_Query
          // ==================================================
          $args = array(

            // -- 記事のタイプ --------------------
            'post_type' => 'post', 
  
            // -- オプション --------------------
            'cat' => array(21,),
            'category__not_in' => array(1,), // acfのカテゴリと未定義は除く
            'tag_id' => 28,
            // 's' => $search_word,
            'posts_per_page' => -1, // -1は全て
            'no_found_rows' => true, //true => ページングを使用しない
          );

          $the_query = new WP_Query($args);
          if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
              $the_query->the_post();
              get_template_part( 'template-parts/list-content', get_post_format());
            }
          }
          wp_reset_postdata();
					?>
        </div>

        <h3 class="com_tail with-margin">カテゴリ一覧を出す(get_categories)</h3>
        <div class="">
          <?php
					// ==================================================
					// カテゴリを一覧で出す(get_categories)
					// ==================================================
					  $categories = get_categories( $args );
						// $tags = get_tags(array('taxonomy' => 'tag'));
						// $arr = array();

						// -- ループ取り出し -------------- //
						if($categories) {
							foreach ( $categories as $category ){
								echo esc_html( $category->name ).'<br>'; // カテゴリ名

								// 説明(category_description)があった場合
								if($category->category_description) {
									echo '説明: '. esc_html( $category->category_description ) . '<br>'; // 説明
								// $tag_ids = explode(',', $category->category_description);
								// var_dump($tag_ids);
								// foreach ( $tags as $tag_id ){
								// 	// echo $tag_id; // 23,22,30,27,28,26,25,24
								// 	echo $tag_id;
									

								// }
								}
								
							}

							
							// var_dump($categories);
							// echo $categories[10]->name; // 東京都
						}
					 ?>


        </div>

        <h3 class="com_tail with-margin">カテゴリ一覧を出す(wp_list_categories)</h3>
        <div class="">
          <?php
					// ==================================================
					// カテゴリを一覧で出す(wp_list_categories)
					// ==================================================
          $args = array(
            'show_option_all'    => '',
            'orderby'            => 'name',
            'order'              => 'ASC',
            'style'              => 'list',
            'show_count'         => 0,
            'hide_empty'         => 1,
            'use_desc_for_title' => 1,
            'child_of'           => 0,
            'feed'               => '',
            'feed_type'          => '',
            'feed_image'         => '',
            'exclude'            => 1,2,
            'exclude_tree'       => '',
            'include'            => '',
            'hierarchical'       => 1,
            // 'title_li'           => ( 'Categories' ),
            'title_li'           => (''),
            'show_option_none'   => (''),
            'number'             => null,
            'echo'               => 1,
            'depth'              => 0,
            'current_category'   => 0,
            'pad_counts'         => 0,
            'taxonomy'           => 'category',
            'walker'             => null
              );
              wp_list_categories( $args ); //

					?>

        </div>
        <h3 class="com_tail with-margin">都道府県に紐づく市区町村をすべて出力</h3>
        <div class="">
          <h4 class="com_tail">カテゴリの説明に記述されているカンマ区切りの文字列数値を数値配列変換してタグidと照らし合わせてタグ名を出力</h4>
          <div class="">
            <ul>
              <?php
					// ==================================================
					// 都道府県に紐づく市区町村をすべて出力
					// ==================================================
					// カテゴリの説明に記述されているカンマ区切りの文字列数値を数値配列変換してタグidと照らし合わせてタグ名を出力
					  // $categories = get_categories(array('taxonomy' => 'category'));
						$tags = get_tags( $args_tag );

						// -- ループ取り出し -------------- //
						if($categories) {
							foreach ( $categories as $category ){

								// -- 特定のカテゴリだけ抜き出す -------------- //
								if($category->term_id == 21){ // 東京都のカテゴリid = 21
									echo esc_html( $category->name ).'<br>'; // 東京都

									// カンマ区切りで配列化。ただしまだ配列の数字は文字列
									$tag_description = explode(',', $category->category_description);

									// 配列の文字列を数値化
									$tag_arr_id = [];
									foreach( $tag_description as $tag_desc_id) {
										foreach( $tags as $tag ) {
											if($tag->term_id == (int)$tag_desc_id) {
												
												?>
              <li><?php echo esc_html( $tag->name );  ?></li>
              <?
											}
										}
									}
								}
							}
						}
					 ?>
            </ul>
          </div>
        </div>
      </div>
      <!-- /.main_inner -->
    </main>
  </div>
</div>
<?php get_footer(); ?>
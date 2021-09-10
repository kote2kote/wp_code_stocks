<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_code_stocks
 */
?>

<aside class="aside px-4" style="width: 300px;">
  <!-- 検索 -->
  <div class="search">
    <h5 class="com_tail">検索</h5>
    <form method="get" action="<?php echo home_url('/'); ?>" class="pt-3">
      <fieldset class="submenu-search-fieldset px-3 pb-8">
        <label for="search" class="hidden">search</label>

        <div class="relative">

          <input type="text" name="s" class="appearance-none rounded-full w-full py-2 pl-4 pr-10 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="search word" />
          <button type="submit" class="inline-block w-4 absolute">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
      </fieldset>
    </form>
  </div>
<!-- 
  <div class="out_test-are-search">
    <div class="inner">
      <h5 class="com_tail">条件検索</h5>
      <ul class="list-none">
        <?php
          // wp_list_categories();
          // $args = array(
          //   'show_option_all'    => '',
          //   'orderby'            => 'name',
          //   'order'              => 'ASC',
          //   'style'              => 'list',
          //   'show_count'         => 0,
          //   'hide_empty'         => 1,
          //   'use_desc_for_title' => 1,
          //   'child_of'           => 0,
          //   'feed'               => '',
          //   'feed_type'          => '',
          //   'feed_image'         => '',
          //   'exclude'            => 1,2,
          //   'exclude_tree'       => '',
          //   'include'            => '',
          //   'hierarchical'       => 1,
          //   // 'title_li'           => ( 'Categories' ),
          //   'title_li'           => (''),
          //   'show_option_none'   => (''),
          //   'number'             => null,
          //   'echo'               => 1,
          //   'depth'              => 0,
          //   'current_category'   => 0,
          //   'pad_counts'         => 0,
          //   'taxonomy'           => 'category',
          //   'walker'             => null
          //     );
          //     wp_list_categories( $args ); //

					?>
      </ul>
    </div>
  </div> -->

  <!-- メニュー -->
  <div class="menu">
    <h5 class="com_tail">メニュー</h5>
    <ul>
      <li><a href="/">トップページ</a></li>
    </ul>
    <ul id="menu-mainmenu" class="menu">
      <?php 
    wp_nav_menu( array(
      'theme_location'	=> 'mainmenu', // function.phpで設定したメニュー名を表示
      'container'			=> false,
      'items_wrap' => '%3$s' //ulを削除
    ) );
    
// 展開例
// <li id="menu-item-31" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-31"><a href="http://localhost:10048/category/cat01/">カテゴリ1</a></li>
// <li id="menu-item-32" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-32"><a href="http://localhost:10048/category/cat02/">カテゴリ2</a></li>
// <li id="menu-item-81" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-81"><a href="http://localhost:10048/category/cat03/">カテゴリ3</a></li>
// <li id="menu-item-82" class="menu-item menu-item-type-post_type menu-item-object-cpt menu-item-82"><a href="http://localhost:10048/cpt/testpage/">カスタム投稿タイプです</a></li>
// <li id="menu-item-94" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-94"><a href="https://www.marugame-seimen.com/shop/">sss</a></li>
  ?>
    </ul>
  </div>
</aside>
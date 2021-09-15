<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_code_stocks
 */
?>

<aside class="aside flex com_h-pageTop overflow-hidden" style="width: 400px;">
  <?php if( is_user_logged_in() ) {?>
  <!-- サブメニュー 左サイドバーの場合はout_lにorder-2を入れる。右サイドバーの場合は削除 -->
  <div class="out_l w-1/2 com_bg-submenu order-2 overflow-y-auto">
    <h2 class="text-sm bg-black pl-2 com_font-anton">items</h2>
    <ul class="pb-12">
      <li v-for="n in postData" :key="n.id" @click="readPage(n.acf.cf_URL, n.tags, n.id)" class="cursor-pointer border-b border-gray-300 border-dashed p-2 hover:bg-green-700">
        <template v-if="n.tags">
          <span v-for="nn in n.tags" :key="nn.term_id">
            <template v-if="nn.slug === 'note'"><i class="fas fa-edit mr-1"></i></template>
          </span>
        </template>

        <span class="text-xs font-bold">{{ n.title.rendered }}</span>
      </li>
    </ul>
  </div>

  <!-- メインサイドバー 左サイドバーの場合はout_rにorder-1を入れる。右サイドバーの場合は削除-->
  <div class="out_r w-1/2 com_bg-sidebar order-1 overflow-y-auto">

    <div class="prof bg-black">
      <div class="com_font-anton py-2 text-center flex items-center justify-center text-xl"><?php bloginfo( 'name' ); ?></div>
      <!-- <div class="flex px-4 pb-4">

        <div class="out_avatar"><?php //echo get_avatar( 1, 60 ); ?></div>
        <div class="pl-4">

          <p class="text-xs"><?php //the_author_meta('user_description',1); ?></p>
          <div class="text-center pt-1">

            <a class="inline-block mr-1" href="https://twitter.com/kote2" target="_blank"><i class="fab fa-twitter"></i></a>
            <a class="inline-block ml-1" href="https://github.com/kote2kote" target="_blank"><i class="fab fa-github"></i></a>
          </div>
        </div>
      </div> -->
    </div>

    <!-- メニュー -->
    <div class="menu">
      <div class="inner pt-8 pl-4 pb-12">
        <ul class="text-sm">
          <li v-for="n in restCatData" :key="n.id" class="py-1">
            <i class="fas fa-chevron-right mr-2"></i><span @click="readPosts(n.id)" class="text-sm font-bold cursor-pointer hover:bg-green-700">{{ n.name }}</span>
            <template v-if="n.children.length !== 0">
              <ul class="ml-6">
                <li v-for="nn in n.children" :key="nn.id" class="py-1">
                  <span @click="readPosts(nn.id)" class="cursor-pointer text-xs hover:bg-green-700">{{ nn.name }}</span>
                  <template v-if="nn.children.length !== 0">
                    <ul class="ml-4">
                      <li v-for="nnn in nn.children" :key="nnn.id" class="py-1 hover:bg-green-700">
                        <span @click="readPosts(nnn.id)" class="cursor-pointer text-xs ">{{ nnn.name }}</span>
                      </li>
                    </ul>
                  </template>
                </li>
              </ul>
            </template>
          </li>
        </ul>
      </div>
    </div>

  </div>
  <?php } ?>
</aside>
<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_code_stocks
 */
?>

<aside class="aside flex h-top-screen overflow-hidden" style="width: 700px;">

  <!-- サブメニュー 左サイドバーの場合はout_rにorder-2を入れる。右の場合は削除 -->
  <div class="out_l w-1/2 overflow-y-auto com_bg-submenu order-2">
    <h2 class="font-sm bg-black pl-2 com_font-anton">items</h2>
    <ul>
      <li v-for="n in postData" :key="n.id" @click="readPage(n.acf.cf_URL, n.tags, n.id)" class="cursor-pointer border-b border-gray-300 border-dashed py-3 px-2">
        <span class="text-sm font-bold">{{ n.title.rendered }}</span>
      </li>
    </ul>
  </div>

  <!-- メインサイドバー 左サイドバーの場合はout_rにorder-1を入れる。右の場合は削除-->
  <div class="out_r w-1/2 overflow-y-auto com_bg-sidebar order-1">

    <div class="prof bg-black">
      <div class="com_font-anton py-2 text-center flex items-center justify-center text-xl"><?php bloginfo( 'name' ); ?></div>
      <div class="flex px-4 pb-4">
        <!-- プロフ写真 -->
        <div class=""><img class="rounded-full w-14" src="https://secure.gravatar.com/avatar/c64041df9e3238269c5e17395331d167" alt=""></div>
        <div class="pl-4">
          <!-- プロフ説明 -->
          <p class="text-xs"><?php the_author_meta('user_description',1); ?></p>
          <div class="text-center pt-1">
            <!-- ソーシャルアイコン -->
            <a class="inline-block mr-1" href="https://twitter.com/kote2" target="_blank"><i class="fab fa-twitter"></i></a>
            <a class="inline-block ml-1" href="https://github.com/kote2kote" target="_blank"><i class="fab fa-github"></i></a>
          </div>
        </div>
      </div>
    </div>

    <!-- メニュー -->
    <div class="menu">
      <div class="inner pt-8 pl-12">
        <ul class="text-sm">
          <li v-for="n in restCatData" :key="n.id" class="py-1">
            <i class="fas fa-chevron-right mr-2"></i><span @click="readPosts(n.id)" class="text-lg font-bold cursor-pointer">{{ n.name }}</span>
            <template v-if="n.children.length !== 0">
              <ul class="ml-6">
                <li v-for="nn in n.children" :key="nn.id" class="py-1">
                  <span @click="readPosts(nn.id)" class="cursor-pointer">{{ nn.name }}</span>
                  <template v-if="nn.children.length !== 0">
                    <ul class="ml-4">
                      <li v-for="nnn in nn.children" :key="nnn.id" class="py-1">
                        <span @click="readPosts(nnn.id)" class="cursor-pointer">{{ nnn.name }}</span>
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

</aside>
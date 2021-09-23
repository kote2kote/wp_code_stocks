<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_code_stocks
 */
?>

<aside class="aside flex h-screen overflow-hidden" @mouseover="catMouseOver" @mouseleave="catMouseLeave">
  <?php if( is_user_logged_in() ) {?>
  <!-- サブメニュー 左サイドバーの場合はout_lにorder-2を入れる。右サイドバーの場合は削除 -->
  <div class="out_subbar com_bg-submenu h-screen overflow-y-auto" :class="{'order-2': isSidebarLeft }" style="width: 18rem">
    <!-- <h2 class="text-sm bg-gray-600 pl-2 com_font-anton">items</h2> -->
    <ul class="pb-12">
      <!-- <li v-for="n in defaultMenuData" :key="n.id" @click="readPage(n)" class="cursor-pointer border-b border-gray-300 border-dashed p-2 hover:bg-green-700">
        <template v-if="n.tags">
          <span v-for="nn in n.tags" :key="nn.term_id">
            <template v-if="nn.slug === 'note'"><i class="fas fa-edit mr-1"></i></template>
          </span>
        </template>

        <span class="text-xs font-bold">{{ n.title.rendered }}</span>
      </li> -->

      <!-- 投稿がない時のみ表示(デフォルト表示) --------------------------------------------------->
      <template v-if="postData.length === 0">
        <!-- <li v-if="postData.length === 0" @click="readURL(`${embedURL.locationURL}/wp-admin/index.php`)" class=""><i class="fas fa-edit mr-1"></i>admin</li>
        <li v-if="postData.length === 0" @click="readURL(`${embedURL.locationURL}/wp-admin/post-new.php`)" class="cursor-pointer border-b border-gray-300 border-dashed p-2 hover:bg-green-700 text-xs font-bold"><i class="fas fa-edit mr-1"></i>new</li> -->
        <li v-for="n in allPostData" :key="n.id" @click="readPage(n)" class="cursor-pointer border-b border-gray-300 border-dashed hover:bg-green-700">
          <div class="">

            <span class="text-xs font-bold">{{ n.title}}{{n.link}}</span>
          </div>
          <div class="flex justify-end">
            <template v-if="n.tags">
              <span v-for="nn in n.tags" :key="nn.id">
                <template v-if="nn.slug === 'star'"><i class="text-yellow-400 fas fa-star mr-1"></i></template>
                <template v-if="nn.slug === 'note'"><i class="fas fa-edit mr-1"></i></template>
                <template v-else-if="nn.slug === 'code'"><i class="fas fa-code mr-1"></i></template>

              </span>
            </template>
            <span class="text-xs">{{ returnDate(n.date)}}</span>
          </div>


        </li>
      </template>

      <!-- 投稿 --------------------------------------------------->
      <li v-for="n in postData" :key="n.id" @click="readPage(n)" class="cursor-pointer border-b border-gray-300 border-dashed hover:bg-green-700">
        <div class="">


          <span class="text-xs font-bold">{{ n.title.rendered }}</span>
        </div>
        <div class="flex justify-end">
          <template v-if="n.tags">
            <span v-for="nn in n.tags" :key="nn.term_id">
              <template v-if="nn.slug === 'star'"><i class="text-yellow-400 fas fa-star mr-1"></i></template>
              <template v-if="nn.slug === 'note'"><i class="fas fa-edit mr-1"></i></template>
              <template v-else-if="nn.slug === 'code'"><i class="fas fa-code mr-1"></i></template>

            </span>
          </template>
          <span class="text-xs">{{ returnDate(n.date_gmt)}}</span>
        </div>
      </li>
    </ul>
  </div>

  <!-- メインサイドバー 左サイドバーの場合はout_rにorder-1を入れる。右サイドバーの場合は削除-->
  <div class="out_mainbar com_bg-sidebar h-screen overflow-y-auto" :class="{'order-1': isSidebarLeft }" style="width: 16rem">

    <div class="prof bg-black pb-2">
      <div class="com_font-noto font-black py-2 text-center flex items-center justify-center text-xl cursor-pointer" @click="onReset"><?php bloginfo( 'name' ); ?></div>
      <!--authorプロフィール-->
      <div class="flex px-4">
        <div class="out_avatar"><?php echo get_avatar( 1, 60 ); ?></div>
        <div class="pl-4">
          <p class="text-xs"><?php the_author_meta('user_description',1); ?></p>
          <div class="text-center pt-1">
            <!-- ソーシャルアイコン(自由に変えてください) -->
            <a class="inline-block mr-1" href="https://twitter.com/kote2" target="_blank"><i class="fab fa-twitter"></i></a>
            <a class="inline-block ml-1" href="https://github.com/kote2kote" target="_blank"><i class="fab fa-github"></i></a>
          </div>
        </div>
      </div>
      <!--/-->
    </div>
    <div class="out_search pt-2">
      <form>
        <fieldset class="submenu-search-fieldset">
          <label for="search" class="hidden">search</label>

          <div class="relative text-center">

            <input type="text" name="s" v-model="searchWord" class="appearance-none rounded-full w-40 h-8 text-xs text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="search word" />
            <button class="w-4 absolute right-7 top-2 text-black" style="" @click.prevent="onSearchSubmit">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </fieldset>
      </form>
    </div>

    <div class="out_switchSidebar py-2">
      <ul class="flex justify-center">
        <li @click="switchSidebar" class="cursor-pointer" title="サイドバー左右入れ替え"><i class="fas fa-exchange-alt"></i></li>
      </ul>
    </div>

    <!-- アイテム -->
    <div class="out_items">
      <div class="inner pt-2 pb-12">
        <ul class="text-sm">
          <li v-for="n in restCatData" :key="n.id" class="pb-6">
            <span class="inline-block font-bold com_font-noto font-black w-full cm py-1 pl-2">{{ n.name }}</span>
            <template v-if="n.children.length !== 0">
              <ul class="ml-6">
                <li v-for="nn in n.children" :key="nn.id" class="py-1">
                  <i v-if="nn.children.length !== 0" class="fas fa-chevron-right mr-2 text-xs"></i><span @click="readPosts(nn.id)" class="cursor-pointer text-sm">{{ nn.name }}</span>
                  <template v-if="nn.children.length !== 0 && checkIsOpen(nn.id)">
                    <ul class="ml-4">
                      <li v-for="nnn in nn.children" :key="nnn.id" class="py-1">
                        <i v-if="nnn.children.length !== 0" class="fas fa-chevron-right mr-2 text-xs"></i>
                        <span @click="readPosts(nnn.id)" class="cursor-pointer text-xs ">{{ nnn.name }}</span>
                        <template v-if="nnn.children.length !== 0 && checkIsOpen(nnn.id)">
                          <ul class="ml-4">
                            <li v-for="nnnn in nnn.children" :key="nnnn.id" class="py-1">
                              <span @click="readPosts(nnnn.id)" class="cursor-pointer text-xs ">{{ nnnn.name }}</span>
                            </li>
                          </ul>
                        </template>
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
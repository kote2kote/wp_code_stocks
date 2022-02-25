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
 * https://codesandbox.io/embed/restless-rgb-4rz91?fontsize=14&hidenavigation=1&theme=dark
 */

get_header();
?>
<main class="main w-full overflow-hidden" :class="[isMobileToggle ? 'w-full':'maxsm:w-1/6']">
  <!-- heder --------------------->
  <div class="bg-black text-white com_h-pageBottom w-full  py-1 pr-2 maxsm:h-8" :class="{'flex-row-reverse': !isSidebarLeft}">

    <div class="out flex justify-between">
      <div class="out_l">
        <div class="com_hamburger-btn">

          <label class='cursor-pointer w-8 h-8 bg-white inline-block flex justify-center items-center'>
            <input @click="changeMobile" type='checkbox' class='hidden' />
            <span class='el-icon relative'>&nbsp;</span>
          </label>
        </div>
      </div>
      <div class="out_r">
        <template v-if="embedURL.postId">
          <span class="inline-block h-6 mx-2">https://code-stocks.kote2.biz/archives/{{embedURL.postId}}</span>
        </template>
        <span @click="readURL(`${embedURL.locationURL}/wp-admin/index.php`)" class="cursor-pointer inline-block h-6 mx-2"><i class="fas fa-edit mr-1"></i>admin</span>
        <span @click="readURL(`${embedURL.locationURL}/wp-admin/post-new.php`)" class="cursor-pointer inline-block h-6 mx-2"><i class="fas fa-edit mr-1"></i>new</span>

        <!-- <div class="absolute w-full top-1/2  text-center">
          <a :href="`${embedURL.locationURL}/login`" target="_blank" class="inline-block h-6"><i class="fas fa-sign-in-alt mr-1"></i>login<br>
            <span>WordPressにログインしてリロードしてください</span></a>
        </div> -->


        <template v-if="embedURL.url || embedURL.postId">

          <span @click="readURL(`${embedURL.locationURL}/wp-admin/post.php?post=${embedURL.postId ? embedURL.postId : 802}&action=edit`)" class="cursor-pointer inline-block h-6 mx-2"><i class="fas fa-pen mr-1"></i>edit</span> <!-- 802は初期ページのpostID -->
          <a target="_blank" :href="`${embedURL.link ? embedURL.link : embedURL.url}`" class="inline-block mx-2 h-6"><i class="fas fa-external-link-alt mr-1"></i>view</a>

        </template>
      </div>
    </div>
  </div>

  <!-- / heder --------------------->
  <div class="inner h-full">

    <template v-if="embedURL.id && embedURL.user">
      <!-- editable=trueを入れると編集可能になるがリソースを食うのでやめておく -->
      <!-- <iframe v-if="isNote" height="100%" style="width: 100%;" scrolling="no" :src="`https://codepen.io/${embedURL.user}/embed/${embedURL.id}?default-tab=js&editable=true`" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true"></iframe> -->
      <iframe height="100%" style="width: 100%;" scrolling="no" :src="`https://codepen.io/${embedURL.user}/embed/${embedURL.id}?default-tab=html%2Cresult&editable=true`" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true"></iframe>
    </template>
    <template v-else-if="embedURL.url">
      <iframe height="100%" style="width: 100%;" :src="`${embedURL.url}`" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true"></iframe>
    </template>
    <template v-else>
      <iframe height="100%" style="width: 100%;" :src="`${embedURL.link}`" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true"></iframe>
    </template>


  </div>
</main>
<?php
get_footer();
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
<main class="main w-full h-screen overflow-hidden">
  <!-- heder --------------------->
  <div class="bg-black text-white com_h-pageBottom w-full flex py-1 pr-2 justify-end" :class="{'flex-row-reverse': !isSidebarLeft}">
    <?php if( is_user_logged_in() ) {?>
    <!-- <a :href="`${embedURL.locationURL}`" class="cursor-pointer inline-block h-6 mx-2"><i class="fas fa-sync-alt mr-1"></i></i>reload</a> -->
    <span @click="readURL(`${embedURL.locationURL}/wp-admin/index.php`)" class="cursor-pointer inline-block h-6 mx-2"><i class="fas fa-edit mr-1"></i>admin</span>
    <span @click="readURL(`${embedURL.locationURL}/wp-admin/post-new.php`)" class="cursor-pointer inline-block h-6 mx-2"><i class="fas fa-edit mr-1"></i>new</span>
    <?php } else { ?>
    <div class="absolute w-full top-1/2  text-center">
      <a :href="`${embedURL.locationURL}/login`" target="_blank" class="inline-block h-6"><i class="fas fa-sign-in-alt mr-1"></i>login<br>
        <span>WordPressにログインしてリロードしてください</span></a>
    </div>

    <?php } ?>
    <template v-if="embedURL.url || embedURL.postId">
      <?php if( is_user_logged_in() ) {?>
      <span @click="readURL(`${embedURL.locationURL}/wp-admin/post.php?post=${embedURL.postId}&action=edit`)" class="cursor-pointer inline-block h-6 mx-2"><i class="fas fa-pen mr-1"></i>edit</span>
      <a target="_blank" :href="`${embedURL.url}`" class="inline-block mx-2 h-6"><i class="fas fa-external-link-alt mr-1"></i>view</a>
      <?php } ?>
    </template>
  </div>
  <!-- / heder --------------------->
  <div class="inner h-full">
    <?php if( is_user_logged_in() ) {?>
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
    <?php }  ?>

  </div>
</main>
<?php
get_footer();
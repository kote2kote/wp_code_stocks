<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_code_stocks
 */
 ?>
</div>
<footer class="bg-black text-white com_h-pageBottom w-full flex py-1 pr-2 justify-end" :class="{'flex-row-reverse': !isSidebarLeft}">
  <?php if( is_user_logged_in() ) {?>
  <a :href="`${embedURL.locationURL}`" class="cursor-pointer inline-block h-6 mx-2"><i class="fas fa-sync-alt mr-1"></i></i>reload</a>
  <span @click="readAdmin(`${embedURL.locationURL}/wp-admin/index.php`)" class="cursor-pointer inline-block h-6 mx-2"><i class="fas fa-edit mr-1"></i>admin</span>
  <span @click="readAdmin(`${embedURL.locationURL}/wp-admin/post-new.php`)" class="cursor-pointer inline-block h-6 mx-2"><i class="fas fa-edit mr-1"></i>new</span>
  <?php } else { ?>
  <div class="absolute w-full top-1/2  text-center">
    <a :href="`${embedURL.locationURL}/login`" target="_blank" class="inline-block h-6"><i class="fas fa-sign-in-alt mr-1"></i>login<br>
      <span>WordPressにログインしてリロードしてください</span></a>
  </div>

  <?php } ?>
  <template v-if="embedURL.url || embedURL.postId">
    <?php if( is_user_logged_in() ) {?>
    <span @click="readAdmin(`${embedURL.locationURL}/wp-admin/post.php?post=${embedURL.postId}&action=edit`)" class="cursor-pointer inline-block h-6 mx-2"><i class="fas fa-pen mr-1"></i>edit</span>
    <a target="_blank" :href="`${embedURL.url}`" class="inline-block mx-2 h-6"><i class="fas fa-external-link-alt mr-1"></i>view</a>
    <?php } ?>
  </template>
</footer>
</div>

<?php wp_footer(); ?>

</body>

</html>
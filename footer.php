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
<?php 
// 右サイドバーの場合はコメントアウト
// get_sidebar();
 ?>
</div>
<footer class="bg-black text-white com_h-pageBottom w-full flex justify-end py-1 pr-2">
  <?php if( is_user_logged_in() ) {?>
  <a target="_blank" :href="`${embedURL.locationURL}/wp-admin/post-new.php`" class="inline-block h-6 mr-4"><i class="fas fa-edit mr-1"></i>new</a>
  <?php } else { ?>
  <a :href="`${embedURL.locationURL}/login`" class="inline-block h-6 mr-4"><i class="fas fa-sign-in-alt mr-1"></i>login</a>
  <?php } ?>
  <template v-if="embedURL.url && embedURL.postId">
    <?php //if( is_user_logged_in() ) : ?>
    <a target="_blank" :href="`${embedURL.locationURL}/wp-admin/post.php?post=${embedURL.postId}&action=edit`" class="inline-block h-6"><i class="fas fa-pen mr-1"></i>edit</a>
    <?php //endif; ?>
    <a target="_blank" :href="`${embedURL.url}`" class="inline-block ml-4 h-6"><i class="fas fa-external-link-alt mr-1"></i>view</a>
  </template>
</footer>
</div>

<?php wp_footer(); ?>

</body>

</html>
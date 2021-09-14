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
  <template v-if="embedURL.url && embedURL.postId">
    <a target="_blank" :href="`${embedURL.locationURL}/wp-admin/post.php?post=${embedURL.postId}&action=edit`" class="inline-block h-6"><i class="fas fa-pen"></i></a>
    <a target="_blank" :href="`${embedURL.url}`" class="inline-block ml-4 h-6"><i class="fas fa-external-link-alt"></i></a>
  </template>
</footer>
</div>

<?php wp_footer(); ?>

</body>

</html>
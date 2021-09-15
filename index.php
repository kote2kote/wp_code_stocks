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
<main class="main w-full">
  <div class="inner h-full">
    <template v-if="embedURL.id && embedURL.user">
      <!-- editable=trueを入れると編集可能になるがリソースを食うのでやめておく -->
      <!-- <iframe v-if="isNote" height="100%" style="width: 100%;" scrolling="no" :src="`https://codepen.io/${embedURL.user}/embed/${embedURL.id}?default-tab=js&editable=true`" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true"></iframe> -->
      <iframe height="100%" style="width: 100%;" scrolling="no" :src="`https://codepen.io/${embedURL.user}/embed/${embedURL.id}?default-tab=html%2Cresult&editable=true`" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true"></iframe>
    </template>
    <template v-else>
      <iframe height="100%" style="width: 100%;" :src="`${embedURL.url}`" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true"></iframe>
    </template>
  </div>
</main>
<?php
get_footer();
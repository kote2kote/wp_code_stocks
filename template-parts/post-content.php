<?php
$category = get_the_category();

// ===========> サムネイル
// if(has_post_thumbnail()) {
//   // $thumb = the_post_thumbnail('full');
//   $image_id = get_post_thumbnail_id ();
//   $image_url = wp_get_attachment_image_src ($image_id, true);
//   $thumb = $image_url[0]; // アイキャッチurlだけ取得 https://on-ze.com/archives/5621
// } else {
//   $thumb = 'https://basic.kote2.co/wp-content/uploads/2021/02/screenshot.png'; //アイキャッチを設定してなかった場合
// }
 ?>
<?php 
    $edit_post_link = get_edit_post_link(); // URLを取得
   ?>
<h1 class="com_tail"><a href="<?php echo $edit_post_link; ?>" class="inline-block p-1 border border-white text-white mr-2"><i class="fas fa-pen"></i></a><?php the_title() ?></h1>
<div class="inner pb-12 px-8">
  <div class="w-full flex pb-8">

    <?php 
// ===========> カテゴリ

$categories = get_the_category();
if(isset($categories[0])) {
?>
    <div class="inline-block"><span class="font-bold">カテゴリ: </span>
      <span><a class="relative underline" href="/category/<?php echo $categories[0]->slug?>"><?php echo $categories[0]->cat_name?></a></span>
    </div>
    <?php } ?>

    <?php 
// ===========> タグ
$tags = get_the_tags();
if(isset($tags[0])) {
  ?>
    <div class="inline-block"><span class="font-bold">タグ: </span>
      <?php
  foreach ( $tags as $tag ) {
?>
      <span><a class="relative underline" href="/tag/<?php echo $tag -> slug; ?>"><?php echo $tag -> name; ?></a></span>
      <?php
    }
    ?>
    </div>
    <?php
  } ?>


  </div>

  <?php 
  // アイキャッチ画像を設定した場合
  if(has_post_thumbnail()) { 
    $image_id = get_post_thumbnail_id ();
    $image_url = wp_get_attachment_image_src ($image_id, true);
    $thumb = $image_url[0]; // アイキャッチurlだけ取得 https://on-ze.com/archives/5621
    ?>
  <div class="text-center pb-12"><img class="inline-block" style="width: 500px;" src="<?php echo $thumb; ?>" alt=""></div>
  <?php } ?>

  <div>
    <?php the_content(); ?>
  </div>

</div>
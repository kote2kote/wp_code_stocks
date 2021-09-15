<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wp_code_stocks
 */
get_header('single');
?>
<main class="main w-full"> 
  　　<div class="inner">
    <?php if( is_user_logged_in() ) : ?>
    <div class="">

      <?php 
        while (have_posts()) {
          the_post();
          get_template_part( 'template-parts/post-content', get_post_type() );
          
        }
      ?>
    </div>
    <?php endif; ?>
  </div>
</main>
<?php
get_footer('single');
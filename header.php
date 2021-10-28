<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_code_stocks
 */
$url = home_url() . "/wp-admin";
if( !is_user_logged_in() ) {
  header("Location:" . $url );
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php wp_head(); ?>
  <!--[if lt IE 9]>
  	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/build/icons/favicon.ico" />
  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/assets/build/icons/favicon-512x512.png">
</head>

<body <?php body_class('js_body'); ?> class="overflow-hidden">

  <div class="vue_app com_h-pageTop inner flex flex-col justify-between">


    <!-- WPの管理画面にログインしているならrefを表示。vueで取得してログイン状態をvueに渡す -->
    <div ref="loginChecker" class="hidden">ログイン中</div>

    <div class="flex flex-grow" :class="{'flex-row-reverse': !isSidebarLeft }">

      <?php
    	get_sidebar();
			?>
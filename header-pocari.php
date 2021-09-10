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

global $is_dev;
global $is_prod;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
	<?php wp_head(); ?>
  <!--[if lt IE 9]>
  	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body <?php body_class('js_body'); ?>>
	<div class="Pocari inner">

<?php if($is_dev) {get_template_part('debug');} ?>
<?php if($is_dev) {?>
	<div class='inner fixed right-0 bg-red-600 text-white p-2 font-bold'>dev</div>
<?php }?>

<!-- <div class="content-outer-top"> -->
<!-- <header class="header bg-black text-white p-4 w-full">
Pocari
</header> -->
<?

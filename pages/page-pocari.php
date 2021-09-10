<?php
/**
 * Template Name: page-pocari
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wp_code_stocks
 */

get_header('pocari');

// while (have_posts()) {
//   the_post();
//   get_template_part( '0405_pocari/Hero' );
//   // get_template_part( 'template-parts/post-content', get_post_type() );
// }
get_template_part( 'pages/210405_pocari/Hero');
get_template_part( 'pages/210405_pocari/PickUp');
get_template_part( 'pages/210405_pocari/AboutScene');

get_footer('pocari');
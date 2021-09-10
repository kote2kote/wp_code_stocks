<?php
/**
 * @package wp_code_stocks
 * Template Name: page-json2
 */

// https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/get_categories
$args = array(
	'exclude' => 1
);
$categories = get_categories($args);
// $tags = get_tags();
$cat_parent_arr = array();
$cat_arr = array();
// $tag_arr = array();

// foreach($categories as $cat) {
//   $tmp_arr = array(
//     "id" => $cat->term_id,
//     "name" => $cat->cat_name,
//     "parent" => $cat->parent,
//   );
//   array_push($cat_arr, $tmp_arr);
// }

foreach($categories as $cat) {
  if($cat->parent == 0) {
    $tmp_arr = array(
      "id" => $cat->term_id,
      "name" => $cat->cat_name,
      "children" => array()
    );
    $tmp_arr3 = array();
    foreach($categories as $cat2) {
      if($cat2->parent == $cat->term_id) {
        $tmp_arr2 = array(
          "id" => $cat2->term_id,
          "name" => $cat2->cat_name,
          "parent" => $cat2->parent
        );
        // var_dump($tmp_arr);
        array_push($tmp_arr3, $tmp_arr2);
      }
    }
    $tmp_arr['children'] = $tmp_arr3;
    // echo 's';
    // echo $tmp_arr['id'];
    array_push($cat_parent_arr, $tmp_arr);
  } 
}

$arr = json_encode($cat_parent_arr);
echo $arr;

 ?>
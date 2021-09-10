<?php
/**
 * @package wp_code_stocks
 * Template Name: page-json
 */

// https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/get_categories
$args = array(
	'exclude' => 1
);
$categories = get_categories($args);
$cat_parent_arr = [];
$cat_arr = [];

foreach($categories as $cat) {
  if($cat->parent == 0) {
    $tmp_arr = [
      "id" => $cat->term_id,
      "name" => $cat->cat_name,
      "children" => []
    ];
    $tmp_arr2_tmp = [];
    foreach($categories as $cat2) {
      if($cat2->parent == $cat->term_id) {
        $tmp_arr2 = [
          "id" => $cat2->term_id,
          "name" => $cat2->cat_name,
          "parent" => $cat2->parent,
          "children" => []
      ];
        $tmp_arr3_tmp = [];
        foreach($categories as $cat3) {
          if($cat3->parent == $cat2->term_id) {
            $tmp_arr3 = [
              "id" => $cat3->term_id,
              "name" => $cat3->cat_name,
              "parent" => $cat3->parent,
              "children" => []
            ];
            // var_dump($tmp_arr);
            array_push($tmp_arr3_tmp, $tmp_arr3);
          }
        }
        // var_dump($tmp_arr);
        $tmp_arr2['children'] = $tmp_arr3_tmp;
        array_push($tmp_arr2_tmp, $tmp_arr2);
      }
    }
    $tmp_arr['children'] = $tmp_arr2_tmp;
    array_push($cat_parent_arr, $tmp_arr);
  } 
}

$arr = json_encode($cat_parent_arr);
echo $arr;

 ?>
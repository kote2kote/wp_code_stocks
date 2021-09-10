<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wp_code_stocks
 * Template Name: page-json
 */

$arr = array(
  
    [
      "id" => 21,
      "name" => "東京都",
        "municipalities" => array(
          [
            "id" => 45,
            "name" => "あきる野市",
          ],
          [
            "id" => 46,
            "name" => "三鷹市",
          ],
          [
            "id" => 47,
            "name" => "世田谷区",
          ]
        )
    ],
    [
      "id" => 38,
      "name" => "神奈川県",
        "municipalities" => array(
          [
            "id" => 24,
            "name" => "磯子区",
          ],
          [
            "id" => 41,
            "name" => "中原区",
          ],
          [
            "id" => 44,
            "name" => "神奈川区",
          ]
        )
    ],
    [
      "id" => 19,
      "name" => "埼玉県",
        "municipalities" => array(
          [
            "id" => 48,
            "name" => "さいたま市",
          ],
          [
            "id" => 57,
            "name" => "三郷市",
          ],
          [
            "id" => 50,
            "name" => "上尾市",
          ]
        )
    ],
    [
      "id" => 20,
      "name" => "千葉県",
        "municipalities" => array(
          [
            "id" => 51,
            "name" => "八千代市",
          ],
          [
            "id" => 52,
            "name" => "千葉市",
          ],
          [
            "id" => 53,
            "name" => "四街道市",
          ]
        )
    ]
  
);
$arr = json_encode($arr);
echo $arr;
 ?>
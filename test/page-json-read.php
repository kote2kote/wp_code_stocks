<?php
/*
	Template Name: page-json-read
*/

$search_pre_str = "";
$search_mu_str = "";

$search_pre_int = 0;
$search_mu_int = 0;

if( $_GET["pre"]&&$_GET["mu"]){
  $search_pre_str = htmlspecialchars($_GET["pre"]);
  $search_mu_str = htmlspecialchars($_GET["mu"]);
  $search_pre_int = (int)$_GET["pre"];
  $search_mu_int = (int)$_GET["mu"];
}

get_header(); ?>
<div class="Starter">
  <div class="inner min-h-screen">
    <h2 class="com_tail with-margin">jsonを読み込む </h2>

    <main>
      <div class="inner px-8">

        <!-- form2 --------------------------------------------------->
        <h2 class="com_tail with-margin">テスト2</h2>
        <div class="">
          <div class="js_json-form2">
            <h4 class="com_tail mb-2">エリア検索</h4>
            <form class="flex cm" method="get" :action="`./`">
              <div class="form1">
                <fieldset class="">
                  <legend class="text-gray-700">都道府県</legend>
                  <label class="block">

                    <select class="form-select block w-48 mr-12 mt-1" name="pre" v-model="selected1" @change="onChange">
                      <option disabled selected value>選択してください</option>
                      <option v-for="n in prefectureData" :key="n.id" :value="n.id">
                        {{ n.name }}
                      </option>
                    </select>
                  </label>
                </fieldset>
              </div>
              <div class="form2">
                <fieldset>
                  <legend class="text-gray-700">市区町村</legend>
                  <label class="block">

                    <select class="form-select block w-48 mt-1" name="mu" v-model="selected2" @change="onChange2">
                      <option disabled selected value>選択してください</option>
                      <template v-if="isSelected">
                        <option v-for="n in municipalitiesData" :key="n.id" :value="n.id" :name="n.id">
                          {{ n.name }}
                        </option>
                      </template>
                    </select>
                  </label>
                </fieldset>
              </div>
              <button class="bg-green-400 block ml-8 h-8 self-center" @click="onSubmit">ボタン</button>
            </form>

            <h4 class="com_tail mb-2 mt-12">沿線検索</h4>
            <form class="flex cm" method="get" :action="`./`">
              <div class="form1">
                <fieldset class="">
                  <legend class="text-gray-700">都道府県</legend>
                  <label class="block">

                    <select class="form-select block w-48 mr-12 mt-1" name="pre" v-model="selected３" @change="onChange3">
                      <option disabled selected value>選択してください</option>
                      <option v-for="n in prefectureData" :key="n.id" :value="n.id">
                        {{ n.name }}
                      </option>
                    </select>
                  </label>
                </fieldset>
              </div>
              <div class="form2">
                <fieldset>
                  <legend class="text-gray-700">沿線</legend>
                  <label class="block">

                    <select class="form-select block w-48 mt-1" name="mu" v-model="selected4" @change="onChange4">
                      <option disabled selected value>選択してください</option>
                      <template v-if="isSelected2">
                        <option v-for="n in municipalitiesData2" :key="n.id" :value="n.id" :name="n.id">
                          {{ n.name }}
                        </option>
                      </template>
                    </select>
                  </label>
                </fieldset>
              </div>
              <button class="bg-green-400 block ml-8 h-8 self-center" @click="onSubmit2">ボタン</button>
            </form>

          </div>
          <!-----------------------------------------------------------
          class
          ------------------------------------------------------------>
          <?php if( $_GET["pre"]&&$_GET["mu"] ){ ?>
          <div class="">
            <p class="my-4 text-2xl font-bold">
              <?php
                echo "p=" . $search_pre_str . "m=" . $search_mu_str;
                $cat = get_category($search_pre_int);
                echo $cat->name;             //カテゴリ名を出力
                $tag = get_tag($search_mu_int);
                echo $tag->name;        //タグ名を出力
              ?>
            </p>

            <div class="outer_map flex justify-center">
              <div id="gmap" class="inner" style="width:620px; height:400px">
                <!-- map --------------------------------------------------->
                <script type="text/javascript">
                // jsonRead3.test();

                function initMap() {
                  // ==================================================
                  // 地図表示全体の設定
                  // ==================================================
                  var map = new google.maps.Map(document.getElementById("gmap"), {
                    zoom: 10, // 1だとほぼ世界地図
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                  });
                  var w = new google.maps.InfoWindow();
                  var geocoder = new google.maps.Geocoder();
                  geocoder.geocode({
                    'address': '東京都世田谷区'
                    // 'address': '東京都墨田区' // 地図をどこを中心とするか
                  }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                      map.setCenter(results[0].geometry.location);
                    }
                  });
                  google.maps.event.addListener(map, 'click', function() {
                    w.close();
                  });

                  // ==================================================
                  // ピンの設定
                  // ==================================================
                  const url = 'http://localhost:10053/wp-json/wp/v2/posts?categories=<?php echo $search_pre_int;?>&tags=<?php echo $search_mu_int;?>'
                  async function callAxios() {
                    try {
                      const res = await fetch(new URL(url));
                      const data = await res.json();
                      console.log(data)
                      for (const n of data) {
                        (function() {
                          var company = {
                            full_name: n.title.rendered,
                            lat: '',
                            lng: '',
                            address: n.acf.cf_address
                          };

                          var clicked_icon = new google.maps.MarkerImage('https://www.tenshokudou.com/img/clicked_marker.png');

                          var marker = new google.maps.Marker({
                            map: map,
                          });
                          google.maps.event.addListener(marker, 'click', function() {
                            w.setContent(
                              '<div style="width:300px; height:100px"><div style="font-weight:bold; font-size:16px">' +
                              company.full_name +
                              '</div><div style="margin-top:10px">' +
                              '東京都' +
                              company.address +
                              '</div><div style="margin-top:10px"><a href="/detail/3764" target="_blank">企業詳細を見る</a></div></div>'
                            );
                            w.open(map, marker);
                            marker.setIcon(clicked_icon);
                          });
                          geocoder.geocode({
                              address: '東京都' + company.address,
                              // address: '〒220-0005 神奈川県横浜市西区南幸2-12-6'
                            },
                            function(results, status) {
                              if (status == google.maps.GeocoderStatus.OK) {
                                marker.setPosition(results[0].geometry.location);
                              }
                            }
                          );
                        })();
                      }
                    } catch (e) {
                      const {
                        status,
                        statusText
                      } = error.response;
                      console.log(`Error! HTTP Status: ${status} ${statusText}`);
                    }
                  }
                  callAxios();
                }
                </script>

                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAy__ZCpT3NEd7K2i3TBHAJgd66eBpFI0&callback=initMap">
                </script>
                <!-- // --------------------------------------------------->
              </div>
            </div>
            <ul>
              <?php
              // ==================================================
              // 検索結果
              // ==================================================
              $args = array(

                // -- 記事のタイプ --------------------
                'post_type' => 'post', 
                // 'post_type' => 'page', 
                // 'post_type' => 'nav_menu_item', 
                // 'post_type' => 'hero_slider', // 

                // -- オプション --------------------
                'cat' => $search_pre_int,
                'category__not_in' => 1, // acfのカテゴリと未定義は除く
                // 'category__not_in' => array(1, 4),//2,4以外
                'tag_id' => $search_mu_int,
                // 's' => $search_word,
                'posts_per_page' => 10, // -1は全て
                'no_found_rows' => false, //true => ページングを使用しない
              );

              $the_query = new WP_Query($args);
                if ($the_query->have_posts()) {
                  while ($the_query->have_posts()) {
                    $the_query->the_post();
                    get_template_part( 'template-parts/list-content', get_post_format());
                  }
                }
                wp_reset_postdata();

              ?>
            </ul>
          </div>
          <?php } ?>

        </div>
        <!-- phpでタグ名からタグidを拾うテスト --------------------------------------------------->
        <h3 class="com_tail with-margin">タグ名からタグidを拾う(php</h3>
        <h4 class="com_tail with-margin">通常</h4>

        <!-- 通常 --------------------->
        <ul class="">
          <?php 
            $tags = get_tags();
            // var_dump($tags);
            foreach($tags as $tag){
              if(strstr($tag->name, '千葉')){ // 千葉が入ってる文字列を検索
                $tag_name  = preg_replace("/( |　)/", "", $tag->name ); // 半角スペースを削除
                $tag_name = str_replace('タクシー求人千葉', '', $tag_name);// 「タクシー求人千葉」を削除
               ?>
          <li><?php  echo $tag_name . '('.$tag->term_id.')'; // 八千代市(74)... ?></li>
          <?php
              }
            }
          ?>
        </ul>

        <!-- テスト1 --------------------------------------------------->
        <h2 class="com_tail with-margin">テスト1</h2>
        <div class="">
          <form class="flex js_json-form">
            <div class="form1">
              <fieldset class="">
                <legend class="text-gray-700">都道府県</legend>
                <label class="block">

                  <select class="form-select block w-48 mr-12 mt-1" @change="onChange">
                    <option disabled selected value>選択してください</option>
                    <option v-for="n in jsonData" :key="n.id" :value="n.id">
                      {{ n.name }}
                    </option>
                  </select>
                </label>
              </fieldset>
            </div>
            <div class="form2 w-24">
              <fieldset>
                <legend class="text-gray-700">市区町村</legend>
                <label class="block">

                  <select class="form-select block w-48 mt-1">
                    <option>選択してください</option>
                    <template v-if="isSelected">
                      <option v-for="n in jsonData2" :key="n.id" :value="n.id">
                        {{ n.name }}
                      </option>
                    </template>
                  </select>
                </label>
              </fieldset>
            </div>
            <button></button>
          </form>
        </div>

        <!-- Vueで処理する場合 --------------------------------------------------->
        <h3 class="com_tail with-margin">Vueで処理する場合</h3>
        <div class="js_json-read">
          <ul v-if="jsonData && jsonData.length">
            <li v-for="n in jsonData" :key="n.id">
              {{ n.name }}
            </li>
          </ul>
        </div>

        <!-- phpで処理する場合 --------------------------------------------------->
        <h3 class="com_tail with-margin">phpで処理する場合</h3>
        <div class="">
          <?php 
				$url= 'http://localhost:10053/test/page-json/';
				$json = file_get_contents($url);
				$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
				$arr = json_decode($json,true);
				echo $arr[0]['name'];
					// var_dump($arr);
					
					 ?>
          <h4 class="com_tail with-margin">var_dump</h4>
          <div class="">
            <?php 
						 var_dump($arr);
						  ?>
          </div>
        </div>

      </div>
      <!-- /.main_inner -->
    </main>
  </div>
</div>
<?php get_footer(); ?>
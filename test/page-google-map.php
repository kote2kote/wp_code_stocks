<?php
/*
	Template Name: page-google-map
*/
get_header('starter'); ?>
<div class="Starter">
  <div class="inner min-h-screen pb-12">
    <h2 class="com_tail with-margin">Google Map</h2>
    <main>
      <div class="inner">
        <h3 class="com_tail with-margin">メイン</h3>
        <div class="map">
          <!-- <script src="http://maps.google.com/maps/api/js?key=AIzaSyAAy__ZCpT3NEd7K2i3TBHAJgd66eBpFI0&language=ja"></script>
					<div id="map" class="h-64"></div>
					<script>
						var MyLatLng = new google.maps.LatLng(35.6811673, 139.7670516);
						var Options = {
							zoom: 15, //地図の縮尺値
							center: MyLatLng, //地図の中心座標
							mapTypeId: 'roadmap' //地図の種類
						};
						var map = new google.maps.Map(document.getElementById('map'), Options);
					</script> -->
        </div>

        <div class="outer_map">
          <div id="gmap" style="width:620px; height:400px"></div>

          <script type="text/javascript">
          // function initMap() {
          // 	var opts = {
          // 		zoom: 15,
          // 		center: new google.maps.LatLng(35.709984,139.810703)
          // 	};
          // 	var map = new google.maps.Map(document.getElementById("gmap"), opts);
          // }
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
            // ピンポイントの設定
            // ==================================================

            // --------------------------------------------------
            // 砧公園
            // --------------------------------------------------
            (function() {
              var company = {
                full_name: 'ここは名前です',
                lat: '',
                lng: '',
                address2: '<?php echo '世田谷区'?>',
                address3: '砧公園1-1-11',
                address4: '',
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
                  company.address2 +
                  company.address3 +
                  company.address4 +
                  '</div><div style="margin-top:10px"><a href="/detail/3764" target="_blank">企業詳細を見る</a></div></div>'
                );
                w.open(map, marker);
                marker.setIcon(clicked_icon);
              });
              geocoder.geocode({
                  address: '東京都' + company.address2 + company.address3 + company.address4,
                  // address: '〒220-0005 神奈川県横浜市西区南幸2-12-6'
                },
                function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                    marker.setPosition(results[0].geometry.location);
                  }
                }
              );
            })();

            // --------------------------------------------------
            // 吉村家
            // --------------------------------------------------
            (function() {
              var company = {
                "full_name": "家系総本山 吉村家",
                "lat": "35.46848554853079",
                "lng": "139.61755308156478",
                "address2": "横浜市西区",
                "address3": "南幸２丁目１２−６",
                "address4": ""
              };


              var clicked_icon = new google.maps.MarkerImage('https://www.tenshokudou.com/img/clicked_marker.png');

              var marker = new google.maps.Marker({
                map: map,
              });
              google.maps.event.addListener(marker, "click", function() {
                w.setContent(
                  '<div style="width:300px; height:100px"><div style="font-weight:bold; font-size:16px">' +
                  company.full_name + '</div><div style="margin-top:10px">' +
                  '神奈川県' + company
                  .address2 + company.address3 + company.address4 +
                  '</div><div style="margin-top:10px"><a href="/detail/79" target="_blank">企業詳細を見る</a></div></div>'
                );
                w.open(map, marker);
                marker.setIcon(clicked_icon);
              });
              marker.setPosition(new google.maps.LatLng(company.lat, company.lng));

            })();
          }
          </script>

          <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAy__ZCpT3NEd7K2i3TBHAJgd66eBpFI0&callback=initMap">
          </script>

        </div>


      </div>
      <!-- /.main_inner -->
    </main>
  </div>
</div>
<?php get_footer(); ?>
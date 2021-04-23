/*********************************
*	
*	下記URLから緯度経度を求める
*	http://www.geocoding.jp/
*	
*	下記のapiも読み込む
*	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
*
*********************************/

//ここにどこの地図なのかのコメントを入れる
google.maps.event.addDomListener(window,'load',function(){
	//1. 緯度経度を取得する
	var lat = 44.019523;  //緯度
	var lng = 144.263644; //軽度

	//2. 項目を設定する(必要があれば)
	var latlng = new google.maps.LatLng(lat, lng); 
	var mapOptions = { 
		zoom: 15, 
		center: latlng, 
		mapTypeId: google.maps.MapTypeId.ROADMAP, 
		scaleControl: true,
		scrollwheel: false //スクロールでの動作を無効
	};

	//3. 表示するID(css)をgetElementByIdに指定する
	var mapObj = new google.maps.Map(document.getElementById('google_map'), mapOptions); 

	var marker = new google.maps.Marker({ 
		position: latlng, 
		map: mapObj 
	}); 
});

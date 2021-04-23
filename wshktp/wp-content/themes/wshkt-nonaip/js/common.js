$(function(){

//クリック範囲拡張
//------------------------------------
$(".click_area").click(function(){
////外部リンクにも対応
if($(this).find("a").attr("target")=="_blank"){
window.open($(this).find("a").attr("href"), '_blank');
}else{
window.location=$(this).find("a").attr("href");
}
return false;

$(this).css("cursor","pointer");
});
//------------------------------------

//画像hover時に透明
//------------------------------------
$("a img").hover(function(){
$(this).stop().fadeTo("fast", 0.7); // マウスオーバー時にmormal速度で、透明度を60%にする
},function(){
$(this).stop().fadeTo("normal", 1.0); // マウスアウト時にmormal速度で、透明度を100%に戻す
});
//h1の場合は透過しないように(主にロゴ用)
$("#header_in a img").hover(function(){
$(this).stop().fadeTo("fast", 1.0); // マウスオーバー時にmormal速度で、透明度を60%にする
},function(){
$(this).stop().fadeTo("normal", 1.0); // マウスアウト時にmormal速度で、透明度を100%に戻す
});

//------------------------------------

//トップblogboxhover時に透明
//------------------------------------
$("#top .blogbox").hover(function(){
$(this).stop().fadeTo("fast", 0.7); // マウスオーバー時にmormal速度で、透明度を60%にする
},function(){
$(this).stop().fadeTo("normal", 1.0); // マウスアウト時にmormal速度で、透明度を100%に戻す
});

//記事詳細ではホバーしても透明にしない
//$("#single .blogbox").hover(function(){
//$(this).stop().fadeTo("fast", 1.0); // マウスオーバー時にmormal速度で、透明度を60%にする
//},function(){
//$(this).stop().fadeTo("normal", 1.0); // マウスアウト時にmormal速度で、透明度を100%に戻す
//});
//------------------------------------

//ランキングhover時に透明
//------------------------------------
$(".ranking").hover(function(){
$(this).stop().fadeTo("fast", 0.7); // マウスオーバー時にmormal速度で、透明度を60%にする
},function(){
$(this).stop().fadeTo("normal", 1.0); // マウスアウト時にmormal速度で、透明度を100%に戻す
});

//------------------------------------

//サイドバーメニューのアコーディオン展開
//------------------------------------
//var $sub_cat = $(".category ul li ul");

//$sub_cat.hide();
//$(".accordion.down").click(function(){
//$(this).stop().next($sub_cat).slideToggle();
//$(this).toggleClass("up");
//});
//------------------------------------


//ページ内スクロール
//------------------------------------
$('a[href^=#]').click(function() { 
// リンク先の位置取得
var targetY = $($(this).attr('href')).offset().top;
// スムーズスクロール
$('html,body').animate({scrollTop: targetY}, 500, 'swing');
return false;
});

//ページトップスクロール
////複数使用する際はclassで1つの場合はidで作成
$(".top_scroll").click(function () {
$('html,body').animate({ scrollTop: 0 }, 'swing');
return false;
});

$(document).ready(function(){
// hide go_top first
$('#top_scroll').hide();
});

//一定時間スクロールがない場合にページトップを表示する
var showPageTopTimer;
$(window).scroll(function () {
$('#top_scroll').fadeOut();
clearTimeout(showPageTopTimer);
showPageTopTimer = setTimeout(function(){
showPageTop();
},1000);
});

//ページトップを表示する
function showPageTop(){
if ($(this).scrollTop() > 100) {
$('#top_scroll').fadeIn();
}
}
//------------------------------------

//bxslider
//------------------------------------
// $('.bxslider').bxSlider({
//   auto:true,
//   speed:3000,
//   pause:3000,
//   touchEnabled: true,// スワイプでページ送り有効
//   pager: true, // PAGER
// });
//------------------------------------



//スライドショー plugin::bxslider.js　使用しない場合はコメントアウト
//------------------------------------
// $('#slides').bxSlider({
// 	//mode:'fade',
// 	auto:true,
// 	speed:1000,
// 	pause:4000,
// 	pager:true,
// 	controls:false,
// 	captions: false,
// 	touchEnabled: true
// });
	//$('#img2 , #img3').delay(3000).css('display','block');
//------------------------------------


//class:aligncenterがついているimgがaタグで囲われている際に<div class="center"></div>を追加
//クリック範囲を画像内におさめる
//------------------------------------
$(function(){
	$("a img.aligncenter").parent("a").wrap('<div class="center"></div>');
});
//------------------------------------



// サイトアクセス時に非表示にしてから、フェードインさせる
//------------------------------------
// var fade_content = $('#main');

// fade_content.hide()
// fade_content.fadeIn(1000);

// // リンククリック時にフェードアウトしてから、画面遷移する
// $('a').click(function(){
// // URLを取得する
// var url = $(this).attr('href');

// // URLが空ではない場合
// if (url != '') {
// // フェードアウトしてから、取得したURLにリンクする
// fade_content.fadeOut(1000);
// setTimeout(function(){
// location.href = url;
// }, 1000);
// }
// return false;

// });
//------------------------------------

/****************************************************
*wordpress用
****************************************************/
//imgタグに自動でpタグが付くのを阻止
// $('p img').unwrap();
// 空のspan要素を消す
$("span:empty").remove();
// 空のp要素を消す
$("p:empty").remove();
});//jQuery END


//スクロールの途中で要素を表示
//------------------------------------
$(window).scroll(function(){

//固定する要素のCSSを変数へ代入
var $fix = $(".btm_fix");

var $scroll_num = jQuery(this).scrollTop();
if($scroll_num >= 700) {
	$fix.css("position","fixed");
	$fix.css("bottom","-8px");

	//固定要素を表示
	$fix.fadeIn();
}else{
	$fix.css("position","fixed");
	$fix.css("bottom","-8px");
	//固定要素を非表示
	$fix.fadeOut();
}
});
//------------------------------------



/*ーーーーーーーーーーーーーーーーーーーーーーーーー
SVGを使えるサイトの場合はSVGを、そうでない場合はsrc内の画像形式を表示　※Modernizr使用

例）
<img src="images/logo.svg" data-no-svg="images/logo.png" alt="logo" width="226" height="100" />
ーーーーーーーーーーーーーーーーーーーーーーーーー*/
//Modernizr.jsを使用してsvgが使用できるか判別
// if (!Modernizr.svg){
// var imgzr = $("img[data-no-svg]")
// imgzr.each(function() {
// //svgが使用できない場合はsrcにdata-no-svgの値を代入
// ////data-no-svg => data("noSvg") ハイフンを取ってキャメルケースになる
// $(this).attr("src",$(this).data("noSvg"));
// });
// }




// フォーム確認ボタンを制御
$(function(){

consent = $.cookie("consent");

if (consent == 'YES') {
	$("#btn_consent").hide();
	$("#agree-1").attr('checked', true);
};


$("#agree-1").click(function(){

	
	if($(this).prop('checked')){
		$("#btn_consent").fadeOut();
		$.cookie("consent" , "YES" , { expires: 7,  path: "/" });
	}else{
		$("#btn_consent").fadeIn();
		$.removeCookie("consent" , { path: "/" });
	}

	
});



});

// テスト用
jQuery( function( $ ) {
$( '#mw_wp_form_mw-wp-form-345 select option[value=""]' )
.html( '選択してください。' );
} );

// 本番用
jQuery( function( $ ) {
$( '#mw_wp_form_mw-wp-form-386 select option[value=""]' )
.html( '選択してください。' );
} );

// スライダー
$(function(){
    $setElm = $('.wideslider');
    baseWidth = 1000;
    baseHeight = 340;
    minWidth = 320;
	slideSpeed = 3000;
	delayTime = 6000;
	easing = 'easeOutQuint';
    autoPlay = '1'; // notAutoPlay = '0'
    flickMove = '1'; // notFlick = '0'
    btnOpacity = 0.5;
    pnOpacity = 0.5;
    ua = navigator.userAgent;
$(window).load(function(){$setElm.find("img").css({display:"block"}),$setElm.each(function(){function t(){if(windowWidth=$(window).width(),findList=d.find("li"),setParts=$setElm,setWrapLeft=parseInt(d.css("left")),setlistWidth=findList.find("img").width(),setLeft=setWrapLeft/setlistWidth,windowWidth<baseWidth){if(windowWidth>minWidth){findList.css({width:windowWidth});var t=findList.find("img").height();findList.css({height:t}),setParts.css({height:t})}else if(windowWidth<=minWidth){findList.css({width:minWidth});var t=findList.find("img").height();findList.css({height:t}),setParts.css({height:t})}}else windowWidth>=baseWidth&&(findList.css({width:baseWidth,height:baseHeight}),setParts.css({height:baseHeight}));if(setWidth=findList.find("img").width(),setHeight=findList.find("img").height(),baseWrapWidth=setWidth*f,ulCount=d.find("ul").length,1==ulCount){var e=d.children("ul");e.clone().prependTo(d),e.clone().appendTo(d),d.children("ul").eq("1").addClass("mainList");var i=d.find(".mainList").children("li");i.eq("0").addClass("mainActive"),allListCount=d.find("li").length}allLWrapWidth=setWidth*allListCount,posAdjust=(windowWidth-setWidth)/2,n.css({left:posAdjust,width:setWidth,height:setHeight}),h.css({left:-posAdjust,width:posAdjust,height:setHeight,opacity:btnOpacity}),c.css({right:-posAdjust,width:posAdjust,height:setHeight,opacity:btnOpacity}),d.css({width:allLWrapWidth,height:setHeight}),d.children("ul").css({width:baseWrapWidth,height:setHeight}),posResetNext=2*-baseWrapWidth,posResetPrev=-baseWrapWidth+setWidth,adjLeft=setWidth*setLeft,d.css({left:adjLeft})}function e(){s=setInterval(function(){c.click()},delayTime)}function i(){var t=p.find("a.active");t.each(function(){var t=v.index(this),e=d.find(".mainList").children("li");e.removeClass("mainActive").eq(t).addClass("mainActive")})}var s,a=$(this);a.children("ul").wrapAll('<div class="wideslider_base"><div class="wideslider_wrap"></div><div class="slider_prev"></div><div class="slider_next"></div></div>');var n=a.find(".wideslider_base"),d=a.find(".wideslider_wrap"),h=a.find(".slider_prev"),c=a.find(".slider_next"),l=$('<div class="pagination"></div>');a.append(l);var o=d.find("li"),r=d.find("li").children("a"),f=d.find("li").length;o.each(function(t){$(this).css({width:baseWidth,height:baseHeight}),l.append('<a href="javascript:void(0);" class="pn'+(t+1)+'"></a>')});var p=a.find(".pagination");t(),d.css({left:-baseWrapWidth});var v=l.children("a"),u=l.children("a:first"),g=l.children("a:last"),m=l.children("a").length;if(-1!=ua.search(/iPhone/)||-1!=ua.search(/iPad/)||-1!=ua.search(/iPod/)||-1!=ua.search(/Android/)?v.css({opacity:pnOpacity}):v.css({opacity:pnOpacity}).hover(function(){$(this).stop().animate({opacity:"1"},300)},function(){$(this).stop().animate({opacity:pnOpacity},300)}),u.addClass("active"),v.click(function(){"1"==autoPlay&&clearInterval(s);var t=v.index(this),a=setWidth*t+baseWrapWidth;d.stop().animate({left:-a},slideSpeed,easing),v.removeClass("active"),$(this).addClass("active"),i(),"1"==autoPlay&&e()}),"1"==autoPlay&&e(),c.click(function(){d.not(":animated").each(function(){"1"==autoPlay&&clearInterval(s);var t=parseInt($(d).css("left")),a=t-setWidth;d.stop().animate({left:a},slideSpeed,easing,function(){var t=parseInt($(d).css("left"));t<=posResetNext&&d.css({left:-baseWrapWidth})});var n=l.children("a.active");n.each(function(){var t=v.index(this),e=t+1;m==e?(n.removeClass("active"),u.addClass("active")):n.removeClass("active").next().addClass("active")}),i(),"1"==autoPlay&&e()})}).hover(function(){$(this).stop().animate({opacity:btnOpacity+.1},100)},function(){$(this).stop().animate({opacity:btnOpacity},100)}),h.click(function(){d.not(":animated").each(function(){"1"==autoPlay&&clearInterval(s);var t=parseInt($(d).css("left")),a=t+setWidth;d.stop().animate({left:a},slideSpeed,easing,function(){var t=parseInt($(d).css("left")),e=posResetNext+setWidth;t>=posResetPrev&&d.css({left:e})});var n=l.children("a.active");n.each(function(){var t=v.index(this),e=t+1;1==e?(n.removeClass("active"),g.addClass("active")):n.removeClass("active").prev().addClass("active")}),i(),"1"==autoPlay&&e()})}).hover(function(){$(this).stop().animate({opacity:btnOpacity+.1},100)},function(){$(this).stop().animate({opacity:btnOpacity},100)}),$(window).on("resize",function(){"1"==autoPlay&&clearInterval(s),t(),"1"==autoPlay&&e()}).resize(),"1"==flickMove){var W="ontouchstart"in window;d.on({"touchstart mousedown":function(t){d.is(":animated")?t.preventDefault():("1"==autoPlay&&clearInterval(s),-1==ua.search(/iPhone/)&&-1==ua.search(/iPad/)&&-1==ua.search(/iPod/)&&-1==ua.search(/Android/)&&t.preventDefault(),this.pageX=W?event.changedTouches[0].pageX:t.pageX,this.leftBegin=parseInt($(this).css("left")),this.left=parseInt($(this).css("left")),this.touched=!0)},"touchmove mousemove":function(t){this.touched&&(t.preventDefault(),this.left=this.left-(this.pageX-(W?event.changedTouches[0].pageX:t.pageX)),this.pageX=W?event.changedTouches[0].pageX:t.pageX,$(this).css({left:this.left}))},"touchend mouseup mouseout":function(t){if(this.touched){this.touched=!1;var s=l.children("a.active"),a=parseInt(o.css("width")),n=-(a*(f-1));this.leftBegin-30>this.left&&this.leftBegin!==n?($(this).stop().animate({left:this.leftBegin-a},slideSpeed,easing,function(){var t=parseInt($(d).css("left"));t<=posResetNext&&d.css({left:-baseWrapWidth})}),s.each(function(){var t=v.index(this),e=t+1;m==e?(s.removeClass("active"),u.addClass("active")):s.removeClass("active").next().addClass("active")}),i()):this.leftBegin+30<this.left&&0!==this.leftBegin?($(this).stop().animate({left:this.leftBegin+a},slideSpeed,easing,function(){var t=parseInt($(d).css("left")),e=posResetNext+setWidth;t>=posResetPrev&&d.css({left:e})}),s.each(function(){var t=v.index(this),e=t+1;1==e?(s.removeClass("active"),g.addClass("active")):s.removeClass("active").prev().addClass("active")}),i()):$(this).stop().animate({left:this.leftBegin},slideSpeed,easing),compBeginLeft=this.leftBegin,compThisLeft=this.left,r.click(function(t){compBeginLeft!=compThisLeft&&t.preventDefault()}),"1"==autoPlay&&e()}}})}setTimeout(function(){t()},500)})});
});




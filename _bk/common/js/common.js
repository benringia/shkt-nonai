// ロールオーバー
$(function() {
	$("img.imgover").mouseover(function(){
		$(this).attr("src",$(this).attr("src").replace(/^(.+)(\.[a-z]+)$/, "$1_o$2"));
	}).mouseout(function(){
		$(this).attr("src",$(this).attr("src").replace(/^(.+)_o(\.[a-z]+)$/, "$1$2"));
	}).each(function(){
		$("<img>").attr("src",$(this).attr("src").replace(/^(.+)(\.[a-z]+)$/, "$1_o$2"));
	});
});

//カレント表示
$(function(){
	var url = window.location.pathname;
	var url = "/"+url.split("/")[1]+"/";
	$('#gnav li a[href="'+url+'"]').parent().addClass('current');
});
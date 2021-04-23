<footer>
    <div id="footer" class=" flex  wrap">
        <div class="flex">
            <p><a href="<?php echo home_url( '/' ); ?>"><img src="<?php echo home_url( '/' ); ?>common/images/logo_wh.png" width="258" height="33" alt="昭和大学江東豊洲病院 脳神経内科"/></a></p>
            <address>
   <p>〒135-8577 東京都江東区豊洲5-1-38<br>
       TEL：03-6204-6000（代表）</p>
   </address>
        </div>
        <ul class="flex">
            <li><a href="<?php echo home_url( '/' ); ?>outline/index.html">病院概要</a></li>
            <li><a href="http://www.showa-u.ac.jp/SHKT/privacy/" target="_blank">個人情報保護方針</a></li>
            <li><a href="<?php echo home_url( '/' ); ?>sitemap/index.html">サイトマップ</a></li>
        </ul>
    </div>
    <div id="copyright">Copyright © 2015 昭和大学江東豊洲病院 脳神経内科 All Rights Reserved.</div>
</footer>
<?php wp_footer(); ?>

<!-- Googleアナリティクス -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-70253887-1', 'auto');
	  ga('send', 'pageview');

	</script>
	
   <script src="<?php echo home_url( '/' ); ?>common/js/jquery-2.1.3.min.js"></script>
    <script src="<?php echo home_url( '/' ); ?>common/js/scrollsmoothly.js" type="text/javascript"></script>
    <script src="<?php echo home_url( '/' ); ?>common/js/zdo_drawer_menu.js" type="text/javascript"></script>
<script src="<?php echo home_url( '/' ); ?>common/js/jquery.colorbox.js"></script>
<script src="<?php echo home_url( '/' ); ?>common/carousel/js/owl.carousel.min.js"></script>

<script>
          $('.carousel').owlCarousel({
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3500,
            autoplayHoverPause: true,
            nav: true,
            arrows:true,
            margin: 10,
            
            responsive:{
            0:{
                items:1
            },
            576:{
              items:1
            },
            768:{
                items:5
            }
        }
    
          })
</script>



<script>
          $('.carousel-alt').owlCarousel({  
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3500,
            autoplayHoverPause: true,
            nav: true,
            arrows:true,
            margin: 20,          
            responsive:{
            0:{
                items: 2
            },
            570: {
                items: 3
            },
            768:{
                items: 5
            }
        }
    
          })
</script>



<script>
//トップに戻るボタン
$(document).ready(function() {
  var pagetop = $('.pagetop');
    $(window).scroll(function () {
       if ($(this).scrollTop() > 100) {
            pagetop.fadeIn();
       } else {
            pagetop.fadeOut();
            }
       });
       pagetop.click(function () {
           $('body, html').animate({ scrollTop: 0 }, 500);
              return false;
   });
});
			
			
//数字カウント
$(function(){
    var countElm = $('.count'),
    countSpeed = 10;
 
    countElm.each(function(){
        var self = $(this),
        countMax = self.attr('data-num'),
        thisCount = self.text(),
        countTimer;
 
        function timer(){
            countTimer = setInterval(function(){
                var countNext = thisCount++;
                self.text(countNext);
 
                if(countNext == countMax){
                    clearInterval(countTimer);
                }
            },countSpeed);
        }
        timer();
    });
  });


			
//ヘッダーにクラスを付ける
$(function() {
  var $win = $(window),
      $header = $('header'),
      animationClass = 'is-animation';

  $win.on('load scroll', function() {
    var value = $(this).scrollTop();
    if ( value > 50 ) {
      $header.addClass(animationClass);
    } else {
      $header.removeClass(animationClass);
    }
  });
});
	
	
	
//下からふわっとアニメーション
$(function(){
    $(window).scroll(function (){
        $('.fadein').each(function(){
            var elemPos = $(this).offset().top;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            if (scroll > elemPos - windowHeight + 200){
                $(this).addClass('scrollin');
            }
        });
    });
});
			
//アコーディオンメニュー
$(function(){
	$(".accordionbox dt").on("click", function() {
		$(this).next().slideToggle();	
		// activeが存在する場合
		if ($(this).children(".accordion_icon").hasClass('active')) {			
			// activeを削除
			$(this).children(".accordion_icon").removeClass('active');				
		}
		else {
			// activeを追加
			$(this).children(".accordion_icon").addClass('active');			
		}			
	});
});

//横スクロールする画像
/*$(function(){
		$('#infiniteslide').infiniteslide({
	speed:65,
	pauseonhover: false
			});
	});*/


//サイドメニュー固定
$(function(){
    var target = $("#side_box");
    if (typeof target.offset() === 'undefined') {
        return;
    }

    var footer = $("footer")
    var targetHeight = target.outerHeight(true);
    var targetTop = target.offset().top;
 
    $(window).scroll(function(){
        var scrollTop = $(this).scrollTop();
        if(scrollTop > targetTop){
            // 動的にコンテンツが追加されてもいいように、常に計算する
            var footerTop = footer.offset().top;
             
            if(scrollTop + targetHeight > footerTop){
                customTopPosition = footerTop - (scrollTop + targetHeight)
                target.css({position: "fixed", top:  customTopPosition + "px"});
            }else{
                target.css({position: "fixed", top: "105px"});
            }
        }else{
            target.css({position: "static", top: "auto"});
        }
    });
});


	
//ポップアップ	
var windowWidth = $(window).width();
var windowSm = 640;
if (windowWidth <= windowSm) {
    $(document).ready(function(){
$(".iframe").colorbox({iframe:true,width:"90%",height:"90%",minWidth:"90%"});
});
} else {
    $(document).ready(function(){
$(".iframe").colorbox({iframe:true,width:"1000px",height:"90%",minWidth:"1000px"});
});
}
</script>
</body>
</html>
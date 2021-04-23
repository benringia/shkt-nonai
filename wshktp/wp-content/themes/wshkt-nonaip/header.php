<html lang="ja">
<head>
	<!-- maximum-scaleの数値を1にすると拡大縮小しなくなる -->
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes" /> -->
<meta name="viewport" content="width=1100">
	<!-- <meta name="format-detection" content="telephone=no"> -->

	<meta charset="UTF-8">
	<meta name="keywords" content="脳神経内科">

	<!-- css_Area -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/common.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/layout.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/print.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/jquery.bxslider.css">



	<?php wp_deregister_script('jquery'); ?>
	<!-- WordPressのjQueryを読み込ませない --> 

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.1.3.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/masonry.pkgd.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/common.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.bxslider.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>




	<!-- ランキングタイトル制限 -->
	<script>
	$(function(){
	    var $setElm = $('.ttl_box a');
	    var cutFigure = '15'; // カットする文字数
	    var afterTxt = ' …'; // 文字カット後に表示するテキスト
	 
	    $setElm.each(function(){
	        var textLength = $(this).text().length;
	        var textTrim = $(this).text().substr(0,(cutFigure))
	 
	        if(cutFigure < textLength) {
	            $(this).html(textTrim + afterTxt).css({visibility:'visible'});
	        } else if(cutFigure >= textLength) {
	            $(this).css({visibility:'visible'});
	        }
	    });
	});
	</script>

	<!-- googleアナリティクス -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-70253887-1', 'auto');
	  ga('send', 'pageview');

	</script>



	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/backgroundSize.js"></script>
	<script>
	$(function() {
	$('#present_area').css( "background-size", "cover" );
	//$('#present_area').css( "background-size", "contain" );
	});
	</script>

	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/selectivizr-min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/PIE.js"></script>
	<script>
		$(function() {
			if (window.PIE) {
				//下記のセレクタにPIE.jsを適用させる
				$('#header').each(function() {PIE.attach(this);});
			}
		});
	</script>
	<![endif]-->
	
<title><?php wp_title(' '); ?><?php if ( wp_title(' ', false) ) { echo ''; } ?> <?php bloginfo('name'); ?></title>



<?php wp_head(); ?>
</head>
<?php if(is_home()): ?>
	<body id="top">

<?php endif; ?>

<?php if(is_page()): ?>
	<body id="page">

<?php endif; ?>

<?php if(is_single()): ?>
	<body id="single">

<?php endif; ?>

<?php if(is_archive()): ?>
	<body id="page">

<?php endif; ?>

<!-- //////////////////// HEADER START //////////////////// -->
<div id="header">
	<div id="header_in">
		<?php if(is_home()): ?>
		<h1><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" height="65" width="323" alt="昭和大学江東豊洲病院 脳神経内科"></a></h1>
		<?php else: ?>
		<div><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" height="65" width="323" alt="昭和大学江東豊洲病院 脳神経内科"></a></div>
		<?php endif; ?>
	<div class="sitemap_link">
		<ul>
			<li><a href="<?php echo home_url(); ?>/company">病院概要</a></li>
			<li><a href="<?php echo home_url(); ?>/sitemap">サイトマップ</a></li>
		</ul>
	</div>
	</div>



	<div id="nav" class="clearfix">
		<ul class="clearfix">
			<li><a href="<?php echo home_url(); ?>/recruit">医局員募集</a></li>
			<li><a href="<?php echo home_url(); ?>/greeting">ご挨拶</a></li>
			<li><a href="<?php echo home_url(); ?>/work">我々のしごと</a></li>
			<li><a href="<?php echo home_url(); ?>/member">診察医のご紹介</a></li>
			<li><a href="<?php echo home_url(); ?>/schedule">今後のスケジュール</a></li>
			<li><a href="<?php echo home_url(); ?>/contact">お問い合わせ</a></li>
		</ul>
		
	</div>


</div>
<!-- /#header -->
<!-- //////////////////// HEADER END //////////////////// -->
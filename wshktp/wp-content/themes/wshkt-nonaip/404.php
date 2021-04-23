<?php get_header(); ?>

<!--//////////////////// visual START ////////////////////-->
<div class="page_404">
<div id="visual_wrap" class="clearfix">
	<div class="visual_in page_visual">
		<h2><span>404 Not Found</span></h2>
	</div>

	<div><?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?></div>	

</div>

<!--//////////////////// visual START ////////////////////-->

<!-- //////////////////// MAIN START //////////////////// -->
<div id="wrapper" class="clearfix">
<div id="main" class="clearfix">	

<!--//////////////////// CONTENT START ////////////////////-->
<div id="content" class="page_404">
	<div class="column page_cont clearfix">

	<p>大変申し訳ございません。<br>お探しのページは見つかりませんでした。</p>

	<p>入力していただいたアドレスを、もう一度お確かめください。</p>

	<p>
		正しいアドレスを入力してもページが表示されない場合は、
		ページが移動したか、アドレスが変更になっている可能性があります。
	</p>

	</div><!-- /.column -->
</div>
<!--//////////////////// CONTENT END ////////////////////-->

<?php get_sidebar(); ?>
</div><!-- /#main -->
</div><!-- /#wrapper -->
<!-- //////////////////// MAIN END //////////////////// -->

<?php get_footer(); ?>

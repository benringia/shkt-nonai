<?php
/*
Template Name: スタッフ募集
*/
?>


<?php get_header(); ?>

<!--//////////////////// visual START ////////////////////-->
<div id="visual_wrap" class="recruit clearfix">
	<div class="visual_in">
		<h1><img src="<?php echo get_template_directory_uri(); ?>/images/staff_header.png" width="1000" alt="チームスタッフ募集"></h1>
	</div>
	<div><?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?></div>	
</div>
<!--//////////////////// visual START ////////////////////-->

<!-- //////////////////// MAIN START //////////////////// -->
<div id="wrapper" class="clearfix">
<div id="main" class="clearfix">	


<!--//////////////////// CONTENT START ////////////////////-->
<div id="content">
	
	<h2><img src="images/staff_key.png" width="1000" alt="ともに働く仲間を募集します"></h2>





	<div class="column clearfix"></div><!-- /.column -->
</div>
<!--//////////////////// CONTENT END ////////////////////-->




</div><!-- /#main -->
</div><!-- /#wrapper -->
<!-- //////////////////// MAIN END //////////////////// -->

<?php get_footer(); ?>

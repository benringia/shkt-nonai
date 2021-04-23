<?php get_header(); ?>

<!--//////////////////// visual START ////////////////////-->
<div id="visual_wrap" class="clearfix">
	<div class="visual_in page_visual">
		<h1><span><?php the_title(); ?></span></h1>
	</div>

	<div><?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?></div>	

</div>
<!--//////////////////// visual START ////////////////////-->

<!-- //////////////////// MAIN START //////////////////// -->
<div id="wrapper" class="clearfix">
<div id="main" class="clearfix">	

<!--//////////////////// CONTENT START ////////////////////-->
<div id="content">
	<div class="column page_cont clearfix">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="page_ttl">
			<h3><span><?php the_title(); ?></span></h3>
			<?php the_content(); ?>
		</div>

	<?php endwhile;endif; ?>
</div><!-- /.column -->
</div>
<!--//////////////////// CONTENT END ////////////////////-->

<?php get_sidebar(); ?>
</div><!-- /#main -->
</div><!-- /#wrapper -->
<!-- //////////////////// MAIN END //////////////////// -->

<?php get_footer(); ?>

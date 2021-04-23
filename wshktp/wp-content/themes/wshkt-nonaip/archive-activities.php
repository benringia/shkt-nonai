<?php get_header(); ?>

<!--//////////////////// visual START ////////////////////-->
<div id="visual_wrap" class="clearfix">
	<div class="visual_in page_visual">
		<h2><span><?php the_title(); ?></span></h2>
	</div>
</div>
<!--//////////////////// visual START ////////////////////-->

<!-- //////////////////// MAIN START //////////////////// -->
<div id="wrapper" class="clearfix">
<div id="main" class="clearfix">	


<!--//////////////////// CONTENT START ////////////////////-->
<div id="content">
	<div class="column clearfix">
		<div class="blogbox">
			<?php if(have_posts()): while(have_posts()): the_post(); ?>
			<?php query_posts('post_type=activities'); ?>
			<h2><span class="cat_name <?php echo $cat->category_nicename; ?>"><?php echo $cat->cat_name; ?></span></h2>
			<img src="<?php echo get_template_directory_uri(); ?>/images/thumb01.png" height="139" width="230" alt="">
			<div>
				<p class="date"><?php the_time(m.'月'.d'日'); ?></p>
				<h3><?php the_title(); ?></h3>
				<p class="blog_txt"><?php the_content(); ?></p>	
			</div>
		</div>
	</div><!-- /.column -->
</div>
<?php endif; ?>
 
</div><!-- end of .events_contents -->
<?php endwhile; endif; ?>
<!--//////////////////// CONTENT END ////////////////////-->

<?php get_sidebar(); ?>
</div><!-- /#main -->
</div><!-- /#wrapper -->
<!-- //////////////////// MAIN END //////////////////// -->

<?php get_footer(); ?>

<?php get_header(); ?>

<!--//////////////////// visual START ////////////////////-->
<div id="visual_wrap" class="clearfix">


<?php
 $pt = $post->post_type ;?>


<?php if ($pt == 'news'): ?>
	<div class="visual_in page_visual">
		<h2><span><?php the_title(); ?></span></h2>
	</div>

<?php else: ?>
	<div class="visual_in">
		<div><span></span></div>
	</div>
<?php endif ?>


	





<div><?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?></div>	

</div>
<!--//////////////////// visual START ////////////////////-->

<!-- //////////////////// MAIN START //////////////////// -->
<div id="wrapper" class="clearfix">
<div id="main" class="clearfix">	


<!--//////////////////// CONTENT START ////////////////////-->
<div id="content">
	<div class="column clearfix">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php if(has_post_thumbnail()): //アイキャッチがあるとき?>
<div class="blogbox">
			<div class="blog_cat"><span class="cat_name <?php echo esc_html(get_post_type_object(get_post_type())->name); ?>">
			<?php echo esc_html(get_post_type_object(get_post_type())->label ); ?>
			</span></div>
			<p class="thumbnail-box"><?php the_post_thumbnail('single_thumbnail'); ?></p>
			<div>
				<p class="date"><?php the_time(m.'月'.j.'日'); ?></p>
				<h1>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<span><?php the_field('投稿者'); ?></span>
				</h1>
				<p class="blog_txt"><?php the_content(); ?></p>	
			</div>
		</div>

<?php else: //アイキャッチがいないとき?>
   <div class="blogbox">
			<div class="blog_cat blogbox"><span class="cat_name <?php echo esc_html(get_post_type_object(get_post_type())->name); ?>">
			<?php echo esc_html(get_post_type_object(get_post_type())->label ); ?>
			</span></div>
			<div class="no_image">
				<p class="date"><?php the_time(m.'月'.j.'日'); ?></p>
				<h1>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<span><?php the_field('投稿者'); ?></span>
				</h1>
				<p class="blog_txt"><?php the_content(); ?></p>	
			</div>
		</div>
<?php endif; ?>

	<?php endwhile;endif; ?>
	</div><!-- /.column -->
	
	<div class="navigation">
		<span class="previous"><?php previous_post_link('%link','&laquo; 前の記事を見る'); ?></span>
		<span class="next"><?php next_post_link('%link','次の記事を見る &raquo;'); ?></span>
	</div>
	<!-- <div class="btn_report"><a href="<?php echo home_url(); ?>/report">ドクターズレポート一覧に戻る</a></div> -->

</div>
<!--//////////////////// CONTENT END ////////////////////-->

<?php get_sidebar(); ?>
</div><!-- /#main -->
</div><!-- /#wrapper -->
<!-- //////////////////// MAIN END //////////////////// -->

<?php get_footer(); ?>

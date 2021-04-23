
<?php get_header(); ?>

<!--//////////////////// visual START ////////////////////-->
<div id="visual_wrap" class="clearfix">
	<div class="visual_in">
		<h1><span></span></h1>
	</div>
	<div><?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?></div>	
</div>
<!--//////////////////// visual START ////////////////////-->

<!-- //////////////////// MAIN START //////////////////// -->
<div id="wrapper" class="clearfix">
<div id="main" class="clearfix">	


<!--//////////////////// CONTENT START ////////////////////-->
<div id="content">
	<div class="column clearfix">


<?php
$temp = $wp_query;
$wp_query = null;

$args = array(
	'post_type' => array('activity'),
	'posts_per_page' => 6,
	'paged' => $paged
);

$wp_query = new WP_Query($args);
//投稿の場合：post、カスタム投稿の場合：投稿タイプ名

$page_num = 20;

while ( $wp_query->have_posts() ) : $wp_query->the_post();
?>


<?php 
$my_content = get_the_content();
$my_content = preg_replace("|(<img[^>]+>)|si","",$my_content);
$my_content = mb_strimwidth($my_content,0,400, "…");

?>




<?php if(has_post_thumbnail()): //アイキャッチがあるとき?>
<div class="blogbox click_area">
			<h2><a href="<?php the_permalink(); ?>"><span class="cat_name <?php echo esc_html(get_post_type_object(get_post_type())->name); ?>">
			<?php echo esc_html(get_post_type_object(get_post_type())->label ); ?>
			</span></a></h2>
			<p class="thumbnail-box"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('page_thumbnail'); ?></a></p>
			<div>
				<p class="date"><?php the_time(m.'月'.j.'日'); ?></p>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<div class="blog_txt"><?php echo $my_content; ?></div>	
			</div>
			<p class="read_more <?php echo $pt;?>"><a href="<?php the_permalink(); ?>">詳しく見る</a></p>
		</div>
<?php else: //アイキャッチがいないとき?>
   <div class="blogbox click_area">
			<h2 class="tal"><a href="<?php the_permalink(); ?>"><span class="cat_name <?php echo esc_html(get_post_type_object(get_post_type())->name); ?>">
			<?php echo esc_html(get_post_type_object(get_post_type())->label ); ?>
			</span></a></h2>
			<div class="no_image">
				<p class="date"><?php the_time(m.'月'.j.'日'); ?></p>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<div class="blog_txt"><?php echo $my_content; ?></div>	
			</div>
			<p class="read_more <?php echo $pt;?>"><a href="<?php the_permalink(); ?>">詳しく見る</a></p>
		</div>
<?php endif; ?>

<?php endwhile; ?>
<?php if ( class_exists( 'WP_SiteManager_page_navi' ) ) { WP_SiteManager_page_navi::page_navi('prev_label=< Prev&next_label=Next >'); } ?>
<?php wp_reset_query(); ?>	
	</div><!-- /.column -->
</div>
<!--//////////////////// CONTENT END ////////////////////-->

<?php get_sidebar(); ?>
</div><!-- /#main -->
</div><!-- /#wrapper -->
<!-- //////////////////// MAIN END //////////////////// -->

<?php get_footer(); ?>

<?php get_header(); ?>

<!--//////////////////// visual START ////////////////////-->
<div id="visual_wrap" class="seminar clearfix">
	<div class="visual_in">
		<h1><img src="<?php echo get_template_directory_uri(); ?>/images/main_visual03.png" width="1000" alt="今後のスケジュール"></h1>
	</div>
	<div><?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?></div>	
</div>
<!--//////////////////// visual START ////////////////////-->

<!-- //////////////////// MAIN START //////////////////// -->
<div id="wrapper" class="clearfix seminar_page">
<div id="main" class="clearfix">	


<!--//////////////////// CONTENT START ////////////////////-->
<div id="content">
	<div class="column clearfix">


<?php
$temp = $wp_query;
$wp_query = null;

$args = array(
	'post_type' => array('seminar'),
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



<?php if( have_rows('seminar') ): ?>
	<?php while( have_rows('seminar') ): the_row(); ?>
	
	<div class="seminar_box">
		<h2><?php the_title(); ?></h2>
		<table>
			<tr>
				<th>日付</th>
				<td><?php the_sub_field('seminar_date'); ?></td>
			</tr>
			<?php if (get_sub_field('seminar_url')) : ?>
			<tr>
				<th>URL</th>
				<td class="link"><a href="<?php the_sub_field('seminar_url'); ?>"><?php the_sub_field('seminar_url'); ?></a></td>
			</tr>
			<?php else : ?>
			<?php endif; ?>
			<tr>
				<th>概要</th>
				<td><?php the_sub_field('seminar_outline'); ?></td>
			</tr>
		</table>
	</div>

	<?php endwhile; ?>
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

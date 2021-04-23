

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


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

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

<?php endwhile;endif; ?>


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

<?php get_header(); ?>

<script>
// $(window).load(function(){
// $('.grid').masonry({
//   // options
//   itemSelector: '.grid-item',
// });
// });
</script>



<!--//////////////////// visual START ////////////////////-->
<!--
	<div id="visual_wrap" class="clearfix">
		<div class="visual_in">
				<img src="<?php echo get_template_directory_uri(); ?>/images/main_visual.png" height="340" width="1000" alt="脳神経内科のことちょっとづつ知っていただきたい。そんな思いが詰まったサイトです。">
		</div>
	</div>
 -->

<div class="wideslider">
    <ul>
    <li><a href="<?php echo home_url(); ?>/work"><img src="<?php echo get_template_directory_uri(); ?>/images/main_visual.png" alt="脳神経内科のことちょっとづつ知っていただきたい。そんな思いが詰まったサイトです。" /></a></li>
    <li><a href="<?php echo home_url(); ?>/recruit"><img src="<?php echo get_template_directory_uri(); ?>/images/main_visual02.png" alt="チームスタッフ募集共に働く仲間を募集しています" /></a></li>
    <li><a href="<?php echo home_url(); ?>/schedule"><img src="<?php echo get_template_directory_uri(); ?>/images/main_visual03.png" alt="今後のスケジュール" /></a></li>
    </ul>
</div><!--/.wideslider-->


<!--//////////////////// visual START ////////////////////-->

<!-- //////////////////// MAIN START //////////////////// -->
<div id="wrapper" class="clearfix">
<div id="main" class="clearfix">

<!--//////////////////// CONTENT START ////////////////////-->
<div id="content">
	<div class="column grid clearfix">

<?php
$temp = $wp_query;
$wp_query = null;

$args = array(
	'post_type' => array('illness','activity','dayreport','staff','news','kamiyadc'),
	'posts_per_page' => 21,
	'paged' => $paged
);

$wp_query = new WP_Query($args);
//投稿の場合：post、カスタム投稿の場合：投稿タイプ名

$page_num = 20;

while ( $wp_query->have_posts() ) : $wp_query->the_post();
?>

		<div class="blogbox grid-item column3 click_area">
		<?php if(has_post_thumbnail()): ?>
			<?php the_post_thumbnail('top_thumbnail'); ?>
		<?php else: //アイキャッチがいないとき?>
			<?php echo '<img src="' . get_bloginfo('template_directory') . '/images/logo_thumb_top.jpg' . '"width="230" alt="thumbnail" />'; ?>
		<?php endif; ?>
			<p class="date"><?php the_time(m.'月'.j.'日'); ?></p>
			<div class="blogtxt">
				<h2><a href="<?php the_permalink(); ?>"><span class="cat_name <?php echo esc_html(get_post_type_object(get_post_type())->name); ?>">
						<?php echo esc_html(get_post_type_object(get_post_type())->label ); ?></span></a></h2>

				<?php if(post_custom('投稿者')): ?>
					<h3>
						<a href="<?php the_permalink(); ?>">
							<?php
							if(mb_strlen($post->post_title, 'UTF-8')>25){
								$title= mb_substr($post->post_title, 0, 25, 'UTF-8');
								echo $title.'…';
							}else{
								echo $post->post_title;
							}
							?>
						</a>
						<span><?php the_field('投稿者'); ?></span>
					</h3>
				<?php else : ?>
					<h3>
						<a href="<?php the_permalink(); ?>">
							<?php
							if(mb_strlen($post->post_title, 'UTF-8')>25){
								$title= mb_substr($post->post_title, 0, 25, 'UTF-8');
								echo $title.'…';
							}else{
								echo $post->post_title;
							}
							?>
						</a>
					</h3>
					<?php 
						$content = get_the_content();
						$content = strip_tags($content);
						$content = str_replace('&nbsp;', " ", $content);
						$content = mb_strimwidth($content,0,100, "…");
					?>
					<div class="txtbox"><?php echo $content; ?></div>
				<?php endif; ?>
			</div>
		</div>
<?php endwhile; ?>

	</div><!-- /.column -->
</div>
<!--//////////////////// CONTENT END ////////////////////-->

<?php get_sidebar(); ?>
</div><!-- /#main -->
</div><!-- /#wrapper -->
<!-- //////////////////// MAIN END //////////////////// -->

<?php get_footer(); ?>


<script>
$(function(){
    var $setElm = $('.ttl_box li a');
    var cutFigure = '15'; // カットする文字数
    var afterTxt = ' …'; // 文字カット後に表示するテキスト

    $setElm.each(function(){
        var textLength = $(this).text().length;

        var textTrim = $(this).text().substr(0,(cutFigure));
 
        if(cutFigure < textLength) {
            $(this).html(textTrim + afterTxt).css({visibility:'visible'});
        } else if(cutFigure >= textLength) {
            $(this).css({visibility:'visible'});
        }
    });
});



</script>


<!--//////////////////// SIDEBAR START ////////////////////-->
<div id="sidebar" class="clearfix">


<!-- ピックアップ記事出力 -->
<div class="rank_box pick_box clearfix">
	<h4><img src="<?php echo get_template_directory_uri(); ?>/images/ico_pic_ttl.png" width="18" alt="PicUpBlog">Pick&nbsp;Up&nbsp;Blog</h4>
	        <?php
	$temp = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query();
	//投稿の場合：post、カスタム投稿の場合：投稿タイプ名 
	$args = Array(
	            'post_type' => array('illness','activity','dayreport','staff','news','kamiyadc'),
	            'posts_per_page' => 5,
	            'meta_query' => array(
	                array(
	                    'key' => 'PickUp',
	                    'value' => 'PickUpBlogに表示する',
	                    'compare' => 'LIKE'
	                )
	             )
	        );
	$wp_query = new WP_Query($args);
	while ( $wp_query->have_posts() ) : $wp_query->the_post();
	?>

					<div class="pick_box_in clearfix click_area">
						<p class="pic_img_ico"><img src="<?php echo get_template_directory_uri(); ?>/images/ico_picup.png" alt="PickUp" width="45"></p>

						<?php if(has_post_thumbnail()): ?>
							<p class="pic_img"><?php the_post_thumbnail('pic-up'); ?></p>
						<?php else: //アイキャッチがいないとき?>
							<?php echo '<img src="' . get_bloginfo('template_directory') . '/images/logo_thumb_top.jpg' . '"width="107" alt="thumbnail" />'; ?>
						<?php endif; ?>

						<div class="pic_cont clearfix">
							<h5>
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
							</h5>
							<p class="date"><?php the_time('Y.m.d'); ?></p>
						</div>
					</div>

	<?php endwhile; ?>
	<?php wp_reset_query(); ?>
</div>
<!-- //ピックアップ記事出力 -->


<div class="rank_box clearfix">
	<h4><img src="<?php echo get_template_directory_uri(); ?>/images/ico_ranking.png" width="18" alt="記事ランキング">記事ランキング</h4>
<?php dynamic_sidebar('サイドバー右'); ?>
</div>


	<div class="cat_box clearfix">
		<div>
			<h4><img src="<?php echo get_template_directory_uri(); ?>/images/ico_category.png" width="13" alt="記事カテゴリー">記事カテゴリー</h4>
			<ul>
				<li><a href="<?php echo home_url(); ?>/report/activity-page">学会の活動</a></li>
				<li><a href="<?php echo home_url(); ?>/report/illenes-page">病気のこと</a></li>
				<li><a href="<?php echo home_url(); ?>/report/dayreport-page">入局・研修について</a></li>
				<li><a href="<?php echo home_url(); ?>/report/staff-page">スタッフから</a></li>
				<li><a href="<?php echo home_url(); ?>/report/kamiyadc-page">管理者より</a></li>
			</ul>
		</div>
	</div>

	<?php if(is_page(report)): ?>
    <?php elseif(is_archive()): ?>
	<?php elseif(is_page("activity-page")): ?>
	<?php elseif(is_page("illenes-page")): ?>
	<?php elseif(is_page("dayreport-page")): ?>
	<?php elseif(is_page("staff-page")): ?>
	<?php elseif(is_page("kamiyadc-page")): ?>
	<?php elseif(is_single()): ?>
    <?php else : ?>
    <div class="bnrbox report">
		<a href="<?php echo home_url(); ?>/report"><img src="<?php echo get_template_directory_uri(); ?>/images/side_bnr_report.png" width="269" alt="ドクターズレポート脳内手帳"></a>
	</div>
    <?php endif; ?>

	<div class="bnrbox">
		<a href="<?php echo home_url(); ?>/member"><img src="<?php echo get_template_directory_uri(); ?>/images/side_bnr_syoukai.png" width="269" alt="診察医のご紹介"></a>
	</div>
	<?php if(is_page(schedule)): ?>
	<?php elseif(is_archive(archive-seminar)): ?>
	<?php else : ?>
	<div class="bnrbox">
		<a href="<?php echo home_url(); ?>/schedule"><img src="<?php echo get_template_directory_uri(); ?>/images/side_schedule.png" width="269" alt="今後のスケジュール"></a>
	</div>
	<?php endif; ?>
	
	<div class="bnrbox">
	<a href="http://www.showa-u.ac.jp/SHKT/"><img src="<?php echo get_template_directory_uri(); ?>/images/side_bnr_news.png" width="269" alt="病院からのお知らせ"></a>
	</div>

</div>
<!--//////////////////// SIDEBAR END ////////////////////-->

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
	<div class="rank_box clearfix">
		<h4><img src="<?php echo get_template_directory_uri(); ?>/images/ico_ranking.png" width="18" alt="記事ランキング">記事ランキング</h4>
	<?php dynamic_sidebar('サイドバー右'); ?>
		
	</div>

	<div class="cat_box clearfix">
		<div>
			<h4><img src="<?php echo get_template_directory_uri(); ?>/images/ico_category.png" width="13" alt="記事カテゴリー">記事カテゴリー</h4>
			<ul>
				<li><a href="<?php echo home_url(); ?>/activity-page">学会の活動</a></li>
				<li><a href="<?php echo home_url(); ?>/illenes-page">病気のこと</a></li>
				<li><a href="<?php echo home_url(); ?>/dayreport-page">日常のあれこれ</a></li>
				<li><a href="<?php echo home_url(); ?>/staff-page">スタッフから</a></li>
				<li><a href="<?php echo home_url(); ?>/kamiyadc-page">管理者より</a></li>
			</ul>
		</div>
	</div>

	<a href="http://www.showa-u.ac.jp/SHKT/"><img src="<?php echo get_template_directory_uri(); ?>/images/side_bnr_news.png" width="269" alt="病院からのお知らせ"></a>
</div>
<!--//////////////////// SIDEBAR END ////////////////////-->
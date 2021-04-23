<!-- //////////////////// FOOTER START //////////////////// -->
<div id="footer">
<div id="footer_in" class="clearfix">

	<div class="logo">
		<img src="<?php echo get_template_directory_uri(); ?>/images/logo_footer.png" height="57" width="256" alt="昭和大学江東豊洲病院 脳神経内科">
		<p>〒135-8577&nbsp;東京都江東区豊洲5-1-38</p>
	</div>

	<ul>
		<li><a href="<?php echo home_url(); ?>">ホーム</a></li>
		<li><a href="<?php echo home_url(); ?>/recruit">医局員募集</a></li>
		<li><a href="<?php echo home_url(); ?>/greeting">ご挨拶</a></li>
		<li><a href="<?php echo home_url(); ?>/work">我々のしごと</a></li>
		<li><a href="<?php echo home_url(); ?>/member">診察医のご紹介</a></li>
		<li><a href="http://www.showa-u.ac.jp/SHKT/">病院からのお知らせ</a></li>
		<li><a href="<?php echo home_url(); ?>/schedule">今後のスケジュール</a></li>
	</ul>

	<div class="clearfix nav02wrap">
		<ul class="footer_nav02">
			<li><a href="<?php echo home_url(); ?>/company">病院概要</a></li>
			<li><a href="http://www.showa-u.ac.jp/SHKT/privacy/">個人情報保護方針</a></li>
			<li><a href="<?php echo home_url(); ?>/contact">お問い合わせ</a></li>
		</ul>
	</div>

</div>
<div class="copywrap">
	<p class="copyright">
		copyright&copy;学校法人昭和大学allright reserved.
	</p>
</div>
</div>

<!-- //////////////////// FOOTER END //////////////////// -->

<script>
$(window).load(function () {

// $('.ttl_box').css('background','#000');

$('.ttl_box a').each(function(){
var title = $(this).text();
if (title.length>28) title = title.substring(0,28) + "…";
$(this).text(title);
});
});
</script>

<?php wp_footer(); ?>
</body>
</html>
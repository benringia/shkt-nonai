<?php
/*
Template Name: スタッフ募集
*/
?>


<?php get_header(); ?>

<!--//////////////////// visual START ////////////////////-->
<div id="visual_wrap" class="recruit clearfix">
	<div class="visual_in">
		<h1><img src="<?php echo get_template_directory_uri(); ?>/images/staff_header.png" width="1000" alt="医局員募集"></h1>
	</div>
	<div><?php if ( class_exists( 'WP_SiteManager_bread_crumb' ) ) { WP_SiteManager_bread_crumb::bread_crumb(); } ?></div>	
</div>
<!--//////////////////// visual START ////////////////////-->

<!-- //////////////////// MAIN START //////////////////// -->
<div id="wrapper" class="clearfix">
<div id="main" class="clearfix">	


<!--//////////////////// CONTENT START ////////////////////-->
<div id="content" class="recruit clearfix">
<div class="cont_bg">	
<div class="cont_inner_wrap">
	<div class="key">
		<h2><img src="<?php echo get_template_directory_uri(); ?>/images/staff_key.png" width="1000" alt="ともに働く仲間を募集します"></h2>
		<p>昭和大学江東豊洲病院脳神経内科では、我々と同じ想いをもって診療してくれる医局員を募集しています。<br>
			ご関心のある方はぜひ一度<a href="<?php echo home_url(); ?>/contact"><span>お問い合わせ</span></a>下さい。</p>
	</div>
	
	
	<div class="policy_box_wrap clearfix">
		<h3><img src="<?php echo get_template_directory_uri(); ?>/images/staff_h3_01.png" width="525" alt="私たちが大切にしているポリシー"></h3>
		<div class="policy_box clearfix">
			<h4><img src="<?php echo get_template_directory_uri(); ?>/images/staff_h4_01.png" width="248" alt="地域，そして日本の神経救急医療を担う"></h4>
			<div class="policy_box_txt">
				<p>
					<span class="pink">脳卒中のみならず、脳神経疾患の急性期を幅広く診療し</span>、内科医、神経内科医の強みを活かした包括的な診療を目指しています。<br>	
					急性期診療に興味をお持ちの熱い内科医の先生、一緒に地域、さらには日本の神経救急を担い、盛り上げてゆきましょう。</p>
			</div>
		</div>

		<div class="policy_box clearfix">
			<h4><img src="<?php echo get_template_directory_uri(); ?>/images/staff_h4_02.png" width="248" alt="手術以外はぜんぶやる"></h4>
			<div class="policy_box_txt">
				<p>
					我々は一般的な内科治療、管理に留まらず、脳血管造影、さらには脳血管内治療を自分たちで行います。また、超音波にも力を入れており、頸部血管や経頭蓋超音波などの脳神経超音波のみならず、経食道心エコーなどの循環器系超音波も我々で行い、包括的診療を行っています。<br>
					<span class="pink">手に職をつけたい内科医の先生にうってつけ</span>です。<br>
					<span class="pink">日本神経学会専門医、日本脳卒中学会専門医、日本脳神経超音波学会認定検査士の取得が可能</span>
					であり、今後は日本脳神経血管内治療学会専門医の取得もできるよう目指しています。</p>
			</div>
		</div>

		<div class="policy_box clearfix">
			<h4><img src="<?php echo get_template_directory_uri(); ?>/images/staff_h4_03.png" width="248" alt="休む時は休む"></h4>
			<div class="policy_box_txt">
				<p>
					急性期、救急というと休めない、遅くまで診療するというイメージがあるかもしれません。我々は休める時には休むことを重視しています。<br>全スタッフに規定の休暇日数を必ず取ってもらっています。<br>また、時間外労働は控え、当直明けには十分な休息が取れるよう配慮しています。
					<span class="pink">働くときは働き、休む時は休む。</span>一緒に充実した診療を行いましょう。	
					</p>
			</div>
		</div>
	</div>

	<div class="cont_box message clearfix">
		<h3><img src="<?php echo get_template_directory_uri(); ?>/images/staff_h3_02.png" width="295" alt="現場の医師から"></h3>
		<div class="message_in clearfix">
			<div class="message_left">
				<img src="<?php echo get_template_directory_uri(); ?>/images/staff_logo.jpg" width="258" alt="昭和大学江東豊洲病院">
			</div>
			<div class="message_right">
				<p>私のきっかけ</p>
				<p>医師</p>
				<p><a href="http://shkt-nonai.jp/dayreport/517">レポートを見る</a></p>
			</div>
		</div>
	</div>

	<div class="cont_box voice clearfix">
		<h3><img src="<?php echo get_template_directory_uri(); ?>/images/staff_h3_03.png" width="295" alt="STAFFの声"></h3>
		<div class="voice_in">
			<p>
				現場は医師だけでなく、技師や看護師、リハビリスタッフやMSWなど、様々なスタッフの協力関係で成り立っています。<br>
				<span class="navy">我々はチームを大事にしています。</span><br>
				実際に我々と共に働くスタッフの声もレポートで紹介しています。<br>
				様々な職種の立場から語られる脳神経内科の現場の雰囲気を是非ご覧ください。
			</p>
		</div>
		
		<div class="staff_box_wrap clearfix">
			<div class="staff_box p-right">
				<img src="<?php echo get_template_directory_uri(); ?>/images/staff_thumb01.jpg" width="228" alt="脳神経内科の友" title="">
				<p>脳神経内科の友</p>
				<p class="purple">放射線技師</p>
				<p><a href="http://shkt-nonai.jp/staff/54">レポートを見る</a></p>
			</div>
			<div class="staff_box">
				<img src="<?php echo get_template_directory_uri(); ?>/images/staff_thumb02.png" width="228" alt="患者さんの病院生活をトータルでケア" title="">
				<p>患者さんの病院生活を<br>トータルでケア</p>
				<p class="green">脳卒中リハビリテーション<br>看護認定看護師</p>
				<p><a href="http://shkt-nonai.jp/staff/286">レポートを見る</a></p>
			</div>
			<div class="staff_box p_left">
				<img src="<?php echo get_template_directory_uri(); ?>/images/staff_thumb03.png" width="228" alt="急性期から積極リハ" title="">
				<p class="dct25">急性期から積極リハ</p>
				<p class="orange">リハビリテーションスタッフ</p>
				<p><a href="http://shkt-nonai.jp/staff/51">レポートを見る</a></p>
			</div>
		</div>

		<div class="staff_box_wrap under clearfix">
			<div class="staff_box_inner clearfix">
				<div class="staff_box">
					<img src="<?php echo get_template_directory_uri(); ?>/images/staff_thumb04_2.jpg" width="228" alt="縁の下の力持ち" title="">
					<p class="dcmt">縁の下の力持ち</p>
					<p class="pink02">MSW（メディカル<br>ソーシャルワーカー）</p>
					<p><a href="http://shkt-nonai.jp/staff/542">レポートを見る</a></p>
				</div>
				<div class="staff_box">
					<img src="<?php echo get_template_directory_uri(); ?>/images/staff_thumb05.png" width="228" alt="クリニカルクラークシップ体験から" title="">
					<p>	クリニカル<br>クラークシップ体験から</p>
					<p class="yellow">医学生</p>
					<p><a href="http://shkt-nonai.jp/dayreport/516">レポートを見る</a></p>
				</div>
			</div>
		</div><!-- /.cont_box.voice -->


		<div class="staff_contact_box">
			<p>
			医師職の応募条件や選考スケジュールなどの詳細情報は、お問い合わせ後に追って御案内をさせて頂きます。<br>
			病院の見学も随時承っておりますので、まずはメールにてお問い合わせ下さい。<br>
			医師以外の職種にご関心のある方のご相談もこちらで承ります。<br>
			皆さまからのご連絡を心よりお待ちしております！
			</p>
			<div class="btn center">
				<a href="<?php echo home_url(); ?>/contact"><img src="<?php echo get_template_directory_uri(); ?>/images/staff_btn_contact.png" width="440" alt=""></a>
			</div>		
		</div>
	</div><!-- /.cont_box -->

</div><!-- /cont_inner_wrap -->
</div><!-- /cont_bg -->
</div>
<!--//////////////////// CONTENT END ////////////////////-->




</div><!-- /#main -->
</div><!-- /#wrapper -->
<!-- //////////////////// MAIN END //////////////////// -->

<?php get_footer(); ?>

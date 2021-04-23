<?php
/*
Template Name: お問い合わせ用
*/
?>


    <?php get_header(); ?>


    <!--ここからメインビジュアル-->
    <div id="hero">
        <div class="ttl-body">
            <h1><img src="<?php echo home_url( '/' ); ?>images/contact/ttl_h1.png" width="388" height="78" alt="CONTACT" /></h1>
            <h4><?php the_title(); ?></h4>
        </div>
    </div>
    <!--ここまでメインビジュアル-->

    <!--ここからコンテンツエリア-->
    <div id="contents">
        <div class="wrap">

            <!--ここからパンくず-->
            <div id="pankuzu">
                <ul class="flex">
                    <li><a href="<?php echo home_url(); ?>">HOME</a></li>
                    <li>CONTACT</li>
                </ul>
            </div>
            <!--ここまでパンくず-->

            <!--ここからメインエリア-->
            <main class="section">
            
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php the_content(); ?>
<?php endwhile;endif; ?>


<!--同意クリックで送信ボタン押せる-->
<script>
        $(function() {
  $('.submit').attr('disabled', 'disabled');
  $('#agree-1').click(function() {
    if ( $(this).prop('checked') == false ) {
      $('.submit').attr('disabled', 'disabled');
    } else {
      $('.submit').removeAttr('disabled');
    }
  });
});		
</script>



            </main>
            <!--ここまでメインエリア-->

        </div>
    </div>
    <!--ここまでコンテンツエリア-->
<?php get_footer(); ?>
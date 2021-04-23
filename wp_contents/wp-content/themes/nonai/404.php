<?php get_header(); ?>


    <!--ここからメインビジュアル-->
    <div id="not_404">
    <div id="hero">
        <div class="ttl-body">
            <h1><img src="<?php echo home_url( '/' ); ?>images/404/ttl_h1.png" width="542" height="78" alt="404 Not Found" /></h1>
            <h4>お探しのページは見つかりません。</h4>
        </div>
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
                    <li>404 Not Found</li>
                </ul>
            </div>
            <!--ここまでパンくず-->

            <!--ここからメインエリア-->
            <main class="section">
            
		<h2>お探しのページは見つかりません。</h2>
	<p class="mab40">お探しのページは削除されたか、名前が変更されたか、<br class="sp">または一時的に利用できない可能性があります。</p>

<p class="btn"><a href="<?php echo home_url(); ?>">トップページに戻る</a></p>



            </main>
            <!--ここまでメインエリア-->

        </div>
    </div>
    <!--ここまでコンテンツエリア-->
<?php get_footer(); ?>
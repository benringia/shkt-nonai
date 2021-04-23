<?php get_header(); ?>

<!-- InstanceBeginEditable name="コンテンツエリア" -->
<!--PC用メインビジュアル-->

<div id="hero" class="pc">

    <video id="video" poster="images/video/mov_moji.png" muted autoplay loop>
        <source src="images/video/mov_moji.mp4" type="video/mp4" />
        <source src="images/video/video.ogv" type="video/ogg" />
        <source src="images/video/video.webm" type="video/webm" />
       </video>


    <p class="scroll"><a href="#recruit_box"><span></span>Scroll</a></p>
</div>

<!--hero-->
<!--SP用メインビジュアル-->
<div id="hero_sp" class="sp">
    <div id="ttl_box"><img src="images/sp/ttl_main_sp.png" alt="New opportunities await you! 開いた扉の数だけ 未来が拡がる" /></div>
   <!-- <div id="visual_sp" style="background-image:url(<?php echo home_url( '/' ); ?>images/sp/img_main_sp.gif);"></div> -->
   <div id="visual_sp" style="background-image:url(<?php echo home_url( '/' ); ?>images/sp/img_main_sp.jpg);"></div>
    <p class="scroll"><a href="#recruit_box"><span></span>Scroll</a></p>
</div>
<!--hero_sp-->

<main>

    <!--ここからRECRUIT-->
    <section id="recruit_box" class="section">
        <div class="wrap">
            <h2><img src="<?php echo home_url( '/' ); ?>images/ttl_recruit.png" width="466" height="95" alt="RECRUIT!!" /></h2>
            <p class="catch">開いた扉の数だけ、未来が拡がる。<br> 我々と共に医療のスペシャリストへの
                <br class="sp"> 扉を開きませんか？
            </p>
            <ul class="flex">
                <li class="btn"><a href="<?php echo home_url( '/' ); ?>recruit/index.html">扉を開いてみる</a></li>
                <li class="btn"><a href="<?php echo home_url( '/' ); ?>blog">ブログを覗いてみる</a></li>
            </ul>
        </div>
    </section>
    <!--ここまでRECRUIT-->

    <!--ここからPOLICY-->
    <section id="policy_box">
        <div class="ttl_box parallax">
            <h2><img src="<?php echo home_url( '/' ); ?>images/ttl_policy.png" width="375" height="50" alt="POLICY" /></h2>
            <p>私たち脳神経内科は、<br class="sp"> 3つのポリシーを大切にしています。
            </p>
        </div>
        <!--ttl_box-->

        <div class="section">
            <ul class="flex wrap">
                <li class="fadein">
                    <h4>神経救急医療を<br class="pc">
                        <span>担う</span></h4>
                    <p>脳卒中のみならず、脳神経疾患の急性期を幅広く診療し、内科医、神経内科医の強みを活かした包括的な診療を目指しています。</p>
                </li>
                <li class="fadein">
                    <h4>手術以外は<br class="pc">
                        <span>全部やる</span></h4>
                    <p>我々は一般的な内科治療、管理に留まらず、脳血管造影、さらには脳血管内治療を自分たちで行います。<br> 日本神経学会専門医、日本脳卒中学会専門医、日本脳神経超音波学会認定検査士、日本脳神経血管内治療学会専門医の取得が可能です。
                    </p>
                </li>


                <li class="fadein">
                    <h4>休む時は<br class="pc">
                        <span>休む</span></h4>
                    <p>急性期、救急というと休めない、遅くまで診療するというイメージがあるかもしれません。我々は休める時には休むことを重視しています。</p>
                </li>

            </ul>
        </div>
    </section>
    <!--ここまでPOLICY-->

    <!--ここからBLOG-->
    <section id="blog_box" class="section">
        <div class="wrap">
            <div class="ttl_box">
                <h2><img src="<?php echo home_url( '/' ); ?>images/ttl_blog.png" width="375" height="50" alt="BLOG" /></h2>
                <p>脳神経内科の活動情報や、<br class="sp"> 日々の様子をお届けします。
                </p>
            </div>
            <!--ttl_box-->

            <ul id="blog_list" class="flex">


                <?php
$temp = $wp_query;
$wp_query = null;
$args = array(
	'post_type' => 'blog', //カスタム投稿名
	'posts_per_page' => 'posts_per_page', //表示する件数
);

$page_count=12; // デフォルト（PC）は12件
if(ereg("iPhone|iPod|Android.*Mobile|Windows.*Phone|dream|blackberry|CUPCAKE|webOS|incognito|webmate",$_SERVER["HTTP_USER_AGENT"])){    // ユーザーエージェント判定
    $page_count=6;  // スマホだったら6件
}
$args['posts_per_page'] = $page_count;  // １度に取得する数を書き換える

$wp_query = new WP_Query($args);
while ( $wp_query->have_posts() ) : $wp_query->the_post();
?>


                    <li>
                        <article>
                            <a href="<?php the_permalink(); ?>" class="flex">
                                <?php if( has_post_thumbnail() ): ?>
                                <div class="blog_catch">
                                    <?php the_post_thumbnail( 'full' ); ?>
                                </div>
                                <?php else: ?>
                                <div class="blog_catch"> <img src="<?php echo home_url( '/' ); ?>images/blog/img_blog_dummy.jpg" alt="ダミー画像" /></div>
                                <?php endif; ?>


                                <div class="article_r">
                                    <ul class="item">
                                        <li class="cate <?php $terms = wp_get_object_terms($post->ID, 'blog_cat'); foreach($terms as $term){echo $term->slug . '';} ?>">
                                            <?php
if ($terms = get_the_terms($post->ID, 'blog_cat')) {
    foreach ( $terms as $term ) {
        echo esc_html($term->name)  ;
    }
}
?>
                                        </li>

                                        <li class="post">
                                            <?php the_time('Y.m.d'); ?>
                                        </li>
                                    </ul>
                                    <p class="bl_ttl">
                                        <?php the_title(); ?>
                                    </p>
                                </div>
                            </a>
                        </article>
                    </li>

                    <?php endwhile; ?>

            </ul>
            <!--blog_img-->

            <p class="btn"><a href="<?php echo home_url( '/' ); ?>blog">ブログ一覧を見る</a></p>
        </div>
    </section>
    <!--ここまでBLOG-->



    <div id="parallax" class="parallax"></div>
    <!--parallax-->

    <!--ここからSCHEDULE-->
    <section id="schedule_box" class="flex column2">
        <div class="fl_l"></div>
        <!--fl_l-->
        <div class="fl_r">
            <div class="text_box">
                <h3><img src="<?php echo home_url( '/' ); ?>images/ttl_schedule.png" width="176" height="40" alt="SCHEDULE" /></h3>
                <p><b>今後のスケジュール</b></p>
                <p>今後参加予定の学会・研究会・<br class="sp"> セミナー情報を掲載
                </p>
                <p class="btn"><a href="<?php echo home_url( '/' ); ?>schedule_list">スケジュールを見る</a></p>
            </div>
            <!--text_box-->
        </div>
        <!--fl_r-->
    </section>
    <!--ここまでSCHEDULE-->

    <!--ここからINFORMATION-->
    <section id="info_box" class="flex column2">
        <div class="fl_l">
            <div class="text_box">
                <h3><img src="<?php echo home_url( '/' ); ?>images/ttl_information.png" width="246" height="40" alt="INFORMATION" /></h3>
                <p><b>病院からのお知らせ</b></p>
                <p>昭和大学江東豊洲病院のお知らせ情報</p>
                <p class="btn"><a href="http://www.showa-u.ac.jp/SHKT/" target="_blank">お知らせを見る</a></p>
            </div>
            <!--text_box-->
        </div>
        <!--fl_l-->

        <div class="fl_r"></div>
        <!--fl_r-->

    </section>
    <!--ここまでINFORMATION-->

</main>
<p class="pagetop"><a href="#header_box">PAGE TOP</a></p>
<?php get_footer(); ?>
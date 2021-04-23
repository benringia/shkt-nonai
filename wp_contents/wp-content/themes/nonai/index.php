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

    <!--ここからNEWS・AWARDS / MEDIA-->
    <section id="info_box" class="section">
        <div class="wrap flex flex-wrap">
        
        
        
        
        <div id="news_box">
        <div class="news-ttl">
            <h2 class="news-ttl"><img src="<?php echo home_url( '/' ); ?>images/ttl_news.png" alt="NEWS" /></h2>
            <p class="catch">新着情報をご紹介</p>
            </div>
            
            
            <ul id="blog_list" class="flex">


                <?php
$temp = $wp_query;
$wp_query = null;
$args = array(
	'post_type' => 'blog', //カスタム投稿名
	'posts_per_page' => 'posts_per_page', //表示する件数
'meta_query' => array(
	                array(
	                    'key' => 'news', 
	                    'value' => 'NEWSに表示する',
	                    'compare' => 'LIKE'
	                )
	             )
	        );

// $page_count=5; // デフォルト（PC）は5件
// if(ereg("iPhone|iPod|Android.*Mobile|Windows.*Phone|dream|blackberry|CUPCAKE|webOS|incognito|webmate",$_SERVER["HTTP_USER_AGENT"])){    // ユーザーエージェント判定
//     $page_count=2;  // スマホだったら2件
// }
$args['posts_per_page'] = $page_count;  // 1度に取得する数を書き換える

$wp_query = new WP_Query($args);
while ( $wp_query->have_posts() ) : $wp_query->the_post();
?>


                    <li class="w100-max">
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
                                    <ul class="item flex flex-col-max">
                                        
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

            </ul><!--blog_list-->
            </div><!--news_box-->
            
            
            
            
            <div id="news_box" class="mar-top-max">
        <div class="news-ttl">
            <h2 class="news-ttl"><img src="<?php echo home_url( '/' ); ?>images/ttl_awards.png" alt="AWARDS" /></h2>
            <p class="catch">表彰・メディア情報のご紹介</p>
            </div>
            
            
            <ul id="blog_list" class="flex">


                <?php
$temp = $wp_query;
$wp_query = null;
$args = array(
	'post_type' => 'blog', //カスタム投稿名
	'posts_per_page' => 'posts_per_page', //表示する件数
'meta_query' => array(
	                array(
	                    'key' => 'awards', 
	                    'value' => 'AWARDS / MEDIAに表示する',
	                    'compare' => 'LIKE'
	                )
	             )
	        );

// $page_count=5; // デフォルト（PC）は5件
// if(ereg("iPhone|iPod|Android.*Mobile|Windows.*Phone|dream|blackberry|CUPCAKE|webOS|incognito|webmate",$_SERVER["HTTP_USER_AGENT"])){    // ユーザーエージェント判定
//     $page_count=2;  // スマホだったら2件
// }
$args['posts_per_page'] = $page_count;  // 1度に取得する数を書き換える

$wp_query = new WP_Query($args);
while ( $wp_query->have_posts() ) : $wp_query->the_post();
?>


                    <li class="w100-max">
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
                                    <ul class="item flex flex-col-max">
                                        
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

            </ul><!--blog_blog_list-->
            </div><!--news_box-->
        
        </div>
        </section>
    <!--ここまでNEWS・AWARDS / MEDIA-->
    
    
    
    <!--ここからRESULT-->
    <section id="result_box" class="section">
        <div class="wrap hidden-max">
            <h2><img src="<?php echo home_url( '/' ); ?>images/ttl_result.png" alt="RESULT" /></h2>
            <p class="catch">昨年度の診療実績</p>
           
            <div class="flex">
            
             <div class="result_block">
                <p><img src="<?php echo home_url( '/' ); ?>images/icon_result_01.png"  alt="入院患者数のアイコン" /></p>
                <p class="result_ttl">入院患者数</p>
                <p class="count" data-num="467">0</p>
                </div>
            
                <div class="result_block">
                <p><img src="<?php echo home_url( '/' ); ?>images/icon_result_02.png"  alt="脳卒中患者数のアイコン" /></p>
                <p class="result_ttl">脳卒中患者数</p>
                <p class="count" data-num="364">0</p>
                </div>
                
                 <div class="result_block">
                <p><img src="<?php echo home_url( '/' ); ?>images/icon_result_03.png"  alt="脳卒中A救急搬送数のアイコン" /></p>
                <p class="result_ttl">脳卒中A救急搬送数</p>
                <p class="count" data-num="271">0</p>
                </div>
                
                 <div class="result_block">
                <p style="padding-left:30px;"><img src="<?php echo home_url( '/' ); ?>images/icon_result_04.png"  alt="脳梗塞急性再開通療法のアイコン" /></p>
                <p class="result_ttl">脳梗塞急性再開通療法</p>
                <p class="count" data-num="71">0</p>
                </div>
                
                
                 <div class="result_block">
                <p><img src="<?php echo home_url( '/' ); ?>images/icon_result_05.png"  alt="アルテプラーゼ静注療法 (IV tPA)のアイコン" /></p>
                <p class="result_ttl02">アルテプラーゼ静注療法<br> (IV tPA)</p>
                <p class="count" data-num="30">0</p>
                </div>
                
                
                 <div class="result_block">
                <p><img src="<?php echo home_url( '/' ); ?>images/icon_result_06.png"  alt="カテーテルによる血行再建術のアイコン" /></p>
                <p class="result_ttl02">カテーテルによる<br>血行再建術</p>
                <p class="count" data-num="57">0</p>
                </div>
                
                
                 <div class="result_block">
                <p><img src="<?php echo home_url( '/' ); ?>images/icon_result_07.png"  alt="脳血管内治療のアイコン" /></p>
                <p class="result_ttl">脳血管内治療</p>
                <p class="count" data-num="101">0</p>
                </div>
                
                
                 <div class="result_block">
                <p><img src="<?php echo home_url( '/' ); ?>images/icon_result_08.png"  alt="経食道心エコーのアイコン" /></p>
                <p class="result_ttl">経食道心エコー</p>
                <p class="count" data-num="107">0</p>
                </div>
                
                
                
            </div>
            

            

             <p class="btn"><a href="<?php echo home_url( '/' ); ?>message/index.html">詳しく見る</a></p>
            
            
        </div>

        <!-- RESULT MOBILE -->

        <div class="wrap hidden-min">
            <h2 class="result-ttl"><img src="<?php echo home_url( '/' ); ?>images/ttl_result.png" alt="RESULT" /></h2>
            <p class="catch">昨年度の診療実績</p>
           
            <div class="flex carousel-alt arw">
            
             <div class="result_block">
                <p><img class="result-img" src="<?php echo home_url( '/' ); ?>images/icon_result_01.png"  alt="入院患者数のアイコン" /></p>
                <p class="result_ttl">入院患者数</p>
                <p class="count" data-num="467">0</p>
                </div>
            
                <div class="result_block">
                <p><img class="result-img" src="<?php echo home_url( '/' ); ?>images/icon_result_02.png"  alt="脳卒中患者数のアイコン" /></p>
                <p class="result_ttl">脳卒中患者数</p>
                <p class="count" data-num="364">0</p>
                </div>
                
                 <div class="result_block">
                <p><img class="result-img" src="<?php echo home_url( '/' ); ?>images/icon_result_03.png"  alt="脳卒中A救急搬送数のアイコン" /></p>
                <p class="result_ttl">脳卒中A救急搬送数</p>
                <p class="count" data-num="271">0</p>
                </div>
                
                 <!-- <div class="result_block">
                <p class="result-img" style="padding-left:30px;"><img class="result-img" src="<?php echo home_url( '/' ); ?>images/icon_result_04.png"  alt="脳梗塞急性再開通療法のアイコン" /></p>
                <p class="result_ttl">脳梗塞急性再開通療法</p>
                <p class="count" data-num="71">0</p>
                </div> -->

                <div class="result_block">
                <p><img class="result-img mar-left-max15" src="<?php echo home_url( '/' ); ?>images/icon_result_04.png"  alt="脳梗塞急性再開通療法のアイコン" /></p>
                <p class="result_ttl">脳梗塞急性再開通療法</p>
                <p class="count" data-num="71">0</p>
                </div>
                
                
                 <div class="result_block">
                <p><img class="result-img" src="<?php echo home_url( '/' ); ?>images/icon_result_05.png"  alt="アルテプラーゼ静注療法 (IV tPA)のアイコン" /></p>
                <p class="result_ttl02">アルテプラーゼ静注療法<br> (IV tPA)</p>
                <p class="count" data-num="30">0</p>
                </div>
                
                
                 <div class="result_block">
                <p><img class="result-img" src="<?php echo home_url( '/' ); ?>images/icon_result_06.png"  alt="カテーテルによる血行再建術のアイコン" /></p>
                <p class="result_ttl02">カテーテルによる<br>血行再建術</p>
                <p class="count" data-num="57">0</p>
                </div>
                
                
                 <div class="result_block">
                <p><img class="result-img" src="<?php echo home_url( '/' ); ?>images/icon_result_07.png"  alt="脳血管内治療のアイコン" /></p>
                <p class="result_ttl">脳血管内治療</p>
                <p class="count" data-num="101">0</p>
                </div>
                
                
                 <div class="result_block">
                <p><img class="result-img" src="<?php echo home_url( '/' ); ?>images/icon_result_08.png"  alt="経食道心エコーのアイコン" /></p>
                <p class="result_ttl">経食道心エコー</p>
                <p class="count" data-num="107">0</p>
                </div>
  
            </div>

             <p class="btn pad-btm-max20"><a href="<?php echo home_url( '/' ); ?>message/index.html">詳しく見る</a></p>
        </div>
    </section>
    <!--ここまでRESULT-->
    
    
    
    
    
     <!--ここからCATHETER-->
    <section id="catheter_box" class="section">
        <div class="wrap-30">
        <div class="flex">
        
         <div class="img_box hidden-max"><img src="<?php echo home_url( '/' ); ?>images/img_catheter.png" alt="カテーテルのイメージ画像" /></div>
        
        <div class="detail_box">
     <div class="cateter_ttl">
            <h2><img src="<?php echo home_url( '/' ); ?>images/ttl_catheter.png" width="200" height="41" alt="CATHETER" /></h2>
            <p class="catch">脳血管内治療・カテーテル治療とは？</p>
       </div>
       
       <p class="cateter_text">ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。<br>
       <br>
ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。<br>
<br>
ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。ここにカテーテルについての説明文が入ります。</p>
<div class="img_box hidden-min"><img src="<?php echo home_url( '/' ); ?>images/img_catheter.png" alt="カテーテルのイメージ画像" /></div>
       </div>
        </div>
       
        </div>
</div>

    <div class="wrap">
       <div class="relation_box">
       <p class="ttl_relation">関連ブログ</p>

        <ul id="relation_list" class="flex carousel-alt">
        <?php
        $temp = $wp_query;
        $wp_query = null;
        $args = array(
            'post_type' => 'blog', //カスタム投稿名
            'posts_per_page' => 'posts_per_page', //表示する件数
        'meta_query' => array(
                            array(
                                'key' => 'kanren', 
                                'value' => '関連ブログに表示する',
                                'compare' => 'LIKE'
                            )
                        )
                    );

        $page_count=10; // デフォルト（PC）は5件
        // if(ereg("iPhone|iPod|Android.*Mobile|Windows.*Phone|dream|blackberry|CUPCAKE|webOS|incognito|webmate",$_SERVER["HTTP_USER_AGENT"])){    // ユーザーエージェント判定
        //     $page_count=2;  // スマホだったら2件
        // }
        $args['posts_per_page'] = $page_count;  // 1度に取得する数を書き換える

        $wp_query = new WP_Query($args);
        while ( $wp_query->have_posts() ) : $wp_query->the_post();
        ?>


        <li>
        <a href="<?php the_permalink(); ?>" class="flex">
        <?php if( has_post_thumbnail() ): ?>

        <div class="blog_catch">
        <?php the_post_thumbnail( 'full' ); ?>
        </div>
        <?php else: ?>
        <div class="blog_catch"> <img src="<?php echo home_url( '/' ); ?>images/blog/img_blog_dummy.jpg" alt="ダミー画像" /></div>
        <?php endif; ?>
        </a>
        <p><?php the_title(); ?></p>
        </li>
        <?php endwhile; ?>
        </ul>
        </div>
    </div>

 
</section>
    <!--ここまでCATHETER-->
    
    
   <!--ここから施設認定・専門医資格-->
    <section id="caption_box" class="section">
        <div class="wrap">
                          <div class="flex flex-column-max">
                        
                <div class="list_box">
                <p class="list_ttl">施設認定</p>
                <ul class="disc">
                <li>日本神経学会認定教育施設</li>
                <li>日本脳卒中学会認定研修教育病院</li>
                <li>日本脳神経血管内治療学会認定教育施設</li>
            </ul>
                
                </div>
                
                
                <div class="list_box">
                <p class="list_ttl">専門医資格</p>
                <ul class="disc">
                <li>日本神経学会専門医4名(うち指導医2名)</li>
<li>日本脳卒中学会専門医3名(うち代議員1名)</li>
<li>日本脳神経血管内治療学会専門医2名(うち指導医1名)</li>
<li>日本脳神経超音波学会認定検査士2名</li>
            </ul>
                
                </div>
                 </div>
                 
                 <p class="btn mar-b-max40"><a href="<?php echo home_url( '/' ); ?>message/index.html">詳しく見る</a></p>
                   </div>
                   
    </section>
    <!--ここまで施設認定・専門医資格-->
    
    
    
    

    <!--ここからPOLICY-->
    <section id="policy_box">
        <div class="ttl_box parallax">
            <h2><img src="<?php echo home_url( '/' ); ?>images/ttl_policy.png"  alt="POLICY" /></h2>
            <p>私たち脳神経内科は、<br class="sp"> 3つのポリシーを大切にしています。
            </p>
        </div>
        <!--ttl_box-->

        <div class="section">
            <ul class="hidden-max flex wrap">
                <li class="fadein">
                    <h4>神経救急医療を担う</h4>
                    <p>脳卒中のみならず、脳神経疾患の急性期を幅広く診療し、内科医、神経内科医の強みを活かした包括的な診療を目指しています。</p>
                    <p><a href="#">詳しく見る</a></p>
                </li>
                <li class="fadein">
                    <h4>手術以外は全部やる</h4>
                    <p>我々は一般的な内科治療、管理に留まらず、脳血管造影、さらには脳血管内治療を自分たちで行います。<br> 日本神経学会専門医、日本脳卒中学会専門医、日本脳神経超音波学会認定検査士、日本脳神経血管内治療学会専門医の取得が可能です。
                    </p>
                    <p><a href="#">詳しく見る</a></p>
                </li>
                <li class="fadein">
                    <h4>休む時は休む</h4>
                    <p>急性期、救急というと休めない、遅くまで診療するというイメージがあるかもしれません。我々は休める時には休むことを重視しています。</p>
                    <p><a href="#">詳しく見る</a></p>
                </li>

            </ul>
    <!-- POLICY MOBILE -->
            <div class="policy-mob wrap-margin hidden-min carousel alt">
                <div class="policy-mob-item">
                    <img src="<?php echo home_url( '/' ); ?>images/img_policy01.jpg" alt="">
                    
                    <div class="policy-mob-text">
                        <h4 class="policy-aft"> 神経救急医療を担う</h4>
                        <p>脳卒中のみならず、脳神経疾患の急性期を幅広く診療し、内科医、神経内科医の強みを活かした包括的な診療を目指しています。</p>
                        <p><a href="#">詳しく見る</a></p>
                    </div>
                </div>

                <div class="policy-mob-item">
                    <img src="<?php echo home_url( '/' ); ?>images/img_policy02.jpg" alt="">
                    <div class="policy-mob-text">
                        <h4 class="policy-aft2">手術以外は全部やる</h4>
                        <p>我々は一般的な内科治療、管理に留まらず、脳血管造影、さらには脳血管内治療を自分たちで行います。<br> 日本神経学会専門医、日本脳卒中学会専門医、日本脳神経超音波学会認定検査士、日本脳神経血管内治療学会専門医の取得が可能です。
                        </p>
                    </div>
                </div>

                <div class="policy-mob-item">
                    <img src="<?php echo home_url( '/' ); ?>images/img_policy03.jpg" alt="">
                    <div class="policy-mob-text">
                        <h4 class="policy-aft3">休む時は休む</h4>
                        <p>急性期、救急というと休めない、遅くまで診療するというイメージがあるかもしれません。我々は休める時には休むことを重視しています。</p>
                        <p><a href="#">詳しく見る</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--ここまでPOLICY-->
    
    
       <!--ここからMESSAGE-->
    <section id="message_box" class="section">
        <div class="wrap">
        <div class="detail_box">
            <h2 class="al-left"><img src="<?php echo home_url( '/' ); ?>images/ttl_message.png" alt="MESSAGE" /></h2>
            <p class="catch al-left">我々がこの地域の脳卒中・<br class="sp"> 神経救急診療を止めずに担う </p>
            <ul>
                <li class="btn"><a href="<?php echo home_url( '/' ); ?>message/index.html">代表メッセージを見る</a></li>
            </ul>
            </div>
            
            <p class="kamiya"><img src="<?php echo home_url( '/' ); ?>images/img_kamiya.png"  alt="神谷先生" /></p>
            
         </div>
    </section>
    <!--ここまでMESSAGE-->
    
    

    <!--ここからBLOG-->
    <section id="blog_box" class="section">
        <div class="wrap">
            <div class="ttl_box">
                <h2><img src="<?php echo home_url( '/' ); ?>images/ttl_blog.png" alt="BLOG" /></h2>
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
// if(ereg("iPhone|iPod|Android.*Mobile|Windows.*Phone|dream|blackberry|CUPCAKE|webOS|incognito|webmate",$_SERVER["HTTP_USER_AGENT"])){    // ユーザーエージェント判定
//     $page_count=6;  // スマホだったら6件
// }
$args['posts_per_page'] = $page_count;  // 1度に取得する数を書き換える

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
    
    
    
    
    <!--ここからRECRUIT-->
    <section id="recruit_box" class="section">
        <div class="wrap">
            <h2><img src="<?php echo home_url( '/' ); ?>images/ttl_recruit_02.png"  alt="RECRUIT!!" /></h2>
            <p class="catch">脳血管内治療、カテーテル治療の分野を<br class="sp">目指す方はこちら！</p>
            <ul class="flex">
                <li class="btn mar-right-min60"><a href="<?php echo home_url( '/' ); ?>recruit/index.html">採用情報を見る</a></li>
                <li class="btn"><a href="<?php echo home_url( '/' ); ?>contact">お問い合わせ</a></li>
            </ul>
        </div>
    </section>
    <!--ここまでRECRUIT-->



    <div id="parallax" class="parallax"></div>
    <!--parallax-->

    <!--ここからSCHEDULE-->
    <section id="schedule_box" class="flex column2">
        <div class="fl_l"></div>
        <!--fl_l-->
        <div class="fl_r">
            <div class="text_box">
                <h3><img src="<?php echo home_url( '/' ); ?>images/ttl_schedule.png" alt="SCHEDULE" /></h3>
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
                <h3><img src="<?php echo home_url( '/' ); ?>images/ttl_information.png"  alt="INFORMATION" /></h3>
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
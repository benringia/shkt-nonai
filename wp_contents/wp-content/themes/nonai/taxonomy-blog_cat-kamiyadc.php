<?php get_header(); ?>


<div id="blog">
    <!--ここからメインビジュアル-->
    <div id="hero">
        <div class="ttl-body">
            <h1><img src="<?php echo home_url( '/' ); ?>images/blog/ttl_h1.png" width="388" height="72" alt="BLOG" /></h1>
            <h4>ブログ</h4>
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
                    <li><a href="<?php echo home_url( '/' ); ?>blog">ブログ一覧</a></li>
                    <li>スタッフから</li>
                </ul>
            </div>
            <!--ここまでパンくず-->

            <!--ここからメインエリア-->
            <main class="section flex">

                <div id="blog_list">


                    <?php query_posts( array(
    'post_type' => 'blog', //カスタム投稿名
    'taxonomy' => 'blog_cat', //タクソノミー名
    'term' => 'kamiyadc',
    'posts_per_page' => 6, //表示件数（ -1 = 全件 ）
    'paged' => $paged //WP-PageNavi使用可能にする
)); ?>


<?php if(have_posts()): ?>
<?php while(have_posts()):the_post(); ?>

<article>
                        <a href="<?php the_permalink(); ?>" class="flex">

                            <?php if( has_post_thumbnail() ): ?>
                            <div class="blog_catch"><?php the_post_thumbnail( 'full' ); ?></div>
                            <?php else: ?>
                           <div class="blog_catch"> <img src="<?php echo home_url( '/' ); ?>images/blog/img_blog_dummy.jpg" alt="ダミー画像" /></div>
                            <?php endif; ?>

                            <div class="article_r">
                                <ul class="item flex">
                                    <li class="cate kamiyadc">管理者より</li>
                                    <li class="post"><?php the_time('Y.m.d'); ?></li>
                                </ul>
                                <h2><?php the_title(); ?></h2>
                                <p class="name_box"><?php the_field('post'); ?></p>
                            </div>
                            
                        </a>
                    </article>

                    <?php endwhile; else: ?> 
                    
                     <div id="blog_inner" class="blog_not">
                            <h2>ブログがありません</h2>
                            <p>「管理者より」カテゴリーのブログは、現在存在しておりません。</p>
                             <p class="btn"><a href="<?php echo home_url( '/' ); ?>">トップに戻る</a></p>
                    </div>
                    
                    <?php endif; ?>
                    <?php wp_reset_query(); ?>
                    
                    <?php wp_pagenavi(); ?>
                    
                    </div><!--blog_list-->


                



                <?php get_sidebar(); ?>
            </main>
            <!--ここまでメインエリア-->
        </div>
    </div>
    <!--ここまでコンテンツエリア-->
</div>
<!--/ #blog -->
<?php get_footer(); ?>
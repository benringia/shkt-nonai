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
                    <li>
                        <?php the_title(); ?>
                    </li>
                </ul>
            </div>
            <!--ここまでパンくず-->

            <!--ここからメインエリア-->
            <main class="section flex">
            
             <div>


                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php if(has_post_thumbnail()):  //アイキャッチ有り ?>

                
                
                <article id="blog_inner">
                    

                    <ul class="item flex">
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

                    <h1>
                        <?php the_title(); ?>
                    </h1>
                    <p class="name_box">
                        <?php the_field('post'); ?>
                    </p>
                    
                    <div id="eyecatch">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                    
                    

                    <div id="text_area">
                        <?php the_content(); ?>
                    </div>

                </article>

                <?php else : //アイキャッチ無し ?>
                <article id="blog_inner">
                    

                    <ul class="item flex">
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

                    <h1>
                        <?php the_title(); ?>
                    </h1>
                    <p class="name_box">
                        <?php the_field('post'); ?>
                    </p>
                    
                    <div id="eyecatch"><img src="<?php echo home_url( '/' ); ?>images/blog/img_blog_dummy.jpg" alt="ダミー画像" /></div>

                    <div id="text_area">
                        <?php the_content(); ?>
                    </div>

                </article>
                <?php endif; ?>
                <?php endwhile;endif; ?>
                

    
    
    <div class="navigation flex">
		<span class="previous"><?php previous_post_link('%link','&laquo; 前の記事を見る'); ?></span>
		<span class="blogtop"><a href="<?php echo home_url( '/' ); ?>blog">ブログ一覧に戻る</a></span>
		<span class="next"><?php next_post_link('%link','次の記事を見る &raquo;'); ?></span>
	</div>
    
                
                </div>
                
                


                <?php get_sidebar(); ?>


            </main>
            <!--ここまでメインエリア-->
        </div>
    </div>
    <!--ここまでコンテンツエリア-->
</div>
<!--/ #blog -->
<?php get_footer(); ?>
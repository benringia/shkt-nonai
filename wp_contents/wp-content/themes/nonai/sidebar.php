<aside id="side_bar">
<div id="side_box">
    <div id="pickup">
        <h3>ピックアップブログ</h3>
        <ul>


            <?php
	$temp = $wp_query;
	$wp_query = null;
	$wp_query = new WP_Query();
	//投稿の場合：post、カスタム投稿の場合：投稿タイプ名 
	$args = Array(
	            'post_type' => array('blog'),
	            'posts_per_page' => 5,
	            'meta_query' => array(
	                array(
	                    'key' => 'pickup',
	                    'value' => 'ピックアップブログに表示する',
	                    'compare' => 'LIKE'
	                )
	             )
	        );
	$wp_query = new WP_Query($args);
	while ( $wp_query->have_posts() ) : $wp_query->the_post();
	?>

                <li>

                    <a href="<?php the_permalink(); ?>" class="flex">


                        <?php if(has_post_thumbnail()): //アイキャッチ有り ?>
                        <div class="eyecatch">
                            <?php the_post_thumbnail('full'); ?>
                        </div>

                        <?php else: //アイキャッチ無し ?>
                        <div class="eyecatch"><img src="<?php echo home_url( '/' ); ?>images/blog/img_blog_dummy.jpg" alt="ダミー画像" /></div>
                        <?php endif; ?>





                        <div class="pickup_r">
                            <h5>
                                <?php the_title(); ?>
                            </h5>
                            <p class="post">
                                <?php the_time('Y.m.d'); ?>
                            </p>
                        </div>

                    </a>
                </li>

                <?php endwhile; ?>
                <?php wp_reset_query(); ?>


        </ul>
    </div>

    <div id="ct_list">
        <h3>ブログカテゴリー</h3>
        <ul>
           <li><a href="<?php echo home_url( '/' ); ?>blog_cat/staff">スタッフより</a></li>
                                        <li><a href="<?php echo home_url( '/' ); ?>blog_cat/activity">学会の活動</a></li>
                                        <li><a href="<?php echo home_url( '/' ); ?>blog_cat/kamiyadc">管理者より</a></li>
                                        <li><a href="<?php echo home_url( '/' ); ?>blog_cat/illness">病気のこと</a></li>
                                        <li><a href="<?php echo home_url( '/' ); ?>blog_cat/dayreport">入局・研修について</a></li>
        </ul>
    </div>
    </div>
</aside>
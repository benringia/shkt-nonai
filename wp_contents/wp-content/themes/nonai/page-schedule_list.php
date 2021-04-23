<?php
/*
Template Name: 今後のスケジュール一覧用
*/
?>


    <?php get_header(); ?>


    <!--ここからメインビジュアル-->


    <div id="hero">
        <div class="ttl-body">
            <h1><img src="<?php echo home_url( '/' ); ?>images/schedule_list/ttl_h1.png" width="388" height="72" alt="SCHEDULE" /></h1>
            <h4>今後のスケジュール</h4>
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
                    <li>SCHEDULE</li>
                </ul>
            </div>
            <!--ここまでパンくず-->

            <!--ここからメインエリア-->
            <main class="section">

<?php query_posts( array(

    'post_type' => 'schedule', //カスタム投稿名
    'posts_per_page' => 6, //表示件数（ -1 = 全件 ）
    'paged' => $paged, //WP-PageNavi使用可能にする

    'post_status'    => 'publish',
    // 'meta_key'       => 'schedule_0_schedule_date',
    // 'orderby'        => 'meta_value',
    // 'order'          => 'DESC',
)); ?>




                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <?php if( have_rows('schedule') ): ?>
                    <?php while( have_rows('schedule') ): the_row(); ?>

                    <section>

                        <h2>
                            <?php the_title(); ?>
                        </h2>
                        <table>
                                <tr>
                                    <th scope="row">日付</th>
                                    <td>
                                        <?php the_sub_field('schedule_date'); ?>
                                    </td>
                                </tr>
                                <?php if (get_sub_field('schedule_url')) : ?>
                                <tr>
                                    <th scope="row">URL</th>
                                    <td>
                                        <a href="<?php the_sub_field('schedule_url'); ?>">
                                            <?php the_sub_field('schedule_url'); ?>
                                        </a>
                                    </td>
                                </tr>
                                <?php else : ?>
                                <?php endif; ?>

                                <tr>

                                <th scope="row">概要</th>
                                <td>
                                    <?php the_sub_field('schedule_outline'); ?>
                                </td>
                                </tr>
                        </table>

                    </section>

                    <?php endwhile; ?>
                    <?php endif; ?>

                    <?php endwhile;endif; ?>

                    <?php wp_pagenavi(); ?>



            </main>
            <!--ここまでメインエリア-->

        </div>
    </div>
    <!--ここまでコンテンツエリア-->
<?php get_footer(); ?>
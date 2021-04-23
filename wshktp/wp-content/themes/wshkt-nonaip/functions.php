<?php



//wpの自動更新をストップする
add_filter( 'pre_site_transient_update_core', '__return_zero' );
remove_action( 'wp_version_check', 'wp_version_check' );
remove_action( 'admin_init', '_maybe_update_core' );

//記事の自動保存機能を停止
// function disable_autosave() {
// 	wp_deregister_script('autosave');
// }
// add_action( 'wp_print_scripts', 'disable_autosave' );

/* ログインロゴ画像 */
function login_logo() {
 echo '<style type="text/css">
 .login h1 a {
    background-image: url('.get_bloginfo('template_directory').'/images/logo_login.jpg);
    height: 92px;
    width: 244px;
    background-size: inherit;
    margin: 0 auto 0;
 }
</style>';
}
add_action('login_head', 'login_logo');

/*ーーーーーーーーーーーーーーーーーーーーーーーーー

header用　headタグ内

ーーーーーーーーーーーーーーーーーーーーーーーーー*/
//javascriptの読み込み 
//$template_url = get_bloginfo('template_directory');
	//if( !is_admin() ){
	//wp_enqueue_script( 'jquery', "{$template_url}/js/jquery-1.8.3.min.js" );
	//wp_enqueue_script( 'modernizr', "{$template_url}/js/modernizr.min.js" );
	//wp_enqueue_script( 'common', "{$template_url}/js/common.js" );
	//wp_deregister_script( 'l10n' );
//}

//ヘッダーを綺麗に
remove_action('wp_head','wp_generator');	//Wordpressのバージョン表示を削除
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );	
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

/*ーーーーーーーーーーーーーーーーーーーーーーーーー

common

ーーーーーーーーーーーーーーーーーーーーーーーーー*/

//カスタムメニュー
//register_nav_menus(array('navbar' => 'ナビゲーションバー'));

//リビジョンを無効
remove_action('pre_post_update', 'wp_save_post_revision' );

//アイキャッチを使用可能にする
add_theme_support( 'post-thumbnails' );

	//オリジナルサイズのサムネイルを作成　<?php the_post_thumbnail('my_thumbnail');
	add_image_size( 'top_thumbnail', 230, 139, true );
	add_image_size( 'page_thumbnail', 360, 288, true );
	add_image_size( 'single_thumbnail', 600, 480, true );
	add_image_size( 'pic-up', 100, 75, true);
	//add_image_size( 'case_thumb_top', 192 , 136, true );

//ログイン時に上部バーを表示、管理者以外の場合は非表示にする
function my_function_admin_bar($content) {
	return ( current_user_can("administrator") ) ? $content : false;
}
add_filter( 'show_admin_bar' , 'my_function_admin_bar');

/*ーーーーーーーーーーーーーーーーーーーーーーーーー

管理画面　投稿画面 ウィジェットetc

ーーーーーーーーーーーーーーーーーーーーーーーーー*/
//Custom CSS Widget
// add_action('admin_menu', 'custom_css_hooks');
// add_action('save_post', 'save_custom_css');
// add_action('wp_head','insert_custom_css');
// function custom_css_hooks() {
// 	add_meta_box('custom_css', 'Custom CSS', 'custom_css_input', 'post', 'normal', 'high');
// 	add_meta_box('custom_css', 'Custom CSS', 'custom_css_input', 'page', 'normal', 'high');
// }
// function custom_css_input() {
// 	global $post;
// 	echo '<input type="hidden" name="custom_css_noncename" id="custom_css_noncename" value="'.wp_create_nonce('custom-css').'" />';
// 	echo '<textarea name="custom_css" id="custom_css" rows="5" cols="30" style="width:100%;">'.get_post_meta($post->ID,'_custom_css',true).'</textarea>';
// }
// function save_custom_css($post_id) {
// 	if (!wp_verify_nonce($_POST['custom_css_noncename'], 'custom-css')) return $post_id;
// 	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
// 	$custom_css = $_POST['custom_css'];
// 	update_post_meta($post_id, '_custom_css', $custom_css);
// }
// function insert_custom_css() {
// 	if (is_page() || is_single()) {
// 	if (have_posts()) : while (have_posts()) : the_post();
// 		echo '<style type="text/css">'.get_post_meta(get_the_ID(), '_custom_css', true).'</style>';
// 		endwhile; endif;
// 		rewind_posts();
// 	}
// }

//Custom JS Widget
// add_action('admin_menu', 'custom_js_hooks');
// add_action('save_post', 'save_custom_js');
// add_action('wp_head','insert_custom_js');
// function custom_js_hooks() {
// 	add_meta_box('custom_js', 'Custom JS', 'custom_js_input', 'post', 'normal', 'high');
// 	add_meta_box('custom_js', 'Custom JS', 'custom_js_input', 'page', 'normal', 'high');
// }
// function custom_js_input() {
// 	global $post;
// 	echo '<input type="hidden" name="custom_js_noncename" id="custom_js_noncename" value="'.wp_create_nonce('custom-js').'" />';
// 	echo '<textarea name="custom_js" id="custom_js" rows="5" cols="30" style="width:100%;">'.get_post_meta($post->ID,'_custom_js',true).'</textarea>';
// }
// function save_custom_js($post_id) {
// 	if (!wp_verify_nonce($_POST['custom_js_noncename'], 'custom-js')) return $post_id;
// 	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
// 	$custom_js = $_POST['custom_js'];
// 	update_post_meta($post_id, '_custom_js', $custom_js);
// }
// function insert_custom_js() {
// 	if (is_page() || is_single()) {
// 		if (have_posts()) : while (have_posts()) : the_post();
// 			echo '<script type="text/javascript">'.get_post_meta(get_the_ID(), '_custom_js', true).'</script>';
// 		endwhile; endif;
// 		rewind_posts();
// 	}
// }

/*ーーーーーーーーーーーーーーーーーーーーーーーーー

サイトに関するfunctions

ーーーーーーーーーーーーーーーーーーーーーーーーー*/
//moreリンクを削除　続きを読むで途中から表示にならなくなる
function custom_content_more_link( $output ) {
	$output = preg_replace('/#more-[\d]+/i', '', $output );
	return $output;
}
add_filter( 'the_content_more_link', 'custom_content_more_link' );

// トップレベルの先祖ページを探す
function ps_get_root_page( $cur_post, $cnt = 0 ) {
	if ( $cnt > 100 ) { return false; }
	$cnt++;
	if ( $cur_post->post_parent == 0 ) {
		$root_page = $cur_post;
	} else {
		$root_page = ps_get_root_page( get_post( $cur_post->post_parent ), $cnt );
	}
	return $root_page;
}

/*ーーーーーーーーーーーーーーーーーーーーーーーーー

サイドバーを追加		

ーーーーーーーーーーーーーーーーーーーーーーーーー*/
register_sidebar( array(
	'name' => 'サイドバー左',
	'id' => 'sidebar_left',
	'before_widget' => '<div class="side_content %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
) );

register_sidebar( array(
	'name' => 'サイドバー右',
	'id' => 'sidebar_right',
	//'before_widget' => '<div class="side_content %2$s">',
	//'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
) );

register_sidebar( array(
	'name' => '上部バナー',
	'id' => 'top_bnr',
	'before_widget' => '<div class="side_content %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>',
) );


//the_permalinkの値を変更する
add_action ('admin_head','r6d_head');
function r6d_head() { echo '<link rel="stylesheet" href="' .get_bloginfo('template_url'). '/admin.css" type="text/css" media="all" />'."\n"; }
add_action('admin_menu', 'rd_add_box_news');
function rd_add_box_news() {
   add_meta_box('rd_box_news','新着情報リンク', 'rd_box_news', 'post', 'advanced' );
   // add_meta_box('rd_box_news','新着情報リンク', 'rd_box_news', 'カスタム投稿', 'advanced' );
}
function rd_box_news() { echo '<input type="hidden" name="rd_noncename" id="rd_noncename" value="'.wp_create_nonce('rd_nonce').'" />';　?>
<table cellpadding="0" cellspacing="0" border="0" class="rd_form_table">
    <tr>
        <th>URL</th>
        <td><input type="text" name="rd_news_url" value="<?php echo get_post_meta($_REQUEST['post'],'rd_news_url',true); ?>"  class="rd_form_text_m" /></td>
    </tr>
    <tr>
        <th>外部リンク</th>
        <td><input type="checkbox" name="rd_news_blank" value="1" class="rd_form_check" <?php if(get_post_meta($_REQUEST['post'],'rd_news_blank',true)) echo 'checked="checked"'; ?> /></td>
    </tr>
</table>
<?php }
add_action('save_post', 'rd_save_news');
function rd_save_news($post_id) {
	global $post_type;
  if ( !wp_verify_nonce( $_POST['rd_noncename'],'rd_nonce')) {
    return $post_id;
  }
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	if (!current_user_can('edit_post', $post_id)) return $post_id;

	update_post_meta($post_id,'rd_news_url',$_POST['rd_news_url']);
	update_post_meta($post_id,'rd_news_blank',$_POST['rd_news_blank']);
}



//カスタム投稿のアーカイブを作成
function my_custom_post_type_archive_where( $where, $args ){  
    $post_type  = isset( $args['post_type'] ) ? $args['post_type'] : 'post';
    $where = "WHERE post_type = '$post_type' AND post_status = 'publish'";
    return $where;
}
add_filter( 'getarchives_where', 'my_custom_post_type_archive_where', 10, 2 );



//カテゴリ一覧の記事数をリンク内に入れる
////->カテゴリのリスト(li)のカテゴリ部分(a)をdisplay:blockにしても【カテゴリ(20)】になる
add_filter( 'wp_list_categories', 'my_list_categories', 10, 2 );
function my_list_categories( $output, $args ) {
$output = preg_replace('/<\/a>\s*\((\d+)\)/',' ($1)</a>',$output);
return $output;}


//記事を登録するときに英数字の半角全角を整える
////->数字や英語は半角、カタカナなどは全角
function convert_content( $data ) {
$convert_fields = array( 'post_title', 'post_content' );
foreach ( $convert_fields as $convert_field ) {
$data[$convert_field] = mb_convert_kana( $data[$convert_field], 'aKV', 'UTF-8' );
}
return $data;
}
add_filter( 'wp_insert_post_data', 'convert_content' );



//JetPack用 カスタム投稿タイプにもパブリサイズ共有を適用
// function hoge() {
//     add_post_type_support( 'case', 'publicize' );
// }
// add_action( 'init', 'hoge' );



//検索フォーム追加
function my_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" action="'.home_url( '/' ).'" >
    <div><label class="screen-reader-text" for="s">' . __('') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </div>
    </form>';
    return $form;
} 
add_filter( 'get_search_form', 'my_search_form' );
//検索フォームの単語複数対応
if(isset($_GET['s'])) $_GET['s']=mb_convert_kana($_GET['s'],'s','UTF-8');


//contact form 7 ラジオボタンを必須にする　他の要素と同様に*をつける
add_action( 'wpcf7_init', 'wpcf7_add_shortcode_radio_required' );
function wpcf7_add_shortcode_radio_required() {
	wpcf7_add_shortcode( array( 'radio*' ), 
		'wpcf7_checkbox_shortcode_handler', true );
}
add_filter( 'wpcf7_validate_radio*', 'wpcf7_checkbox_validation_filter', 10, 2 );


//メディアを挿入　添付ファイルの表示設定のデフォルト値変更
function image_default_setting() {
	$image_link = get_option( 'image_default_link_type' );
	$image_size = get_option( 'image_default_size' );
 
	// リンク先をなしに指定
	if ( $image_link !== 'none' ) {
		update_option( 'image_default_link_type', 'none' );
	}
 
	// サイズをフルサイズに指定
	if ( $image_size !== 'full' ) {
		update_option( 'image_default_size', 'full' );
	}
}
add_action('admin_init', 'image_default_setting', 10);

//絶対パスを相対パスへ変換する
function delete_host_from_attachment_url($url) {
  $regex = '/^http(s)?:\/\/[^\/\s]+(.*)$/';
  if (preg_match($regex, $url, $m)) {
    $url = $m[2];
  }
  return $url;
}
add_filter('wp_get_attachment_url', 'delete_host_from_attachment_url');
add_filter('attachment_link', 'delete_host_from_attachment_url');

// カスタム投稿タイプを作成
// ※プラグインを設定
// ※管理画面のパーマリンク部分に/%○○_category%/を入れる！
// ※チェックもはずす
// 学会の活動
function activity_custom_post_type()
{
$labels = array(
'name' => _x('学会の活動', 'post type general name'),
'singular_name' => _x('activity', 'post type singular name'),
'all_items' => '学会の活動一覧',
'add_new' => _x('新規追加', 'activity'),
'add_new_item' => __('新規追加'),
'edit_item' => __('編集'),
'new_item' => __('新しい情報'),
'view_item' => __('情報を編集'),
'search_items' => __('情報を探す'),
'not_found' => __('記事はありません'),
'not_found_in_trash' => __('ゴミ箱に記事はありません'),
'parent_item_colon' => ''
);
$args = array(
'labels' => $labels,
'public' => true,
'publicly_queryable' => true,
'show_ui' => true,
'query_var' => true,
'rewrite' => true,
'capability_type' => 'post',
'hierarchical' => false,
'menu_position' => 5,
'has_archive' => true,
'supports' => array('title','editor','author','excerpt','comments','thumbnail'),
'taxonomies' => array('activity_category','activity_tag')
);
register_post_type('activity',$args);
// カスタムタクソノミーを作成
//カテゴリータイプ
$args = array(
'label' => 'カテゴリー',
'public' => true,
'show_ui' => true,
'hierarchical' => true,
'rewrite' => array('slug' => 'activity')
// 'rewrite' => true
);
register_taxonomy('activity_category','activity',$args);

//タグタイプ
$args = array(
'label' => 'タグ',
'public' => true,
'show_ui' => true,
'hierarchical' => false
);
register_taxonomy('activity_tag','activity',$args);
}
add_action('init', 'activity_custom_post_type');


// カスタム投稿タイプを作成
// ※プラグインを設定
// ※管理画面のパーマリンク部分に/%○○_category%/を入れる！
// ※チェックもはずす
// 病気のこと
function illness_custom_post_type()
{
$labels = array(
'name' => _x('病気のこと', 'post type general name'),
'singular_name' => _x('illness', 'post type singular name'),
'all_items' => '病気のこと一覧',
'add_new' => _x('新規追加', 'illness'),
'add_new_item' => __('新規追加'),
'edit_item' => __('編集'),
'new_item' => __('新しい情報'),
'view_item' => __('情報を編集'),
'search_items' => __('情報を探す'),
'not_found' => __('記事はありません'),
'not_found_in_trash' => __('ゴミ箱に記事はありません'),
'parent_item_colon' => ''
);
$args = array(
'labels' => $labels,
'public' => true,
'publicly_queryable' => true,
'show_ui' => true,
'query_var' => true,
'rewrite' => true,
'capability_type' => 'post',
'hierarchical' => false,
'menu_position' => 5,
'has_archive' => true,
'supports' => array('title','editor','author','excerpt','comments','thumbnail'),
'taxonomies' => array('illness_category','illness_tag')
);
register_post_type('illness',$args);
// カスタムタクソノミーを作成
//カテゴリータイプ
$args = array(
'label' => 'カテゴリー',
'public' => true,
'show_ui' => true,
'hierarchical' => true,
'rewrite' => array('slug' => 'illness')
// 'rewrite' => true
);
register_taxonomy('illness_category','illness',$args);

//タグタイプ
$args = array(
'label' => 'タグ',
'public' => true,
'show_ui' => true,
'hierarchical' => false
);
register_taxonomy('illness_tag','illness',$args);
}
add_action('init', 'illness_custom_post_type');

// カスタム投稿タイプを作成
// ※プラグインを設定
// ※管理画面のパーマリンク部分に/%○○_category%/を入れる！
// ※チェックもはずす
// 入局・研修について
function dayreport_custom_post_type()
{
$labels = array(
'name' => _x('入局・研修について', 'post type general name'),
'singular_name' => _x('dayreport', 'post type singular name'),
'all_items' => '入局・研修について一覧',
'add_new' => _x('新規追加', 'dayreport'),
'add_new_item' => __('新規追加'),
'edit_item' => __('編集'),
'new_item' => __('新しい情報'),
'view_item' => __('情報を編集'),
'search_items' => __('情報を探す'),
'not_found' => __('記事はありません'),
'not_found_in_trash' => __('ゴミ箱に記事はありません'),
'parent_item_colon' => ''
);
$args = array(
'labels' => $labels,
'public' => true,
'publicly_queryable' => true,
'show_ui' => true,
'query_var' => true,
'rewrite' => true,
'capability_type' => 'post',
'hierarchical' => false,
'menu_position' => 5,
'has_archive' => true,
'supports' => array('title','editor','author','excerpt','comments','thumbnail'),
'taxonomies' => array('dayreport_category','dayreport_tag')
);
register_post_type('dayreport',$args);
// カスタムタクソノミーを作成
//カテゴリータイプ
$args = array(
'label' => 'カテゴリー',
'public' => true,
'show_ui' => true,
'hierarchical' => true,
'rewrite' => array('slug' => 'dayreport')
// 'rewrite' => true
);
register_taxonomy('dayreport_category','dayreport',$args);

//タグタイプ
$args = array(
'label' => 'タグ',
'public' => true,
'show_ui' => true,
'hierarchical' => false
);
register_taxonomy('dayreport_tag','dayreport',$args);
}
add_action('init', 'dayreport_custom_post_type');


// カスタム投稿タイプを作成
// ※プラグインを設定
// ※管理画面のパーマリンク部分に/%○○_category%/を入れる！
// ※チェックもはずす
// スタッフから
function staff_custom_post_type()
{
$labels = array(
'name' => _x('スタッフから', 'post type general name'),
'singular_name' => _x('staff', 'post type singular name'),
'all_items' => 'スタッフから一覧',
'add_new' => _x('新規追加', 'staff'),
'add_new_item' => __('新規追加'),
'edit_item' => __('編集'),
'new_item' => __('新しい情報'),
'view_item' => __('情報を編集'),
'search_items' => __('情報を探す'),
'not_found' => __('記事はありません'),
'not_found_in_trash' => __('ゴミ箱に記事はありません'),
'parent_item_colon' => ''
);
$args = array(
'labels' => $labels,
'public' => true,
'publicly_queryable' => true,
'show_ui' => true,
'query_var' => true,
'rewrite' => true,
'capability_type' => 'post',
'hierarchical' => false,
'menu_position' => 5,
'has_archive' => true,
'supports' => array('title','editor','author','excerpt','comments','thumbnail'),
'taxonomies' => array('staff_category','staff_tag')
);
register_post_type('staff',$args);
// カスタムタクソノミーを作成
//カテゴリータイプ
$args = array(
'label' => 'カテゴリー',
'public' => true,
'show_ui' => true,
'hierarchical' => true,
'rewrite' => array('slug' => 'staff')
// 'rewrite' => true
);
register_taxonomy('staff_category','staff',$args);

//タグタイプ
$args = array(
'label' => 'タグ',
'public' => true,
'show_ui' => true,
'hierarchical' => false
);
register_taxonomy('staff_tag','staff',$args);
}
add_action('init', 'staff_custom_post_type');

// カスタム投稿タイプを作成
// ※プラグインを設定
// ※管理画面のパーマリンク部分に/%○○_category%/を入れる！
// ※チェックもはずす
// 病院からのお知らせ
function news_custom_post_type()
{
$labels = array(
'name' => _x('病院からのお知らせ', 'post type general name'),
'singular_name' => _x('news', 'post type singular name'),
'all_items' => '病院からのお知らせ一覧',
'add_new' => _x('新規追加', 'news'),
'add_new_item' => __('新規追加'),
'edit_item' => __('編集'),
'new_item' => __('新しい情報'),
'view_item' => __('情報を編集'),
'search_items' => __('情報を探す'),
'not_found' => __('記事はありません'),
'not_found_in_trash' => __('ゴミ箱に記事はありません'),
'parent_item_colon' => ''
);
$args = array(
'labels' => $labels,
'public' => true,
'publicly_queryable' => true,
'show_ui' => true,
'query_var' => true,
'rewrite' => true,
'capability_type' => 'post',
'hierarchical' => false,
'menu_position' => 5,
'has_archive' => true,
'supports' => array('title','editor','author','excerpt','comments','thumbnail'),
'taxonomies' => array('news_category','news_tag')
);
register_post_type('news',$args);
// カスタムタクソノミーを作成
//カテゴリータイプ
$args = array(
'label' => 'カテゴリー',
'public' => true,
'show_ui' => true,
'hierarchical' => true,
'rewrite' => array('slug' => 'news')
// 'rewrite' => true
);
register_taxonomy('news_category','news',$args);

//タグタイプ
$args = array(
'label' => 'タグ',
'public' => true,
'show_ui' => true,
'hierarchical' => false
);
register_taxonomy('news_tag','news',$args);
}
add_action('init', 'news_custom_post_type');

// カスタム投稿タイプを作成
// ※プラグインを設定
// ※管理画面のパーマリンク部分に/%○○_category%/を入れる！
// ※チェックもはずす
// 管理者より
function kamiyadc_custom_post_type()
{
$labels = array(
'name' => _x('管理者より', 'post type general name'),
'singular_name' => _x('kamiyadc', 'post type singular name'),
'all_items' => '管理者より一覧',
'add_new' => _x('新規追加', 'kamiyadc'),
'add_new_item' => __('新規追加'),
'edit_item' => __('編集'),
'new_item' => __('新しい情報'),
'view_item' => __('情報を編集'),
'search_items' => __('情報を探す'),
'not_found' => __('記事はありません'),
'not_found_in_trash' => __('ゴミ箱に記事はありません'),
'parent_item_colon' => ''
);
$args = array(
'labels' => $labels,
'public' => true,
'publicly_queryable' => true,
'show_ui' => true,
'query_var' => true,
'rewrite' => true,
'capability_type' => 'post',
'hierarchical' => false,
'menu_position' => 5,
'has_archive' => true,
'supports' => array('title','editor','author','excerpt','comments','thumbnail'),
'taxonomies' => array('kamiyadc_category','kamiyadc_tag')
);
register_post_type('kamiyadc',$args);
// カスタムタクソノミーを作成
//カテゴリータイプ
$args = array(
'label' => 'カテゴリー',
'public' => true,
'show_ui' => true,
'hierarchical' => true,
'rewrite' => array('slug' => 'kamiyadc')
// 'rewrite' => true
);
register_taxonomy('kamiyadc_category','kamiyadc',$args);

//タグタイプ
$args = array(
'label' => 'タグ',
'public' => true,
'show_ui' => true,
'hierarchical' => false
);
register_taxonomy('kamiyadc_tag','kamiyadc',$args);
}
add_action('init', 'kamiyadc_custom_post_type');


// カスタム投稿タイプを作成
// ※プラグインを設定
// ※管理画面のパーマリンク部分に/%○○_category%/を入れる！
// ※チェックもはずす
// セミナーページ
function seminar_custom_post_type()
{
$labels = array(
'name' => _x('セミナーページ', 'post type general name'),
'singular_name' => _x('seminar', 'post type singular name'),
'all_items' => 'セミナーページ一覧',
'add_new' => _x('新規追加', 'seminar'),
'add_new_item' => __('新規追加'),
'edit_item' => __('編集'),
'new_item' => __('新しい情報'),
'view_item' => __('情報を編集'),
'search_items' => __('情報を探す'),
'not_found' => __('記事はありません'),
'not_found_in_trash' => __('ゴミ箱に記事はありません'),
'parent_item_colon' => ''
);
$args = array(
'labels' => $labels,
'public' => true,
'publicly_queryable' => true,
'show_ui' => true,
'query_var' => true,
'rewrite' => true,
'capability_type' => 'post',
'hierarchical' => false,
'menu_position' => 5,
'has_archive' => true,
'supports' => array('title','editor','author','excerpt','comments','thumbnail'),
'taxonomies' => array('seminar_category','seminar_tag')
);
register_post_type('seminar',$args);
// カスタムタクソノミーを作成
//カテゴリータイプ
$args = array(
'label' => 'カテゴリー',
'public' => true,
'show_ui' => true,
'hierarchical' => true,
'rewrite' => array('slug' => 'seminar')
// 'rewrite' => true
);
register_taxonomy('seminar_category','seminar',$args);

//タグタイプ
$args = array(
'label' => 'タグ',
'public' => true,
'show_ui' => true,
'hierarchical' => false
);
register_taxonomy('seminar_tag','seminar',$args);
}
add_action('init', 'seminar_custom_post_type');





//SNS用meta削除
add_filter( 'jetpack_enable_opengraph', '__return_false' );

// ビジュアルエディタ用CSS
//エディタから見出しh1,h5,h6削除
add_editor_style('editor-style.css');
 
function custom_editor_settings( $initArray ) {
    $initArray['body_class'] = 'editor-area';
    $initArray['block_formats'] = "段落=p; 見出し2=h2; 見出し3=h3; 見出し4=h4;";
    return $initArray;
}

add_filter( 'tiny_mce_before_init', 'custom_editor_settings' );

//カスタムフィールド　option pages のタイトルにフック
function option_pages_filter() {
		$settings = array(
			'title' 		=> __('トップページ スライド','acf'),
			'menu'			=> __('トップページ<br>スライド','acf'),
			'slug' 			=> 'acf-options',
			'capability'	=> 'edit_posts',
			'pages' 		=> array(),
		);
		return $settings;
}
add_filter('acf/options_page/settings', 'option_pages_filter');


?>
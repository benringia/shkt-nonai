<?php
//パスワードリセットのリンクを非表示
add_action( 'login_enqueue_scripts', 'hide_lost_password' );
function hide_lost_password() {
	echo <<<EOD
<style>
#login p#nav { display: none; }
</style>
EOD;
}

//TinyMCEの見出し1を削除
function custom_editor_settings( $initArray ){
	$initArray['block_formats'] = "段落=p; 引用=blockquote; 見出し2=h2; 見出し3=h3; 見出し4=h4;";
	return $initArray;
}
add_filter( 'tiny_mce_before_init', 'custom_editor_settings' );

//サムネイル呼び出し関数
function default_thumbnail() {
	if (has_post_thumbnail()) {
		the_post_thumbnail( 'thumbnail');
	}else {
		echo '<img src="' . get_bloginfo('template_directory') . '/images/default.jpg' . '" width="100%" alt="'.get_the_title().'">';
	}
}

// ダッシュボードウィジェット非表示
function example_remove_dashboard_widgets() {
 if (!current_user_can('level_10')) { //level10以下のユーザーの場合ウィジェットをunsetする
 global $wp_meta_boxes;
 unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // 現在の状況
 unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // 最近のコメント
 unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // 被リンク
 unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // プラグイン
 unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // クイック投稿
 unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // 最近の下書き
 unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // WordPressブログ
 unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // WordPressフォーラム
 }
 }
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets');

// generatorを非表示にする
remove_action('wp_head', 'wp_generator');

// EditURIを非表示にする
remove_action('wp_head', 'rsd_link');

// wlwmanifestを非表示にする
remove_action('wp_head', 'wlwmanifest_link');

//更新時 OGPキャッシュクリア
add_action('save_post', 'save_ogp_clear');
function save_ogp_clear($post_id){
    $permalink = get_permalink($post_id);

    $url = "https://graph.facebook.com/?scrape=true&id=".$permalink;

    $POST_DATA = array(
        'scrape' => 'true',
        'id' => $permalink
    );
    $curl=curl_init("https://graph.facebook.com/");
    curl_setopt($curl,CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($POST_DATA));
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl,CURLOPT_COOKIEJAR,      'cookie');
    curl_setopt($curl,CURLOPT_COOKIEFILE,     'tmp');
    curl_setopt($curl,CURLOPT_FOLLOWLOCATION, TRUE);

    $output= curl_exec($curl);
}

//カスタムヘッダー
add_theme_support( 'custom-header' );

//アイキャッチ
add_theme_support('post-thumbnails');

//アイキャッチ画像サイズ
add_image_size( 'blog_thumbnail', 700, 433, true );
add_image_size( 'pickup_thumbnail', 700, 433, true );



/* カスタム投稿タイプを追加 */
add_action( 'init', 'create_post_type' );
function create_post_type() {

/* カスタム投稿タイプ「ブログ」を追加 */
	register_post_type( 'blog', //カスタム投稿タイプ名を指定
		array(
			'labels' => array(
			'name' => __( 'ブログ' ),
			'singular_name' => __( 'ブログ' )
		),
		'public' => true,
		'has_archive' => true, /* アーカイブページを持つ */
		'menu_position' =>5, //管理画面のメニュー順位
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ,'comments' ),
    	)
    	 );

/* カスタム投稿タイプ「今後のスケジュール」を追加 */
	register_post_type( 'schedule', //カスタム投稿タイプ名を指定
		array(
			'labels' => array(
			'name' => __( '今後のスケジュール' ),
			'singular_name' => __( '今後のスケジュール' )
		),
		'public' => true,
		'has_archive' => true, /* アーカイブページを持つ */
		'menu_position' =>5, //管理画面のメニュー順位
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ,'comments' ),
    	)
    	 );

/* ここからタクソノミーを追加 */
  register_taxonomy(
    'blog_cat', /* タクソノミーの名前 */
    'blog', /* blog投稿で設定する */
    array(
      'hierarchical' => true, /* 親子関係が必要なければ false 必要あれば true*/
      'update_count_callback' => '_update_post_term_count',
      'label' => 'ブログカテゴリー', /* 表示するカスタムタクソノミー名*/
      'singular_label' => 'ブログカテゴリー',
      'public' => true,
      'show_ui' => true
    )
  );
  }

/* 投稿のスラッグを日本語 => post-id に自動変換する関数*/
function auto_post_slug( $slug, $post_ID, $post_status, $post_type ) {
if ( preg_match( '/(%[0-9a-f]{2})+/', $slug ) ) {
$slug = utf8_uri_encode( $post_type ) . '-' . $post_ID;
}
return $slug;
}
add_filter( 'wp_unique_post_slug', 'auto_post_slug', 10, 4 );



/* カスタム投稿画面にターム名を表示 */
function add_custom_column( $defaults ) {
$defaults['blog_cat'] = 'カテゴリー';
return $defaults;
}
add_filter('manage_posts_columns', 'add_custom_column');
function add_custom_column_id($column_name, $id) {
if( $column_name == 'blog_cat' ) {
echo get_the_term_list($id, 'blog_cat', '', ', ');
}
}
add_action('manage_posts_custom_column', 'add_custom_column_id', 10, 2);


/* カスタム投稿画面にターム別ソート機能を追加 */
add_action('restrict_manage_posts', function() {
    global $post_type;
    if ( !in_array($post_type, ['blog']) ) return;
    $taxonomy = 'blog_cat';
    $terms = get_terms($taxonomy);
    if ( empty($terms) ) return;
    $selected = get_query_var($taxonomy);
    $options = '';
    foreach ($terms as $term) {
        $options .= sprintf('<option value="%s" %s>%s</option>'
                ,$term->slug
                ,($selected==$term->slug) ? 'selected="selected"' : ''
                ,$term->name
        );
    }
    $select = '<select name="%s"><option value="">指定なし</option>%s</select>';
    printf($select, $taxonomy, $options);
});


/* 投稿一覧の「コメント」を削除 */
function custom_columns ($columns) {
    unset($columns[comments]);
    return $columns;
}
add_filter( 'manage_posts_columns', 'custom_columns' );

/* 投稿一覧の項目順番の変更 */
function sort_column($columns){
	$columns = array(
	'cb' => '<input type="checkbox" />',
	'title' => 'タイトル',
	'blog_cat' => 'カテゴリー',
	'date' => '日時',
	'author' => '作成者',

	);
	return $columns;
}
add_filter( 'manage_posts_columns', 'sort_column');


/* 投稿の編集にスタイルを適応 */
add_editor_style( 'editor-style.css' );


//カスタム投稿タイプ　アイコン変更
function my_dashboard_print_styles() {
?>
<style>
#adminmenu #menu-posts-blog div.wp-menu-image:before { content: "\f331"; }
#adminmenu #menu-posts-schedule div.wp-menu-image:before { content: "\f508"; }
</style>
<?php
}
add_action( 'admin_print_styles', 'my_dashboard_print_styles' );


//ログイン画面　背景色変更
function custom_login() { ?>
  <style>
    .login {
     background-color:#061D30; */
      /*background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/img_login.jpg) top center no-repeat;
      background-size:cover; */
    }
  </style>
<?php }
add_action( 'login_enqueue_scripts', 'custom_login' );


//ログイン画面　ロゴ変更
function custom_login_logo() { ?>
  <style>
    .login #login h1 a {
      background-image:url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo_login.png);
      background-size: 100%;
    height: 50px;
    width: 320px;
}
      }
  </style>
<?php }
add_action( 'login_enqueue_scripts', 'custom_login_logo' );


//「〜 へ戻る」の文字色変更
function login_nav_backtoblog() { ?>
  <style>
    .login #backtoblog  a{
    color: #FFFFFF !important;
    }
  </style>
<?php }
add_action( 'login_enqueue_scripts', 'login_nav_backtoblog' );

/**
 * 2018.06.22
 * HTTP - HTTPS redirect
 *
 */
function force_https_redirect() {
  if ( !is_ssl() ) {
    wp_redirect( 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301 );
  }
}
add_action ( 'template_redirect', 'force_https_redirect', 1 );
<?php
/*
 * cms module:			Site Structure
 * Module Description:	サイトマップ、パンくずナビ、サブナビなど、サイトの構成を一元管理します。
 * Order:				0
 * First Introduced:	1.0
 * Major Changes In:	
 * Builtin:				true
 * Free:				true
 * Module Version:		1.0.2
 * License:				GPLv2 or later
*/

class site_structure {
	var $parent;
	var $settings;
	var $styles_dir;
	var $styles_dir_url;

	function __construct( $parent ) {
		// infinity cmsのオブジェクトをプロパティにセット
		$this->parent = $parent;
		$this->styles_dir['base'] = plugin_dir_path( dirname( __FILE__ ) ) . 'sitemap-styles/';
		$this->styles_dir['extra'] = WP_CONTENT_DIR . '/sitemap-styles/';
		$this->styles_dir_url['base'] = plugin_dir_url( dirname( __FILE__ ) ) . 'sitemap-styles/';
		$this->styles_dir_url['extra'] = WP_CONTENT_URL . '/sitemap-styles/';
		$this->settings['structure'] = get_option( 'wp-sitemanager-site-structure' );
		$this->settings['sitemap'] = get_option( 'wp-sitemanager-sitemap-settings' );
		if ( is_admin() ) {
			// 管理画面にサイトマップのメニューを追加
			add_action( 'admin_menu'					, array( &$this, 'add_sitemap_page' ) );
			
			// サイトマップ設定の保存
			add_action( 'load-wp-sitemanager_page_wp-sitemanager-structure', array( &$this, 'update_sitemap_settings' ) );

			// 固定ページなどの投稿画面にカテゴリーページのチェックボックスを追加表示
			add_action( 'post_submitbox_misc_actions'	, array( &$this, 'add_exclude_sitemap_checkbox' ) );

			// カスタムフィールドにカテゴリーページの設定を格納
			add_action( 'wp_insert_post'				, array( &$this, 'update_exclude_sitemap_setting' ), 10, 2 );
			
			// サイトマップ除外設定のフック登録
			add_action( 'wp_loaded'						, array( &$this, 'taxonomy_update_hooks' ), 9999 );
			
			add_action( 'admin_print_styles-wp-sitemanager_page_wp-sitemanager-structure', array( &$this->parent, 'print_icon_style' ) );
			
			add_filter( 'iis7_supports_permalinks'      , array( &$this, 'disallow_rewrite_web_config' ) );
		} else {
			add_action( 'wp'							, array( &$this, 'enqueue_sitemap_style' ) );
		}
		// カテゴリーページクラスのインスタンス生成
		new category_page;
		// サイトマップ表示用ショートコード
		add_shortcode( 'sitemap'			, array( &$this, 'sitemap' ) );
		// サブナビウィジェットの登録
		add_action( 'widgets_init'			, array( &$this, 'register_subnavi_widget' ) );
	}

	/*
	 * サイトマップメニューの追加
	 * @since 0.0.1
	 */
	public function add_sitemap_page() {
		add_submenu_page( $this->parent->root, 'サイト構造', 'サイト構造', 'administrator', basename( $this->parent->root ) . '-structure', array( &$this, 'setting_page' ) );
	}
	
	/*
	 * サイトマップ設定ページの表示
	 * @since 0.0.1
	 */
	public function setting_page() {
		$post_types = get_post_types( array( 'public' => true, 'show_in_menu' => true ), false );
		$sitemap_styles = $this->get_sitemap_styles();
?>
<div class="wrap">
	<?php screen_icon( 'prime-icon32' ); ?>
	<h2>サイトマップ設定</h2>
	<p>サイトマップの設定を行うことにより、サイトマップ、パンくずナビ、サブナビゲーションの表示を統合的に管理できます。</p>

	<form action="" method="post">
		<?php wp_nonce_field( 'wp-sitemanager-sitemap' ); ?>
		<h3>サイト構造定義</h3>
		<p>固定ページをベースとして投稿タイプ毎に割り当てる固定ページの設定を行います。</p>
		<table class="form-table">
<?php
foreach ( $post_types as $post_type ) :
	if ( in_array( $post_type->name, array( 'page', 'attachment' ) ) ) { continue; }
	$taxonomies = get_object_taxonomies( $post_type->name, false );
	if ( isset( $this->settings['structure'][$post_type->name]['page'] ) ) {
		$selected = '&selected=' . $this->settings['structure'][$post_type->name]['page'];
	} else {
		$selected = '';
	}
	if ( isset( $this->settings['structure'][$post_type->name]['display'] ) && $this->settings['structure'][$post_type->name]['display'] ) {
		$checked = ' checked="checked"';
	} else {
		$checked = '';
	}
?>
			<tr>
				<th>
					<input type="hidden" name="site_structure[<?php echo esc_attr( $post_type->name ); ?>][display]" value="0" />
					<label for="site_structure-<?php echo esc_attr( $post_type->name ); ?>-display">
						<input type="checkbox" name="site_structure[<?php echo esc_attr( $post_type->name ); ?>][display]" id="site_structure-<?php echo esc_attr( $post_type->name ); ?>-display" value="1"<?php echo $checked; ?> />
						<?php echo $post_type->label; ?>
					</label>
				</th>
				<td>
					<?php wp_dropdown_pages( 'sort_column=menu_order, post_title&name=site_structure['. $post_type->name .'][page]&show_option_none=トップページ' . $selected ); ?>
					を
					<select name="site_structure[<?php echo esc_attr( $post_type->name ); ?>][object]">
<?php
	if ( is_post_type_hierarchical( $post_type->name ) ) :
?>
						<option value="archive">一覧</option>
<?php
	endif;

	if ( $taxonomies ) :
		foreach ( $taxonomies as $taxonomy ) :
			if ( $taxonomy->show_ui ) :
				$selected = $this->settings['structure'][$post_type->name]['object'] == $taxonomy->name ? ' selected="selected"' : '';
?>
						<option value="<?php echo esc_attr( $taxonomy->name ); ?>"<?php echo $selected; ?>><?php echo esc_html( $taxonomy->label ); ?></option>
<?php
			endif;
		endforeach;
	endif;
?>
					</select>
					にひもづける。
<!--
					<select name="site_structure[<?php echo esc_attr( $post_type->name ); ?>][type]">
						<option value="parent"<?php echo $this->settings['structure'][$post_type->name]['type'] == 'parent' ? ' selected="selected"' : ''; ?>>の親とする</option>
						<option value="same"<?php echo $this->settings['structure'][$post_type->name]['type'] == 'same' ? ' selected="selected"' : ''; ?>>に割り当てる</option>
					</select>
-->
					順序：
					<input type="text" name="site_structure[<?php echo esc_attr( $post_type->name ); ?>][order]" size="3" value="<?php echo isset( $this->settings['structure'][$post_type->name]['order'] ) ? $this->settings['structure'][$post_type->name]['order'] : 0; ?>" />
				</td>
			</tr>
<?php
endforeach;
?>
		</table>
		
		<h3>サイトマップ設定</h3>
		<p>サイトマップ表示に関する設定を行います。</p>
		
		<table class="form-table">
			<tr>
				<th>出力階層制限</th>
				<td>
					<select name="sitemap[disp_level]" id="sitemap_disp_level">
						<option value="0">制限なし</option>
<?php
for ( $i = 1; $i <= 10; $i++ ) :
	$selected = $this->settings['sitemap']['disp_level'] == $i ? ' selected="selected"' : '';
?>
						<option value="<?php echo esc_attr( $i ); ?>"<?php echo $selected; ?>>第<?php echo esc_attr( $i ); ?>階層</option>
<?php
endfor;
?>
					</select>
				</td>
			</tr>
<!-- 
			<tr>
				<td colspan="2">
				IDで指定する方法はわかりにくいので、除外の設定は、それぞれのカテゴリーや記事の編集画面のチェックボックスに持って行った方がいいかもしれない。
				</td>
			</tr>
			<tr>
				<th>除外カテゴリ
				</th>
				<td>
					<input type="text" name="sitemap[ex_cat_ids]" id="sitemap_ex_cat_ids" value="<?php /* echo esc_attr( $this->settings['sitemap']['ex_cat_ids'] ); */ ?>" /><br />
					* 出力しないカテゴリのIDを入力してください。（複数の場合はカンマ区切り）	
				</td>
			</tr>
			<tr>
				<th>除外記事</th>
				<td>
					<input type="text" name="sitemap[ex_post_ids]" id="sitemap_ex_post_ids" value="<?php /* echo esc_attr( $this->settings['sitemap']['ex_post_ids'] ); */ ?>" /><br />
					* 出力しない記事のIDを入力してください。（複数の場合はカンマ区切り） <br />
					* 固定ページなど階層が有効となっている投稿タイプでは、除外された記事の子記事についても非表示となります。
				</td>
			</tr>
-->
			<tr>
				<th>スタイルの変更</th>
				<td>
					<select name="sitemap[style]" id="sitemap_style">
						<option value="" selected="selected">スタイルなし</option>
<?php if ( $sitemap_styles ) : foreach ( $sitemap_styles as $slug => $sitemap_style ) :
	$selected = $this->settings['sitemap']['style']['path'] == $sitemap_style['path'] ? ' selected="selected"' : '';

?>
						<option value="<?php echo esc_attr( $slug ); ?>"<?php echo $selected; ?>><?php echo esc_html( $sitemap_style['name'] ); ?></option>
<?php endforeach; endif; ?>
					</select>
				</td>
			</tr>
		</table>
		<div id="sitemap_setting_explain">
			<p>サイトマップを表示するには、サイトマップを表示したい箇所に<code>[sitemap]</code>と記述してください。</p>
		</div>

		<?php submit_button( NULL, 'primary', 'wp-sitemanager-sitemap' ); ?>
	</form>
	<div id="developper_information">
		<div id="poweredby">
			<a href="http://www.prime-strategy.co.jp/" target="_blank"><img src="<?php echo preg_replace( '/^https?:/', '', plugin_dir_url( dirname( __FILE__ ) ) ) . 'images/ps_logo.png'; ?>" alt="Powered by Prime Strategy" /></a>
		</div>
	</div>
</div>
<?php
	}
	
	/*
	 * サイトマップ設定のデータ更新処理
	 */
	function update_sitemap_settings() {
		if ( isset( $_POST['wp-sitemanager-sitemap'] ) ) {
			check_admin_referer( 'wp-sitemanager-sitemap' );
			$post_data = stripslashes_deep( $_POST );
			update_option( 'wp-sitemanager-site-structure', $post_data['site_structure'] );
			$this->settings['structure'] = get_option( 'wp-sitemanager-site-structure' );
			$sitemap_styles = $this->get_sitemap_styles();
			if ( isset( $sitemap_styles[$post_data['sitemap']['style']] ) && $sitemap_styles[$post_data['sitemap']['style']]['name'] ) {
				$post_data['sitemap']['style'] = $sitemap_styles[$post_data['sitemap']['style']];
			}
			update_option( 'wp-sitemanager-sitemap-settings', $post_data['sitemap'] );
			$this->settings['sitemap'] = get_option( 'wp-sitemanager-sitemap-settings' );
		}
	}
	
	/*
	 * サイトマップソースの生成
	 */
	public function sitemap( $atts ) {
		$excludes = $this->get_exclude_post_ids();
		$defaults = array(
			'depth' => $this->settings['sitemap']['disp_level'],
			'child_of' => 0, 'exclude' => $excludes,
			'title_li' => '', 'echo' => 0,
			'authors' => '', 'sort_column' => 'menu_order, post_title',
			'link_before' => '', 'link_after' => '', 'walker' => '',
		);

		$args = shortcode_atts( $defaults, $atts );
		$pages = apply_filters( 'sitemap-pages', get_pages( $args ), $atts );
		$depth = (int)$args['depth'];
		$current_page = false;
		$args = array( $pages, $depth, $args, $current_page );
		$walker = new Walker_pageNavi;
		$sitemap = '<ul class="sitemap">' . "\n";
		$sitemap .= apply_filters( 'infinity-sitemap-before', '' );
		$sitemap .= call_user_func_array( array( &$walker, 'walk' ), $args );
		$sitemap .= apply_filters( 'infinity-sitemap-after', '' );
		$sitemap .= '</ul>' . "\n";
		return apply_filters( 'infinity-sitemap', $sitemap, $atts );
	}
	
	/*
	 * サブナビウィジェットの登録
	 */
	public function register_subnavi_widget() {
		register_widget( 'infinity_sub_navi_widget' );
	}
	
	/*
	 * 投稿画面の公開ボックスにサイトマップ除外のチェックボックスを追加する
	 */
	public function add_exclude_sitemap_checkbox() {
		global $post, $post_type;
		// 階層が有効かどうかのチェック
		if ( ! is_post_type_hierarchical( $post_type ) ) { return; }
		$checked = $this->is_exclude_sitemap( $post->ID ) ? ' checked="checked"' : '';
?>
	<div class="misc-pub-section misc-pub-section-last">
		<input type="hidden" name="exclude_sitemap" value="0" />
		<label for="exclude_sitemap_checkbox">
			<input type="checkbox" name="exclude_sitemap" id="exclude_sitemap_checkbox" value="1"<?php echo $checked; ?> />
			サイトマップの表示から除外する
		</label>
	</div>
<?php
	}
	
	/*
	 * 記事のサイトマップ除外設定の保存更新
	 */
	public function update_exclude_sitemap_setting( $post_id, $post ) {
		// 階層が有効になっていない投稿タイプかオートセーブなどの場合は実行しない。
		if ( ! is_post_type_hierarchical( $post->post_type ) || defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE && ! (int)$post_id ) { return; }

		$current = get_post_meta( $post_id, '_exclude_sitemap', true );
		if ( $current ) {
			// 設定がされていて、0がPOSTされたら設定を削除
			if ( isset( $_POST['exclude_sitemap'] ) && ! $_POST['exclude_sitemap'] ) {
				delete_post_meta( $post_id,  '_exclude_sitemap' );
			}
		} else {
			// 設定がされておらず、1がPOSTされたら設定を更新
			if ( isset( $_POST['exclude_sitemap'] ) && $_POST['exclude_sitemap'] ) {
				update_post_meta( $post_id, '_exclude_sitemap', 1 );
			}
		}
	}
	
	/*
	 * サイトマップ除外記事かどうかを判別する
	 */
	private function is_exclude_sitemap( $id ) {
		global $post;
		if ( is_null( $id ) ) {
			$id = $post->ID;
		}
		return (bool)get_post_meta( $id, '_exclude_sitemap', true );
	}
	
	/*
	 * 除外設定された記事のidを全て取得する
	 */
	private function get_exclude_post_ids() {
		global $wpdb;
		
		if ( ! $exclude_post_ids = wp_cache_get( 'infinity-exclude-sitemap-post-ids' ) ) {
			$sql = "
SELECT		`post_id`
FROM		{$wpdb->postmeta}
WHERE		`meta_key` = '_exclude_sitemap'
AND			`meta_value` = '1'
";
			$exclude_post_ids = $wpdb->get_col( $sql );
			wp_cache_set( 'infinity-exclude-sitemap-post-ids', $exclude_post_ids );
		}
		return $exclude_post_ids;
	}
	
	/*
	 * タームのサイトマップ除外設定のフック追加
	 */
	public function taxonomy_update_hooks() {
		$taxonomies = get_taxonomies( array( 'public' => true, 'show_ui' => true ) );
		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $taxonomy ) {
				add_action( $taxonomy . '_add_form_fields'	, array( $this, 'add_sitemap_exclude_term_checkbox' ) );
				add_action( $taxonomy . '_edit_form_fields'	, array( &$this, 'edit_sitemap_exclude_term_checkbox' ), 0, 2 );
				add_action( 'created_' . $taxonomy			, array( &$this, 'update_sitemap_exclude_terms' ) );
				add_action( 'edited_' . $taxonomy			, array( &$this, 'update_sitemap_exclude_terms' ) );
				add_action( 'delete_' . $taxonomy			, array( &$this, 'delete_sitemap_exclude_terms' ) );
			}
		}
	}
	
	/*
	 * 分類新規追加画面へのサイトマップ除外
	 */
	public function add_sitemap_exclude_term_checkbox() {
?>
	<div class="form-field">
		<label for="sitemap_exclude_checkbox">
			<input type="checkbox" name="sitemap_exclude_checkbox" id="sitemap_exclude_checkbox" value="1" style="width: auto;" />
			サイトマップでの表示から除外する
		</label>
	</div>
<?php
	}
	
	/*
	 * ターム編集画にサイトマップに
	 */
	public function edit_sitemap_exclude_term_checkbox( $tag ) {
		$ex_cats = get_option( 'infinity_exclude_terms', array() );
?>
		<tr class="form-field">
			<th scope="row" valign="top">サイトマップ表示</th>
			<td>
				<input type="hidden" name="sitemap_exclude_checkbox" value="0" />
				<label for="sitemap_exclude_checkbox">
					<input type="checkbox" name="sitemap_exclude_checkbox" id="sitemap_exclude_checkbox" value="1" style="width: auto;"<?php echo in_array( $tag->term_id, $ex_cats ) ? ' checked="checked"' : ''; ?> />
					サイトマップの表示から除外する
				</label>
			</td>
		</tr>
<?php
	}
	
	/*
	 * サイトマップ除外のタームidを保存する
	 */
	public function update_sitemap_exclude_terms( $term_id ) {
		if ( ! isset( $_POST['sitemap_exclude_checkbox'] ) ) { return; }
		$ex_cats = get_option( 'infinity_exclude_terms', array() );
		
		if ( $_POST['sitemap_exclude_checkbox'] == '0' ) {
			$key = array_search( $term_id, $ex_cats );
			if ( $key !== false ) {
				array_splice( $ex_cats, $key, 1 );
				update_option( 'infinity_exclude_terms', $ex_cats );
			}
		} elseif ( $_POST['sitemap_exclude_checkbox'] == '1' ) {
			if ( ! in_array( $term_id, $ex_cats ) ) {
				$ex_cats[] = $term_id;
				update_option( 'infinity_exclude_terms', $ex_cats );
			}
		}
	}
	
	
	/*
	 * ターム削除時の除外設定の更新
	 */
	public function delete_sitemap_exclude_terms( $term ) {
		$ex_cats = get_option( 'infinity_exclude_terms', array() );
		$key = array_search( $term, $ex_cats );
		if ( $key !== false ) {
			array_splice( $ex_cats, $key, 1 );
			update_option( 'infinity_exclude_terms', $ex_cats );
		}
	}
	
	
	private function get_sitemap_styles() {
		$header_items = array(
			'name'        => 'Style Name',
			'description' => 'Description',
			'version'     => 'Version'
		);
		$styles = array();

		foreach ( $this->styles_dir as $dir_term => $style_dir ) {
			if ( !$dir = @opendir( $style_dir ) ) {
				continue;
			}
			while ( false !== $file = readdir( $dir ) ) {
				if ( file_exists( $style_dir . $file . '/sitemap.css' ) ) {
					$file_data = get_file_data( $style_dir . $file . '/sitemap.css', $header_items, 'sitemap-styles' );
					if ( $file_data['name'] ) {
						$file_data['path'] = $style_dir . $file . '/sitemap.css';
						$file_data['url'] = $this->styles_dir_url[$dir_term] . $file . '/sitemap.css';
						$styles[$file] = $file_data;
					}
				}
			}
		}
		asort( $styles );
		return $styles;
	}
	
	
	public function enqueue_sitemap_style() {
		global $post;
		if ( is_singular() && strpos( $post->post_content, '[sitemap]' ) !== false && isset( $this->settings['sitemap']['style']['path'] ) && file_exists( $this->settings['sitemap']['style']['path'] ) ) {
			wp_enqueue_style( 'sitemap-style', $this->settings['sitemap']['style']['url'], array(), $this->settings['sitemap']['style']['version'] );
		}
	}
	
	
	/*
	 * location の記述があるweb.cofig ファイルの書き換えを禁止する
	 */
	public function disallow_rewrite_web_config( $supports_permalinks ) {
		$home_path = get_home_path();
		$web_config_file = $home_path . 'web.config';
		if ( $supports_permalinks && file_exists( $web_config_file ) && is_readable( $web_config_file ) ) {
			$web_config_contents = file_get_contents( $web_config_file );
			if ( preg_match( '/<location[\s]+inheritInChildApplications="false"[\s]*>/i', $web_config_contents ) ) {
				$supports_permalinks = false;
			}
		}
		return $supports_permalinks;
	}
} // class end
$this->instance->$slug = new site_structure( $this );



class category_page {
	function __construct() {
		if ( is_admin() ) {
			// 固定ページなどの投稿画面にカテゴリーページのチェックボックスを追加表示
			add_action( 'post_submitbox_misc_actions'	, array( &$this, 'add_category_page_checkbox' ) );

			// カスタムフィールドにカテゴリーページの設定を格納
			add_action( 'wp_insert_post'				, array( &$this, 'update_category_page_setting' ), 10, 2 );
		}
		// カテゴリーページ設定されている固定ページのパーマリンクを子ページのものにフィルタリング
		add_filter( 'page_link'				, array( &$this, 'replace_category_page_permalink' ), 10, 2 );
		
		// カテゴリーページ設定されているカスタム投稿タイプのパーマリンクを子ページのものにフィルタリング
		add_filter( 'post_type_link'		, array( &$this, 'replace_category_page_permalink' ), 10, 2 );
		
		// カテゴリーページにアクセスされた場合のリダイレクト処理
		add_action( 'template_redirect'		, array( &$this, 'redirect_category_page' ) );
		
		// カテゴリーページのフィードの中身を空にする
		add_filter( 'the_content_feed'		, array( &$this, 'filter_feed_content' ) );
		add_filter( 'the_excerpt_rss'		, array( &$this, 'filter_feed_content' ), 9999 );
		add_filter( 'the_content'			, array( &$this, 'filter_feed_content' ) );
		add_filter( 'the_excerpt'			, array( &$this, 'filter_feed_content' ), 9999 );
	}

	/*
	 * カテゴリーページかどうかの判別を行う
	 * @since 0.0.1
	 * @param int
	 * @return bool
	 */
	private function is_category_page( $id = null ) {
		global $post;
		if ( is_null( $id ) ) {
			$id = $post->ID;
		}
		return (bool)get_post_meta( $id, '_category_page', true );
	}

	/*
	 * 投稿画面の公開ボックスにカテゴリーページ設定用のチェックボックスを追加出力
	 * @since 0.0.1
	 */
	public function add_category_page_checkbox() {
		global $post, $post_type;
		// 階層が有効かどうかのチェック
		if ( ! is_post_type_hierarchical( $post_type ) ) { return; }
		$checked = $this->is_category_page( $post->ID ) ? ' checked="checked"' : '';
?>
	<div class="misc-pub-section misc-pub-section-last">
		<input type="hidden" name="category_page" value="0" />
		<label for="category_page_checkbox">
			<input type="checkbox" name="category_page" id="category_page_checkbox" value="1"<?php echo $checked; ?> />
			カテゴリー記事としてリンク先を子記事にする
		</label>
	</div>
<?php
	}

	/*
	 * カテゴリーページの設定保存
	 * @since 0.0.1
	 */
	public function update_category_page_setting( $post_id, $post ) {
		// 階層が有効になっていない投稿タイプかオートセーブなどの場合は実行しない。
		if ( ! is_post_type_hierarchical( $post->post_type ) || defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE && ! (int)$post_id ) { return; }

		$current = get_post_meta( $post_id, '_category_page', true );
		if ( $current ) {
			// 設定がされていて、0がPOSTされたら設定を削除
			if ( isset( $_POST['category_page'] ) && ! $_POST['category_page'] ) {
				delete_post_meta( $post_id,  '_category_page' );
			}
		} else {
			// 設定がされておらず、1がPOSTされたら設定を更新
			if ( isset( $_POST['category_page'] ) && $_POST['category_page'] ) {
				update_post_meta( $post_id, '_category_page', 1 );
			}
		}
	}

	/*
	 * カテゴリーページのパーマリンク変更処理
	 * @since 0.0.1
	 */
	public function replace_category_page_permalink( $link, $id_or_post ) {
		// id（固定ページの場合）かオブジェクトか（カスタム投稿タイプの場合）を判別してパラメーター差違を吸収
		if ( is_int( $id_or_post ) ) {
			$post = get_post( $id_or_post );
		} elseif ( is_object( $id_or_post ) ) {
			$post = $id_or_post;
		} else {
			return $link;
		}
		
		// 階層が有効になっている場合のみリンク書き換えを実行
		if ( is_post_type_hierarchical( $post->post_type ) ) {
			if ( $this->is_category_page( $post->ID ) ) {
				// 子ページのパーマリンクを取得
				$url = $this->get_child_page_url( $post );
				if ( $url ) {
					$link = $url;
				}
			}
		}
		return $link;
	}

	/*
	 * カテゴリーページのリダイレクト処理
	 * @since 0.0.1
	 */
	public function redirect_category_page() {
		global $post;
		// 個別表示で階層が有効となっているか判別
		if ( is_singular() && is_post_type_hierarchical( $post->post_type ) ) {
			if ( $this->is_category_page( $post->ID ) ) {
				// 子ページのパーマリンクを取得できればリダイレクトを行う。
				if ( $redirect = $this->get_child_page_url( $post ) ) {
					wp_redirect( $redirect );
					die;
				}
			}
		}
	}

	/*
	 * 最初の子ページを取得
	 * @since 0.0.1
	 * 
	 * return :object 子ページのオブジェクト
	 */
	private function get_child_page( $post ) {
		$statuses = array( 'publish' );
		if ( current_user_can( 'read_private_posts' ) ) {
			$statuses[] = 'private';
		}

		$child = get_children(
			array(
				'posts_per_page'	=> 1,
				'post_type'			=> $post->post_type,
				'post_status'		=> $statuses,
				'post_parent'		=> $post->ID,
				'orderby'			=> 'menu_order',
				'order'				=> 'ASC'
			)
		);
		
		if ( $child ) {
			$child = array_shift( $child );
		}
		return $child;
	}
	
	/*
	 * 最初の子ページのパーマリンクを取得
	 * @since 0.0.1
	 * @param object 現ページのオブジェクト
	 * @return string 子ページのurl
	 */
	private function get_child_page_url( $post ) {
		$child = $this->get_child_page( $post );
		if ( $child ) {
			$url = get_permalink( $child->ID );
		} else {
			$url = false;
		}
		return $url;
	}
	
	/*
	 * カテゴリーページの場合、フィードの内容を空にする
	 * @since 0.0.1
	 * @param string デフォルトの表示内容
	 * @return string 表示すべき内容
	 */
	public function filter_feed_content( $content ) {
		if ( $this->is_category_page() ) {
			$content = '';
		}
		return $content;
	}
} // class category_page end


/*
 * サイトマップ（およびサブナビ）用のクラス定義を行います。
 * 当該クラスはwp_list_pagesのhtmlを生成するWalker_Pageクラス(wp-includes/post-template.php)を継承し、
 * 一部メソッドをオーバーライドしています。
 * Walker_Pageクラスは、Walkerクラス(wp-includes/class-wp-walker.php)を継承しており、基本的な再帰ロジックを持っています。
 * 基本的な動作としては、walkerメソッドにて、最上位の項目と子の項目に分類され、display_elementメソッドでソース生成を行っています。
 * display_element内で、子の項目があれば、再帰的にdisplay_elementを呼んで再帰動作を実現しています。
 */
class Walker_pageNavi extends Walker_Page {
	var $displayed = array();
	
	function walk( $elements, $max_depth) {

		$args = array_slice(func_get_args(), 2);
		$output = '';

		if ($max_depth < -1) //invalid parameter
			return $output;

		if (empty($elements)) //nothing to walk
			return $output;

		$id_field = $this->db_fields['id'];
		$parent_field = $this->db_fields['parent'];

		// flat display
		if ( -1 == $max_depth ) {
			$empty_array = array();
			foreach ( $elements as $e )
				$this->display_element( $e, $empty_array, 1, 0, $args, $output );
			return $output;
		}

		/*
		 * need to display in hierarchical order
		 * separate elements into two buckets: top level and children elements
		 * children_elements is two dimensional array, eg.
		 * children_elements[10][] contains all sub-elements whose parent is 10.
		 */
		$top_level_elements = array();
		$children_elements  = array();
		foreach ( $elements as $e) {
			if ( 0 == $e->$parent_field )
				$top_level_elements[] = $e;
			else
				$children_elements[ $e->$parent_field ][] = $e;
		}

		/*
		 * when none of the elements is top level
		 * assume the first one must be root of the sub elements
		 */
		if ( empty($top_level_elements) ) {

			$first = array_slice( $elements, 0, 1 );
			$root = $first[0];

			$top_level_elements = array();
			$children_elements  = array();
			foreach ( $elements as $e) {
				if ( $root->$parent_field == $e->$parent_field )
					$top_level_elements[] = $e;
				else
					$children_elements[ $e->$parent_field ][] = $e;
			}
		}

		foreach ( $top_level_elements as $e )
			$this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );

		/*
		 * if we are displaying all levels, and remaining children_elements is not empty,
		 * then we got orphans, which should be displayed regardless
		 */

		/* 
		 * ここは、はぐれ（親が非表示指定されている子ページ）を表示するロジックなので、サイトマップでは要らないはず。
		 * 
		if ( ( $max_depth == 0 ) && count( $children_elements ) > 0 ) {
			$empty_array = array();
			foreach ( $children_elements as $orphans )
				foreach( $orphans as $op )
					$this->display_element( $op, $empty_array, 1, 0, $args, $output );
		}
		*/
		
		$custom_structure = get_option( 'wp-sitemanager-site-structure' );
		if ( $custom_structure ) {
			foreach ( $custom_structure as $post_type => $settings ) {
				if ( ( isset( $settings['display'] ) && $settings['display'] ) && $settings['page'] == 0 && ! in_array( $post_type, $this->displayed ) ) {
					$output = $this->display_post_type_tree( $post_type, $output, 0, $args );
					$this->displayed[] = $post_type;
				}
			}
		}

		 return $output;
	}


		function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"children\">\n";
	}


	function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
		if ( $depth )
			$indent = str_repeat("\t", $depth);
		else
			$indent = '';

		extract($args, EXTR_SKIP);
		
		$css_class = array( 'sitenavi-pages', 'level-' . $depth + 1,
		);
		if ( !empty( $current_page ) ) {
			$_current_page = get_post( $current_page );
			if ( in_array( $page->ID, $_current_page->ancestors ) )
				$css_class[] = 'current-page-ancestor';
			if ( $page->ID == $current_page )
				$css_class[] = 'current-page-item';
			elseif ( $_current_page && $page->ID == $_current_page->post_parent )
				$css_class[] = 'current-page-parent';
		} elseif ( $page->ID == get_option( 'page_for_posts' ) ) {
			$css_class[] = 'current-page-parent';
		}

		$output .= $indent . '<li class="' . implode( ' ', $css_class ) . '"><a href="' . get_permalink($page->ID) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';
	}


	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {

		if ( ! $element )
			return;

		$custom_structure = get_option( 'wp-sitemanager-site-structure' );
		$id_field = $this->db_fields['id'];
		$parent_field = $this->db_fields['parent'];
		if ( $custom_structure ) {
			foreach ( $custom_structure as $post_type => $settings ) {
				if ( ( isset( $settings['display'] ) && $settings['display'] ) && $element->$parent_field == $settings['page'] && $element->menu_order >= $settings['order'] && ! in_array( $post_type, $this->displayed ) ) {
					$output = $this->display_post_type_tree( $post_type, $output, $depth, $args );
					$this->displayed[] = $post_type;
				}
			}
		}
		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);

		

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ( $max_depth == 0 || $max_depth > $depth+1 ) ) {
			if ( isset( $children_elements[$id] ) ) {
				$cnt = 1;
				foreach( $children_elements[ $id ] as $child ){
						if ( !isset($newlevel) ) {
						$newlevel = true;
						//start the child delimiter
						$cb_args = array_merge( array(&$output, $depth), $args);
						call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
					}
					$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
					if ( $custom_structure ) {
						foreach ( $custom_structure as $post_type => $settings ) {
							if ( ( isset( $settings['display'] ) && $settings['display'] ) && count( $children_elements[ $id ] ) == $cnt && $element->$id_field == $settings['page'] && ! in_array( $post_type, $this->displayed ) ) {
								$output = $this->display_post_type_tree( $post_type, $output, $depth, $args );
								$this->displayed[] = $post_type;
							}
						}
					}
					$cnt++;
				}
				unset( $children_elements[ $id ] );
			} else {
				if ( $custom_structure ) {
					foreach ( $custom_structure as $post_type => $settings ) {
						if ( ( isset( $settings['display'] ) && $settings['display'] ) && $element->$id_field == $settings['page'] && ! in_array( $post_type, $this->displayed ) ) {
							if ( ! isset( $newlevel ) ) {
								$newlevel = true;
								$cb_args = array_merge( array(&$output, $depth), $args );
								call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
							}
							$output = $this->display_post_type_tree( $post_type, $output, $depth, $args );
							$this->displayed[] = $post_type;
						}
					}
				}
			}
		}

		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
	
	/*
	 * サイトマップで固定ページにぶら下がるカスタム投稿タイプ、カスタム分類（カテゴリー、タグ含）のツリーを表示
	 */
	function display_post_type_tree( $post_type, $output, $depth, $args ) {
		if ( $args[0]['depth'] == 0 ) {
			$child_depth = 0;
		} elseif ( $args[0]['depth'] == -1 ) {
			$child_depth = -1;
		} else {
			$child_depth = $args[0]['depth'] - $depth - 1;
			if ( $child_depth <= 0 ) {
				return $output;
			}
		}

		$custom_structure = get_option( 'wp-sitemanager-site-structure' );
		if ( ! isset( $custom_structure[$post_type]['object'] ) ) { return; }
		switch ( $custom_structure[$post_type]['object'] ) {
			case 'archive' :
				if ( is_post_type_hierarchical( $post_type ) ) {
					$pages = get_pages(
						array(
							'sort_column' => 'menu_order',
							'post_type'   => $post_type
						)
					);

					$args = array(
						'depth' => $child_depth,
						'child_of' => 0, 'exclude' => '',
						'title_li' => '', 'echo' => 0,
						'authors' => '', 'sort_column' => 'menu_order, post_title',
						'link_before' => '', 'link_after' => '', 'walker' => '',
					);
					$args = array( $pages, $child_depth, $args, '' );
					$walker = new Walker_pageNavi;
					$output .= call_user_func_array( array( &$walker, 'walk' ), $args );
				}
				break;
			default :
				if ( taxonomy_exists( $custom_structure[$post_type]['object'] ) ) {
					$ex_cats = (array)get_option( 'infinity_exclude_terms', array() );
					$args = array(
						'show_option_all' => '', 'show_option_none' => '',
						'orderby' => 'name', 'order' => 'ASC',
						'show_last_update' => 0, 'style' => 'list',
						'show_count' => 0, 'hide_empty' => 0,
						'use_desc_for_title' => 1, 'child_of' => 0,
						'feed' => '', 'feed_type' => '',
						'feed_image' => '', 'exclude' => '',
						'exclude_tree' => $ex_cats, 'current_category' => 0,
						'hierarchical' => true, 'title_li' => '',
						'echo' => 0, 'depth' => $child_depth,
						'taxonomy' => $custom_structure[$post_type]['object']
					);
					$terms = get_categories( $args );
					$args = array( $terms, $child_depth, $args  );
					$walker = new Walk_categoryNavi( $depth );
					$output .= call_user_func_array( array( &$walker, 'walk' ), $args );
				}
		}
		return $output;
	}

} // class Walker_pageNavi end


class Walk_categoryNavi extends Walker_Category {
	var $root_depth;
	function __construct( $depth ) {
		$this->root_depth = $depth;
	}


	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		$current_depth = $depth;
		extract($args);

		$cat_name = esc_attr( $category->name );
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		$link = '<a href="' . esc_attr( get_term_link($category) ) . '" ';
		if ( $use_desc_for_title == 0 || empty($category->description) )
			$link .= 'title="' . esc_attr( $cat_name ) . '"';
		else
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		$link .= '>';
		$link .= $cat_name . '</a>';

		$output .= "\t<li";
		$class = 'sitenavi-pages level-' . ( $this->root_depth + $current_depth + 2 );
		$output .=  ' class="' . $class . '"';
		$output .= ">$link\n";

	}
} // class Walk_categoryNavi end



class infinity_sub_navi_widget extends WP_Widget {
	
	function infinity_sub_navi_widget () {
		$widget_ops = array(
			'classname' => 'sub_navi-widget',
			'description' => 'ホーム、投稿、固定ページでのサブナビをオールインワンで実現'
		);

		$this->defaults = array(
			'home_display'				=> 'latest',
			'home_title'				=> '',
			'home_disp_nums'			=> 5,
			'home_post_type'			=> array( 'post' ),
			'post_display'				=> 'm_archives',
			'post_title'				=> '',
			'post_disp_nums'			=> 5,
			'cat_orderby'				=> 'name',
			'cat_order'					=> 'asc',
			'page_display'				=> 'root',
			'page_display_child_of'		=> 1,
			'page_exclude_other_child'	=> 1,
			'page_title'				=> '',
			'page_disp_level'			=> 2,
			'page_exclude_tree'			=> '',
		);

		$this->WP_Widget( 'sub_navi', 'サブナビ', $widget_ops, $widget_ops );
	}

	function widget( $args, $instance ) {
		global $post;
		
		$instance = wp_parse_args( (array)$instance, $this->defaults );

//		var_dump( $args, $instance );
		$output = '';
		if ( is_home() ) {
			switch ( $instance['home_display'] ) {
			case 'latest' :
				$orderby = 'date';
				$widget_title = '最新情報';
				break;
			case 'modify' :
				$orderby = 'modified';
				$widget_title = '更新情報';
				break;
			default :
				return;
			}
			if ( $instance['home_title'] ) {
				$widget_title = $instance['home_title'];
			}
			$limit = absint( $instance['home_disp_nums'] ) ? absint( $instance['home_disp_nums'] ) : $this->defaults['home_disp_nums'];
			$home_posts = get_posts( array( 'orderby' => $orderby, 'post_type' => $instance['home_post_type'], 'showposts' => $limit ) );
			foreach ( $home_posts as $home_post ) {
				$output .= '<li><a href="' . get_permalink( $home_post->ID ) . '">' . apply_filters( 'the_title',  $home_post->post_title ) . '</a></li>' . "\n";
			}
		} elseif ( is_single() || is_category() || is_date() || is_author() ) {

			switch ( $instance['post_display'] ) {
			case 'all_cat' :
				$child_of = 0;
				$widget_title = __( 'Category' );
				break;
			case 'root_cat' :
				if ( is_single() ) {
					$current = get_the_category();
					$child_of = array();
					foreach ( $current as $cat ) {
						$ancestors = get_ancestors( $cat->term_id, 'category' );
						if ( count( $ancestors ) ) {
							$child_of[] = array_pop( $ancestors );
						} else {
							$child_of[] = $cat->term_id;
						}
					}
					$child_of = array_unique( $child_of );
					$widget_title = count( $current ) == 1 ? $current[0]->name : __( 'Category' );
				} elseif ( is_category() ) {
					$current = get_category( get_query_var( 'cat' ) );
					$ancestors = get_ancestors( $current->term_id, 'category' );
					if ( count( $ancestors ) ) {
						$child_of = array_pop( $ancestors );
						$root = get_term( $child_of, 'category' );
						$widget_title = $root->name;
					} else {
						$child_of = $current->term_id;
						$widget_title = $current->name;
					}
				} else {
					$child_of = array();
					$widget_title = __( 'Category' );
				}

				break;
			case 'current_cat' :
				if ( is_single() ) {
					$current = get_the_category();
					$child_of = array();
					foreach ( $current as $cat ) {
						$child_of[] = $cat->term_id;
					}
					$widget_title = count( $current ) == 1 ? $current[0]->name : __( 'Category' );
				} elseif ( is_category() ) {
					$current = get_category( get_query_var( 'cat' ) );
					$child_of = $current->term_id;
					$widget_title = $current->name;
				} else {
					$child_of = array();
					$widget_title = __( 'Category' );
				}
				break;
			case 'y_archives' :
				$archive_type = 'yearly';
				$widget_title = __( 'Archives' );
				add_filter( 'get_archives_link', array( &$this, 'add_nen_for_get_archives' ) );
				break;
			case 'm_archives' :
				$archive_type = 'monthly';
				$widget_title = __( 'Archives' );
				break;

			default :
				return;
			}

			if ( $instance['post_title'] ) {
				$widget_title = $instance['post_title'];
			}
			if ( strpos( $instance['post_display'], 'archives' ) === false ) {
				if ( ! is_array( $child_of ) ) {
					$child_of = array( $child_of );
				}
				foreach ( $child_of as $cof ) {
					if ( $cof ) {
						$output .= wp_list_categories( array( 'echo' => 0, 'taxonomy' => 'category', 'title_li' => '', 'include' => $cof, 'hide_empty' => 0 ) );
					}
					$output .= wp_list_categories( array( 'echo' => 0, 'taxonomy' => 'category', 'title_li' => '', 'child_of' => $cof, 'orderby' => $instance['cat_orderby'], 'order' => $instance['cat_order'], 'show_option_none' => '' ) );
				}
			} else {
				$limit = absint( $instance['post_disp_nums'] ) ? absint( $instance['post_disp_nums'] ) : $this->defaults['post_disp_nums'];
				$output .= wp_get_archives( array( 'echo' => 0, 'type' => $archive_type, 'limit' => $limit ) );
			}
		} elseif ( is_page() && ! is_front_page() ) {
			$include_ids = '';
			switch ( $instance['page_display'] ) {
			case 'root' :
				$ancestors = get_post_ancestors( $post );
				if ( $ancestors ) {
					$child_of = array_pop( $ancestors );
					$root_post = get_post( $child_of );
					$widget_title = $root_post->post_title;	
				} else {
					$child_of = $post->ID;
					$widget_title = $post->post_title;
				}
				break;
			case 'root_current' :
				$ancestors = get_post_ancestors( $post );
				$instance['page_disp_level'] = count( $ancestors ) + $instance['page_disp_level'];
				if ( $ancestors ) {
					$child_of = array_pop( $ancestors );
					$root_post = get_post( $child_of );
					$widget_title = $root_post->post_title;	
					$exclude_ids = array();
					$first_children = get_children( array( 'post_parent' => $child_of, 'post_type' => 'page', 'post_status' => 'publish', 'exclude' => $ancestors ? $ancestors[count($ancestors)-1] : $post->ID ) );
					if ( $first_children ) {
						$tmp_arr = array();
						foreach ( $first_children as $first_child ) {
							$tmp_arr[] = $first_child->ID;
						}
						$ancestors = array_merge( $ancestors, $tmp_arr );
					}
					if ( $ancestors ) {
						foreach ( $ancestors as $ancestor ) {
							$children = get_children( array( 'post_parent' => $ancestor, 'post_type' => 'page', 'post_status' => 'publish', 'exclude' => $post->ID . ',' .implode( ',', $ancestors ) ) );
							if ( $children ) {
								foreach ( $children as $child ) {
									$exclude_ids[] = $child->ID;
								}
							}
						}
						$instance['page_exclude_tree'] = $instance['page_exclude_tree'] ? $instance['page_exclude_tree'] . ',' . implode( ',', $exclude_ids ) : implode( ',', $exclude_ids );
					}
				} else {
					$child_of = $post->ID;
					$widget_title = $post->post_title;
				}
				break;
			case 'current' :
				$child_of = $post->ID;
				$widget_title = $post->post_title;
				break;
			default :
				return;
			}
			
			if ( $instance['page_title'] ) {
				$widget_title = $instance['page_title'];
			}
			
			$depth = absint( $instance['page_disp_level'] ) ? absint( $instance['page_disp_level'] ) : $this->defaults['page_disp_level'];

			$walker = new Walker_pageNavi;
			if ( $instance['page_display_child_of'] && ! in_array( $child_of, explode( ',', $instance['page_exclude_tree'] ) ) ) {
				$output .= wp_list_pages(
					array(
						'echo'     => 0,
						'title_li' => '',
						'include'  => $child_of,
						'walker'   => $walker
					)
				);
			}
			$output .= wp_list_pages(
				array(
					'echo'         => 0,
					'title_li'     => '',
					'child_of'     => $child_of,
					'depth'        => $depth,
					'exclude'      => $instance['page_exclude_tree'],
					'walker'   => $walker
				)
			);
		} elseif ( get_query_var( 'taxonomy' ) && is_taxonomy_hierarchical( get_query_var( 'taxonomy' ) ) ) {
/*
			$taxonomy = get_query_var( 'taxonomy' ) ? get_query_var( 'taxonomy' ) : 'category';
			if ( is_category() ) {
				$current = get_category( get_query_var( 'cat' ) );
			} else {
				$current = get_term_by( 'slug', get_query_var( 'term' ), $taxonomy );
			}
			switch ( $instance['cat_display'] ) {
			case 'all' :
				$child_of = 0;
				$taxonomy_object = get_taxonomy( $taxonomy );
				$widget_title = $taxonomy == 'category' ? __( 'Category' ) : $taxonomy_object->label;
				break;
			case 'root' :
				$ancestors = get_ancestors( $current->term_id, $taxonomy );
				if ( count( $ancestors ) ) {
					$child_of = array_pop( $ancestors );
					$root = get_term( $child_of, $taxonomy );
					$widget_title = $root->name;
				} else {
					$child_of = $current->term_id;
					$widget_title = $current->name;
				}
				break;
			case 'current' :
				$child_of = $current->term_id;
				$widget_title = $current->name;
				break;
			default :
				return;
			}
			if ( $instance['cat_title'] ) {
				$widget_title = $instance['cat_title'];
			}
			if ( $child_of ) {
				$output .= wp_list_categories( array( 'echo' => 0, 'taxonomy' => $taxonomy, 'title_li' => '', 'include' => $child_of, 'hide_empty' => 0 ) );
			}
			$output .= wp_list_categories( array( 'echo' => 0, 'taxonomy' => $taxonomy, 'title_li' => '', 'child_of' => $child_of, 'orderby' => $instance['cat_orderby'], 'order' => $instance['cat_order'], 'show_option_none' => '' ) );
*/
		}
		if ( $output ) {
			echo $args['before_widget'] . "\n";
			echo $args['before_title'] . apply_filters( 'the_title', $widget_title ) . $args['after_title'] . "\n";
			echo '<ul class="sub_navi">' . "\n";
			echo $output;
			echo "</ul>\n";
			echo $args['after_widget'] . "\n";

		}
	}

	function update( $new_instance, $old_instance ) {
		// validate
		if ( ! isset( $new_instance['page_display_child_of'] ) ) {
			$new_instance['page_display_child_of'] = 0;
		}
		if ( ! isset( $new_instance['page_exclude_other_child'] ) ) {
			$new_instance['page_exclude_other_child'] = 0;
		}

		$new_instance['page_exclude_tree'] = mb_convert_kana( $new_instance['page_exclude_tree'], 'a' );
		$new_instance['page_exclude_tree'] = preg_replace( '/[^\d,]/', '', $new_instance['page_exclude_tree'] );
		$new_instance['page_exclude_tree'] = preg_replace( '/[,]+/', ',', $new_instance['page_exclude_tree'] );
		$new_instance['page_exclude_tree'] = trim( $new_instance['page_exclude_tree'], ',' );
		return $new_instance;
	}
 
	function form( $instance ) {
//		var_dump( $instance );
		$custom_post_types = get_post_types( array( 'public' => true, '_builtin' => false, 'publicly_queryable' => true ), false );
		$instance = wp_parse_args( (array)$instance, $this->defaults );
?>

	<h5>ホーム</h5>
	<p>表示内容：<br />
		<select name="<?php echo $this->get_field_name('home_display'); ?>">
			<option value="none">表示しない</option>
			<option value="latest"<?php echo $instance['home_display'] == 'latest' ? ' selected="selected"' : ''; ?>>最新情報</option>
			<option value="modify"<?php echo $instance['home_display'] == 'modify' ? ' selected="selected"' : ''; ?>>更新情報</option>
		</select>
	</p>
	<p>タイトル：<br />
		<input type="text" size="30" name="<?php echo $this->get_field_name('home_title'); ?>" value="<?php echo esc_html( $instance['home_title'] ); ?>" />
	</p>
	<p>表示数：<br />
		<input type="text" size="2" name="<?php echo $this->get_field_name('home_disp_nums'); ?>" value="<?php echo esc_html( $instance['home_disp_nums'] ); ?>" />
	</p>
	<p>表示タイプ：<br />
		<label for="<?php echo $this->get_field_name('home_post_type'); ?>_post">
			<input type="checkbox" name="<?php echo $this->get_field_name('home_post_type'); ?>[]" id="<?php echo $this->get_field_name('home_post_type'); ?>_post" value="post"<?php echo in_array( 'post', $instance['home_post_type'] ) ? ' checked="checked"' : ''; ?> />
			投稿
		</label>
		<label for="<?php echo $this->get_field_name('home_post_type'); ?>_page">
			<input type="checkbox" name="<?php echo $this->get_field_name('home_post_type'); ?>[]" id="<?php echo $this->get_field_name('home_post_type'); ?>_page" value="page"<?php echo in_array( 'page', $instance['home_post_type'] ) ? ' checked="checked"' : ''; ?> />
			固定ページ
		</label>
<?php if ( $custom_post_types ) : foreach ( $custom_post_types as $type_slug => $custom_post_type ) : ?>
		<label for="<?php echo $this->get_field_name('home_post_type'); ?>_<?php echo esc_attr( $type_slug ); ?>">
			<input type="checkbox" name="<?php echo $this->get_field_name('home_post_type'); ?>[]" id="<?php echo $this->get_field_name('home_post_type'); ?>_<?php echo esc_attr( $type_slug ); ?>" value="<?php echo esc_attr( $type_slug ); ?>"<?php echo in_array( $type_slug, $instance['home_post_type'] ) ? ' checked="checked"' : ''; ?> />
			<?php echo esc_html( $custom_post_type->label ); ?>
		</label>
<?php endforeach; endif; ?>
	</p>
	<h5>投稿・カテゴリー・タグ・アーカイブ・作成者</h5>
	<p>表示内容：<br />
		<select name="<?php echo $this->get_field_name( 'post_display' ); ?>">
			<option value="none">表示しない</option>
			<option value="all_cat"<?php echo $instance['post_display'] == 'all_cat' ? ' selected="selected"' : ''; ?>>すべてのカテゴリー</option>
			<option value="root_cat"<?php echo $instance['post_display'] == 'root_cat' ? ' selected="selected"' : ''; ?>>最上位カテゴリーの子カテゴリー</option>
			<option value="current_cat"<?php echo $instance['post_display'] == 'current_cat' ? ' selected="selected"' : ''; ?>>表示中の子カテゴリー</option>
			<option value="y_archives"<?php echo $instance['post_display'] == 'y_archives' ? ' selected="selected"' : ''; ?>>年別アーカイブ</option>
			<option value="m_archives"<?php echo $instance['post_display'] == 'm_archives' ? ' selected="selected"' : ''; ?>>月別アーカイブ</option>
		</select>
	</p>
	<p>タイトル：<br />
		<input type="text" size="30" name="<?php echo $this->get_field_name( 'post_title' ); ?>" value="<?php echo esc_html( $instance['post_title'] ); ?>" />
	</p>
	<p>カテゴリー表示順：<br />
		<select name="<?php echo $this->get_field_name( 'cat_orderby' ); ?>">
			<option value="name"<?php echo $instance['cat_orderby'] == 'name' ? ' selected="selected"' : ''; ?>>名前順</option>
			<option value="slug"<?php echo $instance['cat_orderby'] == 'slug' ? ' selected="selected"' : ''; ?>>カテゴリースラッグ</option>
			<option value="count"<?php echo $instance['cat_orderby'] == 'count' ? ' selected="selected"' : ''; ?>>投稿数</option>
		</select>
		<select name="<?php echo $this->get_field_name( 'cat_order' ); ?>">
			<option value="asc"<?php echo $instance['cat_order'] == 'asc' ? ' selected="selected"' : ''; ?>>昇順</option>
			<option value="desc"<?php echo $instance['cat_order'] == 'desc' ? ' selected="selected"' : ''; ?>>降順</option>
		</select>
	</p>

	<p>アーカイブ表示数：<br />
		<input type="text" size="2" name="<?php echo $this->get_field_name('post_disp_nums'); ?>" value="<?php echo esc_html( $instance['post_disp_nums'] ); ?>" />
	</p>

	<h5>固定ページ</h5>
	<p>表示内容：<br />
		<select name="<?php echo $this->get_field_name( 'page_display' ); ?>">
			<option value="none">表示しない</option>
			<option value="root"<?php echo $instance['page_display'] == 'root' ? ' selected="selected"' : ''; ?>>最上位を基点とした下層ページを表示</option>
			<option value="root_current"<?php echo $instance['page_display'] == 'root_current' ? ' selected="selected"' : ''; ?>>最上位を基点、第一、上位、子ページを表示</option>
			<option value="current"<?php echo $instance['page_display'] == 'current' ? ' selected="selected"' : ''; ?>>現在地を基点とした下層ページを表示</option>
		</select><br />
		<input type="checkbox" id="<?php echo $this->get_field_name( 'page_display_child_of' ); ?>" name="<?php echo $this->get_field_name( 'page_display_child_of' ); ?>" value="1"<?php echo $instance['page_display_child_of'] ? ' checked="checked"' : ''; ?> />
		<label for="<?php echo $this->get_field_name( 'page_display_child_of' ); ?>">基点ページを表示する</label>
	</p>
	<p>タイトル：<br />
		<input type="text" size="30" name="<?php echo $this->get_field_name( 'page_title' ); ?>" value="<?php echo esc_html( $instance['page_title'] ); ?>" />
	</p>

	<p>表示階層数：<br />
		<input type="text" size="3" name="<?php echo $this->get_field_name('page_disp_level'); ?>" value="<?php echo esc_html( $instance['page_disp_level'] ); ?>" />
	</p>
	<p>除外ページID：<br />
		<input type="text" size="30" name="<?php echo $this->get_field_name('page_exclude_tree'); ?>" value="<?php echo esc_html( $instance['page_exclude_tree'] ); ?>" />
	</p>

<?php
	}
	
	
	function add_nen_for_get_archives( $link_html ) {
		$regex = array ( 
			"/ title='([\d]{4})'/"	=> " title='$1年'",
			"/ ([\d]{4}) /"			=> " $1年 ",
			"/>([\d]{4})<\/a>/"		=> ">$1年</a>"
		);
		$link_html = preg_replace( array_keys( $regex ), $regex, $link_html );
		return $link_html;
	}
} // widget end

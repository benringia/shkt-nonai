<?php
/*
 Plugin Name: WP SiteManager
 Plugin URI: http://www.prime-strategy.co.jp/
 Description: WP SiteManager は、WordPress を CMS として利用する際に必須となる機能を複数搭載した統合プラグインです。
 Author: Prime Strategy Co.,LTD.
 Version: 1.0.15
 Author URI: http://www.prime-strategy.co.jp/
 License: GPLv2 or later
*/

class WP_SiteManager {
	var $version;
	var $enable_modules;
	var $instance;
	var $root;
	var $api_server = '';

	function __construct() {
		$data = get_file_data( __FILE__, array( 'version' => 'Version' ) );
		$this->version = $data['version'];
		$this->instance = new stdClass();

		define( 'CMS_MODULE_DIR', dirname( __FILE__ ) . '/modules' );
		$this->root = plugin_basename( __FILE__ );
		if ( is_admin() ) {
			$page_hook = 'toplevel_page_' . str_replace( '.php', '', $this->root );

			// WP SiteManagerの基本メニュー出力
			add_action( 'admin_menu'			, array( &$this, 'add_cms_menu' ) );

			// WP SiteManager管理画面共通のCSS出力
			add_action( 'admin_print_styles-' . $page_hook								, array( &$this, 'print_icon_style' ) );

			// モジュール一覧ページ用のCSS出力
			add_action( 'admin_print_styles-' . $page_hook								, array( &$this, 'module_page_styles' ) );

			// モジュールの有効/無効切り替えプロセス
			add_action( 'load-' . $page_hook											, array( &$this, 'update_disabled_modules' ) );

			// 一般設定のデータ更新処理
//			add_action( 'wp-sitemanager_page_wp-sitemanager-general'					, array( &$this, 'update_general' ) );

			// WP SiteManager管理画面共通のCSS出力
//			add_action( 'admin_print_styles-wp-sitemanager_page_wp-sitemanager-general'	, array( &$this, 'print_icon_style' ) );

			// アクセス設定のデータ更新処理
			add_action( 'wp-sitemanager_page_wp-sitemanager-access'						, array( &$this, 'update_access' ) );

			// WP SiteManager管理画面共通のCSS出力
			add_action( 'admin_print_styles-wp-sitemanager_page_wp-sitemanager-access'	, array( &$this, 'print_icon_style' ) );

			register_activation_hook( __FILE__											, array( &$this, 'do_activation_module_hooks' ) );
		}
		add_action( 'infinity_key_auth_update_hook'									, array( &$this, 'api_key_auth_update' ) );

		$this->load_modules();
	}

	/*
	 * 
	 */
	private function is_api_key_setuped() {
		return get_option( 'infinity_api_key', array() );
	}


	private function get_api_key() {

	}
	
	
	public function do_activation_module_hooks() {
		$installed_modules = $this->get_modules();
		foreach ( $installed_modules as $slug => $module ) {
			do_action( 'enabled_sitemanager_module-' . $slug );
		}
	}

	/*
	 * 管理画面のメニューに基本メニューの追加を行います。
	 * 基本メニューにはアクションフックのみが記述され、モジュールで設定項目を追加することが可能になっています。
	 * モジュールのadd_submenu_pageがadd_object_pageより先にあるのは、サブメニューをメインメニュー名と異なるものにするためなので修正しないでください。
	 * @since 0.0.1
	 */
	public function add_cms_menu() {
		add_submenu_page( $this->root, 'モジュール', 'モジュール', 'administrator', __FILE__, array( &$this, 'manage_module_page' ) );
		add_object_page( 'WP SiteManager', 'WP SiteManager', 'administrator', __FILE__, array( &$this, 'manage_module_page' ) );
//		add_submenu_page( $this->root, '一般設定', '一般設定', 'administrator', basename( __FILE__ ) . '-general', array( &$this, 'general_page' ) );
		add_submenu_page( $this->root, 'SEO &amp; SMO', 'SEO &amp; SMO', 'administrator', basename( __FILE__ ) . '-access', array( &$this, 'access_page' ) );
	}

	/*
	 * 有効化されているモジュールの読み込みを行います。
	 * 現状、起動毎にディレクトリ内のファイルを全て精査しているのであまり効率が良いとは言えません。
	 * プラグイン同様に有効化されているモジュールのみをDBから読み込み、ディレクトリ内の精査はモジュールページでのみ行うようにすべきでしょう。
	 * @since 0.0.1
	 */
	private function load_modules() {
		$installed_modules = $this->get_modules();
		$disabled_modules = $this->get_disabled_modules();
		foreach ( $installed_modules as $slug => $module ) {
			if ( ! in_array( $slug, $disabled_modules ) ) {
				$instanse = str_replace( '-', '_', $slug );
				require_once( CMS_MODULE_DIR . '/' . $slug . '.php' );
			}
		}
	}


	private function auth_api_key() {
		$api_key = $this->is_api_key_setuped();
		if ( ! $api_key ) { return false; }
		if ( ! $result = get_site_transient( 'infinity_key_auth' ) ) {
			$result = $this->api_key_auth_update();
		} else {
			if ( ! isset( $result['expires'] ) || ( isset( $result['expires'] ) && ( $result['expires'] - time() <= 300 ) && ! wp_next_scheduled( 'infinity_key_auth_update_hook' ) ) ) {
				wp_schedule_single_event( time(), 'infinity_key_auth_update_hook' );
			}
		}
		return $result;
	}


	public function api_key_auth_update() {
		$api_key = $this->is_api_key_setuped();
		$result = wp_remote_post(
			$this->api_server . 'infinity-api.php',
			array(
				'method' => 'POST',
				'timeout' => 5,
				'redirection' => 0,
				'body' => array(
					'account' => $api_key['account'],
					'key'  => $api_key['key']
				),
			)
		);
		if ( isset( $result['response']['code'] ) && $result['response']['code'] == 200 && $result['body'] != 'a:0:{}' ) {
			$expires = time() + 3600;
			$result = array(
				'data'    =>  $result['body'],
				'expires' => $expires
			);
			set_site_transient( 'infinity_key_auth', $result, 3600 );
		} else {
			$result = array();
		}
		return $result;
	}


	/*
	 * モジュール管理ページの表示を行います。
	 * インストールされているモジュールの一覧表示と、組み込み（builtin）以外のモジュールについては、有効化/無効化の切り替えボタンを出力します。
	 * @since 0.0.1
	 */
	public function manage_module_page() {
		$installed_modules = $this->get_modules();
		$disabled_modules = $this->get_disabled_modules();
		$nonce = wp_create_nonce( 'wp-sitemanager-modules' );
		$api_link = add_query_arg( array( 'action' => 'register', 'lang' => get_locale() ),$this->api_server . 'wp-login.php' );
?>
<div class="wrap">
	<?php screen_icon( 'prime-icon32' ); ?>
	<h2>WP SiteManager</h2>
	<h3>モジュール</h3>
<?php
if ( $installed_modules ) : 
	foreach ( $installed_modules as $slug => $module ) : 
		if ( version_compare( $this->version, $module['introduced'], '>=' ) ) :
?>
	<div class="cms-module">
		<h4><?php echo esc_html( $module['name'] ); ?></h4>
		<p><?php echo esc_html( $module['description'] ); ?></p>

<?php
			if ( ! in_array( strtolower( $module['builtin'] ), array( '1', 'true' ) ) ) :
				if ( in_array( $slug, $disabled_modules ) ) :
					$url = add_query_arg( array( 'action' => 'enable', 'module' => $slug, '_nonce' => $nonce ) );
?>
		<span class="activate"><a href="<?php echo esc_url( $url ); ?>" class="button">有効化</a></span>
<?php
				else :
					$url = add_query_arg( array( 'action' => 'disable', 'module' => $slug, '_nonce' => $nonce ) );
?>
		<span class="deactivate"><a href="<?php echo esc_url( $url ); ?>" class="button">停止</a></span>
<?php
				endif;
			endif;
?>
	</div>
<?php
		endif;
	endforeach;
else :
?>
	<p>モジュールがインストールされていません。</p>
<?php
endif;
?>
	<div id="developper_information" class="clear">
		<div id="poweredby">
			<a href="http://www.prime-strategy.co.jp/" target="_blank"><img src="<?php echo preg_replace( '/^https?:/', '', plugin_dir_url( __FILE__ ) ) . 'images/ps_logo.png'; ?>" alt="Powered by Prime Strategy" /></a>
		</div>
	</div>
</div>
<?php
	}
	
	/*
	 * モジュール管理ページで利用するCSSの出力を行います。
	 * @since 0.0.1
	 */
	public function module_page_styles() {
?>
<style type="text/css" charset="utf-8">
.cms-module {
	background: #fff;
	float:  left;
	width:  180px;
	height: 170px;
	margin: 0 0 15px 15px;
	padding: 5px 10px;
	border: solid 1px #ddd;
	border-radius: 3px;
	box-shadow: 0 1px 3px rgba( 0, 0, 0, 0.1 );
	overflow: hidden;
}
.cms-module h4 {
	padding-bottom: 3px;
	border-bottom: solid 1px #ed6d46;
}
</style>
<?php
	}

	/*
	 * モジュールの有効/無効の切り替えを行います。
	 * @since 0.0.1
	 */
	public function update_disabled_modules() {
		$installed_modules = $this->get_modules();
		$disabled_modules = $this->get_disabled_modules();

		if ( isset( $_GET['action'] ) && wp_verify_nonce( $_GET['_nonce'], 'wp-sitemanager-modules' ) ) {
			switch ( $_GET['action'] ) {
				case 'enable' :
					if ( in_array( $_GET['module'], array_keys( $installed_modules ) ) && in_array( $_GET['module'], $disabled_modules ) && ! in_array( strtolower( $installed_modules[$_GET['module']]['builtin'] ), array( '1', 'true' ) ) ) {
						$slug = sanitize_file_name( $_GET['module'] );
						$key = array_search( $_GET['module'], $disabled_modules );
							unset( $disabled_modules[$key] );
						update_option( 'disabled_modules', $disabled_modules );
						$instanse = str_replace( '-', '_', $slug );
						require_once( CMS_MODULE_DIR . '/' . $slug . '.php' );
						do_action( 'enabled_infinity_module-' . $slug );
						$redirect = remove_query_arg( array( 'action', 'module', '_nonce' ) );
						wp_redirect( $redirect );
						exit;
					}
					break;
				case 'disable' ;
					if ( in_array( $_GET['module'], array_keys( $installed_modules ) ) && ! in_array( $_GET['module'], $disabled_modules ) && ! in_array( strtolower( $installed_modules[$_GET['module']]['builtin'] ), array( '1', 'true' ) ) ) {
						$disabled_modules[] = $_GET['module'];
						update_option( 'disabled_modules', $disabled_modules );
						do_action( 'disabled_infinity_module-' . $_GET['module'] );
						$redirect = remove_query_arg( array( 'action', 'module', '_nonce' ) );
						wp_redirect( $redirect );
						exit;
					}
					break;
				default :
			}
		} elseif ( isset( $_POST['wp-sitemanager-api-key'] ) ) {
			check_admin_referer( 'wp-sitemanager-api-key' );
			if ( isset( $_POST['infinity-api-account'] ) && $_POST['infinity-api-account'] && isset( $_POST['infinity-api-key'] ) && $_POST['infinity-api-key'] ) {
				$api_key = array(
					'account' => stripslashes_deep( $_POST['infinity-api-account'] ),
					'key'     => stripslashes_deep( $_POST['infinity-api-key'] )
				);
				add_option( 'infinity_api_key', $api_key );
			}
		}
	}

	/*
	 * 無効化されているモジュールの取得を行います。
	 * @since 0.0.1
	 */
	private function get_disabled_modules() {
		return apply_filters( 'wp-sitemanager/disabled_modules', get_option( 'disabled_modules', array() ) );
	}

	/*
	 * moduleディレクトリ内のファイル精査を行い、全モジュールの取得を行います。
	 * 	 * @since 0.0.1
	 */
	private function get_modules() {
		$files = array();
		$modules = array();

		if ( !$dir = @opendir( CMS_MODULE_DIR ) ) {
			return $modules;
		}
		while ( false !== $file = readdir( $dir ) ) {
			if ( '.' == substr( $file, 0, 1 ) || '.php' != substr( $file, -4 ) ) {
				continue;
			}
			$file = CMS_MODULE_DIR ."/$file";
			if ( !is_file( $file ) ) {
				continue;
			}
			$files[] = $file;
		}

		closedir( $dir );
//		var_dump( $files );
		
		if ( $files ) {
			foreach ( $files as $file ) {
				$headers = $this->get_module_headers( $file );

				if ( $headers['name'] ) {
					$slug = $this->get_module_slug( $file );
					$modules[$slug] = $headers;
				}
			}
		}
		uasort( $modules, array( $this, 'module_sort' ) );

		return $modules;
	}

	/*
	 * モジュールのコメントデータからモジュールに関するデータの取得を行います。
	 * @since 0.0.1
	 */
	private function get_module_headers( $module ) {
		if ( ! file_exists( $module ) ) { return false; }
		
		$header_items = array(
			'name'        => 'cms module',
			'description' => 'Module Description',
			'order'       => 'Order',
			'introduced'  => 'First Introduced',
			'changed'     => 'Major Changes In',
			'builtin'     => 'Builtin',
			'free'        => 'Free',
		);
		return get_file_data( $module, $header_items, 'wp-sitemanager' );
	}

	/*
	 * モジュールのファイル名を元に、モジュールのスラッグを取得します。
	 * @since 0.0.1
	 */
	private function get_module_slug( $module ) {
		return str_replace( '.php', '', basename( $module ) );
	}

	/*
	 * モジュールのorderを元にソートを行うためのコールバック用メソッド
	 * @since 0.0.1
	 * 
	 * @param array ソート用モジュールデータa
	 * @param array ソート用モジュールデータb
	 * @return int
	 */
	private function module_sort( $a, $b ) {
		$order_a = is_numeric( $a['order'] ) ? $a['order'] : 0;
		$order_b = is_numeric( $b['order'] ) ? $b['order'] : 0;
		if ( $order_a == $order_b ) { return 0; }
		return ( $order_a < $order_b ) ? -1 : 1;
	}

	/*
	 * 管理画面用のCSSを出力します。
	 * @since 0.0.1
	 */
	public function print_icon_style() {
		$url = preg_replace( '/^https?:/', '', plugin_dir_url( __FILE__ ) ) . 'images/icon32.png';
?>
<style type="text/css" charset="utf-8">
#icon-prime-icon32 {
	background: url( <?php echo esc_url( $url ); ?> ) no-repeat center;
}
#developper_information {
	margin: 20px 30px 10px;
}
#developper_information .content {
	padding: 10px 20px;
}
#poweredby {
	text-align: right;
}
.setting-section {
	padding: 20px 0;
	border-top: solid 1px #fff;
	border-bottom: solid 1px #ddd;
}
#og-image img {
	max-width: 150px;
	max-height: 150px;
}
</style>
<?php
	}

	/*
	 * 基本ページの一般設定の表示を行います。
	 * TODO nonceの出力と検証はこっちで行うようにしておけば、モジュール側ではデータの更新処理のみの実装で十分となる。
	 * @since 0.0.1
	 */
	public function general_page() {
?>
<div class="wrap">
	<?php screen_icon( 'prime-icon32' ); ?>
	<h2>一般設定</h2>
	<form action="" method="post">
		<?php wp_nonce_field( 'wp-sitemanager-general' ); ?>
		<?php do_action( 'wp-sitemanager-general-page' ); ?>
		<?php submit_button( NULL, 'primary', 'wp-sitemanager-general' ); ?>
	</form>
	<div id="developper_information">
		<div id="poweredby">
			<a href="http://www.prime-strategy.co.jp/" target="_blank"><img src="<?php echo preg_replace( '/^https?:/', '', plugin_dir_url( __FILE__ ) ) . 'images/ps_logo.png'; ?>" alt="Powered by Prime Strategy" /></a>
		</div>
	</div>
</div>
<?php
	}

	/*
	 * 一般設定のデータ更新用フック
	 * @since 0.0.1
	 */
	public function update_general() {
		if ( isset( $_POST['wp-sitemanager-general'] ) ) {
			check_admin_referer( 'wp-sitemanager-general' );
			do_action( 'wp-sitemanager-update-general' );
		}
	}

	/*
	 * 基本ページのアクセス設定の表示を行います。
	 * @since 0.0.1
	 */
	public function access_page() {
?>
<div class="wrap">
	<?php screen_icon( 'prime-icon32' ); ?>
	<h2>SEO &amp; SMO</h2>
	<form action="" method="post">
		<?php wp_nonce_field( 'wp-sitemanager-access' ); ?>
		<?php do_action( 'wp-sitemanager-access-page' ); ?>
		<?php submit_button( NULL, 'primary', 'wp-sitemanager-access' ); ?>
	</form>
	<div id="developper_information">
		<div id="poweredby">
			<a href="http://www.prime-strategy.co.jp/" target="_blank"><img src="<?php echo preg_replace( '/^https?:/', '', plugin_dir_url( __FILE__ ) ) . 'images/ps_logo.png'; ?>" alt="Powered by Prime Strategy" /></a>
		</div>
	</div>
</div>
<?php
	}

	/*
	 * アクセス設定のデータ更新用フック
	 * 
	 * @since 0.0.1
	 */
	public function update_access() {
		if ( isset( $_POST['wp-sitemanager-access'] ) ) {
			check_admin_referer( 'wp-sitemanager-access' );
			do_action( 'wp-sitemanager-update-access' );
		}
	}
} // class end
$WP_SiteManager = new WP_SiteManager;
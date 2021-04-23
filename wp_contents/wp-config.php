<?php
if( isset($_SERVER['HTTP_X_SAKURA_FORWARDED_FOR']) ) {
    $_SERVER['HTTPS'] = 'on';
    $_ENV['HTTPS'] = 'on';
    $_SERVER['HTTP_HOST'] = 'shkt-nonai.jp';
    $_SERVER['SERVER_NAME'] = 'shkt-nonai.jp';
    $_ENV['HTTP_HOST'] = 'shkt-nonai.jp';
    $_ENV['SERVER_NAME'] = 'shkt-nonai.jp';
}

/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.osdn.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

/**
 * for webstyle2
 */
//define('DB_NAME', 'webstyle2_test_nonai');
//define('DB_USER', 'webstyle2');
//define('DB_PASSWORD', '3u969wu7sf');
//define('DB_HOST', 'mysql621.db.sakura.ne.jp');

/**
 * for production
 */
// define('DB_NAME', 'cp624438_shkt_nonai');

// define('DB_USER', 'shkt');

// define('DB_PASSWORD', 'shktpass');

// define('DB_HOST', 'localhost');

define('DB_NAME', 'shkt_nonai_wp');

define('DB_USER', 'root');

define('DB_PASSWORD', '');

define('DB_HOST', 'localhost');

// define('WP_HOME', 'http://shkt-nonai.jp');
// define('WP_SITEURL', 'http://shkt-nonai.jp/wp_contents');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '$Hf%lt |yhr#%v^m)+SlQHQz58(zaadK/-?zG38)!1}ncYTRvp+D{TK@elJ3I Ax');
define('SECURE_AUTH_KEY',  '0(W3poD&K3cagGV}Fc3z!/ Ev;+@jH4l!V9jd&ev~yaWyY}d0aE-Z&.VI%Sp)tMx');
define('LOGGED_IN_KEY',    '[&3/lFV5]}{-2mfRmp(3>Xcu3CW.>0=O},|8e#:3]XCi6x.m~d{ZkGs$4ZF6F{Df');
define('NONCE_KEY',        '}}{(5A-T[NM;{0cOD+Y1[!;-S,-N)+|7J?LGo9C TC`Jwp4jjGI`r%A&Mnz)1C|7');
define('AUTH_SALT',        '~Hq}NDftclH7I>|nSIP lq@u1QFxtw*G?LZ]Q~P%yG}qk6IWV~VKOMx8-m8~[HZw');
define('SECURE_AUTH_SALT', '0vlHl*Macd$}*{?E_~l:|j{c[,_4_K:avI-(IV}|E</rVhOA#tiM;Tb}M~+yd{KN');
define('LOGGED_IN_SALT',   ':mqe(fW6w#8Rt!2A2@ 1>@>{$QAfx[8?CDGea]q?w}qE*}F$;Jv7Kj#g4p_34{JS');
define('NONCE_SALT',       'a.cghyM$QLjMAVk&PUH.N&AVNM$}Ln}{2gmOe MbgH<*jDvK#1nYOXa:ZEo0<[(U');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define('WP_DEBUG', false);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/* Wordpressの自動更新を止める */
define( 'AUTOMATIC_UPDATER_DISABLED', true );

<?php
if ( is_admin() ) { return; }

class SiteManagerAdvancedCache {
	private $device_regexes = array(
### DEVICE REGEX ###
	);
	private $sites = array(
### SITES ARRAY ###
	);
	private $allowed_query_keys;
	private $site_mode = ### SITE MODE ###;

	function __construct() {
		global $table_prefix;
		
		if ( $_SERVER['REQUEST_METHOD'] != 'GET' ) { return; }
		if ( defined( 'CACHE_EXCLUDE_IP' ) ) {
			$exclude_ips = explode( '|', CACHE_EXCLUDE_IP );
			foreach ( $exclude_ips as $exclude_ip ) {
				if ( $_SERVER['REMOTE_ADDR'] == $exclude_ip || preg_match( '/' . preg_quote( $exclude_ip ) . '/', $_SERVER['REMOTE_ADDR'] ) ) {
					return;
				}
			}
		}
		if ( defined( 'CACHE_EXCLUDE_GET' ) && isset( $_GET[CACHE_EXCLUDE_GET] ) ) {
			return;
		}
		foreach ( array_keys( $_COOKIE ) as $key ) {
			if ( strpos( $key, 'wordpress_logged_in_' ) === 0 || strpos( $key, 'comment_author_' ) === 0 ) {
				return;
			}
		}
		### QUERY KEYS ###
		if ( ! $group = $this->get_device_group() ) {
			$group = '';
		}

		switch ( $this->site_mode ) {
		case 'domain' :
			$add_prefix = isset( $this->sites[$_SERVER['SERVER_NAME']] ) && $this->sites[$_SERVER['SERVER_NAME']] != 1 ? $this->sites[$_SERVER['SERVER_NAME']] . '_' : '';
			$site_id = isset( $this->sites[$_SERVER['SERVER_NAME']] ) ? $this->sites[$_SERVER['SERVER_NAME']] : '';
			$table = $table_prefix . $add_prefix;
			break;
			break;
		case 'directory' :
			$key = array_pop( explode( '/', trim( $_SERVER['REQUEST_URI'], '/' ), 2 ) );
			$add_prefix = isset( $this->sites[$key] ) && $this->sites[$key] != 1 ? $this->sites[$key] . '_' : '';
			$site_id = isset( $this->sites[$key] ) ? $this->sites[$key] : '';
			$table = $table_prefix . $add_prefix;
			break;
		default :
			$table = $table_prefix;
			$site_id = '';
		}
### REGEX INCLUDE ###
		$protocol = isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';

		$requerst_query = '';
		$request_uri = parse_url( $_SERVER['REQUEST_URI'] );
		if ( isset( $request_uri['query'] ) ) {
			parse_str( $request_uri['query'], $requerst_query );

			foreach ( $requerst_query as $key => $var ) {
				if ( ! in_array( $key, $this->allowed_query_keys ) ) {
					unset( $requerst_query[$key] );
				}
			}
			ksort( $requerst_query );
			$requerst_query = http_build_query( $requerst_query );
		}

		if ( $requerst_query ) {
			$request_uri = $request_uri['path'] . '?' . $requerst_query;
		} else {
			$request_uri = $request_uri['path'];
		}

		$device_url = array(
			$group,
			$protocol,
			$_SERVER['SERVER_NAME'],
			$request_uri
		);
		$device_url = implode( '|', $device_url );
		$hash = md5( $device_url );

		if ( defined( 'CACHE_DB_NAME' ) && defined( 'CACHE_DB_USER' ) && defined( 'CACHE_DB_PASSWORD' ) && defined( 'CACHE_DB_HOST' ) ) {
			$dbset = array(
				'host' => CACHE_DB_HOST,
				'user' => CACHE_DB_USER,
				'pass' => CACHE_DB_PASSWORD,
				'name' => CACHE_DB_NAME
				
			);
		} else {
			$dbset = array(
				'host' => DB_HOST,
				'user' => DB_USER,
				'pass' => DB_PASSWORD,
				'name' => DB_NAME
				
			);
		}

		$dbh = mysql_connect( 
			$dbset['host'],
			$dbset['user'],
			$dbset['pass'],
			true
		);

		if ( $dbh ) {
			if ( function_exists( 'mysql_set_charset' ) ) {
				mysql_set_charset( DB_CHARSET, $dbh );
			} else {
				$sql = 'set names ' . DB_CHARSET;
				mysql_query( $sql, $dbh );
			}
			mysql_select_db( $dbset['name'], $dbh );
			$now = date( 'Y-m-d H:i:s' );
			$sql = "
SELECT	*
FROM	{$table}site_cache
WHERE	`hash` = '$hash'
AND		`expire_time` >= '$now'
";
			$ret = mysql_query( $sql );

			if ( $ret ) {
				while ( $row = mysql_fetch_object( $ret ) ) {
					if ( $row->device_url == $device_url && strpos( $row->content, '<!-- page cached by WP SiteManager -->' ) !== false ) {
						$headers = unserialize( $row->headers );
						if ( $headers ) {
							foreach ( $headers as $key => $header ) {
								header( $key . ': ' . $header );
							}
						}
						echo $row->content;
						exit;
					}
				}
			}
			mysql_close( $dbh );
		}
	}
	
	
	function get_device_group() {
		$path = preg_replace( '#^' . str_replace( '\\', '/', $_SERVER['DOCUMENT_ROOT'] ) . '#', '', str_replace( '\\', '/', ABSPATH ) );

		if ( isset( $_GET['site-view'] ) ) {
			if ( strtolower( $_GET['site-view'] ) == 'pc' ) {
				setcookie( 'site-view', 'pc', 0, $path );
				return false;
			}
			foreach ( $this->device_regexes as $group => $regex ) {
				if ( strtolower( $_GET['site-view'] ) == strtolower( $group ) ) {
					setcookie( 'site-view', $group, 0, $path );
					return $group;
				}
			}
		} elseif ( isset( $_COOKIE['site-view'] ) ) {
			if ( strtolower( $_COOKIE['site-view'] ) == 'pc' ) {
				setcookie( 'site-view', 'pc', 0, $path );
				return false;
			}
			foreach ( $this->device_regexes as $group => $regex ) {
				if ( strtolower( $_COOKIE['site-view'] ) == strtolower( $group ) ) {
					setcookie( 'site-view', $group, 0, $path );
					return $group;
				}
			}
		}

		foreach ( $this->device_regexes as $group => $regex ) {
			if ( preg_match( $regex, $_SERVER['HTTP_USER_AGENT'] ) ) {
				return $group;
			}
		}
		return false;
	}
}
new SiteManagerAdvancedCache();
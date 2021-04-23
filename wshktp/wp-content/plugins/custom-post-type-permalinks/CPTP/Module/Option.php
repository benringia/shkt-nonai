<?php


/**
 *
 * Options.
 *
 * Save Options.
 *
 * @package Custom_Post_Type_Permalinks
 * @since 0.9.6
 *
 * */
class CPTP_Module_Option extends CPTP_Module {

	public function add_hook() {
		add_action( 'admin_init', array( $this, 'save_options' ), 30 );
		register_uninstall_hook( CPTP_PLUGIN_FILE, array( __CLASS__, 'uninstall_hook' ) );
	}

	public function save_options() {

		if ( empty( $_POST['submit'] ) ) {
			return false;
		}

		if ( empty( $_POST['_wp_http_referer'] ) ) {
			return false;
		}

		if ( false === strpos( $_POST['_wp_http_referer'], 'options-permalink.php' ) ) {
			return false;
		}

		if ( empty ( $_POST['_wpnonce'] ) ) {
			return false;
		}
		$nonce = $_POST['_wpnonce'];

		if ( ! wp_verify_nonce( $nonce, 'update-permalink' ) ) {
			return false;
		}

		$post_types = CPTP_Util::get_post_types();

		foreach ( $post_types as $post_type ):

			$structure = trim( esc_attr( $_POST[ $post_type . '_structure' ] ) );#get setting

			#default permalink structure
			if ( ! $structure ) {
				$structure = CPTP_DEFAULT_PERMALINK;
			}

			$structure = str_replace( '//', '/', '/' . $structure );# first "/"
			#last "/"
			$lastString = substr( trim( esc_attr( $_POST['permalink_structure'] ) ), - 1 );
			$structure  = rtrim( $structure, '/' );

			if ( $lastString == '/' ) {
				$structure = $structure . '/';
			}

			update_option( $post_type . '_structure', $structure );
		endforeach;

		update_option( 'no_taxonomy_structure', ! isset( $_POST['no_taxonomy_structure'] ) );
		update_option( 'add_post_type_for_tax', isset( $_POST['add_post_type_for_tax'] ) );

	}

	public static function uninstall_hook() {
		foreach ( CPTP_Util::get_post_types() as $post_type ) {
			delete_option( $post_type . '_structure' );
		}

		delete_option( 'no_taxonomy_structure' );
	}


}
<?php


/**
 *
 * Add Rewrite Rules
 *
 * @package Custom_Post_Type_Permalinks
 * @version 1.0.3
 * @since 0.9.4
 *
 * */
class CPTP_Module_Rewrite extends CPTP_Module {

	/** @var  Array */
	private $post_type_args;
	/** @var  Array */
	private $taxonomy_args;

	public function add_hook() {
		add_action( 'parse_request', array( $this, 'parse_request' ) );

		add_action( 'registered_post_type', array( $this, 'registered_post_type' ), 10, 2 );
		add_action( 'registered_taxonomy', array( $this, 'registered_taxonomy' ), 10, 3 );

		add_action( 'wp_loaded', array( $this, 'add_rewrite_rules' ), 100 );
	}


	public function add_rewrite_rules() {

		foreach ( $this->taxonomy_args as $args ) {
			call_user_func_array( array( $this, 'register_taxonomy_rules' ), $args );
		}

		foreach ( $this->post_type_args as $args ) {
			call_user_func_array( array( $this, 'register_post_type_rules' ), $args );
		}

	}

	/**
	 *
	 * registered_post_type
	 *
	 * queue post_type rewrite.
	 *
	 * @param string $post_type Post type.
	 * @param object $args Arguments used to register the post type.
	 */
	public function registered_post_type( $post_type, $args ) {
		$this->post_type_args[] = func_get_args();
	}

	/**
	 *
	 * registered_taxonomy
	 *
	 * queue taxonomy rewrite.
	 *
	 * @param string $taxonomy Taxonomy slug.
	 * @param array|string $object_type Object type or array of object types.
	 * @param array $args Array of taxonomy registration arguments.
	 */
	public function registered_taxonomy( $taxonomy, $object_type, $args ) {
		$this->taxonomy_args[] = func_get_args();
	}


	/**
	 *
	 * register_post_type_rules
	 *  ** add rewrite tag for Custom Post Type.
	 * @version 1.1
	 * @since 0.9
	 *
	 * @param string $post_type
	 * @param object $args
	 *
	 */

	public function register_post_type_rules( $post_type, $args ) {

		/** @var WP_Rewrite $wp_rewrite */
		global $wp_rewrite;

		if ( $args->_builtin or ! $args->publicly_queryable or ! $args->show_ui ) {
			return;
		}
		$permalink = CPTP_Util::get_permalink_structure( $post_type );

		if ( ! $permalink ) {
			$permalink = CPTP_DEFAULT_PERMALINK;
		}

		$permalink = '%' . $post_type . '_slug%' . $permalink;
		$permalink = str_replace( '%postname%', '%' . $post_type . '%', $permalink );

		add_rewrite_tag( '%' . $post_type . '_slug%', '(' . $args->rewrite['slug'] . ')', 'post_type=' . $post_type . '&slug=' );

		$taxonomies = CPTP_Util::get_taxonomies( true );
		foreach ( $taxonomies as $taxonomy => $objects ):
			$wp_rewrite->add_rewrite_tag( "%$taxonomy%", '(.+?)', "$taxonomy=" );
		endforeach;

		$rewrite_args = $args->rewrite;
		if ( ! is_array( $rewrite_args ) ) {
			$rewrite_args = array( 'with_front' => $args->rewrite );
		}

		$slug = $args->rewrite['slug'];
		if ( $args->has_archive ) {
			if ( is_string( $args->has_archive ) ) {
				$slug = $args->has_archive;
			};

			if ( $args->rewrite['with_front'] ) {
				$slug = substr( $wp_rewrite->front, 1 ) . $slug;
			}

			$date_front = CPTP_Util::get_date_front( $post_type );

			add_rewrite_rule( $slug . $date_front . '/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$', 'index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . $date_front . '/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$', 'index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . $date_front . '/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$', 'index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . $date_front . '/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$', 'index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . $date_front . '/([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$', 'index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . $date_front . '/([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$', 'index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . $date_front . '/([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$', 'index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . $date_front . '/([0-9]{4})/([0-9]{1,2})/?$', 'index.php?year=$matches[1]&monthnum=$matches[2]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . $date_front . '/([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$', 'index.php?year=$matches[1]&feed=$matches[2]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . $date_front . '/([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$', 'index.php?year=$matches[1]&feed=$matches[2]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . $date_front . '/([0-9]{4})/page/?([0-9]{1,})/?$', 'index.php?year=$matches[1]&paged=$matches[2]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . $date_front . '/([0-9]{4})/?$', 'index.php?year=$matches[1]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . '/author/([^/]+)/page/?([0-9]{1,})/?$', 'index.php?author_name=$matches[1]&paged=$matches[2]&post_type=' . $post_type, 'top' );
			add_rewrite_rule( $slug . '/author/([^/]+)/?$', 'index.php?author_name=$matches[1]&post_type=' . $post_type, 'top' );

			if( in_array( 'category', $args->taxonomies ) ) {

				$category_base = get_option( 'category_base' );
				if( !$category_base ) {
					$category_base = 'category';
				}

				add_rewrite_rule( $slug . '/'. $category_base . '/([^/]+)/page/?([0-9]{1,})/?$', 'index.php?category_name=$matches[1]&paged=$matches[2]&post_type=' . $post_type, 'top' );
				add_rewrite_rule( $slug . '/'. $category_base . '/([^/]+)/?$', 'index.php?category_name=$matches[1]&post_type=' . $post_type, 'top' );

			}

			do_action( 'CPTP_registered_' . $post_type . '_rules', $args, $slug );
		}

		$rewrite_args['walk_dirs'] = false;
		add_permastruct( $post_type, $permalink, $rewrite_args );

	}


	/**
	 *
	 * register_taxonomy_rules
	 *
	 * @param string $taxonomy
	 * @param array|string $object_type
	 * @param array $args
	 *
	 * @return void
	 */
	public function register_taxonomy_rules( $taxonomy, $object_type, $args ) {

		if ( get_option( 'no_taxonomy_structure' ) ) {
			return;
		}
		if ( $args['_builtin'] ) {
			return;
		}

		global $wp_rewrite;

		$post_types = $args['object_type'];
		foreach ( $post_types as $post_type ):
			$post_type_obj = get_post_type_object( $post_type );
			if ( ! empty( $post_type_obj->rewrite['slug'] ) ) {
				$slug = $post_type_obj->rewrite['slug'];
			} else {
				$slug = $post_type;
			}

			if ( ! empty( $post_type_obj->has_archive ) && is_string( $post_type_obj->has_archive ) ) {
				$slug = $post_type_obj->has_archive;
			};


			if ( ! empty( $post_type_obj->rewrite['with_front'] ) ) {
				$slug = substr( $wp_rewrite->front, 1 ) . $slug;
			}

			if ( 'category' == $taxonomy ) {
				$taxonomy_slug = ( $cb = get_option( 'category_base' ) ) ? $cb : $taxonomy;
				$taxonomy_key  = 'category_name';
			} else {
				// Edit by [Xiphe]
				if ( isset( $args['rewrite']['slug'] ) ) {
					$taxonomy_slug = $args['rewrite']['slug'];
				} else {
					$taxonomy_slug = $taxonomy;
				}
				// [Xiphe] stop

				$taxonomy_key = $taxonomy;
			}

			$rules = array(
				//feed.
				array(
					"regex"    => "%s/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$",
					"redirect" => "index.php?{$taxonomy_key}=\$matches[1]&feed=\$matches[2]"
				),
				array(
					"regex"    => "%s/(.+?)/(feed|rdf|rss|rss2|atom)/?$",
					"redirect" => "index.php?{$taxonomy_key}=\$matches[1]&feed=\$matches[2]"
				),
				//year
				array(
					"regex"    => "%s/(.+?)/date/([0-9]{4})/?$",
					"redirect" => "index.php?{$taxonomy_key}=\$matches[1]&year=\$matches[2]"
				),
				array(
					"regex"    => "%s/(.+?)/date/([0-9]{4})/page/?([0-9]{1,})/?$",
					"redirect" => "index.php?{$taxonomy_key}=\$matches[1]&year=\$matches[2]&paged=\$matches[3]"
				),
				//monthnum
				array(
					"regex"    => "%s/(.+?)/date/([0-9]{4})/([0-9]{1,2})/?$",
					"redirect" => "index.php?{$taxonomy_key}=\$matches[1]&year=\$matches[2]&monthnum=\$matches[3]"
				),
				array(
					"regex"    => "%s/(.+?)/date/([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$",
					"redirect" => "index.php?{$taxonomy_key}=\$matches[1]&year=\$matches[2]&monthnum=\$matches[3]&paged=\$matches[4]"
				),
				//day
				array(
					"regex"    => "%s/(.+?)/date/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$",
					"redirect" => "index.php?{$taxonomy_key}=\$matches[1]&year=\$matches[2]&monthnum=\$matches[3]&day=\$matches[4]"
				),
				array(
					"regex"    => "%s/(.+?)/date/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$",
					"redirect" => "index.php?{$taxonomy_key}=\$matches[1]&year=\$matches[2]&monthnum=\$matches[3]&day=\$matches[4]&paged=\$matches[5]"
				),
				//paging
				array(
					"regex"    => "%s/(.+?)/page/?([0-9]{1,})/?$",
					"redirect" => "index.php?{$taxonomy_key}=\$matches[1]&paged=\$matches[2]"
				),
				//tax archive.
				array(
					"regex" => "%s/(.+?)/?$",
					"redirect" => "index.php?{$taxonomy_key}=\$matches[1]"
				),
			);

			//no post_type slug.
			foreach ( $rules as $rule ) {
				$regex    = sprintf( $rule['regex'], "{$taxonomy_slug}" );
				$redirect = $rule['redirect'];
				add_rewrite_rule( $regex, $redirect, 'top' );
			}

			if ( get_option( 'add_post_type_for_tax' ) ) {
				foreach ( $rules as $rule ) {
					$regex    = sprintf( $rule['regex'], "{$slug}/{$taxonomy_slug}" );
					$redirect = $rule['redirect'] . "&post_type={$post_type}";
					add_rewrite_rule( $regex, $redirect, 'top' );
				}

			} else {
				foreach ( $rules as $rule ) {
					$regex    = sprintf( $rule['regex'], "{$slug}/{$taxonomy_slug}" );
					$redirect = $rule['redirect'];
					add_rewrite_rule( $regex, $redirect, 'top' );
				}
			}

			do_action( 'CPTP_registered_' . $taxonomy . '_rules', $object_type, $args, $taxonomy_slug );

		endforeach;
	}


	/**
	 *
	 * Fix taxonomy = parent/child => taxonomy => child
	 * @since 0.9.3
	 *
	 * @param WP $obj
	 */
	public function parse_request( $obj ) {
		$taxes = CPTP_Util::get_taxonomies();
		foreach ( $taxes as $key => $tax ) {
			if ( isset( $obj->query_vars[ $tax ] ) ) {
				if ( false !== strpos( $obj->query_vars[ $tax ], '/' ) ) {
					$query_vars = explode( '/', $obj->query_vars[ $tax ] );
					if ( is_array( $query_vars ) ) {
						$obj->query_vars[ $tax ] = array_pop( $query_vars );
					}
				}
			}
		}
	}
}

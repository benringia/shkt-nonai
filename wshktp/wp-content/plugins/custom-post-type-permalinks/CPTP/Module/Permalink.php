<?php


/**
 *
 * CPTP_Permalink
 *
 * Override Permalinks
 * @package Custom_Post_Type_Permalinks
 * @since 0.9.4
 *
 * */
class CPTP_Module_Permalink extends CPTP_Module {


	public function add_hook() {
		add_filter( 'post_type_link', array( $this, 'post_type_link' ), 0, 4 );
		add_filter( 'term_link', array( $this, 'term_link' ), 0, 3 );
		add_filter( 'attachment_link', array( $this, 'attachment_link' ), 20, 2 );
	}


	/**
	 *
	 * Fix permalinks output.
	 *
	 * @param String $post_link
	 * @param Object $post 投稿情報
	 * @param String $leavename 記事編集画面でのみ渡される
	 *
	 * @version 2.0
	 *
	 * @return string
	 */
	public function post_type_link( $post_link, $post, $leavename ) {
		global /** @var WP_Rewrite $wp_rewrite */
		$wp_rewrite;

		if ( ! $wp_rewrite->permalink_structure ) {
			return $post_link;
		}

		$draft_or_pending = isset( $post->post_status ) && in_array( $post->post_status, array(
				'draft',
				'pending',
				'auto-draft',
			) );
		if ( $draft_or_pending and ! $leavename ) {
			return $post_link;
		}

		$post_type = $post->post_type;
		$permalink = $wp_rewrite->get_extra_permastruct( $post_type );
		$pt_object = get_post_type_object( $post_type );

		$permalink = str_replace( '%post_id%', $post->ID, $permalink );
		$permalink = str_replace( '%' . $post_type . '_slug%', $pt_object->rewrite['slug'], $permalink );

		//親ページが有るとき。
		$parentsDirs = '';
		if ( $pt_object->hierarchical ) {
			if ( ! $leavename ) {
				$postId = $post->ID;
				while ( $parent = get_post( $postId )->post_parent ) {
					$parentsDirs = get_post( $parent )->post_name . '/' . $parentsDirs;
					$postId      = $parent;
				}
			}
		}

		$permalink = str_replace( '%' . $post_type . '%', $parentsDirs . '%' . $post_type . '%', $permalink );

		if ( ! $leavename ) {
			$permalink = str_replace( '%' . $post_type . '%', $post->post_name, $permalink );
		}

		//%post_id%/attachment/%attachement_name%;
		//画像の編集ページでのリンク
		if ( isset( $_GET['post'] ) && $_GET['post'] != $post->ID ) {
			$parent_structure = trim( CPTP_Util::get_permalink_structure( $post->post_type ), '/' );
			$parent_dirs      = explode( '/', $parent_structure );
			if ( is_array( $parent_dirs ) ) {
				$last_dir = array_pop( $parent_dirs );
			} else {
				$last_dir = $parent_dirs;
			}

			if ( '%post_id%' == $parent_structure or '%post_id%' == $last_dir ) {
				$permalink = $permalink . '/attachment/';
			}
		}

		$search  = array();
		$replace = array();

		$replace_tag = $this->create_taxonomy_replace_tag( $post->ID, $permalink );
		$search      = $search + $replace_tag['search'];
		$replace     = $replace + $replace_tag['replace'];

		//from get_permalink.
		$category = '';
		if ( false !== strpos( $permalink, '%category%' ) ) {
			$categories = get_the_category( $post->ID );
			if ( $categories ) {
				usort( $categories, '_usort_terms_by_ID' ); // order by ID
				$category_object = apply_filters( 'post_link_category', $categories[0], $categories, $post );
				$category_object = get_term( $category_object, 'category' );
				$category        = $category_object->slug;
				if ( $parent = $category_object->parent ) {
					$category = get_category_parents( $parent, false, '/', true ) . $category;
				}
			}
			// show default category in permalinks, without
			// having to assign it explicitly
			if ( empty( $category ) ) {
				$default_category = get_term( get_option( 'default_category' ), 'category' );
				$category         = is_wp_error( $default_category ) ? '' : $default_category->slug;
			}
		}

		$author = '';
		if ( false !== strpos( $permalink, '%author%' ) ) {
			$authordata = get_userdata( $post->post_author );
			$author     = $authordata->user_nicename;
		}

		$post_date = strtotime( $post->post_date );
		$permalink = str_replace(
			array(
				'%year%',
				'%monthnum%',
				'%day%',
				'%hour%',
				'%minute%',
				'%second%',
				'%category%',
				'%author%',
			),
			array(
				date( 'Y', $post_date ),
				date( 'm', $post_date ),
				date( 'd', $post_date ),
				date( 'H', $post_date ),
				date( 'i', $post_date ),
				date( 's', $post_date ),
				$category,
				$author,
			),
			$permalink
		);
		$permalink = str_replace( $search, $replace, $permalink );
		$permalink = rtrim( home_url(), '/' ) . '/' . ltrim( $permalink, '/' );

		return $permalink;
	}


	/**
	 *
	 * create %tax% -> term
	 *
	 * @param int $post_id
	 * @param string $permalink
	 *
	 * @return array
	 */
	private function create_taxonomy_replace_tag( $post_id, $permalink ) {
		$search  = array();
		$replace = array();

		$taxonomies = CPTP_Util::get_taxonomies( true );

		//%taxnomomy% -> parent/child
		//運用でケアすべきかも。

		foreach ( $taxonomies as $taxonomy => $objects ) {

			if ( false !== strpos( $permalink, '%' . $taxonomy . '%' ) ) {
				$terms = wp_get_post_terms( $post_id, $taxonomy, array( 'orderby' => 'term_id' ) );

				if ( $terms and ! is_wp_error( $terms ) ) {
					$parents  = array_map( array( __CLASS__, 'get_term_parent' ), $terms ); //親の一覧
					$newTerms = array();
					foreach ( $terms as $key => $term ) {
						if ( ! in_array( $term->term_id, $parents ) ) {
							$newTerms[] = $term;
						}
					}

					//このブロックだけで良いはず。
					$term_obj  = reset( $newTerms ); //最初のOBjectのみを対象。
					$term_slug = $term_obj->slug;

					if ( isset( $term_obj->parent ) and 0 != $term_obj->parent ) {
						$term_slug = CPTP_Util::get_taxonomy_parents( $term_obj->parent, $taxonomy, false, '/', true ) . $term_slug;
					}
				}

				if ( isset( $term_slug ) ) {
					$search[]  = '%' . $taxonomy . '%';
					$replace[] = $term_slug;
				}
			}
		}

		return array( 'search' => $search, 'replace' => $replace );
	}

	private static function get_term_parent( $term ) {
		if ( isset( $term->parent ) and $term->parent > 0 ) {
			return $term->parent;
		}
	}


	/**
	 *
	 * fix attachment output
	 *
	 * @version 1.0
	 * @since 0.8.2
	 *
	 * @param string $link
	 * @param int $postID
	 *
	 * @return string
	 */

	public function attachment_link( $link, $postID ) {
		/** @var WP_Rewrite $wp_rewrite */
		global $wp_rewrite;

		if ( ! $wp_rewrite->permalink_structure ) {
			return $link;
		}

		$post = get_post( $postID );
		if ( ! $post->post_parent ) {
			return $link;
		}
		$post_parent = get_post( $post->post_parent );
		$permalink   = CPTP_Util::get_permalink_structure( $post_parent->post_type );
		$post_type   = get_post_type_object( $post_parent->post_type );

		if ( false == $post_type->_builtin ) {
			if ( strpos( $permalink, '%postname%' ) < strrpos( $permalink, '%post_id%' ) && false === strrpos( $permalink, 'attachment/' ) ) {
				$link = str_replace( $post->post_name, 'attachment/' . $post->post_name, $link );
			}
		}

		return $link;
	}

	/**
	 *
	 * Fix taxonomy link outputs.
	 * @since 0.6
	 * @version 1.0
	 *
	 * @param string $termlink
	 * @param Object $term
	 * @param Object $taxonomy
	 *
	 * @return string
	 */
	public function term_link( $termlink, $term, $taxonomy ) {
		/** @var WP_Rewrite $wp_rewrite */
		global $wp_rewrite;

		if ( ! $wp_rewrite->permalink_structure ) {
			return $termlink;
		}

		if ( get_option( 'no_taxonomy_structure' ) ) {
			return $termlink;
		}

		$taxonomy = get_taxonomy( $taxonomy );
		if ( $taxonomy->_builtin ) {
			return $termlink;
		}

		if ( empty( $taxonomy ) ) {
			return $termlink;
		}

		$wp_home = rtrim( home_url(), '/' );

		if ( in_array( get_post_type(), $taxonomy->object_type ) ) {
			$post_type = get_post_type();
		} else {
			$post_type = $taxonomy->object_type[0];
		}
		$post_type_obj = get_post_type_object( $post_type );
		$slug          = $post_type_obj->rewrite['slug'];
		$with_front    = $post_type_obj->rewrite['with_front'];
		$front         = substr( $wp_rewrite->front, 1 );
		$termlink      = str_replace( $front, '', $termlink );

		if ( $with_front ) {
			$slug = $front . $slug;
		}

		$termlink = str_replace( $wp_home, $wp_home . '/' . $slug, $termlink );

		if ( ! $taxonomy->rewrite['hierarchical'] ) {
			$termlink = str_replace( $term->slug . '/', CPTP_Util::get_taxonomy_parents( $term->term_id, $taxonomy->name, false, '/', true ), $termlink );
		}

		return $termlink;
	}

}

<?php
/*
 * cms module:			メタ情報設定
 * Module Description:	サイトのheadタグ内にメタキーワード、メタディスクリプションの表示を行います。
 * Order:				10
 * First Introduced:	x
 * Major Changes In:	
 * Builtin:				true
 * Free:				false
 * License:				GPLv2 or later
*/

class meta_manager {
	var $default = array(
		'includes_taxonomies'    => array(),
		'excerpt_as_description' => true,
		'include_term'           => true,
		'ogp_output'             => true,
		'twitcards_output'       => true,
	
		'twitter_site_account'   => ''
	);

	var $setting;
	var $term_keywords;
	var $term_description;
	var $parent;
	var $_server_https;
	var $meta_description_chars = 120;
	var $ogp_description_chars = 120;

	function __construct( $parent ) {
		$this->parent = $parent;

		if ( is_admin() ) {
			add_action( 'add_meta_boxes'					, array( &$this, 'add_post_meta_box' ), 10, 2 );
			add_action( 'wp_insert_post'					, array( &$this, 'update_post_meta' ) );
			add_action( 'admin_print_styles-post.php'		, array( &$this, 'print_metabox_styles' ) );
			add_action( 'admin_print_styles-post-new.php'	, array( &$this, 'print_metabox_styles' ) );
			add_action( 'wp-sitemanager-access-page'		, array( &$this, 'setting_page' ) );
			add_action( 'wp-sitemanager-update-access'		, array( &$this, 'update_settings' ) );
			add_action( 'admin_print_styles-wp-sitemanager_page_wp-sitemanager-access'	, array( &$this, 'setting_page_scripts') );
		}

		add_action( 'wp_loaded', array( &$this, 'taxonomy_update_hooks' ), 9999 );
		add_action( 'wp_head'  , array( &$this, 'output_meta' ), 0 );
		add_action( 'wp_head'  , array( &$this, 'check_and_replace_canonical_link' ), 9 );


		$this->term_keywords = get_option( 'term_keywords' );
		$this->term_description = get_option( 'term_description' );
		$this->ogp_image = get_option( 'ogp_image' );
		$this->setting = wp_parse_args( get_option( 'meta_manager_settings', array() ), $this->default );
		
		if ( isset( $this->setting['ogp_output'] ) && $this->setting['ogp_output'] ) {
			add_filter( 'jetpack_enable_open_graph', '__return_false' );
		}
	}
	
	function taxonomy_update_hooks() {
		$taxonomies = get_taxonomies( array( 'public' => true, 'show_ui' => true ) );
		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $taxonomy ) {
				add_action( $taxonomy . '_add_form_fields', array( $this, 'add_keywords_form' ) );
				add_action( $taxonomy . '_edit_form_fields', array( &$this, 'edit_keywords_form' ), 0, 2 );
				add_action( 'created_' . $taxonomy, array( &$this, 'update_term_meta' ) );
				add_action( 'edited_' . $taxonomy, array( &$this, 'update_term_meta' ) );
//				add_action( 'delete_' . $taxonomy, array( &$this, 'delete_term_meta' ) );
			}
		}
	}

	function add_keywords_form() {
	?>
	<div class="form-field">
		<label for="meta_keywords">メタキーワード</label>
		<textarea name="meta_keywords" id="meta_keywords" rows="3" cols="40"></textarea>
	</div>
	<div class="form-field">
		<label for="meta_description">メタディスクリプション</label>
		<textarea name="meta_description" id="meta_description" rows="5" cols="40"></textarea>
	</div>
	<?php
	}
	
	
	function edit_keywords_form( $tag ) {
	?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="meta_keywords">メタキーワード</label></th>
			<td><input type="text" name="meta_keywords" id="meta_keywords" size="40" value="<?php echo isset( $this->term_keywords[$tag->term_id] ) ? esc_html( $this->term_keywords[$tag->term_id] ) : ''; ?>" />
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="meta_description">メタディスクリプション</label></th>
			<td><textarea name="meta_description" id="meta_description" cols="40" rows="5"><?php echo isset( $this->term_description[$tag->term_id] ) ? esc_html( $this->term_description[$tag->term_id] ) : ''; ?></textarea>
		</tr>
	<?php
	}


function update_term_meta( $term_id ) {
	if ( ! isset( $_POST['meta_keywords'] ) ) { return; }
	$post_keywords = stripslashes_deep( $_POST['meta_keywords'] );
	$post_keywords = $this->get_unique_keywords( $post_keywords );
	$post_description = stripslashes_deep( $_POST['meta_description'] );
	
	if ( ! isset( $this->term_keywords[$term_id] ) || $this->term_keywords[$term_id] != $post_keywords ) {
		$this->term_keywords[$term_id] = $post_keywords;
		update_option( 'term_keywords', $this->term_keywords );
	}
	if ( ! isset( $this->term_description[$term_id] ) || $this->term_description[$term_id] != $post_description ) {
		$this->term_description[$term_id] = $post_description;
		update_option( 'term_description', $this->term_description );
	}
}


function add_post_meta_box( $post_type, $post ) {
	if ( isset( $post->post_type ) && in_array( $post_type, get_post_types( array( 'public' => true ) ) ) && $post_type != 'attachment' ) {
		add_meta_box( 'postmeta_meta_box', 'メタ情報', array( &$this, 'post_meta_box' ), $post_type, 'normal', 'high');
	}
}


function post_meta_box() {
	global $post;
	$post_keywords = get_post_meta( $post->ID, '_keywords', true ) ? get_post_meta( $post->ID, '_keywords', true ) : '';
	$post_description = get_post_meta( $post->ID, '_description', true ) ? get_post_meta( $post->ID, '_description', true ) : '';
?>
<dl>
	<dt>メタキーワード</dt>
	<dd><input type="text" name="_keywords" id="post_keywords" size="100" value="<?php echo esc_html( $post_keywords ); ?>" /></dd>
	<dt>メタディスクリプション</dt>
	<dd><textarea name="_description" id="post_description" cols="100" rows="3"><?php echo esc_html( $post_description ); ?></textarea></dd>
</dl>
<?php
}


function print_metabox_styles() {
?>
<style type="text/css" charset="utf-8">
#post_keywords,
#post_description {
	width: 98%;
}
</style>
<?php
}


function update_post_meta( $post_ID ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( isset( $_POST['_keywords'] ) ) {
		$post_keywords = stripslashes_deep( $_POST['_keywords'] );
		$post_keywords = $this->get_unique_keywords( $post_keywords );
		update_post_meta( $post_ID, '_keywords', $post_keywords );
	}
	if ( isset( $_POST['_description'] ) ) {
		$post_keywords = stripslashes_deep( $_POST['_description'] );
		update_post_meta( $post_ID, '_description', $post_keywords );
	}
}


function output_meta() {
	$meta = $this->get_meta();
	$output = '';

	// metaタグ
	// $output .= "\n<!-- WP SiteManager meta Tags -->\n";
	if ( $meta['keywords'] ) {
		$output .= '<meta name="keywords" content="' . esc_attr( $meta['keywords'] ) . '" />' . "\n";
	}
	
	if ( is_home() || is_front_page() ) {
		$meta['description'] = ! empty ( $meta['description'] ) ? $meta['description'] : get_bloginfo( 'description' );
	} elseif ( is_singular() ) {
		if ( post_password_required() ) $meta['description'] = 'この投稿はパスワードで保護されています。';
	}

	if ( $meta['description'] ) {
		$output .= '<meta name="description" content="' . esc_attr( $meta['description'] ) . '" />' . "\n";
	}

	// OGP
	if ( isset( $this->setting['ogp_output'] ) && $this->setting['ogp_output'] ) {
		$output .= "\n<!-- WP SiteManager OGP Tags -->\n";
		// Jetpack used to force it in, seems to have stopped but just for good measure
		remove_action( 'wp_head', 'jetpack_og_tags' );
		$og_output = $this->get_ogp( $meta );
		$output .= $og_output;
	}
	if ( isset( $this->setting['twitcards_output'] ) && $this->setting['twitcards_output'] ) {
		$output .= "\n<!-- WP SiteManager Twitter Cards Tags -->\n";
		$tc_output = $this->get_twitcards( $meta );
		$output .= $tc_output;
	}

	echo $output;
}


private function get_meta() {
	$meta = array();
	$option = array();
	$meta['keywords'] = get_option( 'meta_keywords' ) ? get_option( 'meta_keywords' ) : '';
	$meta['description'] = get_option( 'meta_description' ) ? get_option( 'meta_description' ) : '';
	if ( is_singular() ) {
		$option = $this->get_post_meta();
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$option = $this->get_term_meta();
	}

	if ( ! empty( $option ) && $option['keywords'] ) {
		$meta['keywords'] = $this->get_unique_keywords( $option['keywords'], $meta['keywords'] );
	} else {
		$meta['keywords'] = $this->get_unique_keywords( $meta['keywords'] );
	}
	
	if ( ! empty( $option ) && $option['description'] ) {
		$meta['description'] = $option['description'];
	}
	$this->meta_description_chars = apply_filters( 'wp_sitemanager_meta_description_chars', $this->meta_description_chars );
	$meta['description'] = mb_substr( $meta['description'], 0, $this->meta_description_chars, 'UTF-8' );
	return $meta;
}

private function get_post_meta() {
	global $post;
	$post_meta = array();
	$post_meta['keywords'] = get_post_meta( $post->ID, '_keywords', true ) ? get_post_meta( $post->ID, '_keywords', true ) : '';
	if ( ! empty( $this->setting['includes_taxonomies'] ) ) {
		foreach ( $this->setting['includes_taxonomies'] as $taxonomy ) {
			$taxonomy = get_taxonomy( $taxonomy );
			if ( $taxonomy && in_array( $post->post_type, $taxonomy->object_type ) ) {
				$terms = get_the_terms( $post->ID, $taxonomy->name );
				if ( $terms ) {
					$add_keywords = array();
					foreach ( $terms as $term ) {
						$add_keywords[] = $term->name;
					}
					$add_keywords = implode( ',', $add_keywords );
					if ( $post_meta['keywords'] ) {
						$post_meta['keywords'] .= ',' . $add_keywords;
					} else {
						$post_meta['keywords'] = $add_keywords;
					}
				}
			}
		}
	}
	$post_meta['description'] = get_post_meta( $post->ID, '_description', true ) ? get_post_meta( $post->ID, '_description', true ) : '';
	if ( $this->setting['excerpt_as_description'] && ! $post_meta['description'] ) {
		if ( trim( $post->post_excerpt ) ) {
			$post_meta['description'] = $post->post_excerpt;
		} else {
			$excerpt = apply_filters( 'the_content', strip_shortcodes( $post->post_content ) );
			$excerpt = strip_shortcodes( $excerpt );
			$excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
			$excerpt = strip_tags( $excerpt );
			$post_meta['description'] = trim( preg_replace( '/[\n\r\t ]+/', ' ', $excerpt), ' ' );
		}
	}
	return $post_meta;
}


private function get_term_meta() {
	$term_meta = array();
	if ( is_tax() ) {
		$taxonomy = get_query_var( 'taxonomy' );
		$slug = get_query_var( 'term' );
		$term = get_term_by( 'slug', $slug, $taxonomy );
		$term_id = $term->term_id;
	} elseif ( is_category() ) {
		$term_id = get_query_var( 'cat' );
		$term = get_category( $term_id );
	} elseif ( is_tag() ) {
		$slug = get_query_var( 'tag' );
		$term = get_term_by( 'slug', $slug, 'post_tag' );
		$term_id = $term->term_id;
	}

	$term_meta['keywords'] = isset( $this->term_keywords[$term_id] ) ? $this->term_keywords[$term_id] : '';
	if ( $this->setting['include_term'] ) {
		$term_meta['keywords'] = $term->name . ',' . $term_meta['keywords'];
	}
	$term_meta['description'] = isset( $this->term_description[$term_id] ) ? $this->term_description[$term_id] : $term->description;
	return $term_meta;
}


private function get_unique_keywords() {
	$args = func_get_args();
	$keywords = array();
	if ( ! empty( $args ) ) {
		foreach ( $args as $arg ) {
			if ( is_string( $arg ) ) {
				$keywords[] = trim( $arg, ', ' );
			}
		}
		$keywords = implode( ',', $keywords );
		$keywords = preg_replace( '/[, ]*,[, ]*/', ',', $keywords );
		$keywords = explode( ',', $keywords );
		foreach ( $keywords as $key => $keyword ) {
			if ( $keyword === '' ) {
				unset( $keywords[$key] );
			}
		}
		$keywords = array_map( 'trim', $keywords );
		$keywords = array_unique( $keywords );
	}
	$keywords = implode( ',', $keywords );
	return $keywords;
}

private function get_ogp( $meta ) {
	$og_output = '';
	$og_tags = array();

	$image_width  = apply_filters( 'wp_sitemanager_open_graph_image_width', false );
	$image_height = apply_filters( 'wp_sitemanager_open_graph_image_height', false );

	$sns_meta = $this->get_sns_meta( $meta );

	if ( empty( $sns_meta ) )
		return;
	

	foreach ( $sns_meta as $tag_property => $tag_content ) {
		$og_tags['og:' . $tag_property] = $tag_content;
	}

	$og_tags['og:site_name'] = get_bloginfo( 'name' );
	$og_tags['og:image'] = $this->og_get_image( $image_width, $image_height );
	if ( preg_match( '"^/"', $og_tags['og:image'] ) ) {
		$og_tags['og:image'] = home_url( $og_tags['og:image'] );
	}

	// Facebook whines if you give it an empty title
	if ( empty( $og_tags['og:title'] ) )
		$og_tags['og:title'] = apply_filters( 'wp_sitemanager_open_graph_title', '(no title)' );

	// Shorten the description if it's too long
	$this->ogp_description_chars = apply_filters( 'wp_sitemanager_ogp_description_chars', $this->ogp_description_chars );
	$og_tags['og:description'] = mb_substr( $og_tags['og:description'], 0, $this->ogp_description_chars, 'UTF-8' );
	
	$og_tags = apply_filters( 'wp_sitemanager_open_graph_tags', $og_tags );

	foreach ( (array)$og_tags as $tag_property => $tag_content ) {
		if ( empty( $tag_content ) )
			continue; // Don't ever output empty tags

		$og_output .= sprintf( '<meta property="%s" content="%s" />', esc_attr( $tag_property ), esc_attr( $tag_content ) ) . "\n";
	}
	return $og_output;
}


private function get_twitcards( $meta ) {
	$tc_output = '';
	$tc_tags = array();

	$sns_meta = $this->get_sns_meta( $meta );
	
	$image_width  = absint( apply_filters( 'wp_sitemanager_twitter_cards_image_width', 300 ) );
	$image_height = absint( apply_filters( 'wp_sitemanager_twitter_cards_image_height', 300 ) );

	if ( empty( $sns_meta ) )
		return;

	foreach ( $sns_meta as $tag_property => $tag_content ) {
		switch ( $tag_property ) {
			case 'type' :
				break;
			default :
				$tc_tags['twitter:' . $tag_property] = $tag_content;
		}
	}
	
	$tc_tags['twitter:card'] = 'summary';
	if ( isset( $this->setting['twitter_site_account'] ) && $this->setting['twitter_site_account'] ) {
		$tc_tags['twitter:site'] = '@' . preg_replace( '/[^a-zA-Z0-9_]/', '', $this->setting['twitter_site_account'] );
	}
	$tc_tags['twitter:image'] = $this->og_get_image( $image_width, $image_height );
	if ( preg_match( '"^/"', $tc_tags['twitter:image'] ) ) {
		$tc_tags['twitter:image'] = home_url( $tc_tags['twitter:image'] );
	}
	// Shorten the description if it's too long
	$tc_tags['twitter:description'] = mb_substr( $tc_tags['twitter:description'], 0, 200, 'UTF-8' );

	$tc_tags = apply_filters( 'wp_sitemanager_twitter_cards_tags', $tc_tags );
	
	foreach ( (array)$tc_tags as $tag_property => $tag_content ) {
		if ( empty( $tag_content ) )
			continue; // Don't ever output empty tags

		$tc_output .= sprintf( '<meta name="%s" content="%s" />', esc_attr( $tag_property ), esc_attr( $tag_content ) ) . "\n";
	}

	return $tc_output;
}


private function get_sns_meta( $meta ) {
	$tags = array();
	if ( is_home() || is_front_page() ) {
		$tags['title'] = get_bloginfo( 'name' );
		$tags['type'] = 'website';
		$front_page_id = get_option( 'page_for_posts' );
		if ( $front_page_id && is_home() )
			$tags['url'] = get_permalink( $front_page_id );
		else
			$tags['url'] = home_url( '/' );
		$tags['description'] = ! empty ( $meta['description'] ) ? $meta['description'] : get_bloginfo( 'description' );
	} elseif ( is_singular() ) {
		global $post;
		$data = $post; // so that we don't accidentally explode the global

		$tags['title'] = ! empty( $data->post_title ) ? wp_kses( $data->post_title, array() ) : '';
		$tags['type']  = 'article';
		$tags['url']   = $this->get_pagenum_link( get_query_var( 'paged' ), get_permalink( $data->ID ) );
		$tags['description'] = $meta['description'];
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$term_obj = get_queried_object();
		$tags['title'] = $term_obj->name ;
		$tags['type']  = 'article';
		$tags['url']   = $this->get_pagenum_link( get_query_var( 'paged' ), get_term_link( $term_obj, $term_obj->taxonomy ) );
		$tags['description'] = ! empty( $meta['description'] ) ? $meta['description'] : ' ';
	} elseif ( is_author() ) {
		$author_obj = get_queried_object();
		$tags['title'] = $author_obj->display_name;
		$tags['type'] = 'author';
		$tags['url']   = $this->get_pagenum_link( get_query_var( 'paged' ), get_author_posts_url( $author_obj->ID ) );
		$tags['description'] = ! empty( $author_obj->description ) ? $author_obj->description : ' ';
	} elseif ( is_post_type_archive() ) { //カスタム投稿タイプのアーカイブ 'has_archive' => true
		$posttype_obj = get_queried_object();
		$tags['title'] = $posttype_obj->labels->name;
		$tags['type'] = 'article';
		$tags['url']   = $this->get_pagenum_link( get_query_var( 'paged' ), get_post_type_archive_link( $posttype_obj->name ) );
		$tags['description'] = ! empty( $posttype_obj->description ) ? $posttype_obj->description : ' ';
	}
	return $tags;
}

private function og_get_image( $width = 200, $height = 200 ) { // Facebook requires thumbnails to be a minimum of 200x200
	global $post;
	// see. http://developers.facebook.com/docs/opengraph/creating-object-types/
	
	$size = is_int( $width ) && is_int( $height ) ? array( absint( $width ), absint( $height ) ) : false;

	$image = get_option( 'ogp_image' ) ? wp_get_attachment_image_src( get_option( 'ogp_image' ) , $size ) : '';
	$image = ! empty($image) ? $image[0] : '';

	if ( is_attachment() ) {
		$image = wp_get_attachment_image_src( $post->ID, $size );
		$image = $image[0];
	} elseif ( is_singular() ) {
		$args = array(
			'post_type'   => 'attachment',
			'posts_per_page' => 1,
			'post_status' => null,
			'post_parent' => $post->ID,
			'exclude'     => get_post_thumbnail_id(),
			'orderby'     => 'menu_order',
			'order'       => 'asc'
		);
		$attachments = get_posts( $args );

		if ( post_type_supports( $post->post_type, 'thumbnail' ) &&  has_post_thumbnail( $post->ID ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
			$image = $image[0];
		} elseif ( $attachments ) {
			$attachment = $attachments[0];
			$image = wp_get_attachment_image_src( $attachment->ID, $size );
			$image = $image[0];
		} else {
			$content_image = preg_match_all('/<img.+src=\"([^\"]+)\".[^>]*>/i', $post->post_content, $matches);
			if ( !empty($matches[1]) ) $image = $matches[1][0];
		}
	} elseif ( is_author() ) {
		$author = get_queried_object();
		$image = $this->get_avatar_url( $author->user_email, $width );
/*
		if ( function_exists( 'get_avatar_url' ) ) {
			$avatar = get_avatar_url( $author->user_email, $width );

			if ( ! empty( $avatar ) ) {
				if ( is_array( $avatar ) )
					$image = $avatar[0];
				else
					$image = $avatar;
			}
		} else {
			$has_filter = has_filter( 'pre_option_show_avatars', '__return_true' );
			if ( !$has_filter ) {
				add_filter( 'pre_option_show_avatars', '__return_true' );
			}
			$avatar = get_avatar( $author->user_email, $width );
			if ( !$has_filter ) {
				remove_filter( 'pre_option_show_avatars', '__return_true' );
			}

			if ( !empty( $avatar ) && !is_wp_error( $avatar ) ) {
				if ( preg_match( '/src=["\']([^"\']+)["\']/', $avatar, $matches ) );
					$image = wp_specialchars_decode( $matches[1], ENT_QUOTES );
			}
		}
*/
	}

	if ( empty( $image ) ) {
		$image = false;
	}

	return apply_filters( 'wp_sitemanager_open_graph_image', $image );
}


private function get_avatar_url( $email, $width ) {
	add_filter( 'pre_option_show_avatars', '__return_true', 999 );
	$this->_server_https = isset( $_SERVER['HTTPS'] ) ? $_SERVER['HTTPS'] : '--UNset--';
	$_SERVER['HTTPS'] = 'off';

	$avatar_img_element = get_avatar( $email, $width, '' );

	if ( !$avatar_img_element || is_wp_error( $avatar_img_element ) ) {
		$return = '';
	} elseif ( !preg_match( '#src=([\'"])?(.*?)(?(1)\\1|\s)#', $avatar_img_element, $matches ) ) {
		$return = '';
	} else {
		$return = esc_url_raw( htmlspecialchars_decode( $matches[2] ) );
	}

	remove_filter( 'pre_option_show_avatars', '__return_true', 999 );
	if ( '--UNset--' === $this->_server_https ) {
		unset( $_SERVER['HTTPS'] );
	} else {
		$_SERVER['HTTPS'] = $this->_server_https;
	}

	return $return;
}

function setting_page() {
	$meta_keywords = get_option( 'meta_keywords' ) ? get_option( 'meta_keywords' ) : '';
	$meta_description = get_option( 'meta_description' ) ? get_option( 'meta_description' ) : '';
	$ogp_image = get_option( 'ogp_image' ) ? get_option( 'ogp_image' ) : '';
	$ogp_image_src = ! empty( $ogp_image ) ? wp_get_attachment_image_src( $ogp_image, 'full' ) : '';
	$ogp_image_src = ! empty( $ogp_image_src ) ? $ogp_image_src[0] : '';
	$taxonomies = get_taxonomies( array( 'public' => true, 'show_ui' => true ), false );
?>
	<div class="setting-section">
		<h3>キーワード &amp; ディスクリプション</h3>
		<h4>サイトワイド設定</h4>
		<table class="form-table">
			<tr>
				<th>共通キーワード</th>
				<td>
					<label for="meta_keywords">
						<input type="text" name="meta_keywords" id="meta_keywords" size="100" value="<?php echo esc_html( $meta_keywords ); ?>" />
					</label>
				</td>
			</tr>
			<tr>
				<th>基本ディスクリプション</th>
				<td>
					<label for="meta_description">
						<textarea name="meta_description" id="meta_description" cols="100" rows="3"><?php echo esc_html( $meta_description ); ?></textarea>
					</label>
				</td>
			</tr>
		</table>
		<h4>記事設定</h4>
		<table class="form-table">
<?php if ( $taxonomies ) : $cnt = 1; ?>
			<tr>
				<th>記事のキーワードに含める分類</th>
				<td>
<?php foreach ( $taxonomies as $tax_slug => $taxonomy ) : ?>
					<label for="includes_taxonomies-<?php echo $cnt; ?>">
						<input type="checkbox" name="includes_taxonomies[]" id="includes_taxonomies-<?php echo $cnt; ?>" value="<?php echo esc_html( $tax_slug ); ?>"<?php echo in_array( $tax_slug, $this->setting['includes_taxonomies'] ) ? ' checked="checked"' : ''; ?> />
						<?php echo esc_html( $taxonomy->labels->singular_name ); ?>
					</label>
<?php $cnt++; endforeach; ?>
				</td>
			</tr>
<?php endif; ?>
			<tr>
				<th>記事のメタディスクリプション</th>
				<td>
					<label for="excerpt_as_description">
						<input type="checkbox" name="excerpt_as_description" id="excerpt_as_description" value="1"<?php echo $this->setting['excerpt_as_description'] ? ' checked="checked"' : ''; ?> />
						抜粋を記事のディスクリプションとして利用する
					</label>
				</td>
			</tr>
		</table>
		<h4>タクソノミー設定</h4>
		<table class="form-table">
			<tr>
				<th>タクソノミーのメタキーワード</th>
				<td>
					<label for="include_term">
						<input type="checkbox" name="include_term" id="include_term" value="1"<?php echo $this->setting['include_term'] ? ' checked="checked"' : ''; ?> />
						分類名をキーワードに含める
					</label>
				</td>
			</tr>
		</table>
		<h4>ソーシャル設定</h4>
		<table class="form-table">
			<tr>
				<th>共通イメージ画像</th>
				<td>
					<button id="select-og-image" class="button">画像を選択</button>

					<button id="deleat-og-image" class="button"<?php echo empty( $ogp_image_src ) ? ' style="display: none"': ''; ?>>画像を削除</button>
					<div id="og-image">
						<?php echo empty( $ogp_image_src ) ? '': '<img src="' . $ogp_image_src . '" id="og-sample-image" />'; ?>
					</div>
					<input type="hidden" name="ogp_image" id="ogp_image" value="<?php echo esc_attr( $ogp_image ); ?>" />
				</td>
			</tr>
			<tr>
				<th>OGPの出力</th>
				<td>
					<label for="ogp_output">
						<input type="checkbox" name="ogp_output" id="ogp_output" value="1"<?php echo $this->setting['ogp_output'] ? ' checked="checked"' : ''; ?> />
						出力する
					</label>
				</td>
			</tr>
			<tr>
				<th>Twitter Cardsの出力</th>
				<td>
					<label for="twitcards_output">
						<input type="checkbox" name="twitcards_output" id="twitcards_output" value="1"<?php echo $this->setting['twitcards_output'] ? ' checked="checked"' : ''; ?> />
						出力する
					</label>
				</td>
			</tr>
			<tr>
				<th>Twitter Cardsのサイトアカウント</th>
				<td>
					@<input type="text" name="twitter_site_account" id="twitter_site_account" value="<?php echo esc_attr( $this->setting['twitter_site_account'] ); ?>" />
				</td>
			</tr>
		</table>
	</div>
<?php
}

function setting_page_scripts() {
	// http://firegoby.jp/archives/4031

	wp_enqueue_media(); // メディアアップローダー用のスクリプトをロードする

	// カスタムメディアアップローダー用のJavaScript
	wp_enqueue_script(
		'ogp-media-uploader',
		plugin_dir_url( dirname( __FILE__ ) ) . 'js/media-uploader.js',
//		plugins_url( 'media-uploader.js', __FILE__),
		array('jquery'),
		filemtime( dirname( dirname( __FILE__ ) ).'/js/media-uploader.js' ),
		false
	);
}


function update_settings() {
	if ( isset( $_POST['wp-sitemanager-access'] ) ) {
		$post_data = stripslashes_deep( $_POST );
		check_admin_referer( 'wp-sitemanager-access' );
		$setting = array();
		foreach ( $this->default as $key => $def ) {
			if ( ! isset( $post_data[$key] ) ) {
				if ( $key == 'includes_taxonomies' ) {
					$setting['includes_taxonomies'] = array();
				} elseif ( $key == 'twitter_site_account' ) {
					$setting['twitter_site_account'] = $def;
				} else {
					$setting[$key] = false;
				}
			} else {
				if ( $key == 'includes_taxonomies' ) {
					$setting['includes_taxonomies'] = $post_data['includes_taxonomies'];
				} elseif ( $key == 'twitter_site_account' ) {
					$setting['twitter_site_account'] = preg_replace( '/[^a-zA-Z0-9_]/', '', $post_data[$key] );
				} else {
					$setting[$key] = true;
				}
			}
		}
		$meta_keywords = $this->get_unique_keywords( $post_data['meta_keywords'] );
		update_option( 'meta_keywords', $meta_keywords );
		update_option( 'meta_description', $post_data['meta_description'] );
		update_option( 'meta_manager_settings', $setting );
		update_option( 'ogp_image', (int)$post_data['ogp_image'] );
		$this->setting = $setting;
	}
}


private function get_pagenum_link($pagenum = 1, $request, $escape = true ) {
	global $wp_rewrite;

	$pagenum = (int) $pagenum;

	$request = remove_query_arg( 'paged', $request );

	$home_root = parse_url(home_url());
	$home_root = ( isset($home_root['path']) ) ? $home_root['path'] : '';
	$home_root = preg_quote( $home_root, '|' );

	$request = preg_replace('|^'. $home_root . '|i', '', $request);
	$request = preg_replace('|^/+|', '', $request);

	if ( !$wp_rewrite->using_permalinks() || is_admin() ) {

		if ( $pagenum > 1 ) {
			$result = add_query_arg( 'paged', $pagenum, $request );
		} else {
			$result = $request;
		}
	} else {
		$qs_regex = '|\?.*?$|';
		preg_match( $qs_regex, $request, $qs_match );

		if ( !empty( $qs_match[0] ) ) {
			$query_string = $qs_match[0];
			$request = preg_replace( $qs_regex, '', $request );
		} else {
			$query_string = '';
		}

		$request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request);
		$request = preg_replace( '|^' . preg_quote( $wp_rewrite->index, '|' ) . '|i', '', $request);
		$request = ltrim($request, '/');

		if ( $pagenum > 1 ) {
			$request = ( ( !empty( $request ) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
		}

		$result = $request . $query_string;
	}

	$result = apply_filters('wp-sitemanager_meta-manager_get_pagenum_link', $result);

	if ( $escape )
		return esc_url( $result );
	else
		return esc_url_raw( $result );
}


public function check_and_replace_canonical_link() {
	if ( has_action( 'wp_head', 'rel_canonical' ) ) {
		remove_action( 'wp_head', 'rel_canonical' );
		add_action( 'wp_head', array( &$this, 'rel_canonical' ) );
	}
}


public function rel_canonical() {
	if ( !is_singular() )
		return;

	global $wp_the_query;
	if ( !$id = $wp_the_query->get_queried_object_id() )
		return;

	$link = $this->get_pagenum_link( get_query_var( 'paged' ), get_permalink( $id ) );

	if ( $page = get_query_var('cpage') )
		$link = get_comments_pagenum_link( $page );
	
	echo '<link rel="canonical" href="' . $link . '" />' . "\n";
}



} // class end
$this->instance->$instanse = new meta_manager( $this );
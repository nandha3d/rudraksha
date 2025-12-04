<?php
/**
 * Custom template tags for this theme.
 *
 * @package pastry_shop
 */

if ( ! function_exists( 'pastry_shop_entry_footer' ) ) :

	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function pastry_shop_entry_footer() {

		$pastry_shop_show_meta_author = true;
		if ( 'post' === get_post_type() ) {
			$posted_on = '';
			if ( is_single() ) {
				$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
				if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
					$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
				}

				$time_string = sprintf( $time_string,
					esc_attr( get_the_date( 'c' ) ),
					esc_html( get_the_date() ),
					esc_attr( get_the_modified_date( 'c' ) ),
					esc_html( get_the_modified_date() )
				);

				$posted_on = sprintf(
					'%s',
					'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
				);
			}
			if ( ! empty( $posted_on ) ) {
				echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
			}

			$byline = '';
			$pastry_shop_show_post_admin = pastry_shop_get_option( 'pastry_shop_show_post_admin_setting' );
			if ( true === $pastry_shop_show_meta_author ) {
				if ( true === $pastry_shop_show_post_admin ) { 
					$byline = sprintf(
						'%s',
						'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
					);
				}
			}
			if ( ! empty( $byline ) ) {
				echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
			}

		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			$pastry_shop_show_post_comments = pastry_shop_get_option( 'pastry_shop_show_post_comments_setting' );
			if ( true === $pastry_shop_show_post_comments) { 
				$pastry_shop_show_meta_comment = true;
				if ( true === $pastry_shop_show_meta_comment ) {
					echo '<span class="comments-link">';
					comments_popup_link( esc_html__( 'Leave a comment', 'pastry-shop' ), esc_html__( '1 Comment', 'pastry-shop' ), esc_html__( '% Comments', 'pastry-shop' ) );
					echo '</span>';
				}
			}
		}

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$pastry_shop_show_meta_categories = true;
			$pastry_shop_show_post_categories = pastry_shop_get_option( 'pastry_shop_show_post_categories_setting' );
			if ( true === $pastry_shop_show_post_categories) {
				if ( true === $pastry_shop_show_meta_categories ) {
					/* Translators: used between list items, there is a space after the comma. */
					$pastry_shop_categories_list = get_the_category_list( esc_html__( ', ', 'pastry-shop' ) );
					if ( $pastry_shop_categories_list && pastry_shop_categorized_blog() ) {
						printf( '<span class="cat-links">%1$s</span>', $pastry_shop_categories_list ); // WPCS: XSS OK.
					}
				}
			}
			$pastry_shop_show_meta_tags = true;
			$pastry_shop_show_meta_tags = pastry_shop_get_option( 'pastry_shop_show_post_tags_setting' );
			if ( true === $pastry_shop_show_meta_tags) {
				if ( true === $pastry_shop_show_meta_tags ) {
					/* Translators: used between list items, there is a space after the comma. */
					$pastry_shop_tags_list = get_the_tag_list( '', esc_html__( ', ', 'pastry-shop' ) );
					if ( $pastry_shop_tags_list ) {
						printf( '<span class="tags-links">%1$s</span>', $pastry_shop_tags_list ); // WPCS: XSS OK.
					}
				}
			}
		}

		edit_post_link( esc_html__( 'Edit', 'pastry-shop' ), '<span class="edit-link">', '</span>' );
	}
endif;

if ( ! function_exists( 'pastry_shop_entry_meta_date' ) ) :

	/**
	 * Prints HTML with date meta.
	 */
	function pastry_shop_entry_meta_date() {
		?>
		<?php $pastry_shop_show_post_date = pastry_shop_get_option( 'pastry_shop_show_post_date_setting' );
		if ( true === $pastry_shop_show_post_date ) { ?>
			<div class="custom-entry-date">
				<span class="entry-month"><?php the_time( _x( 'M', 'date format', 'pastry-shop' ) ); ?></span>
				<span class="entry-day"><?php the_time( _x( 'd', 'date format', 'pastry-shop' ) ); ?></span>
			</div>
		<?php } ?>
		<?php
	}

endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function pastry_shop_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'pastry_shop_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'pastry_shop_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so pastry_shop_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so pastry_shop_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in pastry_shop_categorized_blog.
 */
function pastry_shop_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'pastry_shop_categories' );
}
add_action( 'edit_category', 'pastry_shop_category_transient_flusher' );
add_action( 'save_post',     'pastry_shop_category_transient_flusher' );

/**
 * Display single taxonomy link.
 *
 * Used inside loop only.
 *
 * @since 1.0.0
 *
 * @param string $taxonomy Taxonomy slug.
 * @param string $before   HTML to place before.
 * @param string $after    HTML to place after.
 * @param int    $post_id  Post ID.
 */
function pastry_shop_the_term_link_single( $taxonomy = 'category', $before = '', $after = '', $post_id = false ) {

	// Bail if post is not related to taxonomy.
	if ( ! is_object_in_taxonomy( get_post_type( $post_id ), $taxonomy ) ) {
		return;
	}

	$post = get_post( $post_id );

	// Bail if not valid post.
	if ( ! is_a( $post, 'WP_Post' ) ) {
		return;
	}

	$terms = wp_get_post_terms( $post->ID, $taxonomy );

	// Bail if no terms available.
	if ( empty( $terms ) ) {
		return;
	}

	// Sort the terms by ID and get the first category.
	if ( function_exists( 'wp_list_sort' ) ) {
		$terms = wp_list_sort( $terms, 'term_id' );
	}
	else {
		usort( $terms, '_usort_terms_by_ID' );
	}

	$term = array_shift( $terms );

	$link = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';

	$link = $before . $link . $after;

	echo $link;

}

<?php
/**
 * Theme functions related to structure.
 *
 * This file contains structural hook functions.
 *
 * @package pastry_shop
 */

if ( ! function_exists( 'pastry_shop_doctype' ) ) :
	/**
	 * Doctype Declaration.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_doctype() {
	?><!DOCTYPE html> <html <?php language_attributes(); ?>><?php
	}
endif;

add_action( 'pastry_shop_action_doctype', 'pastry_shop_doctype', 10 );


if ( ! function_exists( 'pastry_shop_head' ) ) :
	/**
	 * Header Codes.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_head() {
	?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php
	}
endif;
add_action( 'pastry_shop_action_head', 'pastry_shop_head', 10 );

if ( ! function_exists( 'pastry_shop_page_start' ) ) :
	/**
	 * Page Start.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_page_start() {
	?>
    <div id="page" class="hfeed site">
    <?php
	}
endif;
add_action( 'pastry_shop_action_before', 'pastry_shop_page_start' );

if ( ! function_exists( 'pastry_shop_page_end' ) ) :
	/**
	 * Page End.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_page_end() {
	?></div><!-- #page --><?php
	}
endif;

add_action( 'pastry_shop_action_after', 'pastry_shop_page_end' );

if ( ! function_exists( 'pastry_shop_content_start' ) ) :
	/**
	 * Content Start.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_content_start() {
	?><?php if(!is_page_template( 'home-page-template.php' )) { echo '<div id="content" class="site-content">'; } ?><?php if(!is_page_template( 'home-page-template.php' )) { echo '<div class="container">'; } ?><div class="inner-wrapper"><?php
	}
endif;
add_action( 'pastry_shop_action_before_content', 'pastry_shop_content_start' );


if ( ! function_exists( 'pastry_shop_content_end' ) ) :
	/**
	 * Content End.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_content_end() {
	?></div><!-- .inner-wrapper --></div><!-- .container --><?php if(!is_page_template( 'home-page-template.php' )) { echo '</div>'; } ?><!-- #content --><?php
	}
endif;
add_action( 'pastry_shop_action_after_content', 'pastry_shop_content_end' );


if ( ! function_exists( 'pastry_shop_header_start' ) ) :
	/**
	 * Header Start.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_header_start() {
		?><header id="masthead" class="site-header" role="banner"><?php
	}
endif;
add_action( 'pastry_shop_action_before_header', 'pastry_shop_header_start' );

if ( ! function_exists( 'pastry_shop_header_end' ) ) :
	/**
	 * Header End.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_header_end() {
	?></div><!-- .container --></header><!-- #masthead --><?php
	}
endif;
add_action( 'pastry_shop_action_after_header', 'pastry_shop_header_end' );



if ( ! function_exists( 'pastry_shop_footer_start' ) ) :
	/**
	 * Footer Start.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_footer_start() {
		$pastry_shop_footer_status = apply_filters( 'pastry_shop_filter_footer_status', true );
		if ( true !== $pastry_shop_footer_status ) {
			return;
		}
	?><footer id="colophon" class="site-footer" role="contentinfo"><div class="container"><?php
	}
endif;
add_action( 'pastry_shop_action_before_footer', 'pastry_shop_footer_start' );


if ( ! function_exists( 'pastry_shop_footer_end' ) ) :
	/**
	 * Footer End.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_footer_end() {
		$pastry_shop_footer_status = apply_filters( 'pastry_shop_filter_footer_status', true );
		if ( true !== $pastry_shop_footer_status ) {
			return;
		}
		$pastry_shop_enable_cursor_dot_outline = pastry_shop_get_option('pastry_shop_enable_cursor_dot_outline');
		if ($pastry_shop_enable_cursor_dot_outline) { ?>
			<!-- Custom cursor -->
			<div class="cursor-point-outline"></div>
			<div class="cursor-point"></div>
			<!-- .Custom cursor -->
		<?php } ?>
		</div><!-- .container --></footer><!-- #colophon --><?php
	}
endif;
add_action( 'pastry_shop_action_after_footer', 'pastry_shop_footer_end' );

<?php
/**
 * Core functions.
 *
 * @package pastry_shop
 */

if ( ! function_exists( 'pastry_shop_get_option' ) ) :

	/**
	 * Get theme option
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function pastry_shop_get_option( $key ) {

		$pastry_shop_default_options = pastry_shop_get_default_theme_options();

		if ( empty( $key ) ) {
			return;
		}

		$pastry_shop_theme_options = (array)get_theme_mod( 'theme_options' );
		$pastry_shop_theme_options = wp_parse_args( $pastry_shop_theme_options, $pastry_shop_default_options );

		$pastry_shop_value = null;

		if ( isset( $pastry_shop_theme_options[ $key ] ) ) {
			$pastry_shop_value = $pastry_shop_theme_options[ $key ];
		}

		return $pastry_shop_value;

	}

endif;

if ( ! function_exists( 'pastry_shop_get_options' ) ) :

	/**
	 * Get all theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Theme options.
	 */
  function pastry_shop_get_options() {

    $pastry_shop_default_options = pastry_shop_get_default_theme_options();
    $pastry_shop_theme_options = (array)get_theme_mod( 'theme_options' );
    $pastry_shop_theme_options = wp_parse_args( $pastry_shop_theme_options, $pastry_shop_default_options );
    return $pastry_shop_theme_options;

  }

endif;

if( ! function_exists( 'pastry_shop_exclude_category_in_blog_page' ) ) :

  /**
   * Exclude category in blog page.
   *
   * @since 1.0
   */
  function pastry_shop_exclude_category_in_blog_page( $query ) {

    if( $query->is_home && $query->is_main_query()   ) {
      $pastry_shop_exclude_categories = pastry_shop_get_option( 'exclude_categories' );
      if ( ! empty( $pastry_shop_exclude_categories ) ) {
        $cats = explode( ',', $pastry_shop_exclude_categories );
        $cats = array_filter( $cats, 'is_numeric' );
        $pastry_shop_string_exclude = '';
        if ( ! empty( $cats ) ) {
          $pastry_shop_string_exclude = '-' . implode( ',-', $cats);
          $query->set( 'cat', $pastry_shop_string_exclude );
        }
      }
    }
    return $query;
  }

endif;

add_filter( 'pre_get_posts', 'pastry_shop_exclude_category_in_blog_page' );

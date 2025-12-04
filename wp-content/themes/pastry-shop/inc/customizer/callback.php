<?php
/**
 * Callback functions for active_callback.
 *
 * @package pastry_shop
 */

if ( ! function_exists( 'pastry_shop_is_image_in_archive_active' ) ) :

	/**
	 * Check if image in archive is active.
	 *
	 * @since 1.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function pastry_shop_is_image_in_archive_active( $control ) {

		if ( 'disable' !== $control->manager->get_setting( 'theme_options[pastry_shop_archive_image]' )->value() ) {
			return true;
		} else {
			return false;
		}

	}

endif;

if ( ! function_exists( 'pastry_shop_is_image_in_single_active' ) ) :

	/**
	 * Check if image in single is active.
	 *
	 * @since 1.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function pastry_shop_is_image_in_single_active( $control ) {

		if ( 'disable' !== $control->manager->get_setting( 'theme_options[pastry_shop_single_image]' )->value() ) {
			return true;
		} else {
			return false;
		}

	}

endif;

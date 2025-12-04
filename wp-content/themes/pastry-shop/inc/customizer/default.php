<?php
/**
 * Default theme options.
 *
 * @package pastry_shop
 */

if ( ! function_exists( 'pastry_shop_get_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function pastry_shop_get_default_theme_options() {

		$defaults = array();

		// Typography
		$defaults['pastry_shop_body_font_family']         = '';
		$defaults['pastry_shop_h1_font_family']          	= '';
		$defaults['pastry_shop_h1_font_size']         	= '';
		$defaults['pastry_shop_h2_font_family']          	= '';
		$defaults['pastry_shop_h2_font_size']         	= '';
		$defaults['pastry_shop_h3_font_family']          	= '';
		$defaults['pastry_shop_h3_font_size']         	= '';
		$defaults['pastry_shop_h4_font_family']          	= '';
		$defaults['pastry_shop_h4_font_size']         	= '';
		$defaults['pastry_shop_h5_font_family']          	= '';
		$defaults['pastry_shop_h5_font_size']         	= '';
		$defaults['pastry_shop_h6_font_family']          	= '';
		$defaults['pastry_shop_h6_font_size']         	= '';

		// Site title And tagline Option

		$defaults['pastry_shop_site_title_font_size']         = '';
		$defaults['pastry_shop_site_tagline_font_size']         = '';
		$defaults['pastry_shop_site_title_color'] = '#FFF';

		// Global Color
		$defaults['pastry_shop_first_color']        = '#803D18';
		$defaults['pastry_shop_second_color']        = '#A6633F';

		//General Option
        $defaults['pastry_shop_show_scroll_to_top']          = true;
        $defaults['pastry_shop_show_preloader_setting']      = false;
        $defaults['pastry_shop_show_data_sticky_setting']    = false;
		$defaults['pastry_shop_enable_cursor_dot_outline'] = false;

        //Post Option
        $defaults['pastry_shop_show_post_date_setting']         		 = true;
        $defaults['pastry_shop_show_post_heading_setting']      		 = true;
        $defaults['pastry_shop_show_post_content_setting']       		 = true;
        $defaults['pastry_shop_show_post_admin_setting']         		 = true;
        $defaults['pastry_shop_show_post_categories_setting']    		 = true;
        $defaults['pastry_shop_show_post_comments_setting']    	 	 = true;
        $defaults['pastry_shop_show_post_featured_image_setting']   	 = true;
        $defaults['pastry_shop_show_post_tags_setting']    			 = true;
		$defaults['pastry_shop_enable_post_navigation'] 				= true;
		$defaults['pastry_shop_show_first_caps']      			= false;

		// Related Post
		$defaults['pastry_shop_enable_related_post'] 					= true;
		$defaults['pastry_shop_enable_related_post_image'] 					= true;

		// Header.
		$defaults['pastry_shop_show_title']            = true;
		$defaults['pastry_shop_show_tagline']          = false;
	
		// Layout.
		$defaults['pastry_shop_global_layout']           = 'right-sidebar';
		$defaults['pastry_shop_archive_layout']          = 'excerpt';
		$defaults['pastry_shop_archive_image']           = 'large';
		$defaults['pastry_shop_archive_image_alignment'] = 'none';
		$defaults['pastry_shop_single_image']            = 'large';

		// Home Page.
		$defaults['pastry_shop_home_content_status'] = true;

		// Wow Animation
        $defaults['pastry_shop_animation'] = true;
		
		// No Result.
		$defaults['pastry_shop_no_result_title']  = esc_html__( 'Nothing Found', 'pastry-shop' );
		$defaults['pastry_shop_no_result_text']  = esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'pastry-shop' );

		// Footer.
		$defaults['pastry_shop_copyright_text']        = esc_html__( 'Copyright &copy; All rights reserved.', 'pastry-shop' );
		$defaults['pastry_shop_copyright_background_color'] = '#803D18';
		$defaults['pastry_shop_copyright_text_color'] = '#fff';

		// Pass through filter.
		$defaults = apply_filters( 'pastry_shop_filter_default_theme_options', $defaults );
		return $defaults;
	}

endif;

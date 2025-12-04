<?php
/**
 * Custom theme functions.
 *
 * This file contains hook functions attached to theme hooks.
 *
 * @package pastry_shop
 */

if ( ! function_exists( 'pastry_shop_skip_to_content' ) ) :
	/**
	 * Add Skip to content.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_skip_to_content() {
	?><a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'pastry-shop' ); ?></a><?php
	}
endif;

add_action( 'pastry_shop_action_before', 'pastry_shop_skip_to_content', 15 );

// Middle Header

if ( ! function_exists( 'pastry_shop_site_branding' ) ) :

	/**
	 * Site branding.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_site_branding() {

		$pastry_shop_header_top_button_text = pastry_shop_get_option( 'pastry_shop_header_top_button_text' );
		$pastry_shop_header_top_button_link = pastry_shop_get_option( 'pastry_shop_header_top_button_link' );
		$pastry_shop_quote_button_link = pastry_shop_get_option( 'pastry_shop_quote_button_link' );

		$pastry_shop_data_sticky = pastry_shop_get_option( 'pastry_shop_show_data_sticky_setting' );
		?>

		<div id="middle-header" class="py-2" data-sticky= "<?php echo esc_attr($pastry_shop_data_sticky); ?>">
			<div class="container">
				<div class="row">
					<div class="col-xl-2 col-lg-3 col-md-3 col-12 align-self-center">
						<div class="site-branding mb-3 mb-lg-0 text-md-start text-center">
							<?php pastry_shop_the_custom_logo(); ?>
							<?php $pastry_shop_show_title = pastry_shop_get_option( 'pastry_shop_show_title' ); ?>
							<?php $pastry_shop_show_tagline = pastry_shop_get_option( 'pastry_shop_show_tagline' ); ?>
							<?php if ( true === $pastry_shop_show_title || true === $pastry_shop_show_tagline ) :  ?>
								<div id="site-identity" class="text-center text-md-start text-lg-start">
									<?php if ( true === $pastry_shop_show_title ) :  ?>
										<?php if ( is_front_page() ) : ?>
											<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
										<?php else : ?>
											<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
										<?php endif; ?>
									<?php endif; ?>
									<?php if ( true === $pastry_shop_show_tagline ) :  ?>
										<p class="site-description"><?php bloginfo( 'description' ); ?></p>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-xl-7 col-lg-6 col-md-4 col-3 align-self-center">
						<div class="toggle-menu gb_menu">
							<button onclick="pastry_shop_gb_Menu_open()" class="gb_toggle"><span class="dashicons dashicons-menu-alt"></span></button>
						</div>
						<div id="gb_responsive" class="nav side_gb_nav">
							<nav id="top_gb_menu" class="gb_nav_menu" role="navigation" aria-label="<?php esc_attr_e( 'Menu', 'pastry-shop' ); ?>">
								<?php
									wp_nav_menu( array( 
										'theme_location' => 'primary-menu',
										'container_class' => 'gb_navigation clearfix' ,
										'menu_class' => 'clearfix',
										'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav m-0 px-0">%3$s</ul>',
										'fallback_cb' => 'wp_page_menu',
									) );
								?>
								<a href="javascript:void(0)" class="closebtn gb_menu" onclick="pastry_shop_gb_Menu_close()">x<span class="screen-reader-text"><?php esc_html_e('Close Menu','pastry-shop'); ?></span></a>
							</nav>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-5 col-9 align-self-center text-center d-flex justify-content-between">
						<?php if( !empty($pastry_shop_quote_button_link)):?>
							<div class="cart-btn my-2">
								<a href="<?php echo esc_url($pastry_shop_quote_button_link);?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/basket.svg" alt=""></a>
							</div>
						<?php endif; ?>
						<?php if( !empty($pastry_shop_header_top_button_text) || !empty($pastry_shop_header_top_button_link) ):?>
							<div class="online-btn my-2"><a href="<?php echo esc_url($pastry_shop_header_top_button_link);?>" target="_blank" ><span class="dashicons dashicons-calendar-alt me-2"></span><?php echo esc_html($pastry_shop_header_top_button_text);?></a></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		
	    <?php
	}

endif;

add_action( 'pastry_shop_action_header', 'pastry_shop_site_branding' );

/////////////////////////////////// copyright start /////////////////////////////

if ( ! function_exists( 'pastry_shop_footer_copyright' ) ) :

	/**
	 * Footer copyright
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_footer_copyright() {

		// Check if footer is disabled.
		$pastry_shop_footer_status = apply_filters( 'pastry_shop_filter_footer_status', true );
		if ( true !== $pastry_shop_footer_status ) {
			return;
		}

		// Copyright content.
		$pastry_shop_copyright_text = pastry_shop_get_option( 'pastry_shop_copyright_text' );
		$pastry_shop_copyright_text = apply_filters( 'pastry_shop_filter_copyright_text', $pastry_shop_copyright_text );
		if ( ! empty( $pastry_shop_copyright_text ) ) {
			$pastry_shop_copyright_text = wp_kses_data( $pastry_shop_copyright_text );
		}

		// Powered by content.
		$pastry_shop_powered_by_text = sprintf( __( 'Pastry Shop by %s', 'pastry-shop' ), '<span>' . __( 'Mizan Themes', 'pastry-shop' ) . '</span>' );
		?>

		<div class="colophon-inner">
		    <?php if ( ! empty( $pastry_shop_copyright_text ) ) : ?>
			    <div class="colophon-column">
			    	<div class="copyright">
						<a href="<?php echo esc_url('https://www.mizanthemes.com/products/free-pastry-wordpress-theme','pastry-shop'); ?>"><?php echo $pastry_shop_copyright_text; ?></a>
			    	</div><!-- .copyright -->
			    </div><!-- .colophon-column -->
		    <?php endif; ?>

		    <?php if ( ! empty( $pastry_shop_powered_by_text ) ) : ?>
			    <div class="colophon-column">
			    	<div class="site-info">
						<?php echo $pastry_shop_powered_by_text; ?>
			    	</div><!-- .site-info -->
			    </div><!-- .colophon-column -->
		    <?php endif; ?>
		</div><!-- .colophon-inner -->
		
	    <?php
	}

endif;

add_action( 'pastry_shop_action_footer', 'pastry_shop_footer_copyright', 10 );

// /////////////////////////////////sidebar//////////////////

if ( ! function_exists( 'pastry_shop_add_sidebar' ) ) :

	/**
	 * Add sidebar.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_add_sidebar() {

		global $post;

		$pastry_shop_global_layout = pastry_shop_get_option( 'pastry_shop_global_layout' );
		$pastry_shop_global_layout = apply_filters( 'pastry_shop_filter_theme_global_layout', $pastry_shop_global_layout );

		// Check if single.
		if ( $post && is_singular() ) {
			$pastry_shop_post_options = get_post_meta( $post->ID, 'pastry_shop_theme_settings', true );
			if ( isset( $pastry_shop_post_options['post_layout'] ) && ! empty( $pastry_shop_post_options['pastry_shop_post_layout'] ) ) {
				$pastry_shop_global_layout = $pastry_shop_post_options['pastry_shop_post_layout'];
			}
		}

		// Include primary sidebar.
		if ( 'no-sidebar' !== $pastry_shop_global_layout ) {
			get_sidebar();
		}
		// Include Secondary sidebar.
		switch ( $pastry_shop_global_layout ) {
			case 'three-columns':
			get_sidebar( 'secondary' );
			break;

			default:
			break;
		}

		// Include Secondary sidebar 1.
		switch ( $pastry_shop_global_layout ) {
			case 'four-columns':
			get_sidebar( 'secondary' );
			break;

			default:
			break;
		}

	}

endif;

add_action( 'pastry_shop_action_sidebar', 'pastry_shop_add_sidebar' );

//////////////////////////////////////// single page


if ( ! function_exists( 'pastry_shop_add_image_in_single_display' ) ) :

	/**
	 * Add image in single post.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_add_image_in_single_display() {

		global $post;

		if ( has_post_thumbnail() ) {

			$values = get_post_meta( $post->ID, 'pastry_shop_theme_settings', true );
			$pastry_shop_theme_settings_single_image = isset( $values['pastry_shop_single_image'] ) ? esc_attr( $values['pastry_shop_single_image'] ) : '';

			if ( ! $pastry_shop_theme_settings_single_image ) {
				$pastry_shop_theme_settings_single_image = pastry_shop_get_option( 'pastry_shop_single_image' );
			}

			if ( 'disable' !== $pastry_shop_theme_settings_single_image ) {
				$args = array(
					'class' => 'alignleft',
				);
				the_post_thumbnail( esc_attr( $pastry_shop_theme_settings_single_image ), $args );
			}
		}

	}

endif;

add_action( 'pastry_shop_single_image', 'pastry_shop_add_image_in_single_display' );

if ( ! function_exists( 'pastry_shop_footer_goto_top' ) ) :

	/**
	 * Go to top.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_footer_goto_top() {
        
        $pastry_shop_show_scroll_to_top = pastry_shop_get_option( 'pastry_shop_show_scroll_to_top' );
        if ( true === $pastry_shop_show_scroll_to_top ) :
		echo '<a id="scrollToTopBtn" href="#page">
				<svg id="progressCircle" width="50" height="50" aria-hidden="true">
					<circle cx="25" cy="25" r="22" stroke-width="4" fill="none"/>
				</svg>
				<i class="fa-solid fa-arrow-up"></i>
				</a>';
		endif;

	}

endif;

add_action( 'pastry_shop_action_after', 'pastry_shop_footer_goto_top', 20 );
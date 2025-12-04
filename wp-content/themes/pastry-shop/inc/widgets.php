<?php
/**
 * Theme widgets.
 *
 * @package pastry_shop
 */

if ( ! function_exists( 'pastry_shop_load_widgets' ) ) :

	/**
	 * Load widgets.
	 *
	 * @since 1.0.0
	 */
	function pastry_shop_load_widgets() {

		// Social widget.
		register_widget( 'Pastry_Shop_Social_Widget' );

	}

endif;

add_action( 'widgets_init', 'pastry_shop_load_widgets' );

if ( ! class_exists( 'Pastry_Shop_Social_Widget' ) ) :

	/**
	 * Social widget Class.
	 *
	 * @since 1.0.0
	 */
	class Pastry_Shop_Social_Widget extends pastry_shop_Widget_Base {

		/**
		 * Sets up a new widget instance.
		 *
		 * @since 1.0.0
		 */
		function __construct() {

			$opts = array(
				'classname'                   => 'pastry_shop_widget_social',
				'description'                 => __( 'Displays social icons.', 'pastry-shop' ),
				'customize_selective_refresh' => true,
				);
			$fields = array(
				'title' => array(
					'label' => __( 'Title:', 'pastry-shop' ),
					'type'  => 'text',
					'class' => 'widefat',
					),
				);

			if ( false === has_nav_menu( 'social' ) ) {
				$fields['message'] = array(
					'label' => __( 'Social menu is not set. Please create menu and assign it to Social Menu.', 'pastry-shop' ),
					'type'  => 'message',
					'class' => 'widefat',
					);
			}

			parent::__construct( 'pastry-shop-social', __( 'Social Widget', 'pastry-shop' ), $opts, array(), $fields );

		}

		/**
		 * Outputs the content for the current widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments.
		 * @param array $instance Settings for the current widget instance.
		 */
		function widget( $args, $instance ) {

			$params = $this->get_params( $instance );

			echo $args['before_widget'];

			if ( ! empty( $params['title'] ) ) {
				echo $args['before_title'] . $params['title'] . $args['after_title'];
			}

			if ( has_nav_menu( 'social' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'social',
					'container'      => false,
					'depth'          => 1,
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>',
				) );
			}

			echo $args['after_widget'];

		}
	}
endif;

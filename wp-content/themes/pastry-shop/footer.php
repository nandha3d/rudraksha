<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pastry_shop
 */

	/**
	 * Hook - pastry_shop_action_after_content.
	 *
	 * @hooked pastry_shop_content_end - 10
	 */
	do_action( 'pastry_shop_action_after_content' );
?>

	<?php
	/**
	 * Hook - pastry_shop_action_before_footer.
	 *
	 * @hooked pastry_shop_add_footer_bottom_widget_area - 5
	 * @hooked pastry_shop_footer_start - 10
	 */
	do_action( 'pastry_shop_action_before_footer' );
	?>
    <?php
	  /**
	   * Hook - pastry_shop_action_footer.
	   *
	   * @hooked pastry_shop_footer_copyright - 10
	   */
	  do_action( 'pastry_shop_action_footer' );
	?>
	<?php
	/**
	 * Hook - pastry_shop_action_after_footer.
	 *
	 * @hooked pastry_shop_footer_end - 10
	 */
	do_action( 'pastry_shop_action_after_footer' );
	?>

<?php
	/**
	 * Hook - pastry_shop_action_after.
	 *
	 * @hooked pastry_shop_page_end - 10
	 * @hooked pastry_shop_footer_goto_top - 20
	 */
	do_action( 'pastry_shop_action_after' );
?>

<?php wp_footer(); ?>
</body>
</html>

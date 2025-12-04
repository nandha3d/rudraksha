<?php
/**
 * The Secondary Sidebar.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pastry_shop
 */

?>
<?php $pastry_shop_default_sidebar = apply_filters( 'pastry_shop_filter_default_sidebar_id', 'sidebar-2', 'secondary' ); ?>
<div id="sidebar-secondary" class="widget-area sidebar zoomInRight wow" role="complementary">
	<?php if ( is_active_sidebar( $pastry_shop_default_sidebar ) ) : ?>
		<?php dynamic_sidebar( $pastry_shop_default_sidebar ); ?>
	<?php else : ?>
		<?php
			do_action( 'pastry_shop_action_default_sidebar', $pastry_shop_default_sidebar, 'secondary' );
		?>
	<?php endif ?>
</div>

<?php $pastry_shop_default_sidebar1 = apply_filters( 'pastry_shop_filter_default_sidebar_id1', 'sidebar-3', 'secondary' ); ?>
<div id="sidebar-secondary1" class="widget-area sidebar zoomInRight wow" role="complementary">
	<?php if ( is_active_sidebar( $pastry_shop_default_sidebar1 ) ) : ?>
		<?php dynamic_sidebar( $pastry_shop_default_sidebar1 ); ?>
	<?php else : ?>
		<?php
			do_action( 'pastry_shop_action_default_sidebar1', $pastry_shop_default_sidebar1, 'secondary' );
		?>
	<?php endif ?>
</div>
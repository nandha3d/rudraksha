<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package pastry_shop
 */

?>

<?php $pastry_shop_no_result_title = pastry_shop_get_option( 'pastry_shop_no_result_title' ); ?>
<?php $pastry_shop_no_result_text = pastry_shop_get_option( 'pastry_shop_no_result_text' ); ?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php echo esc_html($pastry_shop_no_result_title);?></h1>
	</header>
	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'pastry-shop' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
		<?php elseif ( is_search() ) : ?>
			<p><?php echo esc_html($pastry_shop_no_result_text);?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'pastry-shop' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
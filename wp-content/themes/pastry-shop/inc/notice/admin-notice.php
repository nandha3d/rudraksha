<?php
$theme = wp_get_theme();

$screen = get_current_screen();
if ( ! empty( $screen->base ) && 'appearance_page_pastry-shop-getting-started' === $screen->base ) {
	return false;
}

?>
<div class="notice notice-success is-dismissible pastry-shop-admin-notice">
	<div class="pastry-shop-admin-notice-wrapper">
		<h2 style="font-size:25px;" ><?php esc_html_e( 'Thank you for selecting ', 'pastry-shop' ); ?> <?php echo $theme->get( 'Name' ); ?> <?php esc_html_e( 'Theme!', 'pastry-shop' ); ?></h2>
		<p style="font-size:14px; margin:20px 0px;" ><?php esc_html_e( 'Explore the benefits of our simple Demo Importer and automatic Plugin Installation. Click the button below to begin.', 'pastry-shop' ); ?></p>
		<span class="admin-2-btn" >
			<a class="button-secondary" style="margin-bottom: 15px; margin-right: 10px; padding: 3px 15px;" href="<?php echo esc_url( admin_url( 'themes.php?page=pastry-shop-getting-started' ) ); ?>"><?php esc_html_e( 'Import Theme Demo', 'pastry-shop' ); ?></a>
	        <a class="button-primary" style="margin-bottom: 15px; padding: 3px 15px;" href="<?php echo esc_url('https://www.mizanthemes.com/products/cake-shop-wordpress-theme'); ?>" target="_blank"><?php esc_html_e('Get Pastry Shop Pro', 'pastry-shop'); ?></a>
        </span>
	</div>
</div>
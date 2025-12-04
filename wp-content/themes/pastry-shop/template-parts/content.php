<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package pastry_shop
 */

?>
<div class="blog-content">
	<article id="post-<?php the_ID(); ?>" <?php post_class("zoomInRight wow"); ?>>
		<?php $pastry_shop_archive_layout = pastry_shop_get_option( 'pastry_shop_archive_layout' );
		$pastry_shop_show_post_image = pastry_shop_get_option( 'pastry_shop_show_post_featured_image_setting' );
		if ( true === $pastry_shop_show_post_image ) { ?>
			<div class="blog-img">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php
					$pastry_shop_archive_image           = pastry_shop_get_option( 'pastry_shop_archive_image' );
					$pastry_shop_archive_image_alignment = pastry_shop_get_option( 'pastry_shop_archive_image_alignment' );
					?>
					<?php if ( 'disable' !== $pastry_shop_archive_image ) : ?>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( esc_attr( $pastry_shop_archive_image ), array( 'class' => 'align'. esc_attr( $pastry_shop_archive_image_alignment ) ) ); ?></a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php }?>
		<div class="entry-content-wrapper">
			<?php pastry_shop_entry_meta_date(); ?>
			<?php $pastry_shop_show_post_heading = pastry_shop_get_option( 'pastry_shop_show_post_heading_setting' );
			if ( true === $pastry_shop_show_post_heading ) { ?>
				<header class="entry-header">
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				</header>
			<?php } ?>
			<footer class="entry-footer">
				<?php pastry_shop_entry_footer(); ?>
			</footer>
		</div>
		<?php $pastry_shop_show_post_content = pastry_shop_get_option( 'pastry_shop_show_post_content_setting' );
		if ( true === $pastry_shop_show_post_content ) { ?>
			<div class="text-content">
				<?php if ( 'full' === $pastry_shop_archive_layout ) : ?>
					<?php
					the_content( sprintf(
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'pastry-shop' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );
					?>
					<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'pastry-shop' ),
							'after'  => '</div>',
						) );
					?>
			    <?php else : ?>
					<?php the_excerpt(); ?>
			    <?php endif; ?>
			</div>
		<?php } ?>
	</article>
</div>


<?php
/**
 * Related posts based on categories and tags.
 * 
 */

$pastry_shop_archive_layout = pastry_shop_get_option( 'pastry_shop_archive_layout' ); 
$pastry_shop_related_posts_taxonomy = pastry_shop_get_option( 'pastry_shop_related_posts_taxonomy', 'category' );

$pastry_shop_post_args = array(
    'posts_per_page'    => 3,
    'orderby'           => 'rand',
    'post__not_in'      => array( get_the_ID() ),
);

$pastry_shop_tax_terms = wp_get_post_terms( get_the_ID(), 'category' );
$pastry_shop_terms_ids = array();
foreach( $pastry_shop_tax_terms as $tax_term ) {
	$pastry_shop_terms_ids[] = $tax_term->term_id;
}

$pastry_shop_post_args['category__in'] = $pastry_shop_terms_ids;

$pastry_shop_related_posts = new WP_Query( $pastry_shop_post_args );

if ( $pastry_shop_related_posts->have_posts() ) : ?>
    <div class="related-post">
        <h3><?php echo esc_html__('Related Post' ,'pastry-shop' );?></h3>
        <div class="row">
            <?php while ( $pastry_shop_related_posts->have_posts() ) : $pastry_shop_related_posts->the_post(); ?>
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                  <article id="post-<?php the_ID(); ?>" <?php post_class("zoomInRight wow"); ?>>
                  <?php $pastry_shop_enable_related_post_image = pastry_shop_get_option('pastry_shop_enable_related_post_image');
                    if ($pastry_shop_enable_related_post_image) { ?>
                      <div class="blog-img mb-2">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                        <?php endif; ?>
                      </div>
                    <?php } ?>
                    <div class="entry-content-wrapper">
                      <?php pastry_shop_entry_meta_date(); ?>
                        <header class="entry-header">
                          <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                        </header>
                    </div>
                    <div class="text-content">
                      <?php if ( 'full' === $pastry_shop_archive_layout ) : ?>
                        <?php
                        the_content( sprintf(
                          wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'pastry-shop' ), array( 'span' => array( 'class' => array() ) ) ),
                          the_title( '<span class="screen-reader-text">"', '"</span>', false )
                        ) );
                        ?>
                        <?php else : ?>
                        <?php the_excerpt(); ?>
                        <?php endif; ?>
                    </div>
                  </article>
              </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif;
wp_reset_postdata();
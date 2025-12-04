<?php
/**
 * Help Panel.
 *
 */
?>
<!-- Help file panel -->
<div id="help-panel" class="panel-left">
    <div class="panel-aside">
        <h4><?php esc_html_e( 'Theme Customizer', 'pastry-shop' ); ?></h4>
        <p><?php esc_html_e( 'To begin customizing your website, start by clicking "Customize"', 'pastry-shop' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( admin_url('customize.php') ); ?>" title="<?php esc_attr_e( 'Visit the Demo', 'pastry-shop' ); ?>" target="_blank">
            <?php esc_html_e( 'Customizing', 'pastry-shop' ); ?>
        </a>
    </div><!-- .panel-aside -->

    <div class="panel-aside">
        <h4><?php esc_html_e( 'Documentation', 'pastry-shop' ); ?></h4>
        <p><?php esc_html_e( 'Explore the comprehensive guide and instructions for this WordPress Theme. Begin your journey with assurance.', 'pastry-shop' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( PASTRY_SHOP_DOCUMENTATION ); ?>" title="<?php esc_attr_e( 'Visit the doc', 'pastry-shop' ); ?>" target="_blank">
            <?php esc_html_e( 'Documentation', 'pastry-shop' ); ?>
        </a>
    </div><!-- .panel-aside -->

    <div class="panel-aside">
        <h4><?php esc_html_e( 'Support Ticket', 'pastry-shop' ); ?></h4>
        <p><?php esc_html_e( 'Our dedicated team is well prepared to help you out in case of queries and doubts regarding our theme', 'pastry-shop' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( PASTRY_SHOP_SUPPORT ); ?>" title="<?php esc_attr_e( 'Visit the Support', 'pastry-shop' ); ?>" target="_blank">
            <?php esc_html_e( 'Contact Support', 'pastry-shop' ); ?>
        </a>
    </div><!-- .panel-aside -->

    <div class="panel-aside">
        <h4><?php esc_html_e( 'Reviews & Testimonials', 'pastry-shop' ); ?></h4>
        <p><?php esc_html_e( 'All the features and aspects of this WordPress Theme are phenomenal. I\'d recommend this theme to all.', 'pastry-shop' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( PASTRY_SHOP_REVIEW ); ?>" title="<?php esc_attr_e( 'Visit the Demo', 'pastry-shop' ); ?>" target="_blank">
            <?php esc_html_e( 'Review', 'pastry-shop' ); ?>
        </a>
    </div><!-- .panel-aside -->
</div>
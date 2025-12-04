<?php
/**
 * Plugin Panel.
 *
 */
?>
<!-- Updates panel -->
<div id="plugins-panel" class="panel-left">
    <div id="Mizan_Demo_Importor_editor" class="tabcontent">
        <?php if(!class_exists('Mizan_Importer_ThemeWhizzie')){
            $plugin_ins = Pastry_Shop_Plugin_Activation_Mizan_Demo_Importor::get_instance();
            $pastry_shop_actions = $plugin_ins->recommended_actions;
            ?>
            <div class="pastry-shop-recommended-plugins ">
                    <div class="pastry-shop-action-list">
                        <?php if ($pastry_shop_actions): foreach ($pastry_shop_actions as $key => $pastry_shop_actionValue): ?>
                                <div class="pastry-shop-action" id="<?php echo esc_attr($pastry_shop_actionValue['id']);?>">
                                    <div class="action-inner plugin-activation-redirect">
                                        <h4 class="action-title"><?php echo esc_html($pastry_shop_actionValue['title']); ?></h4>
                                        <div class="action-desc"><?php echo esc_html($pastry_shop_actionValue['desc']); ?></div>
                                        <?php echo wp_kses_post($pastry_shop_actionValue['link']); ?>
                                    </div>
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>
            </div>
        <?php }else{ ?>
            <div class="tab-outer-box">
                <h2><?php esc_html_e( 'Welcome to Mizan Theme!', 'pastry-shop' ); ?></h2>
                <p><?php esc_html_e( 'For setup the theme, First you need to click on the Begin activating plugins', 'pastry-shop' ); ?></p>
                <p><?php esc_html_e( '1. Install Mizan Demo Importor', 'pastry-shop' ); ?></p>
                <p><?php esc_html_e( '>> Then click to Return to Required Plugins Installer ', 'pastry-shop' ); ?></p>
                <p><?php esc_html_e( '2. Activate Mizan Demo Importor ', 'pastry-shop' ); ?></p>
                <p><?php esc_html_e( '>> Click on the start now button', 'pastry-shop' ); ?></p>
                <p><?php esc_html_e( '>> Click install plugins', 'pastry-shop' ); ?></p>
                <p><?php esc_html_e( '>> Click import demo button to setup the theme and click visit your site button', 'pastry-shop' ); ?></p>
            </div>
        <?php } ?>
    </div>
</div><!-- .panel-left -->
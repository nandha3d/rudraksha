<?php
/**
 * Start Elementor.
 *
 */
?>
<!-- Start Elementor -->
<div id="start-panel" class="panel-left visible">
    <div id="pastry-shop-importer" class="tabcontent open">
        <?php if(!class_exists('Mizan_Importer_ThemeWhizzie')){
            $plugin_ins = Pastry_Shop_Plugin_Activation_Mizan_Demo_Importor::get_instance();
            $pastry_shop_actions = $plugin_ins->recommended_actions;
            ?>
            <div class="pastry-shop-recommended-plugins ">
                <div class="pastry-shop-action-list">
                    <?php if ($pastry_shop_actions): foreach ($pastry_shop_actions as $key => $pastry_shop_actionValue): ?>
                            <div class="pastry-shop-action" id="<?php echo esc_attr($pastry_shop_actionValue['id']);?>">
                                <div class="action-inner plugin-activation-redirect">
                                    <h3 class="action-title"><?php echo esc_html($pastry_shop_actionValue['title']); ?></h3>
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
                <h3><?php esc_html_e('Welcome to Mizan Themes', 'pastry-shop'); ?></h3>
                <p class="start-text"><?php esc_html_e('The demo will import after you click the Start Quickly button.', 'pastry-shop'); ?></p>
                <div class="info-link">
                    <a class="button button-primary" href="<?php echo esc_url( admin_url('admin.php?page=mizandemoimporter-wizard') ); ?>"><?php esc_html_e('Start Quickly', 'pastry-shop'); ?></a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

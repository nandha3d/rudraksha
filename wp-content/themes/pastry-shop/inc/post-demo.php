<?php
class Whizzie {

    public function __construct() {
        $this->init();
    }

    public function init() {
        $this->pastry_shop_setup_theme_mods();
    }

    public function pastry_shop_setup_theme_mods() {
        $pastry_shop_options = get_theme_mod('theme_options', []);
        $pastry_shop_options['pastry_shop_header_top_button_text'] = 'Online Book';
        $pastry_shop_options['pastry_shop_header_top_button_link'] = '#';
        $pastry_shop_options['pastry_shop_quote_button_link'] = '#';
        set_theme_mod('theme_options', $pastry_shop_options);
    }
}
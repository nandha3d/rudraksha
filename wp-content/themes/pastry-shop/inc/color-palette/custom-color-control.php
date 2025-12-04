<?php

  $pastry_shop_color_palette_css = '';

	// Global Color

	$pastry_shop_first_color = pastry_shop_get_option('pastry_shop_first_color');
	$pastry_shop_second_color = pastry_shop_get_option('pastry_shop_second_color');

	if($pastry_shop_first_color != false){
		$pastry_shop_color_palette_css .=':root {';
			$pastry_shop_color_palette_css .='--primary-theme-color: '.esc_attr($pastry_shop_first_color).'!important;';
			$pastry_shop_color_palette_css .='--secondary-theme-color: '.esc_attr($pastry_shop_second_color).'!important;';
		$pastry_shop_color_palette_css .='}';
	}

	// Copyright Background Color
	$pastry_shop_copyright_background_color = pastry_shop_get_option('pastry_shop_copyright_background_color');
	$pastry_shop_color_palette_css .='#colophon {';
	$pastry_shop_color_palette_css .='background: '.esc_attr($pastry_shop_copyright_background_color);
	$pastry_shop_color_palette_css .='}';

	// Copyright Text Color
	$pastry_shop_copyright_text_color = pastry_shop_get_option('pastry_shop_copyright_text_color');
	$pastry_shop_color_palette_css .='#colophon a , #colophon{';
	$pastry_shop_color_palette_css .='color: '.esc_attr($pastry_shop_copyright_text_color);
	$pastry_shop_color_palette_css .='}';


	// Site title And tagline Option
	$pastry_shop_site_title_font_size = pastry_shop_get_option('pastry_shop_site_title_font_size');
	$pastry_shop_site_title_color = pastry_shop_get_option('pastry_shop_site_title_color');
	$pastry_shop_color_palette_css .='.site-title>a , .site-title {';
		$pastry_shop_color_palette_css .='font-size: '.esc_attr($pastry_shop_site_title_font_size).'px;';
		$pastry_shop_color_palette_css .='color: '.esc_attr($pastry_shop_site_title_color).';';
	$pastry_shop_color_palette_css .='}';
	
	$pastry_shop_site_tagline_font_size = pastry_shop_get_option('pastry_shop_site_tagline_font_size');
	if($pastry_shop_site_tagline_font_size != false){
		$pastry_shop_color_palette_css .='.site-description {';
			$pastry_shop_color_palette_css .='font-size: '.esc_attr($pastry_shop_site_tagline_font_size).'px;';
		$pastry_shop_color_palette_css .='}';
	}

	//First Cap
	$pastry_shop_show_first_caps = pastry_shop_get_option('pastry_shop_show_first_caps', false);
	if($pastry_shop_show_first_caps == 'true' ){
	$pastry_shop_color_palette_css .='.blog-content .text-content p:nth-of-type(1)::first-letter{';
	$pastry_shop_color_palette_css .=' font-size: 50px; font-weight: 600;';
	$pastry_shop_color_palette_css .=' margin-right: 5px;';
	$pastry_shop_color_palette_css .=' line-height: 1;';
	$pastry_shop_color_palette_css .='}';
	}elseif($pastry_shop_show_first_caps == 'false' ){
	$pastry_shop_color_palette_css .='.blog-content .text-content p:nth-of-type(1)::first-letter {';
	$pastry_shop_color_palette_css .='display: none;';
	$pastry_shop_color_palette_css .='}';
	}

	// preloader background image
	$pastry_shop_show_preloader_background_image = pastry_shop_get_option('pastry_shop_show_preloader_background_image');
	if($pastry_shop_show_preloader_background_image != false){
		$pastry_shop_color_palette_css .='#preloader {';
			$pastry_shop_color_palette_css .='background: url('.esc_attr($pastry_shop_show_preloader_background_image).');-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;';
		$pastry_shop_color_palette_css .='}';
	}
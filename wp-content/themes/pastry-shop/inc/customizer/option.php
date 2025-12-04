<?php
/**
 * Theme Options.
 *
 * @package pastry_shop
 */

$default = pastry_shop_get_default_theme_options();

// Add Panel.
$wp_customize->add_panel( 'pastry_shop_theme_option_panel',
	array(
	'title'      => __( 'Theme Options', 'pastry-shop' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	)
);

// Typography Section.

$pastry_shop_font_array = array(
	''                       => 'No Fonts',
	'Abril Fatface'          => 'Abril Fatface',
	'Acme'                   => 'Acme',
	'Anton'                  => 'Anton',
	'Architects Daughter'    => 'Architects Daughter',
	'Arimo'                  => 'Arimo',
	'Arsenal'                => 'Arsenal',
	'Arvo'                   => 'Arvo',
	'Alegreya'               => 'Alegreya',
	'Alfa Slab One'          => 'Alfa Slab One',
	'Averia Serif Libre'     => 'Averia Serif Libre',
	'Bangers'                => 'Bangers',
	'Boogaloo'               => 'Boogaloo',
	'Bad Script'             => 'Bad Script',
	'Bitter'                 => 'Bitter',
	'Bree Serif'             => 'Bree Serif',
	'BenchNine'              => 'BenchNine',
	'Cabin'                  => 'Cabin',
	'Cardo'                  => 'Cardo',
	'Courgette'              => 'Courgette',
	'Cherry Swash'           => 'Cherry Swash',
	'Cormorant Garamond'     => 'Cormorant Garamond',
	'Crimson Text'           => 'Crimson Text',
	'Cuprum'                 => 'Cuprum',
	'Cookie'                 => 'Cookie',
	'Chewy'                  => 'Chewy',
	'Days One'               => 'Days One',
	'Dosis'                  => 'Dosis',
	'Droid Sans'             => 'Droid Sans',
	'Economica'              => 'Economica',
	'Fredoka One'            => 'Fredoka One',
	'Fjalla One'             => 'Fjalla One',
	'Francois One'           => 'Francois One',
	'Frank Ruhl Libre'       => 'Frank Ruhl Libre',
	'Gloria Hallelujah'      => 'Gloria Hallelujah',
	'Great Vibes'            => 'Great Vibes',
	'Handlee'                => 'Handlee',
	'Hammersmith One'        => 'Hammersmith One',
	'Inconsolata'            => 'Inconsolata',
	'Indie Flower'           => 'Indie Flower',
	'IM Fell English SC'     => 'IM Fell English SC',
	'Julius Sans One'        => 'Julius Sans One',
	'Josefin Slab'           => 'Josefin Slab',
	'Josefin Sans'           => 'Josefin Sans',
	'Kanit'                  => 'Kanit',
	'Lobster'                => 'Lobster',
	'Lato'                   => 'Lato',
	'Lora'                   => 'Lora',
	'Libre Baskerville'      => 'Libre Baskerville',
	'Lobster Two'            => 'Lobster Two',
	'Merriweather'           => 'Merriweather',
	'Monda'                  => 'Monda',
	'Montserrat'             => 'Montserrat',
	'Muli'                   => 'Muli',
	'Marck Script'           => 'Marck Script',
	'Noto Serif'             => 'Noto Serif',
	'Open Sans'              => 'Open Sans',
	'Overpass'               => 'Overpass',
	'Overpass Mono'          => 'Overpass Mono',
	'Oxygen'                 => 'Oxygen',
	'Orbitron'               => 'Orbitron',
	'Patua One'              => 'Patua One',
	'Pacifico'               => 'Pacifico',
	'Padauk'                 => 'Padauk',
	'Playball'               => 'Playball',
	'Playfair Display'       => 'Playfair Display',
	'PT Sans'                => 'PT Sans',
	'Philosopher'            => 'Philosopher',
	'Permanent Marker'       => 'Permanent Marker',
	'Poiret One'             => 'Poiret One',
	'Quicksand'              => 'Quicksand',
	'Quattrocento Sans'      => 'Quattrocento Sans',
	'Raleway'                => 'Raleway',
	'Rubik'                  => 'Rubik',
	'Rokkitt'                => 'Rokkitt',
	'Russo One'              => 'Russo One',
	'Righteous'              => 'Righteous',
	'Slabo'                  => 'Slabo',
	'Source Sans Pro'        => 'Source Sans Pro',
	'Shadows Into Light Two' => 'Shadows Into Light Two',
	'Shadows Into Light'     => 'Shadows Into Light',
	'Sacramento'             => 'Sacramento',
	'Shrikhand'              => 'Shrikhand',
	'Tangerine'              => 'Tangerine',
	'Ubuntu'                 => 'Ubuntu',
	'VT323'                  => 'VT323',
	'Varela Round'           => 'Varela Round',
	'Vampiro One'            => 'Vampiro One',
	'Vollkorn'               => 'Vollkorn',
	'Volkhov'                => 'Volkhov',
	'Yanone Kaffeesatz'      => 'Yanone Kaffeesatz'
);

$wp_customize->add_section( 'pastry_shop_typography',
	array(
	'title'      => __( 'Typography', 'pastry-shop' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'pastry_shop_theme_option_panel',
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_body_font_family]',
	array(
	'default'           => $default['pastry_shop_body_font_family'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_choices',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_body_font_family]',
	array(
	'label'    => __( 'Body font family', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'select',
	'choices'  => $pastry_shop_font_array,
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_h1_font_family]',
	array(
	'default'           => $default['pastry_shop_h1_font_family'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_choices',
	)
);

$wp_customize->add_control( 'theme_options[pastry_shop_h1_font_family]',
	array(
	'label'    => __( 'H1 font family', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'select',
	'choices'  => $pastry_shop_font_array,
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_h1_font_size]',
	array(
	'default'           => $default['pastry_shop_h1_font_size'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control( 'theme_options[pastry_shop_h1_font_size]',
	array(
	'label'    => __( 'H1 Font Size', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'text',
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_h2_font_family]',
	array(
	'default'           => $default['pastry_shop_h2_font_family'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_choices',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_h2_font_family]',
	array(
	'label'    => __( 'H2 font family', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'select',
	'choices'  => $pastry_shop_font_array,
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_h2_font_size]',
	array(
	'default'           => $default['pastry_shop_h2_font_size'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_h2_font_size]',
	array(
	'label'    => __( 'H2 Font Size', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'text',
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_h3_font_family]',
	array(
	'default'           => $default['pastry_shop_h3_font_family'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_choices',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_h3_font_family]',
	array(
	'label'    => __( 'H3 font family', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'select',
	'choices'  => $pastry_shop_font_array,
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_h3_font_size]',
	array(
	'default'           => $default['pastry_shop_h3_font_size'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_h3_font_size]',
	array(
	'label'    => __( 'H3 Font Size', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'text',
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_h4_font_family]',
	array(
	'default'           => $default['pastry_shop_h4_font_family'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_choices',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_h4_font_family]',
	array(
	'label'    => __( 'H4 font family', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'select',
	'choices'  => $pastry_shop_font_array,
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_h4_font_size]',
	array(
	'default'           => $default['pastry_shop_h4_font_size'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_h4_font_size]',
	array(
	'label'    => __( 'H4 Font Size', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'text',
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_h5_font_family]',
	array(
	'default'           => $default['pastry_shop_h5_font_family'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_choices',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_h5_font_family]',
	array(
	'label'    => __( 'H5 font family', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'select',
	'choices'  => $pastry_shop_font_array,
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_h5_font_size]',
	array(
	'default'           => $default['pastry_shop_h5_font_size'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_h5_font_size]',
	array(
	'label'    => __( 'H5 Font Size', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'text',
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_h6_font_family]',
	array(
	'default'           => $default['pastry_shop_h6_font_family'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_choices',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_h6_font_family]',
	array(
	'label'    => __( 'H6 font family', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'select',
	'choices'  => $pastry_shop_font_array,
	'priority' => 100,
	)
);
$wp_customize->add_setting( 'theme_options[pastry_shop_h6_font_size]',
	array(
	'default'           => $default['pastry_shop_h6_font_size'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_h6_font_size]',
	array(
	'label'    => __( 'H6 Font Size', 'pastry-shop' ),
	'section'  => 'pastry_shop_typography',
	'type'     => 'text',
	'priority' => 100,
	)
);

// Site title And tagline Option

$wp_customize->add_setting( 'theme_options[pastry_shop_site_title_font_size]',
	array(
	'default'           => $default['pastry_shop_site_title_font_size'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_site_title_font_size]',
	array(
	'label'    => __( 'Site Title Font Size', 'pastry-shop' ),
	'section'  => 'title_tagline',
	'type'     => 'text',
	'priority' => 10,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_site_tagline_font_size]',
	array(
	'default'           => $default['pastry_shop_site_tagline_font_size'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_site_tagline_font_size]',
	array(
	'label'    => __( 'Site Tagline Font Size', 'pastry-shop' ),
	'section'  => 'title_tagline',
	'type'     => 'text',
	'priority' => 10,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_site_title_color]', array(
	'default'           => $default['pastry_shop_site_title_color'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
	'priority' => 100,
));

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'theme_options[pastry_shop_site_title_color]', array(
	'label'       => __( 'Site Title Color', 'pastry-shop' ),
	'section'     => 'title_tagline',
	'settings'    => 'theme_options[pastry_shop_site_title_color]',
	'priority' => 10,
)));

// Global Color

$wp_customize->add_section( 'pastry_shop_section_global_color', array(
	'title'      => __( 'Theme Color', 'pastry-shop' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'pastry_shop_theme_option_panel',
));

$wp_customize->add_setting( 'theme_options[pastry_shop_first_color]', array(
	'default'           => $default['pastry_shop_first_color'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
));

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'theme_options[pastry_shop_first_color]', array(
	'label'       => __( 'Highlight First Color', 'pastry-shop' ),
	'description' => __( 'With a single click, you can change the highlight color of the inner page; use the Elementor editor for customization on the homepage.', 'pastry-shop' ),
	'section'     => 'pastry_shop_section_global_color',
	'settings'    => 'theme_options[pastry_shop_first_color]',
)));

$wp_customize->add_setting( 'theme_options[pastry_shop_second_color]', array(
	'default'           => $default['pastry_shop_second_color'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
));

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'theme_options[pastry_shop_second_color]', array(
	'label'       => __( 'Highlight Second Color', 'pastry-shop' ),
	'description' => __( 'With a single click, you can change the highlight color of the inner page; use the Elementor editor for customization on the homepage.', 'pastry-shop' ),
	'section'     => 'pastry_shop_section_global_color',
	'settings'    => 'theme_options[pastry_shop_second_color]',
)));

// General Option.
$wp_customize->add_section( 'pastry_shop_section_general_option',
	array(
	'title'      => __( 'General Options', 'pastry-shop' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'pastry_shop_theme_option_panel',
	)
);

// Cursor Dot Outline
$wp_customize->add_setting(
    'theme_options[pastry_shop_enable_cursor_dot_outline]',
    array(
        'default' => $default['pastry_shop_enable_cursor_dot_outline'],
        'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'theme_options[pastry_shop_enable_cursor_dot_outline]',
    array(
        'label' => esc_html__('Enable Cursor Dot Outline', 'pastry-shop'),
        'section' => 'pastry_shop_section_general_option',
        'type' => 'checkbox',
    )
);

//Wow Animation
$wp_customize->add_setting(
    'pastry_shop_animation',
    array(
        'default' => $default['pastry_shop_animation'],
        'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
    )
);
$wp_customize->add_control(
    'pastry_shop_animation',
    array(
        'label' => esc_html__('Enable  Animation', 'pastry-shop'),
        'section' => 'pastry_shop_section_general_option',
        'type' => 'checkbox',
    )
);


// Setting show scroll to top.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_scroll_to_top]',
	array(
	'default'           => $default['pastry_shop_show_scroll_to_top'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_scroll_to_top]',
	array(
	'label'    => __( 'Show Scroll To Top', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_general_option',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting show Preloader.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_preloader_setting]',
	array(
	'default'           => $default['pastry_shop_show_preloader_setting'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_preloader_setting]',
	array(
	'label'    => __( 'Show Preloader', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_general_option',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting Preloader Background image.

$wp_customize->add_setting( 'theme_options[pastry_shop_show_preloader_background_image]',
	array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control( new WP_Customize_Image_Control(
	$wp_customize,
	'theme_options[pastry_shop_show_preloader_background_image]',
	array(
		'label'    => __( 'Preloader Background Image', 'pastry-shop' ),
		'section'  => 'pastry_shop_section_general_option',
		'priority' => 100,
	)
));

// Setting show Sticky Header.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_data_sticky_setting]',
	array(
	'default'           => $default['pastry_shop_show_data_sticky_setting'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_data_sticky_setting]',
	array(
	'label'    => __( 'Show Sticky Header', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_general_option',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Post Option.
$wp_customize->add_section( 'pastry_shop_section_post_option',
	array(
	'title'      => __( 'Post Options', 'pastry-shop' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'pastry_shop_theme_option_panel',
	)
);

// Setting show Post date.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_post_date_setting]',
	array(
	'default'           => $default['pastry_shop_show_post_date_setting'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_post_date_setting]',
	array(
	'label'    => __( 'Show Post Date', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_post_option',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting show Post Heading.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_post_heading_setting]',
	array(
	'default'           => $default['pastry_shop_show_post_heading_setting'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_post_heading_setting]',
	array(
	'label'    => __( 'Show Post Heading', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_post_option',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting show Post Content.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_post_content_setting]',
	array(
	'default'           => $default['pastry_shop_show_post_content_setting'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_post_content_setting]',
	array(
	'label'    => __( 'Show Post Full Content', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_post_option',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting show Post admin.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_post_admin_setting]',
	array(
	'default'           => $default['pastry_shop_show_post_admin_setting'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_post_admin_setting]',
	array(
	'label'    => __( 'Show Post Admin', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_post_option',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting show Post Categories.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_post_categories_setting]',
	array(
	'default'           => $default['pastry_shop_show_post_categories_setting'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_post_categories_setting]',
	array(
	'label'    => __( 'Show Post Categories', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_post_option',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting show Post Comments.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_post_comments_setting]',
	array(
	'default'           => $default['pastry_shop_show_post_comments_setting'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_post_comments_setting]',
	array(
	'label'    => __( 'Show Post Comments', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_post_option',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting show Post Featured Image.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_post_featured_image_setting]',
	array(
	'default'           => $default['pastry_shop_show_post_featured_image_setting'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_post_featured_image_setting]',
	array(
	'label'    => __( 'Show Post Featured Image', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_post_option',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting show Post Tags.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_post_tags_setting]',
	array(
	'default'           => $default['pastry_shop_show_post_tags_setting'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_post_tags_setting]',
	array(
	'label'    => __( 'Show Post Tags', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_post_option',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting Post Navigation.

$wp_customize->add_setting(
    'theme_options[pastry_shop_enable_post_navigation]',
    array(
        'default' => $default['pastry_shop_enable_post_navigation'],
        'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'theme_options[pastry_shop_enable_post_navigation]',
    array(
        'label' => esc_html__('Enable Post Navigation', 'pastry-shop'),
        'section' => 'pastry_shop_section_post_option',
        'type' => 'checkbox',
    )
);

// Setting show to First Cap

$wp_customize->add_setting( 'theme_options[pastry_shop_show_first_caps]',
	array(
	'default'           => $default['pastry_shop_show_first_caps'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_first_caps]',
	array(
	'label'    => __( 'First Cap (First Capital Letter)', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_post_option',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Related post

$wp_customize->add_section( 'pastry_shop_related_post_option',
	array(
	'title'      => __( 'Related Post Options', 'pastry-shop' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'pastry_shop_theme_option_panel',
	)
);

$wp_customize->add_setting(
    'theme_options[pastry_shop_enable_related_post]',
    array(
        'default' => $default['pastry_shop_enable_related_post'],
        'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'theme_options[pastry_shop_enable_related_post]',
    array(
        'label' => esc_html__('Enable Related post', 'pastry-shop'),
        'section' => 'pastry_shop_related_post_option',
        'type' => 'checkbox',
    )
);

$wp_customize->add_setting(
    'theme_options[pastry_shop_enable_related_post_image]',
    array(
        'default' => $default['pastry_shop_enable_related_post_image'],
        'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
    )
);

$wp_customize->add_control(
    'theme_options[pastry_shop_enable_related_post_image]',
    array(
        'label' => esc_html__('Enable Related post Image', 'pastry-shop'),
        'section' => 'pastry_shop_related_post_option',
        'type' => 'checkbox',
    )
);

// Header Section.
$wp_customize->add_section( 'pastry_shop_section_header',
	array(
	'title'      => __( 'Header Options', 'pastry-shop' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'pastry_shop_theme_option_panel',
	)
);

// Setting show_title.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_title]',
	array(
	'default'           => $default['pastry_shop_show_title'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_title]',
	array(
	'label'    => __( 'Show Site Title', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_header',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting show_tagline.
$wp_customize->add_setting( 'theme_options[pastry_shop_show_tagline]',
	array(
	'default'           => $default['pastry_shop_show_tagline'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_show_tagline]',
	array(
	'label'    => __( 'Show Tagline', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_header',
	'type'     => 'checkbox',
	'priority' => 100,
	)
);

// Setting button Text
$wp_customize->add_setting( 'theme_options[pastry_shop_header_top_button_text]',
	array(
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_header_top_button_text]',
	array(
	'label'    => __( 'Add Button Text', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_header',
	'type'     => 'text',
	'priority' => 100,
	)
);
// Setting button Url
$wp_customize->add_setting( 'theme_options[pastry_shop_header_top_button_link]',
	array(
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_header_top_button_link]',
	array(
	'label'    => __( 'Add Button Link', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_header',
	'type'     => 'url',
	'priority' => 100,
	)
);

// Contact button link
$wp_customize->add_setting( 'theme_options[pastry_shop_quote_button_link]',
	array(
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control( 'theme_options[pastry_shop_quote_button_link]',
	array(
	'label'    => __( 'Cart Link', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_header',
	'type'     => 'url',
	'priority' => 100,
	)
);

// Layout Section.
$wp_customize->add_section( 'pastry_shop_section_layout',
	array(
	'title'      => __( 'Layout Options', 'pastry-shop' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'pastry_shop_theme_option_panel',
	)
);

// Setting global_layout.
$wp_customize->add_setting( 'theme_options[pastry_shop_global_layout]',
	array(
	'default'           => $default['pastry_shop_global_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_global_layout]',
	array(
	'label'    => __( 'Global Layout', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_layout',
	'type'     => 'select',
	'choices'  => pastry_shop_get_global_layout_options(),
	'priority' => 100,
	)
);

// Setting archive_layout.
$wp_customize->add_setting( 'theme_options[pastry_shop_archive_layout]',
	array(
	'default'           => $default['pastry_shop_archive_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_archive_layout]',
	array(
	'label'    => __( 'Archive Layout', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_layout',
	'type'     => 'select',
	'choices'  => pastry_shop_get_archive_layout_options(),
	'priority' => 100,
	)
);

// Setting archive_image.
$wp_customize->add_setting( 'theme_options[pastry_shop_archive_image]',
	array(
	'default'           => $default['pastry_shop_archive_image'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_archive_image]',
	array(
	'label'    => __( 'Image in Archive', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_layout',
	'type'     => 'select',
	'choices'  => pastry_shop_get_image_sizes_options( true, array( 'disable', 'thumbnail', 'medium', 'large' ), false ),
	'priority' => 100,
	)
);
// Setting archive_image_alignment.
$wp_customize->add_setting( 'theme_options[pastry_shop_archive_image_alignment]',
	array(
	'default'           => $default['pastry_shop_archive_image_alignment'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_archive_image_alignment]',
	array(
	'label'           => __( 'Image Alignment in Archive', 'pastry-shop' ),
	'section'         => 'pastry_shop_section_layout',
	'type'            => 'select',
	'choices'         => pastry_shop_get_image_alignment_options(),
	'priority'        => 100,
	'active_callback' => 'pastry_shop_is_image_in_archive_active',
	)
);
// Setting single_image.
$wp_customize->add_setting( 'theme_options[pastry_shop_single_image]',
	array(
	'default'           => $default['pastry_shop_single_image'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_select',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_single_image]',
	array(
	'label'    => __( 'Image in Single Post/Page', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_layout',
	'type'     => 'select',
	'choices'  => pastry_shop_get_image_sizes_options( true, array( 'disable', 'large' ), false ),
	'priority' => 100,
	)
);

// No Results Page Setting

$wp_customize->add_section( 'pastry_shop_no_result_page',
	array(
	'title'      => __( 'No Results Page Settings', 'pastry-shop' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'pastry_shop_theme_option_panel',
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_no_result_title]',
	array(
	'default'           => $default['pastry_shop_no_result_title'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control( 'theme_options[pastry_shop_no_result_title]',
	array(
	'label'    => __( 'Add Title', 'pastry-shop' ),
	'section'  => 'pastry_shop_no_result_page',
	'type'     => 'text',
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_no_result_text]',
	array(
	'default'           => $default['pastry_shop_no_result_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control( 'theme_options[pastry_shop_no_result_text]',
	array(
	'label'    => __( 'Add Text', 'pastry-shop' ),
	'section'  => 'pastry_shop_no_result_page',
	'type'     => 'text',
	'priority' => 100,
	)
);

// Footer Section.
$wp_customize->add_section( 'pastry_shop_section_footer',
	array(
	'title'      => __( 'Footer Options', 'pastry-shop' ),
	'priority'   => 100,
	'capability' => 'edit_theme_options',
	'panel'      => 'pastry_shop_theme_option_panel',
	)
);

// Setting copyright_text.
$wp_customize->add_setting( 'theme_options[pastry_shop_copyright_text]',
	array(
	'default'           => $default['pastry_shop_copyright_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'pastry_shop_sanitize_textarea_content',
	'transport'         => 'postMessage',
	)
);
$wp_customize->add_control( 'theme_options[pastry_shop_copyright_text]',
	array(
	'label'    => __( 'Copyright Text', 'pastry-shop' ),
	'section'  => 'pastry_shop_section_footer',
	'type'     => 'text',
	'priority' => 100,
	)
);

$wp_customize->add_setting( 'theme_options[pastry_shop_copyright_background_color]', array(
	'default'           => $default['pastry_shop_copyright_background_color'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
	'priority' => 100,
));

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'theme_options[pastry_shop_copyright_background_color]', array(
	'label'       => __( 'Copyright background Color', 'pastry-shop' ),
	'section'     => 'pastry_shop_section_footer',
	'settings'    => 'theme_options[pastry_shop_copyright_background_color]',
	'priority' => 100,
)));

$wp_customize->add_setting( 'theme_options[pastry_shop_copyright_text_color]', array(
	'default'           => $default['pastry_shop_copyright_text_color'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
	'priority' => 100,
));

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'theme_options[pastry_shop_copyright_text_color]', array(
	'label'       => __( 'Copyright Text Color', 'pastry-shop' ),
	'section'     => 'pastry_shop_section_footer',
	'settings'    => 'theme_options[pastry_shop_copyright_text_color]',
	'priority' => 100,
)));
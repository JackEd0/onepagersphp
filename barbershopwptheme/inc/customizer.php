<?php

function barbershop_customize_register($wp_customize) {
    // Hero Text
    $wp_customize->add_section('barbershop_hero_section', [
        'title' => __('Hero Section', 'barbershop'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('hero_text', [
        'default' => 'Welcome to Barbershop Deluxe',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('hero_text', [
        'label' => __('Hero Text', 'barbershop'),
        'section' => 'barbershop_hero_section',
        'type' => 'text',
    ]);

    // Hero Image
    $wp_customize->add_setting('hero_image', [
        'default' => get_template_directory_uri() . '/assets/barbershop.jpg',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', [
        'label' => __('Hero Image', 'barbershop'),
        'section' => 'barbershop_hero_section',
    ]));
}
add_action('customize_register', 'barbershop_customize_register');

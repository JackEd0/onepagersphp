<?php
function barbershop_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
}

function barbershop_enqueue_scripts() {
    wp_enqueue_style('tailwind-css', 'https://cdn.tailwindcss.com');
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/assets/custom.js', [], false, true);
}

add_action('after_setup_theme', 'barbershop_theme_setup');
add_action('wp_enqueue_scripts', 'barbershop_enqueue_scripts');

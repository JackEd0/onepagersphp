<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-gray-100'); ?>>

<header class="bg-black text-white p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold"><?php bloginfo('name'); ?></h1>
    <select id="languageSwitcher" class="text-black p-2">
        <option value="en">EN</option>
        <option value="fr">FR</option>
        <option value="es">ES</option>
    </select>
</header>

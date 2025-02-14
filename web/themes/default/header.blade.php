<!doctype html>
<html lang="<?php language_attributes(); ?>">

<head>
    <title><?php bloginfo('title'); ?></title>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php echo isset($seo_meta_tags) ? $seo_meta_tags : ''; ?>
    <link rel="icon" type="image/png" href="{{ asset($current_theme_assets . 'assets/img/favicon.png') }}">
    <?php site_head(); ?>
    <?php wp_head(); ?>
</head>

<body class="<?php echo body_class(); ?>">

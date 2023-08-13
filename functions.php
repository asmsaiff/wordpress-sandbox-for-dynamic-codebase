<?php
    // Libraries
    require_once(get_theme_file_path( '/lib/acf/acf.php' ));

    // Theme Setup
    function sb_theme_setup() {
        load_theme_textdomain( 'sb' );

        // Theme Supports
        add_theme_support( 'title-tag' );
        add_theme_support( 'menus' );
        add_theme_support( 'post-thumbnails' );

        // Menu Register
        register_nav_menus(array(
            'primary-menu'      =>  __('Primary Menu', 'sb'),
        ));
    }
    add_action( 'after_setup_theme', 'sb_theme_setup' );

    // Assets Enqueue
    function sb_assets_enqueue() {
        // StyleSheets
        wp_enqueue_style('wp-stylesheet', get_stylesheet_directory_uri());
        wp_enqueue_style('tw-elem-stylesheet', '//cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css');

        // Scripts
        wp_enqueue_script('tailwind', '//cdn.tailwindcss.com', time(), null, false);
        wp_enqueue_script('tailwind-elem', '//cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js', time(), null, true);
        wp_enqueue_script('app-js', get_template_directory_uri() . '/assets/js/app.js', time(), null, true);
    }
    add_action( 'wp_enqueue_scripts', 'sb_assets_enqueue' );
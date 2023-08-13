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
        wp_enqueue_script('tailwind', '//cdn.tailwindcss.com', null, time(), false);
        wp_enqueue_script('tailwind-elem', '//cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js', null, time(), true);
        wp_enqueue_script('app-js', get_template_directory_uri() . '/assets/js/app.js', array('jquery'), time(), true);

        // Define ajaxurl for use in JavaScript
        wp_localize_script('app-js', 'aj', array('ajaxurl' => admin_url('admin-ajax.php')));
    }
    add_action( 'wp_enqueue_scripts', 'sb_assets_enqueue' );

    function handle_file_upload_ajax() {
        if (isset($_FILES['file_upload'])) {
            $file = $_FILES['file_upload'];
    
            // Your validation and handling logic here
    
            $upload_dir = wp_upload_dir();
            $file_path = $upload_dir['path'] . '/' . $file['name'];
    
            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                $attachment = array(
                    'guid'           => $upload_dir['url'] . '/' . $file['name'],
                    'post_mime_type' => $file['type'],
                    'post_title'     => sanitize_file_name($file['name']),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );
    
                $attachment_id = wp_insert_attachment($attachment, $file_path);
    
                if (!is_wp_error($attachment_id)) {
                    require_once ABSPATH . 'wp-admin/includes/image.php';
                    $attachment_data = wp_generate_attachment_metadata($attachment_id, $file_path);
                    wp_update_attachment_metadata($attachment_id, $attachment_data);
    
                    echo 'File uploaded successfully!';
                } else {
                    echo 'Error uploading file.';
                }
            } else {
                echo 'Error moving file.';
            }
        } else {
            echo 'No file uploaded.';
        }
    
        die();
    }
    add_action('wp_ajax_handle_file_upload', 'handle_file_upload_ajax');
    add_action('wp_ajax_nopriv_handle_file_upload', 'handle_file_upload_ajax');
    
<?php
    function sandbox_post_types() {
        $labels = array(
            'name'                  => _x( 'Reservation', 'sandbox' ),
            'singular_name'         => _x( 'Reservation', 'sandbox' ),
            'menu_name'             => _x( 'Reservations', 'sandbox' ),
            'name_admin_bar'        => _x( 'Reservation', 'sandbox' ),
            'add_new'               => __( 'Add Reservation', 'sandbox' ),
            'add_new_item'          => __( 'New Reservation', 'sandbox' ),
            'new_item'              => __( 'New Reservation', 'sandbox' ),
            'edit_item'             => __( 'Edit Reservation', 'sandbox' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'reservation' ),
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_icon'          => 'dashicons-media-document',
            'menu_position'      => null,
            'supports'           => array( 'title' ),
        );

        register_post_type('reservation', $args);
    }
    add_action( 'init', 'sandbox_post_types' );
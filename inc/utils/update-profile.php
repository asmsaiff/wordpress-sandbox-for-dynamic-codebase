<?php
    $user = wp_get_current_user();

    if (isset($_POST['submit'])) {
        // Update user data
        $new_display_name = sanitize_text_field($_POST['user_display_name']);
        $new_email = sanitize_email($_POST['user_email']);

        // Update user display name and email
        wp_update_user(array(
            'ID'           => $user->ID,
            'display_name' => $new_display_name,
            'user_email'   => $new_email,
        ));

        // Handle profile picture upload
        if (!empty($_FILES['profile_picture']['name'])) {
            $profile_picture = $_FILES['profile_picture'];

            // if (strpos($profile_picture['type'], 'image') === 0) {
                $upload_dir = wp_upload_dir();
                $upload_path = $upload_dir['path'] . '/profile-pictures/';

                if (!file_exists($upload_path)) {
                    mkdir($upload_path, 0755);
                }

                $file_name = uniqid('profile_', true) . '.' . pathinfo($profile_picture['name'], PATHINFO_EXTENSION);
                $file_path = $upload_path . $file_name;

                move_uploaded_file($profile_picture['tmp_name'], $file_path);

                update_user_meta($user->ID, 'profile_picture', $upload_dir['url'] . '/profile-pictures/' . $file_name);
            // }
        }

        // Redirect or display success message
        wp_redirect(home_url('/dashboard'));
    }
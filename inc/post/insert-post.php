<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_post"])) {
        $post_title = sanitize_text_field($_POST["post_title"]);
        $post_content = wp_kses_post($_POST["post_content"]);
    
        // Insert the post
        $new_post = array(
            'post_title'    => $post_title,
            'post_content'  => $post_content,
            'post_status'   => 'publish',
            'post_author'   => get_current_user_id(),
            'post_type'     => 'post',
        );
    
        $post_id = wp_insert_post($new_post);
    
        // Handle the thumbnail upload
        if ($_FILES['post_thumbnail']['size'] > 0) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            
            $attachment_id = media_handle_upload('post_thumbnail', $post_id);
            set_post_thumbnail($post_id, $attachment_id);
        }
    
        // Redirect after successful submission
        if (!is_wp_error($post_id)) {
            wp_redirect(home_url('/dashboard'));
        }
    }
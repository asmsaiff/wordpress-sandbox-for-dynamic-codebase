<?php
    get_header();

    if(!is_user_logged_in()) {
        wp_redirect('/login');
        exit;
    }
    
    $user = wp_get_current_user();
?>

<main class="w-8/12 mx-auto">
    <!--Tabs navigation-->
    <div class="flex h-screen">
        <div class="h-full w-72 bg-gray-100">
            <div class="px-6">
                <?php
                    $profile_picture_url = get_user_meta($user->ID, 'profile_picture', true);
                ?>
                <img src="<?php echo $profile_picture_url; ?>" class="rounded-full w-20 h-20 mx-auto mt-24" alt="" loading="lazy">

                <h2 class="text-xl font-extrabold text-black mt-4 mb-8 text-center">
                <?php
                    echo $user->display_name;
                ?>

                </h2>
            </div>
            <ul class="flex list-none flex-col flex-wrap pl-0 "
            role="tablist"
            data-te-nav-ref>
                <li role="presentation" class="flex-grow text-center">
                    <a
                    href="#tabs-home03"
                    class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                    data-te-toggle="pill"
                    data-te-target="#tabs-home03"
                    data-te-nav-active
                    role="tab"
                    aria-controls="tabs-home03"
                    aria-selected="true"
                    >Dashboard</a>
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <a
                    href="#tabs-profile03"
                    class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                    data-te-toggle="pill"
                    data-te-target="#tabs-profile03"
                    role="tab"
                    aria-controls="tabs-profile03"
                    aria-selected="false"
                    >Edit Profile</a
                    >
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <a
                    href="#tabs-messages03"
                    class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                    data-te-toggle="pill"
                    data-te-target="#tabs-messages03"
                    role="tab"
                    aria-controls="tabs-messages03"
                    aria-selected="false"
                    >Blog Post</a
                    >
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <a href="<?php echo wp_logout_url(); ?>">Logout</a>
                </li>
            </ul>
        </div>

        <!--Tabs content-->
        <div class="my-2 p-6">
            <div
                class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                id="tabs-home03"
                role="tabpanel"
                aria-labelledby="tabs-home-tab03"
                data-te-tab-active>
                Tab 1 content
            </div>
            <div
                class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                id="tabs-profile03"
                role="tabpanel"
                aria-labelledby="tabs-profile-tab03">
                <form id="edit-profile-form" method="post" enctype="multipart/form-data">
                    <label for="user_display_name">Display Name</label>
                    <input type="text" name="user_display_name" class="w-full border p-3" value="<?php echo esc_attr($user->display_name); ?>" />

                    <label for="user_email">Email</label>
                    <input type="email" name="user_email" class="w-full border p-3" value="<?php echo esc_attr($user->user_email); ?>" />

                    <label for="profile_picture" class="my-4 block">Profile Picture</label>
                    <input type="file" value="<?php echo esc_url($user->profile_picture); ?>" name="profile_picture" />
                    <!-- Add more fields for other user information -->

                    <div>
                        <input type="submit" name="submit" class="bg-blue-600 text-sm text-white px-4 py-2 rounded-md mt-4" value="Update Profile" />
                    </div>
                </form>
            </div>
            <div
                class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                id="tabs-messages03"
                role="tabpanel"
                aria-labelledby="tabs-profile-tab03">
                Tab 3 Content
            </div>
            <div
                class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                id="tabs-contact03"
                role="tabpanel"
                aria-labelledby="tabs-contact-tab03">
                Tab 4 content
            </div>
        </div>
    </div>
</main>

<?php
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
        } else {
            error_log();
        }

        // Redirect or display success message
        wp_redirect(home_url('/dashboard'));
        exit();
    }

    get_footer();
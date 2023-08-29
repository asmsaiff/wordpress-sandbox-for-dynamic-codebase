<?php
    if(!is_user_logged_in()) {
        wp_redirect('/login');
        exit;
    }

    require_once(get_theme_file_path( '/inc/post/insert-post.php' ));
    require_once(get_theme_file_path( '/inc/utils/update-profile.php' ));
    
    $user = wp_get_current_user();

    get_header();
?>

<main class="w-8/12 mx-auto">
    <!--Tabs navigation-->
    <div class="flex h-screen">
        <div class="h-full w-72 block bg-gray-100">
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
                    aria-selected="false">
                    Edit Profile
                    </a>
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
        <div class="my-2 p-6 flex-grow">
            <div
                class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                id="tabs-home03"
                role="tabpanel"
                aria-labelledby="tabs-home-tab03"
                data-te-tab-active>
                
                <div>
                    <table class="table-auto w-full">
                        <thead class="border-b">
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $current_loggedin_user = wp_get_current_user();
                                $current_author_post = new WP_Query(array(
                                    'post_type'         =>  'post',
                                    'author__in'        =>  $current_loggedin_user->ID,
                                ));

                                $post_count = 0;
                                while($current_author_post->have_posts()) :
                                    $current_author_post->the_post();
                                    $post_id = get_the_ID();

                                    $post_count++;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $post_count; ?>
                                </td>
                                <td>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                                            the_title();
                                        ?>
                                    </a>
                                </td>
                                <td>
                                    <?php
                                        echo $user->display_name;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo get_the_date();
                                    ?>
                                </td>
                                <td class="flex gap-2 items-center justify-end">
                                    <button data-post-id="<?php echo $post_id; ?>" class="delete-post bg-red-600 rounded-md text-white px-3 py-1 text-xs font-bold">
                                        Delete
                                    </button>
                                    <button data-te-toggle="modal"
                                        data-te-target="#edit-post-<?php echo $post_count; ?>"
                                        data-te-ripple-init
                                        data-post-id="<?php echo $post_id; ?>"
                                        data-te-ripple-color="light" class="edit-post bg-blue-600 rounded-md text-white px-3 py-1 text-xs font-bold">
                                        Edit
                                    </button>
                                </td>

                                <div
                                    data-te-modal-init
                                    class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
                                    id="edit-post-<?php echo $post_count; ?>"
                                    tabindex="-1"
                                    aria-modal="true"
                                    role="dialog">
                                    <div
                                        data-te-modal-dialog-ref
                                        class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
                                        <div
                                        class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none">

                                        
                                        <!--Modal body-->
                                        <div class="relative p-4">
                                            <form method="post" class="w-full" enctype="multipart/form-data">
                                                <label for="post_title">Post Title:</label>
                                                <input type="text" class="w-full border p-3" name="edit_post_title" required><br>

                                                <label for="post_content">Post Content:</label>
                                                <textarea class="w-full border p-3" name="edit_post_content" required></textarea><br>

                                                <label for="post_thumbnail">Thumbnail:</label>
                                                <input type="file" name="post_thumbnail"><br>

                                                <div>
                                                    <input type="submit" name="edited_submit_post" class="bg-blue-600 text-sm text-white px-4 py-2 rounded-md mt-4" value="Submit Post">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            <?php
                                endwhile;
                            ?>
                        </tbody>
                    </table>
                </div>
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
                <form method="post" enctype="multipart/form-data">
                    <label for="post_title">Post Title:</label>
                    <input type="text" class="w-full border p-3" name="post_title" required><br>

                    <label for="post_content">Post Content:</label>
                    <textarea class="w-full border p-3" name="post_content" required></textarea><br>

                    <label for="post_thumbnail">Thumbnail:</label>
                    <input type="file" name="post_thumbnail"><br>

                    <div>
                        <input type="submit" name="submit_post" class="bg-blue-600 text-sm text-white px-4 py-2 rounded-md mt-4" value="Submit Post">
                    </div>
                </form>
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
    get_footer();
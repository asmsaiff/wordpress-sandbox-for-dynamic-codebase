<?php
    get_header();

?>

<div class="w-8/12 mx-auto">
    <form id="postForm" enctype="multipart/form-data">
        <!-- Other fields for post data -->
        <input type="text" name="post_title" placeholder="Post Title" required>
        <textarea name="post_content" placeholder="Post Content" required></textarea>
        
        <!-- File input for featured image -->
        <input type="file" name="featured_image" accept="image/*" required>
        
        <button type="button" id="submitPost">Submit Post</button>
    </form>
</div>

<?php
    get_footer();
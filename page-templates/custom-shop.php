<?php
    /**
     * Template Name: Custom Shop
     */
    get_header();
?>

<main class="w-8/12 py-12 mx-auto">
    <div id="product-container" class="grid grid-cols-8">
        <?php
            $products = new WP_Query(array(
                'post_type'             =>  'product',
                'posts_per_page'        =>  -1,
            ));

            // echo "<pre>";
            // print_r($products);
            // echo "</pre>";

            while($products->have_posts(  )) {
                $products->the_post();

                global $product;
                $product = get_product( get_the_ID() );
        ?>
        <div class="my-6">
            <h5><?php the_title(); ?></h5>
            <button class="add-to-cart-btn bg-blue-600 text-xs text-white px-6 py-1 my-3" data-product-id="<?php echo $product->id ?>">Add To Cart</button>
        </div>
        <?php
            }
        ?>
    </div>

    <div id="cart-container">
        <h3 class="mt-6 text-2xl font-bold">Cart</h3>
        <p>Total Item In Cart : <span class="cart-count"></span></p>
        <div id="cart-items">
            <!-- Cart items will be displayed here -->
        </div>

        <a href="<?php echo wc_get_checkout_url(); ?>">Checkout</a>
    </div>

</main>

<?php
    get_footer();
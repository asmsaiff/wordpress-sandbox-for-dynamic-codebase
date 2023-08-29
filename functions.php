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

        add_theme_support('woocommerce');

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
        wp_enqueue_style('theme', get_template_directory_uri() . '/assets/css/style.css');

        // Scripts
        wp_enqueue_script('tailwind', '//cdn.tailwindcss.com', null, time(), false);
        wp_enqueue_script('app-js', get_template_directory_uri() . '/assets/js/app.js', array('jquery'), time(), true);

        // Define ajax url for use in JavaScript
        wp_localize_script('app-js', 'aj', array(
            'ajax_url'  => admin_url('admin-ajax.php'),
            'nonce'     => wp_create_nonce('wp_rest'),
            'ajax_nonce'     => wp_create_nonce('custom-ajax-nonce'),
        ));
    }
    add_action( 'wp_enqueue_scripts', 'sb_assets_enqueue' );



    function get_cart_product_count() {
        echo WC()->cart->get_cart_contents_count();
        die();
    }
    add_action('wp_ajax_get_cart_product_count', 'get_cart_product_count');
    add_action('wp_ajax_nopriv_get_cart_product_count', 'get_cart_product_count');
    

    function custom_add_to_cart() {    
        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $quantity = 1; // Product quantity limited to 1
    
        $result = WC()->cart->add_to_cart($product_id, $quantity);
    
        if ($result) {
            echo 'success';
        } else {
            echo 'error';
        }
    
        die();
    }
    add_action('wp_ajax_custom_add_to_cart', 'custom_add_to_cart');
    add_action('wp_ajax_nopriv_custom_add_to_cart', 'custom_add_to_cart');
    
    
    

    function custom_get_cart_contents() {
        ob_start();
    ?>
    <?php
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
    ?>
    <div class="cart-item">
        <div class="cart-item-details">
            <div class="cart-item-title"><?php echo $_product->get_name(); ?></div>
            <div class="cart-item-price"><?php echo wc_price($_product->get_price()); ?></div>
            <div class="cart-quantity-display">Cart Quantity: <span class="cart-quantity">0</span></div>
            <button class="remove-cart-item bg-red-700 text-white text-xs px-3 py-1 rounded-sm" data-cart-item-id="<?php echo $cart_item_key; ?>">X</button>
        </div>
        <hr>
    </div>
    <?php
        }
    
        $cart_contents = ob_get_clean();
        echo $cart_contents;
    }
    add_action('wp_ajax_custom_get_cart_contents', 'custom_get_cart_contents');
    add_action('wp_ajax_nopriv_custom_get_cart_contents', 'custom_get_cart_contents');
    

    function custom_remove_cart_item() {
        if (isset($_POST['cart_item_id'])) {
            $cart_item_key = sanitize_text_field($_POST['cart_item_id']);
            WC()->cart->remove_cart_item($cart_item_key);
        }
        die();
    }
    add_action('wp_ajax_custom_remove_cart_item', 'custom_remove_cart_item');
    add_action('wp_ajax_nopriv_custom_remove_cart_item', 'custom_remove_cart_item');
    
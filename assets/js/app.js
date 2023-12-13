; (function ($) {
    jQuery(document).ready(function ($) {
        

        $(".edit-post").click(function () {
            var post_id = $(this).data('post-id');

            $.getJSON(`http://localhost/sandbox/wp-json/wp/v2/posts/${post_id}`, function (res) {
                $('input[name="edit_post_title"').val(res.title.rendered)
            })
        })

        // Delete Post
        $(".delete-post").click(function () {
            var post_id_d = $(this).data('post-id');

            // $.getJSON(`http://localhost/sandbox/wp-json/wp/v2/posts/${post_id_d}`, {method: "DELETE"}, function (res) {
            //     console.log(res.title.rendered + ' is deleted')
            // })

            console.log(aj.nonce)
            console.log(aj.ajax_nonce)

            $.ajax({
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("X-WP-Nonce", aj.nonce)
                },
                url: `http://localhost/sandbox/wp-json/wp/v2/posts/${post_id_d}`,
                type: 'DELETE',
                success: function (res) {
                    location.reload()
                }
            })
        })

        jQuery(document).ready(function($) {
            $.ajax({
                type: 'GET',
                url: aj.ajax_url, // WordPress AJAX URL
                data: {
                    action: 'get_cart_product_count'
                },
                success: function(response) {
                    $('.cart-count').text(response); // Update the cart count element
                }
            });
        });
        

        // Function to update the state of all "Add to Cart" buttons
        function updateAddToCartButtons(cartQuantity) {
            var maxAllowedQuantity = 3;
            
            if (cartQuantity === maxAllowedQuantity) {
                $('.add-to-cart-button').removeClass("bg-blue-600");
                $('.add-to-cart-button').addClass("bg-red-600");
            } else {
                $('.add-to-cart-button').removeClass("bg-red-600");
                $('.add-to-cart-button').addClass("bg-blue-600");
            }
        }

        // Get initial cart quantity
        var initialCartQuantity = parseInt($('.cart-quantity').text());
        updateAddToCartButtons(initialCartQuantity);
        
        $('.add-to-cart-btn').on('click', function(e) {
            e.preventDefault();

            var product_id = $(this).data('product-id');
            var quantity = 1;

            // Trigger the default WooCommerce add to cart action
            $(document.body).trigger('adding_to_cart', [$(this), true]);
            $(document.body).trigger('added_to_cart', [null, null, null, $(this)]);
    
            $.ajax({
                type: 'POST',
                url: aj.ajax_url,
                data: {
                    action: 'custom_add_to_cart',
                    product_id: product_id,
                    quantity: quantity,
                    nonce: aj.ajax_nonce
                },
                success: function(response) {
                    updateCartContents();
                }
            });
        });
        

        var cartContainer = $('#cart-items');

        function updateCartContents() {
            $.ajax({
                type: 'POST',
                url: aj.ajax_url,
                data: {
                    action: 'custom_get_cart_contents'
                },
                success: function(response) {
                    cartContainer.html(response);

                    updateCartContents();
                }
            });
        }

        cartContainer.on('click', '.remove-cart-item', function() {
            var cartItemId = $(this).data('cart-item-id');
    
            $.ajax({
                type: 'POST',
                url: aj.ajax_url,
                data: {
                    action: 'custom_remove_cart_item',
                    cart_item_id: cartItemId
                },
                success: function() {
                    updateCartContents();
                }
            });
        });

        updateCartContents();
    });


    $("#reserve").click(function () {
        $.post(aj.ajax_url, {
            action: 'reservation',
            name: $("#name").val(),
            email: $("#email").val(),
            persons: $("#persons").val(),
            date: $("#date").val(),
            time: $("#time").val(),
            rn: $("#rn").val()
        }, function (data) {
            console.log(data)
        })
        return false;
    })

    $('#submitPost').on('click', function () {
        // Create FormData object
        var formData = new FormData($('#postForm')[0]);

        // Add additional post meta data
        formData.append('action', 'insert_post');

        // Make AJAX request
        $.ajax({
            type: 'POST',
            url: aj.ajax_url,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#postForm')[0].reset();
            },
            error: function (error) {
                console.error(error);
                // Handle error, e.g., show an error message
            }
        });
    });
}(jQuery)); 

// const initTE = window.initTE();
// const Collapse = window.Collapse;
// const Dropdown = window.Dropdown;
// const Tab = window.Tab;
// const Ripple = window.Ripple;
// const Datatable = window.Datatable;
// const Datepicker = window.Datepicker;
// const Input = window.Input;

// initTE({ Collapse, Dropdown, Tab, Ripple, Datatable, Datepicker, Input });
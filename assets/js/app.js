; (function ($) {
    jQuery(document).ready(function($) {
        $('#file-upload-form').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: aj.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#upload-status').html(response);
                }
            });
        });
    });
}(jQuery)); 

initTE({ Collapse, Dropdown });
initTE({ Tab });